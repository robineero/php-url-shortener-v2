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
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex,nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>URL Shortener V2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <div class="row py-3">
        <div class="col">

            <form action="functions.php" method="POST">
                <div class="mb-3">
                    <label for="url" class="form-label">URL</label>
                    <input type="text" name="url" class="form-control" value="" id="url">
                </div>
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" value="<?php echo $temp; ?>" id="slug">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>

    <div class="row">
        <div class="col">

            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">Short</th>
                    <th scope="col">Destination</th>
                    <th scope="col">Created at</th>
                </tr>
                </thead>
                <?php foreach ($links as $link): ?>
                    <tr>
                        <td><a href="<?= $link['slug'] ?>" target="_blank"><?= $link['slug'] ?></a></td>
                        <td><a href="<?= $link['url'] ?>" target="_blank"><?= $link['url'] ?></a></td>
                        <td><?= $link['created_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

        </div>
    </div>

</div>

</body>
</html>
