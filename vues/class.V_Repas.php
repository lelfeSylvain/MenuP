<?php
require_once 'inc/class.Repas.php';
/**
 * classe qui met en forme une case repas.
 *
 * @author sylvain
 */
class V_Repas {
    private $unRepas;
     public function __construct($unRepas) {
        $this->unRepas = $unRepas;
     }
     
     public function afficherRepas($bg,$i){
        include ("vues/v_repas.php");
    }
    
    public function getRepas(){
        return $this->unRepas;
    }
}
