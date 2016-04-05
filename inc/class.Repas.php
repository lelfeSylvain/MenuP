<?php

/**
 * Description of Repas
 *
 * @author sylvain
 */
class Repas {

    //titm,ent1,ent2,plat,lait,des1,des2,des3,type,mes1,mes2,annee,numsema,numserv,urlimage
    // ligne 0 => Titre, 1 entrées ou rien, 2 plat ou message, 3 laitage, 4 desserts
    private $ligne;
    private $num, $type, $image;
    public static $TYPEMESSAGE = "message";
    public static $TYPEREPAS = "repas";

    public function __construct($unRepas) {
        $communique = true;
        if (!empty($unRepas)) {
            $this->num = $unRepas['numserv'];
            $this->image = $unRepas['urlimage'];
            //est-ce un message ?
            if ($unRepas['type'] === Repas::$TYPEMESSAGE) {
                $this->ligne[0] = $unRepas['mes1'];
                $this->ligne[2] = $unRepas['mes2'];
                $this->type = Repas::$TYPEMESSAGE;
            } elseif ($unRepas['type'] === Repas::$TYPEREPAS and ! $this->estVide($unRepas)) {
                $this->ligne[0] = $unRepas['titm'];
                $this->ligne[1] = $this->format($unRepas, 1, 3);
                $this->ligne[2] = $unRepas['plat'];
                $this->ligne[3] = $unRepas['lait'];
                $this->ligne[4] = $this->format($unRepas, 5, 8);
                $this->type = Repas::$TYPEREPAS;
            } else {// problème dans le type du message ou repas vide
                $communique = false;
            }
        }
        else {// problème dans le type du message ou repas vide
                $communique = false;
            }
        if (!$communique) {
            $this->type = Repas::$TYPEMESSAGE;
            $this->ligne[0] = "Le menu n'a pas été communiqué";
            $this->ligne[2] = "Revenez plus tard";
        }
    }

    private function estVide($unRepas) {
        $trouve = true;
        if (!empty($unRepas)) {
            for ($i = 0; $i < 8; $i++) {
                $trouve = empty($i) && $trouve;
            }
        }
        
        return $trouve;
    }

    public function getTitre() {
        return $this->ligne[0];
    }

    public function getNum() {
        return $this->num;
    }

    public function getPlat() {
        return $this->ligne[2];
    }

    public function getLait() {
        return $this->ligne[3];
    }

    public function getEnt() {
        return $this->ligne[1];
    }

    // permet de concaténer les entrees ou les desserts facilement
    private function format($unRepas, $init, $max) {
        $result = "";
        for ($i = $init; $i < $max; $i++) {
            if (!empty($unRepas[$i])) {
                if (empty($result)) {
                    $result = $unRepas[$i];
                } else {
                    $result.=" ou " . $unRepas[$i];
                }
            }
        }
        return $result;
    }

    public function getDes() {
        return $this->ligne[4];
    }

    public function getTitreMes() {
        return $this->ligne[0];
    }

    public function getMes() {
        return $this->ligne[2];
    }

    public function getLignes(){
        return $this->ligne;
    }
    
    public function getTypeCase(){
        return $this->type;
    }
    
    public function getLigne($i){
        if ($i < 5 and $i > 0) {
            return $this->ligne[$i];
        } else {
            return $this->ligne[0];
        }
    }
    
    
}
