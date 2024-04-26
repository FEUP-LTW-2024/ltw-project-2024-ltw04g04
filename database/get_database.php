<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../utils/session.php');

    
    function getDatabaseConnection() : PDO {
        $db = new PDO('sqlite:' . __DIR__ . '/../database/database.db');
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $db;
    }


    function getCategories() : array {
        $db = getDatabaseConnection();

        $stmt = $db->query('SELECT CategoryName FROM Category');
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }

    function getSizes() : array {
        $db = getDatabaseConnection();

        $stmt = $db->query('SELECT DISTINCT Size_ FROM Item');
        $sizes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $sizes;
    }

    function getBrands() : array {
        $db = getDatabaseConnection();

        $stmt = $db->query('SELECT DISTINCT Brand FROM Item');
        $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $brands;
    }

    function getModels() : array {
        $db = getDatabaseConnection();

        $stmt = $db->query('SELECT DISTINCT Model FROM Item');
        $models = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $models;
    }
?>