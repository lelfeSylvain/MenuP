<?php
require_once 'inc/class.Repas.php';

/**
 * classe qui met en forme une case repas.
 *
 * @author sylvain
 */
class V_Repas {

    private $unRepas; //de type Repas
    private $estConnecte; // booléen
    private $semaine; // de type Date

    public function __construct($unRepas, $s, $estConnecte = false) {
        $this->unRepas = $unRepas;
        $this->semaine = $s;
        $this->estConnecte = $estConnecte;
    }

    public function afficherFormulaireRepas() {
        // par défaut c'est vide
        $titre = '';
        $plat = '';
        $entree = '';
        $titreMes = '';
        $message = '';
        $lait = 'Fromage ou yaourt nature';
        $dessert = '';
        $txtbtn = "Valider";
        if ($this->unRepas->estCommunique()) {
            $titre = $this->unRepas->getTitre();
            $entree = $this->unRepas->getEnt();
            $plat = $this->unRepas->getPlat();
            $lait = $this->unRepas->getLait();
            $dessert = $this->unRepas->getDes();
            $titreMes = $this->unRepas->getTitre();
            $message = $this->unRepas->getPlat();
            $txtbtn = "Modifier";
        }
        if (!$this->unRepas->estMessage() || ($this->unRepas->estMessage() && !$this->unRepas->estCommunique())) {
            $chkmenu = 'checked = "checked"';
            $chkmess = '';
            $titreMes = '';
            $message = '';
        } else {
            $chkmess = 'checked = "checked"';
            $chkmenu = '';
            $titre = '';
            $plat = '';
        }

        // ********************************* les champs **************************
        ?>
        <section class='formulaireBoutonRAdio'>
            <div class='formulaireLigneRadio'>
                <input type = "radio" name = "message" value = "repas"  <?php echo $chkmenu; ?> />
                <p class="palibel"> Repas</p>
            </div>
            <div class='formulaireLesChamps'>

                <div class='formulaireLigneChamp'>
                    <p class="palibel">Titre  :</p>
                    <input type="text" size="120" name="titm" placeholder="un titre pour ce menu" class="pachamp" value="<?php echo $titre; ?>">
                </div>
                <div class='formulaireLigneChamp'>
                    <p class="palibel">Entrée :</p>
                    <input type="text" size="120" name="ent" placeholder="liste des entrées" class="pachamp" value="<?php echo $entree; ?>"> 
                </div>
                <div class='formulaireLigneChamp'>
                    <p class="palibel">Plat :</p>
                    <input type="text" size="120" name="plat" placeholder="liste des plats" class="pachamp" value="<?php echo $plat; ?>">
                </div>  
                <div class='formulaireLigneChamp'>                
                    <p class="palibel">Laitage :</p>
                    <input type="text" size="120" name="lait"  class="pachamp" value="<?php echo $lait; ?>">
                </div>
                <div class='formulaireLigneChamp'>
                    <p class="palibel">Dessert :</p>
                    <input type="text" size="120" name="des" placeholder="liste des desserts" class="pachamp" value="<?php echo $dessert; ?>"> 
                </div>
            </div>
        </div>
        </section>
        <section class='formulaireBoutonRadio'>
            <div class='formulaireLigneRadio'>
                <input type = "radio" name = "message" value = "message"  <?php echo $chkmess; ?> /> 
                <p class="palibel2">Message</p>
            </div>
            <div class='formulaireLesChamps'>

                <div class='formulaireLigneChamp'>
                    <p class="palibel2">Texte principal :</p>
                    <input type="text" size="114" name="mes1" placeholder="jour férié par exemple"  value="<?php echo $titreMes; ?>">
                </div>
                <div class='formulaireLigneChamp'>
                    <p class="palibel2">Commentaire :</p>
                    <input type="text" size="114" name="mes2" placeholder="un complément d'information" value="<?php echo $message; ?>">
                </div>
            </div>
        </section>

        <?php // *************************les boutons ****************************** ?>
<section class="formulaireBoutonValidation">
        <input type="reset" value="Effacer" class="boutonValidation"/>
        <input type="submit"  value="<?php echo $txtbtn; ?>" class="boutonValidation"/>
</section>
        <?php
    }

    /*
     * Affichage de la case repas dans le menu hebdomadaire.
     * $bg :
     * $i : numéro du service (0 : lundi midi, 1 : lundi soir etc.
     */

    public function afficherRepas($bg, $i) {
        if ($this->getRepas()->getTypeCase() === Repas::TYPEREPAS) {
            ?>
            <section class='unecase <?php echo $bg; ?>' id='r<?php echo $i; ?>'>
                <header>
                    <?php echo $this->getRepas()->getTitre() . EL; ?>
                </header>
                <section class='repas' >   
                    <div class='entree'>
                        <?php echo $this->getRepas()->getLigne(1) . EL; ?>
                    </div>
                    <div class='plat'>
                        <?php echo $this->getRepas()->getLigne(2) . EL; ?>
                    </div>
                    <div class='lait'>
                        <?php echo $this->getRepas()->getLigne(3) . EL; ?>
                    </div>
                    <div class='dessert'>
                        <?php echo $this->getRepas()->getLigne(4) . EL; ?>
                    </div>
                    <?php
                    $this->afficheBouton($this->estConnecte, $this->unRepas->estCommunique(), $this->semaine->format('Y-m-d'), $i);
                    ?>
                </section>
            </section>
            <?php
        } else {
            ?>
            <section class='unecase <?php echo $bg; ?>' id='r<?php echo $i; ?>'>
                <header>
                    <?php echo $this->getRepas()->getTitre() . EL; ?>
                </header>
                <section class='repas' >   
                    <div class='plat'>
                        <?php echo $this->getRepas()->getLigne(2) . EL; ?>
                    </div>
                    <?php
                    $this->afficheBouton($this->estConnecte, $this->unRepas->estCommunique(), $this->semaine->format('Y-m-d'), $i);
                    ?>
                </section>
            </section>
            <?php
        }
    }

    /*
     * privée affiche correctement le bouton Saisir ou Modifier
     */

    private function afficheBouton($estConnecte, $estCommunique, $jour, $i) {
        if ($estConnecte) {// on ajoute un bouton
            if ($estCommunique) {
                $txtbtn = "Modifier";
                $num = "f";
            } else {
                $txtbtn = "Saisir";
                $num = "f";
            }
            ?>
            <form method="post" action="index.php?uc=ecrire&num=<?php echo $num . $jour . $i; ?>" name='btnrepas<?php echo $i; ?>'>
                <input type="submit" value="<?php echo $txtbtn; ?>" >
            </form>
            <?php
        }
    }

    /*
     * Renvoie un repas de tpe Repas
     */

    public function getRepas() {
        return $this->unRepas;
    }

}
