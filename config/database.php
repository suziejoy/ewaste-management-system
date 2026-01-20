<?php
try {
    $db_path = __DIR__ . "/../database/db.sqlite";

    if (!file_exists($db_path)) {
        die("Database file not found at $db_path");
    }

    $conn = new PDO("sqlite:" . $db_path);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
