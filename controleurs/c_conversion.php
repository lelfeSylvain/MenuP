<?php
/*
 * vieux controleur permettant de faire migrer la BD
require_once 'vues/class.V_Repas.php';
require_once 'inc/class.Semaine.php';

$lesRepas = $pdo->getLesRepas2();
echo 'conversion <br />';
foreach ($lesRepas as $unRepas) {
    $maSem = new Semaine($unRepas['annee'] . $unRepas['numsema'], 'YW');
    $leRepas = new Repas($unRepas, "lu");
    if ($unRepas['numsema'] < 10)
        $zero = "0";
    else
        $zero = "";
    $exp = $unRepas['annee'] . $zero . $unRepas['numsema'];
    if ($exp !== $maSem->getAnneeSem())
        echo $exp . " -> " . $maSem->getAnneeSem() . " : " . $leRepas->getEnt() . '<br />';
    $res = $pdo->setLeRepas2($maSem,$unRepas['numserv'],$leRepas);
}*/