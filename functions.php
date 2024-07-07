<?php

require __DIR__ . '/vendor/autoload.php';
use Doctrine\DBAL\DriverManager;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function getConnection() {
    $connectionParams = [
        'path' => $_ENV['DB_FILE_NAME'],
        'driver' => 'pdo_sqlite',
    ];

    $conn = DriverManager::getConnection($connectionParams);

    return $conn;
}

function getLinks() {

    $sql = "SELECT * FROM link ORDER BY created_at DESC";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $result = $stmt->executeQuery();
    $conn->close();

    return $result->fetchAllAssociative();
}

if (isset($_POST['url']) && isset($_POST['slug'])) {

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

    header("Location: /" . $_ENV['DIR_NAME'], true, 301);
}
