<?php 

	include_once("biblioRepas.php");	
	$pdo=connexionBD();
	entete("Saisir ou modifier un menu");
	$action = "Saisir";
	if (isset($_POST['annee'] ) and isset($_POST['numsem'] ) and isset($_POST['numserv'] ))
	{	
		$annee=cleanaff($_POST['annee']);
		$numsem=cleanaff($_POST['numsem']);
		$numserv=cleanaff($_POST['numserv']);
		$sql="SELECT * FROM ".PdoMenu::$prefixe."repas WHERE annee='".$annee."' AND numsema='".$numsem."' AND numserv='".$numserv."'";
		if ($donneesRepas = sqlexe($sql)) {
			$action = "Modifier";}
	}		
	else
		die("veuillez retourner sur la <a href='index.php'>page d'accueil</a>");

	// sauvegarde une fiche repas
	if (isset($_POST['AEnregistrer']))
	{
		$id = cleanaff($_POST['AEnregistrer']);
		//en cas de modification je supprime le précédent enregistrement pour le réinsérer après... c'est plus simple que de le modifier
		$sql="DELETE FROM ".PdoMenu::$prefixe."repas WHERE annee='".$annee."' AND numsema='".$numsem."' AND numserv='".$id. "'";
		$reponse = sqlexe($sql); // Requête SQL
		
		if ($_POST['message']=="repas")
		{
			$repas['type']=	"repas";
			$repas['titm']=	addslashes(clean(strtolower($_POST['titm'])));	
			$repas['ent1']=	addslashes(clean(strtolower($_POST['ent1'])));	
			$repas['ent2']=	addslashes(clean(strtolower($_POST['ent2'])));	
			$repas['plat']=	addslashes(clean(strtolower($_POST['plat'])));	
			$repas['lait']=	addslashes(clean(strtolower($_POST['lait'])));	
			$repas['des1']=	addslashes(clean(strtolower($_POST['des1'])));	
			$repas['des2']=	addslashes(clean(strtolower($_POST['des2'])));	
			$repas['des3']=	addslashes(clean(strtolower($_POST['des3'])));	
			$sql="INSERT INTO ".PdoMenu::$prefixe."repas (annee, numsema, numserv, titm,ent1, ent2, plat, lait, des1, des2, des3, type) VALUES ('";
			$sql .=  $annee . "' , '".$numsem . "' , '".$id . "' , '" . $repas['titm'] . "' ,'" . $repas['ent1'] ;
			$sql .=  "' , '" .  $repas['ent2']."', '" .  $repas['plat'] . "' , '" .  $repas['lait']  ;
			$sql .=  "' ,'" . $repas['des1']. "' ,'" . $repas['des2']. "' ,'" . $repas['des3']. "','repas')";
			
		}
		else 
		{
			$repas['type']=	"message";
			$repas['mes1']=	addslashes(clean(strtolower($_POST['mes1'])));	
			$repas['mes2']=	addslashes(clean(strtolower($_POST['mes2'])));	
			$sql="INSERT INTO ".PdoMenu::$prefixe."repas (type, annee, numsema, numserv,  mes1, mes2) VALUES ('message','". $annee . "' , '".$numsem . "' , '".$id . "' , '" . $repas['mes1'] . "' , '" . $repas['mes2'] . "')";
		}
		$reponse = sqlexe($sql); // Requête SQL
		echo "Le menu suivant vient d'être enregistré : <br/>";
			
		afficheRepas($repas);
	}
