<form action="index.php?uc=ecrire&num=v<?php echo $dateSem.$numrep; ?>" method="post" id="frmSaisi" name ="repas" class="formulaireSaisie">
    
    <?php
        echo  "<div class='dateFormulaireSaisie'>".$maSem->getDateService($numrep)."</div>".EOL;
        $menu->afficherFormulaireRepas();
    ?>
</form>
<script>
    var monResetButton= document.getElementById('resetbutton');
    
    var monRadioRepas= document.getElementById('radiorepas');
    var monRadioMessage= document.getElementById('radiomessage');
    var monChampRequis = document.getElementById('mesRequis');
    monRadioMessage.addEventListener('click',function(e) {
        monChampRequis.required=true;
    });
    monResetButton.addEventListener('click',function(e) {
        monChampRequis.required=false;
    });
    monRadioRepas.addEventListener('click',function(e) {
        monChampRequis.required=false;
    });
</script>
   
