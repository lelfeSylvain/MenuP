<!DOCTYPE html>
<?php
/* Projet menu du self v2 
  sylvain mars 2016
 */
require_once 'inc/fonctions.php'; //appelle tous les 'include' et fonctions utilitaires


if (!isset($_REQUEST['uc'])) {//s'il n'y a pas d'uc alors on consulte le menu
    $uc = 'lecture';
    $num = 'actuelle';
} else { // s'il y a un uc, on l'utilise après l'avoir nettoyé
    $uc = clean($_REQUEST['uc']);
    if (isset($_REQUEST['num'])) {
        $num = clean($_REQUEST['num']);
    } else {
        $num = "";
    }
}
if ($uc === 'login') {
    include('controleurs/c_login.php');
}
// si l'utilisateur n'est pas identifié, il doit le faire
elseif (!Session::isLogged()) {
    include('controleurs/c_semaine.php');
} else {// à partir d'ici, l'utilisateur est forcément connecté
    // instanciation de la fabrique de vue
    $vue = FabriqueVue::getFabrique();

    // justement on enregistre la dernière activité de l'utilisateur dans la BD
    $pdo->setDerniereCx($_SESSION['numUtil']);

    // gère le fil d'ariane : TODO à gérer
    //include_once 'controleurs/c_ariane.php';
    //aiguillage principal
    switch ($uc) {
        case 'lecture': {// uc lecture du menu 
                include("controleurs/c_semaine.php");
                break;
            }
        case 'creer': {// uc création d'un post ou rubrique
                include("controleurs/c_creation.php");
                break;
            }
        default :  // par défaut on consulte les posts
            include("controleurs/c_lecture.php");
    }
}
include("vues/v_pied.php");
 