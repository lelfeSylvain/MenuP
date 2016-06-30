/*
 * converti le mot de passe saisi en mot de passe crypté
 * dans le formulaire login
 */
function doChallengeResponse() {
    str = "f4G4k2#e33&" + document.identification.password.value;
    document.identification.reponse.value = MD5(str);
    document.identification.mot_de_passe.value = "";

}

/*
 * analyse le nouveau mot de passe saisi 
 * dans le formulaire chngerMDP
 */
function changerMDP() {
    var reponse =true;
    var ancien =  document.identification.ancien.value;
    var nouveau =  document.identification.nouveau.value;
    var confirmation =  document.identification.confirmation.value;
    var msg = document.getElementById('msg');
    alert(ancien +" "+nouveau+" "+confirmation+' '+msg.innerHTML);
    if (nouveau === confirmation) {} else {
        msg.innerHTML += " Les deux mots de passe sont différents.";
        reponse = false;
    }
    return reponse;
}