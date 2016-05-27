<?php

require_once 'inc/class.Semaine.php';
require_once 'vues/class.V_Repas.php';
// quel jour sommes-nous ?
$maintenant = new DateTime();
if (empty($_POST['date'])) {
    $maDate = $maintenant->format("Y-m-d");
} else {
    $maDate = clean($_POST['date']);
}
// sommes-nous en train de nous promener dans les menus ? Supposons que non : 
$estParcouru=false;
if ($num!=="actuelle") {
    $estParcouru=true;
    $m = new DateTime($maDate);
    if ($maintenant->format("YW") === $m->format("YW")) {
        // on force à actuelle pour afficher la sélection du service
        $num = "actuelle";
    } 
    unset($m);
}
// si la semaine à afficher est la semaine actuelle
// on calcule le service à mettre en valeur
if ($num === "actuelle") {// on consulte le menu de la semaine actuelle
    // le prochain repas
    // Quelle heure est-il ?
    $h = $maintenant->format("H");
    // Quel jour sommes-nous ? 1 : lundi, 5 : vendredi, 7 : dimanche
    // *2 => 2 : lundi soir, 10 : vendredi soir, 14 : dimanche soir
    $numservSelectionne = $maintenant->format("N") * 2;
    if ($h > 13) {// à partir de 14h on s'interesse au repas du soir
        $estMatin = " tantot";
    } else {
        // si on pointe sur le matin on est sur le service du midi
        $estMatin = " matin";
        $numservSelectionne--;
    }
    // mais on peut être le week-end aussi (sauf si on se promène dans les menus)
    if ($numservSelectionne > 9 && !$estParcouru) { // du coup on recalcule la date de la semaine affichée
        $numservSelectionne = 1;
        $maintenant->modify("Monday"); // on passe au lundi suivant
        $maDate = $maintenant->format("Y-m-d");
        $estMatin = " matin";
    }
} else {
    $estMatin = " matin";
    $numservSelectionne = 11;
}
// on récupère dans la BD les services de la semaine et on créé des instances de V_Repas (classe qui affiche les repas).
$maSem = new Semaine($maDate);
$jour = $maSem->getLundi();
for ($i = 0; $i < 9; $i++) {
    $LesMenus[$i] = new V_Repas(new Repas($pdo->getLeRepas($maSem, $i)), $jour, isset($_SESSION['pseudo']));
}

//gestion du vendredi soir
$LesMenus[9] = new V_Repas(new Repas("vendredi"), $jour, false);

include 'vues/v_semaine.php';

