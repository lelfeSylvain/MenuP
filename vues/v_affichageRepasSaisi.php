<?php
echo "<div class='formulaireSaisie'>".EL;
echo "Vous venez de saisir le repas suivant :" . EL . "<div class='dateFormulaireSaisie'>".$maSem->getDateService($numrep)."</div>" . EOL;
$monRepasAffiche->afficherRepas($bg, $numrep);
echo "</div>";
