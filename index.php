<!DOCTYPE html>
<?php 
/* Projet menu du self v2 
sylvain mars 2016
*/
    require_once  'inc/fonctions.php';
	
    //s'il n'y a pas d'uc alors on consulte le menu
	 if(!isset($_REQUEST['uc'])){ 
        $_REQUEST['uc'] = 'lecture';
        $_REQUEST['num'] = 'actuelle';
     }
    // si l'utilisateur n'est pas identifié, il doit le faire
    if (!Session::isLogged()) {
        include('controleurs/c_semaine.php');
    }
    else {  // à partir d'ici, l'utilisateur est forcément connecté
        // instanciation de la fabrique de vue
        $vue = FabriqueVue::getFabrique();
        
        // justement on enregistre la dernière activité de l'utilisateur dans la BD
        $pdo->setDerniereCx($_SESSION['numUtil']);
        // actions ?
        if(!isset($_REQUEST['uc'])){ //s'il n'y a pas d'uc alors on consulte les posts
            $_REQUEST['uc'] = 'lecture';
            $_REQUEST['num'] = 'tout';
        }	 
        $uc = $_REQUEST['uc'];
        // gère le fil d'ariane
        include_once 'controleurs/c_ariane.php';
        
        //aiguillage principal
        switch($uc){
            case 'lecture':{// uc lecture des posts
                include("controleurs/c_lecture.php");break;
            }
            case 'creer':{// uc création d'un post ou rubrique
                include("controleurs/c_creation.php");break;
            }
            default :  // par défaut on consulte les posts
                include("controleurs/c_lecture.php");
        }
    }
    include("vues/v_pied.php") ;



/* ici commence l'ancienne version
    
    <?php 
	include_once("biblioRepas.php");
	include_once("class.pdomenu.inc.old.php");
	entete("Accueil");
	$pdo=connexionBD();
	//vérification  des logins (le formulaire a-t-il été appelé depuis password.php ?
	if (isset($_POST['login']) and isset($_POST['password']))
	{
		$login=clean($_POST['login']);
		$password=clean($_POST['password']);
		$sql="SELECT * FROM ".PdoMenu::$prefixe."user WHERE pseudo='".$login."' AND passwd=PASSWORD('".$password."')";
		if ($result=sqlexe($sql))
		{
			$_SESSION['user']=$result['pseudo'];
			echo "<P class='accueil'>Bonjour ".$login.", votre dernière connexion a eu lieu le : ".date('j/m/Y à  H:i:s', $result['time'])."</P>";
			$sql="UPDATE ".PdoMenu::$prefixe."user SET time=" . time() . " WHERE pseudo='".$_SESSION['user']."'";
			$donnees=sqlexe($sql);
		}
		else
		{
			$_SESSION['user']="visiteur";
			if ($login<>"")
				$espace=" ";
			else
				$espace="";
			echo "<P class='accueil'>Bonjour".$espace.$login.", vous êtes connecté en tant que visiteur !!</P>";
		}
	}
?>
		<form action="semaine.php" method="post">
			   <P class='accueil'>Bienvenue <?php if ($_SESSION['user']<>"visiteur") echo $_SESSION['user']; ?> sur le site du service de restauration de la cité scolaire de Bertran-de-Born.
				<div class="accueil">Cliquez sur le bouton pour voir le menu de la semaine 
				<?php 
				$madate =recalculerDate();
				$numsem= $madate->format('W');
				$_SESSION['numsem']=$numsem;
				$_SESSION['annee']=$madate->format('Y');
				$sql="SELECT deb,fin FROM ".PdoMenu::$prefixe."semaine WHERE num ='".$numsem."' AND annee='" .$_SESSION['annee']."'";
				$datedonnees=sqlexe($sql);
				$currentDate = new DateTime($datedonnees['deb']);
				$endDate     = new DateTime($datedonnees['fin']);
				echo $numsem." du ". $currentDate -> format('j/m/Y')." au ". $endDate -> format('j/m/Y');
				?></div>
			<?php
				echo '<input type="'.$_SESSION['debug'].'" value="'.$numsem.'" name="numsem" size="20"/>';
				echo '<input type="'.$_SESSION['debug'].'" value="'.$_SESSION['annee'].'" name="annee" size="20"/>';
			?>
			<div> </div><div> </div>
			<div class="accueil"><input type="submit" value="Voir le menu" /></div></p>
		</form>
		<?php
		if ($_SESSION['user']<>"visiteur")
		{
	?>
	<form action="password.php" method="post">
		<table class="invisible"><caption class="invisible">Vous pouvez changer votre mot de passe :</caption>
		<tr class="invisible"><td class="invisible">Nom d'utilisateur :</td><td class="invisible"><input type="text" value="" name="login" size="30"/></td></tr>
		<tr class="invisible"><td class="invisible">Ancien mot de Passe :</td><td class="invisible"><input type="password" value="" name="password" size="30"/></td></tr>
		<tr class="invisible"><td class="invisible">Nouveau mot de Passe :</td><td class="invisible"><input type="password" value="" name="newpassword" size="30"/></td></tr>
		<tr class="invisible"><td class="invisible">Répéter mot de Passe :</td><td class="invisible"><input type="password" value="" name="newpassword2" size="30"/></td></tr>
		<tr class="invisible"><td class="invisible"></td><td class="invisible"><input type="submit" value="Changer" /></td></tr></table>
	</form>
		<?php 
		}
		pied();
		if ($_SESSION['user']=="debug")
			phpinfo(); ?>
	</body>
</html>
*/ 