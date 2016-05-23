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
        <input type = "radio" name = "message" value = "repas"  <?php echo $chkmenu; ?> /> Repas<br />
        Titre  : <input type="text" size="110" name="titm" placeholder="un titre pour ce menu" value="<?php echo $titre; ?>"> <br />
        Entrée : <input type="text" size="110" name="ent" placeholder="liste des entrées" value="<?php echo $entree; ?>"> <br />
        Plat : <input type="text" size="110" name="plat" placeholder="liste des plats" value="<?php echo $plat; ?>"><br />
        Laitage : <input type="text" size="110" name="lait"  value="<?php echo $lait; ?>"><br />
        Dessert : <input type="text" size="110" name="des" placeholder="liste des desserts" value="<?php echo $dessert; ?>"> <br />
        <input type = "radio" name = "message" value = "message" <?php echo $chkmess; ?> /> Message <br />
        Texte principal : <input type="text" size="110" name="mes1" placeholder="jour férié par exemple"  value="<?php echo $titreMes; ?>"> <br />
        le commentaire : <input type="text" size="110" name="mes2" placeholder="un complément d'information" value="<?php echo $message; ?>"><br />
        <?php // *************************les boutons ****************************** ?>
        <input type="reset" class="boutonsinserer" value="Effacer"/>
        <input type="submit" class="boutonsinserer" value="<?php echo $txtbtn; ?>"/>
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
                    $txtbtn= "Modifier";
                    $num="f";
                } else {
                    $txtbtn= "Saisir";
                    $num="f";
                }
            ?>
            <form method="post" action="index.php?uc=ecrire&num=<?php echo $num.$jour . $i; ?>" name='btnrepas<?php echo $i; ?>'>
                <input type="submit" value="<?php echo $txtbtn;?>" >
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
