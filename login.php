<?php 
    require_once  'inc/class.Session.php'; 
    Session::init();
    require_once 'inc/class.PDOMenu.php'; 
    include 'vues/v_entete.php';
    // constantes 
    define("EOL","<br />\n");// fin de ligne html et saut de ligne
    define("EL","\n");//  saut de ligne 
    
    if (isset($_POST['login']) && isset($_POST['password'])) {
        $pdo = PDOMenu::getPdoMenu();
        $login = $_POST['login'];
        $mdp = $_POST['password'];
        if ($rep = $pdo->getInfoUtil($login)) {// si j'ai une réponse du modèle
            if (Session::login($login, $mdp, $rep['pseudo'], $rep['mdp'])){
                $_SESSION['nom'] = $rep['nom'];
                $_SESSION['prenom'] = $rep['prenom'];
                $_SESSION['tsDerniereCx'] = $rep['tsDerniereCx'];
                $_SESSION['numUtil'] = $rep['num'];
                
                $pdo->setDerniereCx($rep['num']);
                header('Location: index.php');
                
            }
        }
        
    }
?>
    <form method="post" action="login.php">
      Pour se connecter : <br>
      Identifiant  : <input type="text" name="login"> <br>
      Mot de passe : <input type="password" name="password">
      <input type="submit" value="Login">
    </form>
<?php
	include 'vues/v_pied.php';
?> 
