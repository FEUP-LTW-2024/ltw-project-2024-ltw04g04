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

        $stmt = $db->query('SELECT SizeVal FROM Size_');
        $sizes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $sizes;
    }

    function getBrands() : array {
        $db = getDatabaseConnection();

        $stmt = $db->query('SELECT BrandName FROM Brand');
        $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $brands;
    }

    function getModels() : array {
        $db = getDatabaseConnection();

        $stmt = $db->query('SELECT ModelName FROM Model');
        $models = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $models;
    }

    function getConditions() : array {
        $db = getDatabaseConnection();

        $stmt = $db->query('SELECT ConditionName FROM Condition');
        $conditions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $conditions;
    }
?>