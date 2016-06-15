                
<footer  class="principal">
    <nav class='pied'>
        <?php
        $texte = "";
        if (Session::isLogged()) {
            $texte = $_SESSION['username'];
            if (isset($_SESSION['prenom']) or isset($_SESSION['nom'])) {
                $texte .= " alias " . $_SESSION['prenom'] . " " . $_SESSION['nom'];
            }
            $texte .= " - ";
            echo "<a href='index.php?uc=lecture&num=actuelle' class='textgros'>Retourner à l'accueil</a> - ";
            echo "<a href='index.php?uc=login&num=out'>Déconnexion</a> \n";
        } else {// non loggé : on propose de se connecter
            echo "<a href='index.php?uc=login'>Connexion</a> - ";
        }
        ?>
    
        <?php
        echo $phraseNbVisiteur;
        echo $texte . "Menu v2.0.1 alpha - <a href='http://etablissementbertrandeborn.net/'>BTS SIO BdeB</a> - <img src='https://licensebuttons.net/l/by-nc-sa/3.0/80x15.png' alt='cc-by-nc-sa' />" . EL;
        ?>
    </nav>    
    <?php
    if (isset($_SESSION['pseudo']) && $_SESSION['pseudo'] === "debug" && $_SESSION['debug'] === "text") {
        phpinfo();
    }
    ?>

</footer>
</section>
</body>
</html>
