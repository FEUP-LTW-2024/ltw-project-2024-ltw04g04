<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../database/connectDB.php');

function getCategories() : array {

    try {
        $db = getDatabaseConnection();
        //echo "Connecting to database successfull!";
    } catch (PDOException $e) {
        echo "Error connecting to database: " . $e->getMessage();
    }


    // Query para obter as categorias da base de dados
    $stmt = $db->query('SELECT CategoryName FROM Category');
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $categories;
}
?>