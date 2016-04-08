<?php
    require_once  'inc/class.Session.php'; 
    Session::init();
    require_once 'inc/class.PDOMenu.php'; 
	require_once 'inc/class.FabriqueVue.php';
    include 'vues/v_entete.php';
    // constantes 
    define("EOL","<br />\n");// fin de ligne html et saut de ligne
    define("EL","\n");//  saut de ligne 
    // instanciation du modèle PDO
        $pdo = PDOMenu::getPdoMenu();
	$tabjour=array("lundi ","mardi ","mercredi ","jeudi ","vendredi ");
    $_SESSION['debug']="hidden";
    // TODO effacer le mode debug
    //$_SESSION['debug']="text";
	// instanciation de la fabrique de vue
    $vue = FabriqueVue::getFabrique();
    // instanciation du modèle PDO
    $pdo = PDOMenu::getPdoMenu();
    //print_r ($_REQUEST);
	
function clean($texte){	return (htmlspecialchars(trim($texte)));}
function cleanaff($texte){//utf8_decode
	return stripslashes(htmlspecialchars(trim($texte)));
}

