<?php
    declare(strict_types = 1);
    //require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../database/item.class.php');

    $db = getDatabaseConnection();

    if (isset($_GET['query'])) {
        $search = '%' . $db->quote($_GET['query']) . '%'; // Adiciona % para fazer uma pesquisa parcial
        
        $result = Item::getItemWithName($db, $search);

        if (!empty($result)) {
            foreach ($result as $item) {
                echo "Nome do item: " . $item->getName() . "<br>";
                // Você pode adicionar mais informações do item conforme necessário
            }
        } else {
            echo "Nenhum resultado encontrado.";
        }
    }
?>