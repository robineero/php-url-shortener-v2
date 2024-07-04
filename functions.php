<?php

function getConnection() : PDO {

    try {
        $conn = new PDO("sqlite:" . __DIR__ . "/data.db");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;

    } catch (PDOException $e) {
        throw new RuntimeException("Can not connect.");
    }
}



if (isset($_POST['url']) && isset($_POST['slug'])) {

    echo $_POST['url'] . PHP_EOL;
    echo $_POST['slug'];

    $created_at = date('Y-m-d H:i:s');

    $conn = getConnection();

    $sql = "INSERT INTO link (url, slug, created_at)
            VALUES (:url, :slug, :created_at)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':url', $_POST['url']);
    $stmt->bindParam(':slug', $_POST['slug']);
    $stmt->bindParam(':created_at', $created_at);
    $stmt->execute();

}