<?php
/****** Affichage de l'entete *********/
echo "<section class='menu'>".EL."<header class='titre'>".EL;
echo "Semaine n° ".$maSem->getNumsem()." du lundi ".$maSem->getLundi()->format('d/m/Y')." au vendredi ".$maSem->getVendredi()->format('d/m/Y');
echo "</header>".EL;
/****** Affichage des boutons *********/
echo "<nav>".EL;
// précédent 
    echo "<div class='boutons'>\n\t<form action='index.php?uc=lecture&num=0' method='post'>".EL;
    echo "\t\t<input type='".$_SESSION['debug']."' name='date' value='".$maSem->getDateSemaineDerniere()."'>".EL;
    echo "\t\t<input type='submit' value='<- Semaine Précédente'>".EL;
    echo "\t</form>\n</div>".EL;
// actuelle (si nécessaire)
if ( $num !== "actuelle") {
    echo "<div class='boutons'>\n\t<form action='index.php?uc=lecture&num=actuelle' method='post'>".EL;
    
    echo "\t\t<input type='submit' value='Aujourd&#39;hui'>".EL;
    echo "\t</form>\n</div>".EL;
}
// suivant
    echo "<div class='boutons'>\n\t<form action='index.php?uc=lecture&num=1' method='post'>".EL;
    echo "\t\t<input type='".$_SESSION['debug']."' name='date' value='".$maSem->getDateSemaineProchaine()."'>".EL;
    echo "\t\t<input type='submit' value='Semaine Suivante ->'>".EL;
    echo "\t</form>\n</div>".EL;

echo "</nav>".EL;
/****** Fin d'affichage des boutons *********/

for ($i=0;$i<10;$i++ ){// debut boucle des repas
    if ($i % 2==0) {
        $bg="midi".$estMatin;
        echo "<section class='ligneMenu'>".EL;
    }
    else {
        $bg="soir".$estMatin;
        ?>
        <section class='jour'>
            <?php echo $tabjour[$i/2].EOL.$jour->format(" j"); ?>
        </section>
<?php
        $jour->modify("+1 day");

    }
    if ($i+1===$selection) $bg.=' selection';
    $LesMenus[$i]->afficherRepas($bg,$i);
    
    if ($i % 2==1) {
        echo "</section>".EL;
    }
 }// fin boucle des repas
echo "</section>".EL;// fin de la dscription d'un menu

 