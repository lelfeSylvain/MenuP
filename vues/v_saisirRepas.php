<form action="index.php?uc=ecrire&num=v<?php echo $num; ?>" method="post" name ="repas">
    
    <?php
        echo $maSem->getDateService($numrep).EOL;
        $menu->afficherFormulaireRepas();
    ?>
</form>
