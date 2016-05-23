<?php
// bibliothèque de fonctions	
include_once("class.pdomenu.inc.old.php");	
function clean($texte){	return (htmlspecialchars(trim($texte)));}
function cleanaff($texte){//utf8_decode
	return stripslashes(htmlspecialchars(trim($texte)));
}
function sqlexe($sql,$mode="alone"){	
	if ($_SESSION['user']=="debug")
		echo  "<br/>".$sql."<br/>";	
	$pdo = PdoMenu::getPdoMenu();
	$donnees=$pdo->executerRequete($sql,$mode);
	return $donnees;
}
function connexionBD()	{ 
		return PdoMenu::getPdoMenu();
	}
?>
