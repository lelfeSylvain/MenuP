Changer votre mot de passe </div>

</header>
<?php
echo $texteNav;
?>
<form method="post" action="index.php?uc=changer&num=check" name='identification' class="formulaireLogin">
    <div class='formulaireLigneRadio'>               
        Saisissez votre ancien mot de passe puis deux fois le nouveau. Un bon mot de passe comporte au moins 8 caractères, n'est ni une date, n'est ni un 
        nom commun, ni un nom propre. En outre, il doit contenir au moins une majuscule, au moins un minuscule, au moins un chiffre et au moins un symbole.
    </div>
    <div class='formulaireLigneChamp'>
        <p class="palibel2">Ancien mot de passe  :</p>
        <input type="password" name="ancien" value="" required>
    </div>
    <div class='formulaireLigneChamp'>
        <p class="palibel2">Nouveau mot de passe  :</p>
        <input type="password" name="nouveau" value="" required pattern="[A-Za-z0-9&#-_@=+*/?.!$<>]{8,30}">
    </div>
    <div class='formulaireLigneChamp'>
        <p class="palibel2">Confirmation : </p>
        <input type="password" name="password" value="" required pattern="[A-Za-z0-9&#-_@=+*/?.!$<>]{8,30}">
        <input type="submit" value="Changer" onClick="changerMDP();" class="boutonConnexion">
    </div>

    
    <input type="hidden" name="reponse"  value="" size=32>
</form>