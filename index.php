<?php

require __DIR__ . '/vendor/autoload.php';
require 'functions.php';

$slug = basename($_SERVER["REQUEST_URI"]);

function redirect($slug) {

    $conn = getConnection();
    $sql = "SELECT * FROM link WHERE slug = :slug LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':slug', $slug);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        header("Location: " . $row['url'], true, 302);
        exit;
    }



}

if ($slug && $slug !== "redirect") {
    redirect($slug);
}

$temp = time();

?>

<a href="<?php echo $temp; ?>" target="_blank"><?php echo $temp; ?></a>


<form action="functions.php" method="POST">
    URL: <input type="text" name="url" value="https://erimell.ee/tootekategooria/jahutusvedelikud/?fwp_pakendi_suurus=vaat&fwp_brand=mannol"><br>
    Slug: <input type="text" name="slug" value="<?php echo $temp; ?>"><br>
    <input type="submit">
</form>