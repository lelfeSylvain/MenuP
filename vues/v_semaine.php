<?php
/* * **** Affichage de l'entete ******** */
echo "Semaine n° " . $maSem->getNumsem() . " du " . $maSem->getLundi()->format('d/m/Y') . " au " . $maSem->getVendredi()->format('d/m/Y');
echo "</div>" . EL . "</header>" . EL . "<section class='menu'>" . EL;


for ($i = 0; $i < 10; $i++) {// debut boucle des repas
    if ($i % 2 == 0) {
        $bg = "midi" . $estMatin;
        echo "<section class='ligneMenu'>" . EL;
        ?>
        <section class='jour smallscreen'>
            <div class='j1'>
                <?php echo $tabJour[$i / 2] ."</div><div class='j1'>" . $jour->format(" j ") . "</div><div class='j1'>" . $tabMois[(int) ($jour->format("m")) - 1]; ?>
            </div>
        </section>
        <?php
    } else {
        $bg = "soir" . $estMatin;
        ?>

        <section class='jour largescreen'>
            <?php echo $tabJour[$i / 2] . EOL . $jour->format(" j ") . EOL . $tabMois[(int) ($jour->format("m")) - 1]; ?>
        </section>
        <?php
        $jour->modify("+1 day");
    }
    if ($i + 1 === $numservSelectionne) {
        $bg.=' selection';
    }
    $LesMenus[$i]->afficherRepas($bg, $i);

    if ($i % 2 == 1) {
        echo "</section>" . EL; // ligneMenu
    }
}// fin boucle des repas
/* * **** Affichage des boutons ******** */
echo "<nav class='principal'>" . EL;
// précédent 
echo "<div class='boutons'>\n\t<form action='index.php?uc=lecture&num=precedent' method='post'>" . EL;
echo "\t\t<input type='" . $_SESSION['debug'] . "' name='date' value='" . $maSem->getDateSemaineDerniere() . "'>" . EL;
echo "\t\t<input type='submit' value='<- Semaine Précédente'>" . EL;
echo "\t</form>\n</div>" . EL;
// actuelle (si nécessaire)
if ($num !== "actuelle") {
    echo "<div class='boutons'>\n\t<form action='index.php?uc=lecture&num=actuelle' method='post'>" . EL;

    echo "\t\t<input type='submit' value='Aujourd&#39;hui'>" . EL;
    echo "\t</form>\n</div>" . EL;
}
// suivant
echo "<div class='boutons'>\n\t<form action='index.php?uc=lecture&num=suivant' method='post'>" . EL;
echo "\t\t<input type='" . $_SESSION['debug'] . "' name='date' value='" . $maSem->getDateSemaineProchaine() . "'>" . EL;
echo "\t\t<input type='submit' value='Semaine Suivante ->'>" . EL;
echo "\t</form>\n</div>" . EL;

echo "</nav>" . EL;
/* * **** Fin d'affichage des boutons ******** */
echo "</section>" . EL; // fin de la dscription d'un menu

 
