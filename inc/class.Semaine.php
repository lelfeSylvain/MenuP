<?php

/**
 * classe pour gérer la notion de semaine.
 *
 * @author sylvain
 */
class Semaine {

    private $annee;
    private $numSem;
    private $lundi; //de type date
    private $vendredi; //de type date

    public function __construct($date = "", $format = "Y-m-d") {
        if ($format === "Y-m-d") {
            $this->recalculerDate($date);
        } else {
            $this->recalculerDateSemaine($date);
        }
    }

    public function __destruct() {
        unset($annee, $numSem, $lundi, $vendredi);
    }

    /**
     * initialise la classe
     * @param type $date
     */
    private function recalculerDate($date = "") {
        $madate = new DateTime($date);
        $this->numSem = $madate->format('W');
        $this->annee = $madate->format('Y');
        // on cherche le lundi: N==1
        while ($madate->format('N') != 1) {
            //echo 'recherche du lundi '.$debdate -> format('N')." ".$debdate -> format('Y-m-d').'<br>';
            $madate->modify('-1 day');
        }
        $this->lundi = new DateTime($madate->format("Y-m-d"));
        // la fin de la semaine, c'est 4 jours après			
        $this->vendredi = $madate->modify('+4 day');
    }

    /**
     * initialise la classe à partir d'un format YW
     * @param type $date : String
     */
    private function recalculerDateSemaine($date) {
        $annee = substr($date, 0, 4);
        $semaine = substr($date, 4, 2);
        //echo "année :" . $annee . " semaine : " . $semaine . "<br />";
        $maDate = new DateTime($annee . "-07-01");
        $calcul = $this->dichotomie($maDate, $annee, $semaine, 182);
        $this->recalculerDate($calcul->format("Y-m-d"));
        
    }

    private function estPlusGrand($maDate, $annee, $semaine) {
        if ($maDate->format("Y") > $annee)
            return true;
        else if ($maDate->format("Y") < $annee)
            return false;
        else if ($maDate->format("W") > $semaine)
            return true;
        return false;
    }

    private function dichotomie($maDate, $annee, $semaine, $pas) {
        if ($semaine < 10)
            $zero = "0";
        else
            $zero = "";
        if ($maDate->format("YW") === $annee . $zero . $semaine) {
            return $maDate;
        }
        if ($pas < 8) {
            $pas = 7;
        } else {
            $pas = (int) ($pas / 2);
        }
        if ($this->estPlusGrand($maDate, $annee, $semaine)) {
            $maDate->modify("-" . $pas . " day");
        } else {
            $maDate->modify("+" . $pas . " day");
        }
        return $this->dichotomie($maDate, $annee, $semaine, $pas);
    }

    /**
     * renvoie le numéro de la semaine dans l'année
     * @return type : integer de 1 à 53
     */
    public function getNumsem() {
        return $this->numSem;
    }

    /**
     * renvoie l'année de la semaine
     * @return type : integer
     */
    public function getAnnee() {
        return $this->annee;
    }

    /**
     * renvoie la semaine sous la forme aaaass
     * @return type : integer
     */
    public function getAnneeSem() {
        /* if ($this->numSem <10) $num='0'.$this->numSem;
          else */
        $num = $this->numSem;
        return $this->annee . $num;
    }

    /**
     * calcule la date du lundi de la semaine
     * @return type date 
     */
    public function getLundi() {
        return clone $this->lundi;
    }

    /**
     * calcule la date du vendredi de la semaine
     * @return type date 
     */
    public function getVendredi() {
        return clone $this->vendredi;
    }

    /**
     * calcule la date de la semaine prochaine
     * @return la date de la semaine prochaine en String
     */
    public function getDateSemaineProchaine() {
        $unedate = clone $this->lundi;
        $unedate->modify("+7 days");
        return $unedate->format('Y-m-d');
    }

    /**
     * calcule la date de la semaine prochaine
     * @return nouvelle instance de Semaine 
     */
    public function getSemaineProchaine() {
        return new Semaine($this->getDateSemaineProchaine());
    }

    /**
     * calcule la date de la semaine precedente
     * @return la date de la semaine precedente en String
     */
    public function getDateSemaineDerniere() {
        $unedate = clone $this->lundi;
        $unedate->modify("-7 days");
        return $unedate->format('Y-m-d');
    }

    /**
     * calcule la date de la semaine precedente
     * @return nouvelle instance de Semaine 
     */
    public function getSemaineDerniere() {
        return new Semaine($this->getDateSemaineDerniere());
    }

    public function getDateService($numserv) {
        $tabJour = array("lundi ", "mardi ", "mercredi ", "jeudi ", "vendredi ");
        $tabMois = array("janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
        $day = (int) ($numserv / 2);
        $rep = $tabJour[$day];
        $aujourdhui = clone $this->lundi;
        $aujourdhui->modify("+" . $day . " days");
        $service = "soir";
        if ($numserv % 2 === 0) {
            $service = "midi";
        }
        return $rep . $aujourdhui->format(" d ") . $tabMois[$aujourdhui->format("m") - 1] . $aujourdhui->format(" Y ") . $service;
    }

    public function getDateLundi() {
        return $this->lundi->format('Y-m-d');
    }

}
