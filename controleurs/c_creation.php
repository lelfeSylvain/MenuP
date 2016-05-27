<?php

require_once 'vues/class.V_Repas.php';
require_once 'inc/class.Semaine.php';
// TODO vérifier $num plutôt $_REQUEST
if (!isset($_REQUEST['num'])) {// erreur d'aiguillage
    include 'vues/v_erreur.php';
} else {
    // on récupère l'action et l'identification du repas
    $num = clean($_REQUEST['num']);

    $codeAction = substr($num, 0, 1);
    $numrep = substr($num, -1);
    $dateSem = substr($num, 1, strlen($num) - 2);
    $maSem = new Semaine($dateSem);

    switch ($codeAction) {
        case 'v': {//validation d'un repas
                $repas = array();
                $repas[0] = clean($_POST["titm"]);
                $repas[1] = clean($_POST["ent"]);
                $repas[2] = clean($_POST["plat"]);
                $repas[3] = clean($_POST["lait"]);
                $repas[4] = clean($_POST["des"]);
                $repas[5] = $numrep;
                $repas[6] = clean($_POST["message"]);
                $repas[7] = null;
                if ($repas[6] === "message") {
                    $repas[0] = clean($_POST["mes1"]);
                    $repas[2] = clean($_POST["mes2"]);
                    $repas[6] = Repas::TYPEMESSAGE;
                } else {
                    $repas[6] = Repas::TYPEREPAS;
                }
                $monRepas = new Repas($repas, "saisi");

                // enregistre le repas dans la BD
                $pdo->setLeRepas($maSem, $numrep, $monRepas);

                $monRepasAffiche = new V_Repas($monRepas, $maSem->getLundi(), true);
               
                if ($numrep % 2 === 0) {
                    $bg = "midi saisi";
                } else {
                    $bg = "soir saisi";
                }
                 include 'vues/v_affichageRepasSaisi.php';
                $numrep++;
                if ($numrep >= 9) {
                    break;
                }
            }
        case 'f': {// affichage du formulaire de saisie
                $unRepas = new Repas($pdo->getLeRepas($maSem, $numrep));
                $menu = new V_Repas($unRepas, $maSem->getLundi(), true);
                include 'vues/v_formulaireRepas.php';break;
            }
        default : {// erreur d'aiguillage :  le code action n'est pas connu
                include 'vues/v_erreur.php';
            }
    }
}
