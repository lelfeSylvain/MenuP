<?php
/*
 * Controleur pour gérer la modification du mot de passe
 */
$texteNav="";
if ($num === 'in') {// on se connecte
    $login = "";
    $mdp = "";
    
    if (isset($_POST['login']) && isset($_POST['password'])) {
        $login = clean($_POST['login']);
        $mdp = clean($_POST['reponse']);
        $pdo = PDOMenu::getPdoMenu();

        
    }
}

include('vues/v_changerMDP.php');