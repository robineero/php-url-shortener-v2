<?php

require __DIR__ . '/vendor/autoload.php';
require 'functions.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$slug = basename($_SERVER["REQUEST_URI"]);

function redirect($slug) {

    $slug = strpos($slug, "?") ? strstr($slug, "?", true) : $slug;

    $conn = getConnection();
    $sql = "SELECT * FROM link WHERE slug = :slug LIMIT 1";
    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':slug', $slug);
    $result = $stmt->executeQuery();

    $row = $result->fetchAssociative();

    if ($row) {

        $created_at = date('Y-m-d H:i:s');

        $sql = "INSERT INTO log (link_id, created_at) VALUES(:link_id, :created_at)";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue("link_id", $row['id']);
        $stmt->bindValue("created_at", $created_at);
        $stmt->executeStatement();

        $conn->close();

        header("Location: " . $row['url'], true, 301);
        exit;
    }

}

if ($slug && $slug !== $_ENV['DIR_NAME']) {
    redirect($slug);
}

$temp = time();
$links = getLinks();

?>

<form action="functions.php" method="POST">
    URL: <input type="text" name="url" value="https://erimell.ee/pood/?fwp_pakendi_suurus=vaat&fwp_brand=mannol"><br>
    Slug: <input type="text" name="slug" value="<?php echo $temp; ?>"><br>
    <input type="submit">
</form>

<?php foreach ($links as $link): ?>
    <a href="<?= $link['slug'] ?>" target="_blank"><?= $link['slug'] ?></a><br>
<?php endforeach; ?>