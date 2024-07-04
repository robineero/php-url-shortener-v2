<?php

require __DIR__ . '/vendor/autoload.php';
use Doctrine\DBAL\DriverManager;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function getConnection() {
    $connectionParams = [
        'path' => 'data.db',
        'driver' => 'pdo_sqlite',
    ];

    $conn = DriverManager::getConnection($connectionParams);

    return $conn;
}

if (isset($_POST['url']) && isset($_POST['slug'])) {

    echo $_POST['url'] . PHP_EOL;
    echo $_POST['slug'];

    $created_at = date('Y-m-d H:i:s');

    $conn = getConnection();

    $sql = "INSERT INTO link (url, slug, created_at)
            VALUES (:url, :slug, :created_at)";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':url', $_POST['url']);
    $stmt->bindValue(':slug', $_POST['slug']);
    $stmt->bindValue(':created_at', $created_at);
    $stmt->executeStatement();

    $conn->close();
}


