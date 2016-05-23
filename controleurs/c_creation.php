<?php
require_once  'vues/class.V_Repas.php';
require_once  'inc/class.Semaine.php';

if (isset($_REQUEST['num'])) {
    $num = clean($_REQUEST['num']);
} else {
    $num = "";//TODO redirection erreur
}
$codeAction= substr($num,0,1);
$numrep=substr($num,-1);
$maSem = new Semaine(substr($num,1,strlen($num)-2));
$unRepas = new Repas($pdo->getLeRepas($maSem, $numrep));

$menu=new V_Repas($unRepas,  $maSem->getLundi(), true);
if ($codeAction==='f') {// affichage du formulaire de saisie
    include 'vues/v_saisirRepas.php';
}
elseif ($codeAction==='v') {//validation d'un repas
    $repas=array();
    $repas[0]=clean($_POST["titm"]);
    $repas[1]=clean($_POST["ent"]);
    $repas[2]=clean($_POST["plat"]);
    $repas[3]=clean($_POST["lait"]);
    $repas[4]=clean($_POST["des"]);
    $repas[5]=$numrep;
    $repas[6]=clean($_POST["message"]);
    $repas[7]=null;
    if ($repas[6] === "message") {
        $repas[0] = clean($_POST["mes1"]);
        $repas[2] = clean($_POST["mes2"]);
        $repas[6] = Repas::TYPEMESSAGE;
    } else {
        $repas[6] = Repas::TYPEREPAS;
    }
    $monRepas= new Repas($repas,"saisi");
    /* pour les tests
     * print_r ($repas);
    $test= new V_Repas($monRepas, $maSem->getLundi(), true);
    $test->afficherRepas($bg, $i);*/
    // enregistre le repas dans la BD
    $pdo->setLeRepas($maSem, $numrep,$monRepas);
    
}
