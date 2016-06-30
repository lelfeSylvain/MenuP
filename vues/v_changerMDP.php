Changer votre mot de passe </div>

</header>
<?php
echo $texteNav;
?>
<form method="post" action="index.php?uc=changer&num=check" name='identification' class="formulaireLogin" >
    <div class='formulaireLigneRadio'>               
        Saisissez votre ancien mot de passe puis deux fois le nouveau. Un bon mot de passe comporte au moins 8 caractères, n'est ni une date, n'est ni un 
        nom commun, ni un nom propre. En outre, il doit contenir au moins une majuscule, au moins un minuscule, au moins un chiffre et au moins un symbole.
    </div>
    <div class='formulaireLigneChamp'>
        <p class="palibel2">Ancien mot de passe  :</p>
        <input type="password" name="ancien" value="" required id="ancien">
    </div>
    <div class='formulaireLigneChamp'>
        <p class="palibel2">Nouveau mot de passe  :</p>
        <input type="password" name="nouveau" value="" id="nouveau" required pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[&#-_@=+*/?.!$<>]).{8,30}$">
    </div>
    <div class='formulaireLigneChamp'>
        <p class="palibel2">Confirmation : </p>
        <input type="password" name="confirmation" value="" id="confirmation" required pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[&#-_@=+*/?.!$<>]).{8,30}$">
        <input type="submit" value="Changer" id="btnChanger" class="boutonConnexion">
    </div>
    <label id="msg">Tous les champs sont obligatoires.</label>

    <input type="hidden" name="reponse"  value="" size=32>
</form>

<script>
    var reponse = true;
    var ancien = document.getElementById('ancien');
    var nouveau = document.getElementById('nouveau');
    var confirmation = document.getElementById('confirmation');
    var msg = document.getElementById('msg');
    var btnChanger = document.getElementById('btnChanger');
    confirmation.addEventListener('change', function (e) {
        if (nouveau.value === confirmation.value) {
            btnChanger.disabled = false;
            msg.innerHTML = "Tous les champs sont obligatoires.";
        } else {
            msg.innerHTML = "Tous les champs sont obligatoires. Les deux mots de passe sont différents.";
            btnChanger.disabled = true;
        }
    });
    nouveau.addEventListener('change', function (e) {
        if (nouveau.value === confirmation.value) {
            btnChanger.disabled = false;
            msg.innerHTML = "Tous les champs sont obligatoires.";
        } else {
            msg.innerHTML = "Tous les champs sont obligatoires. Les deux mots de passe sont différents.";
            btnChanger.disabled = true;
        }
    });

</script>