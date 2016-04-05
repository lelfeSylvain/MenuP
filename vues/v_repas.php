<?php 

    if ($this->getRepas()->getTypeCase() === Repas::$TYPEREPAS) {
?>
    <section class='unecase <?php echo $bg; ?>' id='r<?php echo $i; ?>'>
        <header>
            <?php echo $this->getRepas()->getTitre().EL; ?>
        </header>
        <section class='repas' >   
            <div class='entree'>
                <?php echo $this->getRepas()->getLigne(1).EL; ?>
            </div>
            <div class='plat'>
                <?php echo $this->getRepas()->getLigne(2).EL; ?>
            </div>
            <div class='lait'>
                <?php echo $this->getRepas()->getLigne(3).EL; ?>
            </div>
            <div class='dessert'>
                <?php echo $this->getRepas()->getLigne(4).EL; ?>
            </div>
        </section>
    </section>
<?php
    }
    else {
        ?>
    <section class='unecase <?php echo $bg; ?>' id='r<?php echo $i; ?>'>
        <header>
            <?php echo $this->getRepas()->getTitre().EL; ?>
        </header>
        <section class='repas' >   
            <div class='plat'>
                <?php echo $this->getRepas()->getLigne(2).EL; ?>
            </div>
        </section>
    </section>
<?php
    }
