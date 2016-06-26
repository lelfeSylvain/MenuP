/*
 * converti le mot de passe saisi en mot de passe crypté
 * dans le formulaire login
 */
function doChallengeResponse() {
    str = "f4G4k2#e33&" + document.identification.password.value;
    document.identification.reponse.value = MD5(str);
    document.identification.mot_de_passe.value = "";

}
