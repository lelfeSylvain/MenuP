
<form method="post" action="index.php?uc=login" name='identification'>
    Pour se connecter : <br>
    Identifiant  : <input type="text" name="login" value="<?php echo $login; ?>"> <br>
    Mot de passe : <input type="password" name="password" value="<?php echo $mdp; ?>">
    <input type="submit" value="Connexion" onClick="doChallengeResponse();">
    <input type="hidden" name="reponse"  value="" size=32>
</form>