?> 
<form action="insererrepas.php" method="post">
	<?php 		if ($numserv<>"fin")// si nous ne sommes pas le dernier jour de la semaine
		{
			$titm='';
			$e1 = '';
			$e2 = '';
			$p = '';
			$lait = 'fromage ou yaourt nature';//modifier le paramètre par défaut
			$d1 = '';
			$d2 = '';
			$d3 = '';
			$c1="checked";
			$c2="";
			$m1 = "";
			$m2 =""; 
			// affiche le jour, le service de la semaine sélectionnée
			$sql="SELECT * FROM ".PdoMenu::$prefixe."service "; 
			$sql.= "WHERE num ='".$numserv."'";
			if ($donnees = sqlexe($sql)) 
			{
				$currentDate = semaine2date($annee,$numsem);
				$endDate     = new DateTime($currentDate->format("Y-m-d"));
				$endDate->modify("next Friday");
				echo "<table><caption>".$action." le repas du " .cleanaff(strtolower($donnees['jour'])) ." ".cleanaff($donnees['serv'])." de la semaine du ".$currentDate -> format('j/m/Y')." au ".$endDate -> format('j/m/Y')."</caption>"; 
			
				//récupère le menu existant dans le cas d'une modification
				if ($action=="Modifier") 
				{
					$titm= cleanaff($donneesRepas['titm']);
					$e1 = cleanaff($donneesRepas['ent1']);
					$e2 = cleanaff($donneesRepas['ent2']);
					$p = cleanaff($donneesRepas['plat']);
					$lait = cleanaff($donneesRepas['lait']);
					$d1 = cleanaff($donneesRepas['des1']);
					$d2 = cleanaff($donneesRepas['des2']);
					$d3 = cleanaff($donneesRepas['des3']);
					$m1 = cleanaff($donneesRepas['mes1']);
					$m2 = cleanaff($donneesRepas['mes2']);
					
					$c1=$c2="";
					if (cleanaff($donneesRepas['type'])=="repas")
						$c1="checked";
					else
						$c2="checked";
					
				} 
		?>
				<tr ><th rowspan="5"><input type="radio" name="message" value="repas" <?php echo $c1;?> /> Menu
				</th>
				<th>Titre  :</th>
					<td><input type="text" size="110" name="titm" value="<?php echo $titm;?>"> </td></tr>
				<th>Entrée :</th>
					<td><input type="text" size="50" name="ent1" value="<?php echo $e1;?>"> ou 
					<input type="text" size="50" name="ent2" value="<?php echo $e2;?>"></td></tr>
				<tr><th>Plat :</th>
					<td><input type="text" size="110" name="plat" value="<?php echo $p;?>"></td></tr>
				<tr><th>Laitage : </th>
					<td><input type="text" size="50" name="lait"  value="<?php echo $lait;?>"></td></tr>
				<tr><th>Dessert : </th>
					<td><input type="text" size="30" name="des1" value="<?php echo $d1;?>"> ou
					<input type="text" size="30" name="des2" value="<?php echo $d2;?>"> ou
					<input type="text" size="30" name="des3" value="<?php echo $d3;?>"></td></tr>
				</table>
				<P></P>
				<table>
					<tr ><th rowspan="3"><input type="radio" name="message" value="message" <?php echo $c2;?>/>Message</th> </tr>
						<tr><th>Texte principal : </th><td><input type="text" size="110" name="mes1" value="<?php echo $m1;?>"> </td></tr>
						<tr><th>le commentaire : </th><td><input type="text" size="110" name="mes2" value="<?php echo $m2;?>"></td></tr>
				</table>
				<P class="boutonsinserer"><input type="reset" class="boutonsinserer" value="Effacer"/>
				<input type="submit" class="boutonsinserer" value="<?php
				if ($action=="Saisir")
						echo "Valider";
				else 
						echo $action;?>"/></P>
				<?php // nous allons maintenant remplir le champ caché qui va recevoir l'identifiant du repas, le numsem, l'année, et le numserv suivant s'il y lieu
				echo '<input type="'.$_SESSION['debug'].'" name="AEnregistrer"  value="'.$numserv.'">';
				echo '<input type="'.$_SESSION['debug'].'" name="numsem"  value="'.$numsem.'">';
				echo '<input type="'.$_SESSION['debug'].'" name="annee"  value="'.$annee.'">';
				echo '<input type="'.$_SESSION['debug'].'" name="numserv"  value="';
				if($numserv<9)
					echo $numserv+1;
				else
					echo "fin";//pas de saisi suivante
				echo'">';
				?>
				</form>
				<?php 
		}
		else
				die("Problème d'accès aux données, dans le script insererrepas.php : date repas<br/>".mysql_error()) ; 
	}// fin du si ($numserv="fin")
			
	pied();?>
	</body>
</html>

