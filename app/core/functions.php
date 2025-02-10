<?php

use JetBrains\PhpStorm\NoReturn;

function show($stuff)
{
    echo "<pre>";
    print_r($stuff);
    echo "<pre>";
}

function set_value($key)
{
    if(!empty($_POST[$key]))
    {
        return $_POST[$key];
    }
    return '';
}

function redirect($link): void
{
    header("Location: ". ROOt . "/" .$link);
    die;
}

function message($msg = '', $erase = false)
{
    if (!empty($msg)) {
        $_SESSION["message"] = $msg; // Enregistrer le message
    } else {
        if (!empty($_SESSION["message"])) {
            $msg = $_SESSION["message"]; // Récupérer le message
            if ($erase) {
                unset($_SESSION["message"]); // Effacer après affichage
            }
            return $msg;
        }
    }
    return ''; // Retourner une chaîne vide si aucun message
}
