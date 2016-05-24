<form action="index.php?uc=ecrire&num=v<?php echo $dateSem.$numrep; ?>" method="post" name ="repas" class="formulaireSaisie">
    
    <?php
        echo  "<div class='dateFormulaireSaisie'>".$maSem->getDateService($numrep)."</div>".EOL;
        $menu->afficherFormulaireRepas();
    ?>
</form>
