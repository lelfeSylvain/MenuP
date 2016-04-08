<?php

    include_once 'inc/class.MakeLog.php';
/**
 * Modèle du projet : permet d'accéder aux données de la BD
 * La classe est munie d'un outil pour logger les requêtes
 *
 * @author sylvain
 * @date janvier-février 2016
 */
class PDOMenu {
    // paramètres d'accès au SGBD
    private static $serveur='mysql:host=localhost';
    private static $bdd='dbname=sylvain';   		
    private static $user='sylvain' ;    		
    private static $mdp='sylvain' ;
    // préfixe de toutes les tables
    public static $prefixe='menu2_';
    // classe technique permettant d'accéder au SGBD
    private static $monPdo;
    // pointeur sur moi-même (pattern singleton)
    private static $moi=null; 
    // active l'enregistrement des logs
    private  $modeDebug=true;
    private $monLog;
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */				
    private function __construct(){
	PdoMenu::$monPdo = new PDO(PdoMenu::$serveur.';'.PdoMenu::$bdd, PdoMenu::$user, PdoMenu::$mdp); 
        PdoMenu::$monPdo->query("SET CHARACTER SET utf8");
        // initialise le fichier log
        $this->monLog = new MakeLog("erreurSQL","./","w");
            
    }
    public function __destruct(){
            PdoMenu::$monPdo = null;
    }
/**
 * Fonction statique qui crée l'unique instance de la classe
 * Appel : $instancePdoMenu = PdoMenu::getPdoMenu();
 * @return l'unique objet de la classe PdoMenu
 */
    public  static function getPdoMenu(){
            if(PdoMenu::$moi==null){
                    PdoMenu::$moi= new PdoMenu();
            }
            return PdoMenu::$moi;  
    }
    
	// enregistre la dernière requête faite dans un fichier log
    private function logSQL($sql){
        if ($this->modeDebug) {
            $this->monLog->ajouterLog($sql);
        }
    }
   	
    /** renvoie les informations sur un utilisateur dont le pseudo est passé en paramètre
     * 
     * @param type $name : pseudo de l'utilisateur
     * @return type toutes les informations sur un utilisateur
     */
    public function getInfoUtil($name){
        $sql="select num, pseudo,  mdp,  tsDerniereCx from ".PdoMenu::$prefixe."user where pseudo='".$name."'";
        $this->logSQL($sql);
        $rs = PdoMenu::$monPdo->query($sql);
        $ligne = $rs->fetch();
        return $ligne;    
    }
    
    /** met à jour la dernière connexion/activité d'un utilisateur
     * 
     * @param type $num : id de l'utilisateur
     */
    public function setDerniereCx($num){
        $date = new DateTime();
        $sql="update ".PdoMenu::$prefixe."util set tsDerniereCx ='".$date->format('Y-m-d H:i:s')."' where num=".$num;
        $this->logSQL($sql);
        $rs =  PdoMenu::$monPdo->exec($sql);
    }
    
    /** insère un nouvel utilisateur dans la base
     * 
     */
    // TODO : Pour le moment, on ajoute que le pseudo et le mdp
    // il faut aussi enregistrer les autres propriétés
    public function setNouveauUtil($pseudo,$mdp){
        $sql="insert into ".PdoMenu::$prefixe."util (pseudo, mdp) values ('".$pseudo."','".$mdp."')";
        $this->logSQL($sql);
        $rs =  PdoMenu::$monPdo->exec($sql);
        return $rs;
    }
	
    /** renvoie tous les menus d'une semaine passée en paramètre dans un tableau 
     * 
     */
    public function getLesMenus($uneSem){
        if (is_object($uneSem)) {
            if (get_class($uneSem)==="Semaine"){
                $sql="select * from ".PdoMenu::$prefixe."repas where numsema=".$uneSem->getNumsem()." and annee=".$uneSem->getAnnee()." order by numserv";
                $this->logSQL($sql);
                $rs = PdoMenu::$monPdo->query($sql);
                $result= $rs->fetchAll();
            }
        }
        return $result;
    }
  
    /** renvoie le menu d'un repas d'une semaine passée en paramètre dans un tableau 
     * 
     */
    public function getLeRepas($uneSem,$num){
        if (is_object($uneSem)) {
            if (get_class($uneSem)==="Semaine"){
                $sql="select * from ".PdoMenu::$prefixe."repas where numsema=".$uneSem->getNumsem()." and annee=".$uneSem->getAnnee()." and numserv=".$num;
                $this->logSQL($sql);
                $rs = PdoMenu::$monPdo->query($sql);
                $result= $rs->fetch();
            }
        }
        return $result;
    }
    

    
}
