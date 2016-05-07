<?php
require_once  'inc/class.Semaine.php';
require_once  'vues/class.V_Repas.php';
// quel jour sommes-nous ?
if (empty($_POST['date'])) {
    $m = new DateTime();
    $maDate = $m->format("Y-m-d");
    unset($m);
} else {
    $maDate = clean($_POST['date']);
}
if (isset($_REQUEST['num'])) {
    $num = clean($_REQUEST['num']);
} else {
    $num = "";
}

$maSem = new Semaine($maDate);
$jour = $maSem->getLundi();
for ($i = 0; $i < 9; $i++) {
    $LesMenus[$i] = new V_Repas(new Repas($pdo->getLeRepas($maSem, $i )),  $jour, isset($_SESSION['pseudo']));
}
$estMatin = "matin";
$selection=11;
if ($num === "actuelle") {// on consulte le menu de la semaine actuelle
    // le prochain repas
    // Quelle heure est-il ?
    $maintenant = new DateTime();
    $h = $maintenant->format("H");
    // Quel jour sommes-nous ? 1 : lundi, 5 : vendredi
    // *2 => 2 : lundi soir, 10 : vendredi soir
    $j = $maintenant->format("N") * 2;
    if ($h > 13) {
        $estMatin = "soir";
    } else {
        // si on pointe sur le matin on est sur le service du midi
        $estMatin = "matin";
        $j--;
    }
    // mais on peut être le week-end aussi
    if ($j > 9) { // du coup on recalcule tout
        $j = 1;
        $maSem = $maSem->getSemaineProchaine();
        $estMatin = "matin";
        $jour = $maSem->getLundi();
        for ($i = 0; $i < 10; $i++) {
            $LesMenus[$i] = new V_Repas(new Repas($pdo->getLeRepas($maSem, $i )), $jour, isset($_SESSION['pseudo']));
        }
    }
    // Service à mettre en valeur 
    $selection = $j;
}
//gestion du vendredi soir
$LesMenus[9] = new V_Repas(new Repas("vendredi"), $jour, false);

include 'vues/v_semaine.php';

