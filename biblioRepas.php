<?php	
	// bibliothèque de fonctions pour la gestion des menus.
	include_once("biblio.php");// bibliothèque de fonctions	

	function afficheRepas($repas)
	{// cette fonction affiche le menu d'un service
		echo "<p>";		if ($repas['type']=="repas")
		{
			if ($repas['titm']!="")
				echo "<div class='titm'>".ucfirst(cleanaff($repas['titm']))."</div>";
			echo "<div>".ucfirst(cleanaff($repas['ent1']));
			$e2 = ucfirst(cleanaff($repas['ent2']));
			$d2 = ucfirst(cleanaff($repas['des2']));
			$d3 = ucfirst(cleanaff($repas['des3']));
			if ($e2<>"") 
				echo " ou ".ucfirst(cleanaff($repas['ent2']));
			echo "</div><div>".ucfirst(cleanaff($repas['plat']))."</div>" ;
			echo "<div>".ucfirst(cleanaff($repas['lait']))."</div>" ;
			echo "<div>".ucfirst(cleanaff($repas['des1']));
			if ($d2<>"")
				echo " ou ".ucfirst(cleanaff($repas['des2']));
			if ($d3<>"")
				echo " ou ".ucfirst(cleanaff($repas['des3']));
			echo "</div>" ;
		}
		else if ($repas['type']=="message")
		{
			echo "<h2>".strtoupper(cleanaff($repas['mes1']))."</h2>";
			echo ucfirst(cleanaff($repas['mes2']));
		}		
		
		
		else //pas d'info saisie
			pasdemenu();
		echo "</p>";
	}
	function pasdemenu()
	{
		echo "<h2>Le menu n'a pas été communiqué</h2>";
	}	
	function afficherBouton($numsem,$annee,$numserv,$libelle)
	{// affiche le bouton modifier ou saisir en fonction de l'utilisateur
				if ($_SESSION['user']<>"visiteur") // si l'utilisateur est un visiteur on affiche rien
				{
					echo '<form action="insererrepas.php" method="post">';
					echo '<input type="'.$_SESSION['debug'].'" name="numsem" value="'.$numsem.'">';
					echo '<input type="'.$_SESSION['debug'].'" name="annee" value="'.$annee.'">';
					echo '<input type="'.$_SESSION['debug'].'" name="numserv" value="'.$numserv.'">';
					echo '<input type="submit" value="'.$libelle.'"></form>';
				}
	}
	function afficherTitreSemaine($numsem,$annee,$titre)
	{// affiche le bouton modifier ou saisir en fonction de l'utilisateur
				if ($_SESSION['user']<>"visiteur") // si l'utilisateur est un visiteur on affiche rien
				{
					echo '<form action="semaine.php" method="post">';
					echo '<input type="'.$_SESSION['debug'].'" name="numsem" value="'.$numsem.'">';
					echo '<input type="'.$_SESSION['debug'].'" name="annee" value="'.$annee.'">';
					echo '<input type="text" name="titre" size="110" value="'.$titre.'">';
					echo '<input type="submit" value="Modifier le titre"></form>';
				}
				else
				{
					if ($titre!="")
						echo"<div class='titm'>".strtoupper($titre)."</div>";
					
				}
	}
	function pied()
	{// affiche le pied de page
		echo "<P class='pied'><div class='pied'><a href='semaine.php'>Retourner au menu du jour</a> - <a href='index.php'>Retourner à  l'accueil</a></div><div class='pied'>";
		echo " <a href='password.php'>Connexion</a> - <a href='http://etablissementbertrandeborn.net'>site de BdeB</a></div>";
		echo "<div class='pied'>".nbconnexions()."</div>";
		echo "<div class='pied'>AppliMenu 1.6 - septembre 2008 - janvier 2016 - <a href='mailto:webmestre@etablissementbertrandeborn.net'>contacter le webmestre</a></div></P>";
	}
	
	function entete($texte)
	{//affiche une partie de l'entête
		session_start(); // On démarre la session AVANT toute chose
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';		echo "\n";
		echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >';		echo "\n";
		echo '<head>       <title>Cité scolaire Bertran-de-Born - '.$texte.'</title>';		echo "\n";
        echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';		echo "\n";
    	echo '<link rel="alternate stylesheet" media="screen" type="text/css" title="classique" href="styles/stylemenu.css" />';		echo "\n";
		echo '<link rel="stylesheet" media="screen" type="text/css" title="moderne" href="styles/stylemenu2.css" />';		echo "\n";
		echo '</head><body>';		echo "\n";
		echo '<h1>Service de restauration de la cité scolaire Bertran-de-Born</h1>';		echo "\n";
		if (isset($_SESSION['user'])) // est-ce que la variable session user vaut quelque chose ?
			if ($_SESSION['user']=="")
				$_SESSION['user']="visiteur"; // maintenant elle vaut quelque chose
			else 
				;// ne rien faire car elle a déjà  une valeur
		else
			$_SESSION['user']="visiteur";// maintenant elle vaut quelque chose
		if ($_SESSION['user']=="debug")// si nous sommes en mode débug... les zones  hidden apparaissent
			$_SESSION['debug']="text";
		else
			$_SESSION['debug']="hidden";
		if ($_SESSION['user']=="debug")
		{
			echo "<div>variable de session : ";
			print_r( $_SESSION);
			echo "</div><div>variable POST : ";
			print_r( $_POST);
			echo "</div>";
		}

	}
	function semaine2date($annee,$numsem) {
		$date = DateTime::createFromFormat('j-m-Y', '01-01-'.$annee);
		while ($date->format("Y")==$annee && $date->format("W")<$numsem){
			$date->modify("next Monday");
			//echo $date->format("Y-W")."<BR />";
		}
		return $date;
	}

	function recalculerDate(){
		$madate =new DateTime();
		$numsem= $madate->format('W');
		$annee=$madate->format('Y');		
		//echo 'dans recalculer :'.$madate->format('d-m-Y').'<br>';
		//on vérifie que la semaine en cours est dans la base 
		$sql="SELECT deb,fin FROM ".PdoMenu::$prefixe."semaine WHERE annee='".$annee."' and num='".$numsem."'";		
		if (!($donnees = sqlexe($sql))){ //la semaine en cours n'est pas dans la BD
			//on doit donc l'ajouter dans la base
			$debdate=new DateTime();
			//echo 'aujourd hui '.$debdate -> format('Y-m-d').'<br>';
			// on cherche le lundi: N==1
			while($debdate -> format('N')!=1) {
				//echo 'recherche du lundi '.$debdate -> format('N')." ".$debdate -> format('Y-m-d').'<br>';
				$debdate -> modify('-1 day');
			}
			// la fin de la semaine, c'est 4 jours après
			$findate = new DateTime($debdate -> format('Y-m-d'));
			//echo 'lundi trouvé '.$debdate -> format('Y-m-d').'<br>';				
			$findate -> modify('+4 day');
			ajoutersemaine( $annee,$numsem,$debdate -> format('Y-m-d'),$findate -> format('Y-m-d'));
			$madate = $debdate;
		}
		return $madate;
	}
	
	function afficherPrecSuiv($numsem,$annee)
	{
		// on calcule les dates des semaines précédente et suivante
		$sql="SELECT deb,fin FROM ".PdoMenu::$prefixe."semaine WHERE annee='".$annee."' and num='".$numsem."'";
		$donnees = sqlexe($sql);
		$debdatesuiv     = new DateTime($donnees['deb']);
		$debdatesuiv -> modify('+1 week');// date début de la semaine suivante
		$anneesuiv = $debdatesuiv -> format('o');//année suivante
		$numsemsuiv = $debdatesuiv -> format('W');//num de la semaine suivante
		$debdateprec = new DateTime($donnees['deb']);
		$debdateprec -> modify('-1 week');//date début de la semaine précédente
		$anneeprec = $debdateprec -> format('o');//année précédente
		$numsemprec = $debdateprec -> format('W');//num de la semaine précédente
		$sql="SELECT deb,fin FROM ".PdoMenu::$prefixe."semaine WHERE annee='".$anneeprec."' and num='".$numsemprec."'";
		if ($donneesprec = sqlexe($sql))
			afficherBoutonNavigation($numsemprec, $anneeprec,"Précédent");
		if ($_SESSION['user']=="visiteur")
		{	// si c'est un visiteur qui vient consulter, il ne peut pas ajouter de nouvelles semaines à  la BD 
			$sql="SELECT deb,fin FROM ".PdoMenu::$prefixe."semaine WHERE annee='".$anneesuiv."' and num='".$numsemsuiv."'";
			if ($donneessuiv = sqlexe($sql)) // on affiche le bouton suivant que si la semaine suivante existe
				afficherBoutonNavigation($numsemsuiv, $anneesuiv,"Suivant");
		}
		else
		{
			$sql="SELECT deb,fin FROM ".PdoMenu::$prefixe."semaine WHERE annee='".$anneesuiv."' and num='".$numsemsuiv."'";
			//s'il n'existe pas de semaine suivante, on l'ajoute.
			if (!($donneessuiv = sqlexe($sql)))		
			{
				$findatesuiv     = new DateTime($donnees['fin']);
				$findatesuiv -> modify('+1 week');// date fin de la semaine  suivante
				$debdatesuiv     = new DateTime($donnees['deb']);
				$debdatesuiv -> modify('+1 week');// date début de la semaine  suivante
				ajouterSemaine( $anneesuiv,$numsemsuiv,$debdatesuiv -> format('Y-m-d'),$findatesuiv -> format('Y-m-d'));
			}// puis on affiche le bouton 'suivant'
			afficherBoutonNavigation($numsemsuiv, $anneesuiv,"Suivant");
		}
	}	
	function ajouterSemaine($anneesuiv, $numsemsuiv, $debdatesuiv,$findatesuiv)
	{
		$sql="INSERT INTO ".PdoMenu::$prefixe."semaine (annee, num, deb, fin) VALUES ('".$anneesuiv."', '".$numsemsuiv."', '".$debdatesuiv."', '".$findatesuiv."')";
		$d=sqlexe($sql);
	}
	function afficherBoutonNavigation($numsem, $annee,$mouvement)
	{
		echo '<form action="semaine.php" method="post">';		echo "\n";
		echo '<input type="'.$_SESSION['debug'].'" name="numsem" value="'.$numsem.'">';		echo "\n";
		echo '<input type="'.$_SESSION['debug'].'" name="annee" value="'.$annee.'">';		echo "\n";
		echo'<input type="submit" class="bouton'.$mouvement.'" value="Semaine '.$mouvement.'e"></form>';		echo "\n";
	}
	function nbconnexions()
	{
		// Connexion à  MySQL
		$pdo=connexionBD();
		// ETAPE 0 : on récupère le nombre de connexion du jour
		$jour=new DateTime();
		$sql="SELECT nb FROM ".PdoMenu::$prefixe."log WHERE jour='".$jour -> format('Y-m-d')."'";
		if (!($donnees = sqlexe($sql)) )
		{// si il n'y en a pas on insère un enregistrement
			$sql="INSERT INTO ".PdoMenu::$prefixe."log (jour,nb) VALUES ('" . $jour -> format('Y-m-d') .  "', '0')";
			sqlexe($sql);
		}

		// -------
		// ETAPE 1 : on vérifie si l'IP se trouve déjà  dans la table
		// Pour faire à§a, on n'a qu'à  compter le nombre d'entrées dont le champ "ip" est l'adresse ip du visiteur
		$donnees = sqlexe('SELECT COUNT(*) AS nbre_entrees FROM '.PdoMenu::$prefixe.'connexions WHERE ip=\'' . $_SERVER['REMOTE_ADDR'] . '\'');
		if ($donnees['nbre_entrees'] == 0) // L'ip ne se trouve pas dans la table, on va l'ajouter
		{
		    $sql='INSERT INTO '.PdoMenu::$prefixe.'connexions (ip,time,pseudo) VALUES (\'' . $_SERVER['REMOTE_ADDR'] .  '\', ' . time() . ",'".$_SESSION['user']."')";
			sqlexe($sql);						
			$sql="UPDATE ".PdoMenu::$prefixe."log SET nb=nb+1 WHERE jour='".$jour -> format('Y-m-d')."'";
			sqlexe($sql);	
		}
		else // L'ip se trouve déjà  dans la table, on met juste à  jour le timestamp
		{
		    $sql='UPDATE '.PdoMenu::$prefixe.'connexions SET time=' . time() . ' WHERE ip=\'' . $_SERVER['REMOTE_ADDR'] . '\'';
			sqlexe($sql);
			$sql="SELECT pseudo FROM ".PdoMenu::$prefixe."connexions WHERE ip='".$_SERVER['REMOTE_ADDR'] . "'";
			if ($donnees = sqlexe($sql))
			{
				if ($donnees['pseudo']==NULL or $donnees['pseudo']<>$_SESSION['user'])
				{
					$sql="UPDATE ".PdoMenu::$prefixe."connexions SET pseudo='" . $_SESSION['user'] . "' WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "'";
					sqlexe($sql);
				}
			}
		}
		// -------
		// ETAPE 2 : on supprime toutes les entrées dont le timestamp est plus vieux que 5 minutes
		// On stocke dans une variable le timestamp qu'il était il y a 5 minutes :

		$timestamp_5min = time() - (60 * 5); // 60 * 5 = nombre de secondes écoulées en 5 minutes
		sqlexe("DELETE FROM ".PdoMenu::$prefixe."connexions WHERE time < " . $timestamp_5min);
		// -------
		// ETAPE 3 : on compte le nombre d'ip stockées dans la table. C'est le nombre de visiteurs connectés
		$donnees = sqlexe("SELECT COUNT(*) AS nbre_entrees FROM ".PdoMenu::$prefixe."connexions");
		// Ouf ! On n'a plus qu'à  afficher le nombre de connectés !
		if ($donnees['nbre_entrees']<2)
			$r=' visiteur connecté';
		else
			$r=' visiteurs connectés';
		$r='Il y a actuellement ' . $donnees['nbre_entrees'] . $r.' !';
		// ETAPE 4 : on liste les pseudos des visiteurs connectés
		if ($_SESSION['user']<>"visiteur")
		{
			$donnees = sqlexe("SELECT * FROM ".PdoMenu::$prefixe."connexions");
			$r2="";
			while ($donnees)
			{
				if ($r2=="")
					$r2=" - ".$donnees['pseudo'];
				else
					$r2.=", ".$donnees['pseudo'];
				$donnees= $pdo->suivant();
			}
			$donnees = sqlexe("SELECT nb FROM ".PdoMenu::$prefixe."log WHERE jour='".$jour -> format('Y-m-d')."'");
			$r2.="<div>nombre de connexion aujourd'hui : ".$donnees['nb'];
			$donnees = sqlexe("SELECT max(nb) as nbmax FROM ".PdoMenu::$prefixe."log ");
			$r2.="</div><div>nombre max de connexion : ".$donnees['nbmax'];
			$donnees = sqlexe("SELECT jour FROM ".PdoMenu::$prefixe."log WHERE nb = (SELECT max(nb) as nbmax FROM ".PdoMenu::$prefixe."log)");
			$jourmax = new DateTime($donnees['jour']);
			$r2.=" le ".$jourmax-> format('j/m/Y')."</div>";
			$r.=$r2;
		}
		return $r;
	}
?>
