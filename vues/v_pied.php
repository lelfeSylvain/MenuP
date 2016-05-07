                
<footer id="footer" role="contentinfo" class="line ptm txtcenter mal ">
    <p class='textgros'>
        <?php
        if (Session::isLogged()) {
            echo $_SESSION['username'];
            if (isset($_SESSION['prenom']) or isset($_SESSION['nom'])) {
                echo " alias " . $_SESSION['prenom'] . " " . $_SESSION['nom'];
            }

            echo "<br /><a href='index.php?uc=lecture&num=actuelle' class='textgros'>Retourner à l'accueil</a> - ";
            echo "<a href='index.php?uc=login&num=out'>Déconnexion</a> \n";
        } else {// non loggé : on propose de se connecter
            echo "<a href='index.php?uc=login'>Connexion</a> \n";
        }
        echo "<br />Menu v2.0.0 alpha - <a href='http://etablissementbertrandeborn.net/'>BTS SIO BdeB</a> - <img src='https://licensebuttons.net/l/by-nc-sa/3.0/80x15.png' alt='cc-by-nc-sa' />" . EL;
        if (isset ($_SESSION['pseudo']) && $_SESSION['pseudo'] === "debug" && $_SESSION['debug'] === "text") {
            phpinfo();
        }
        ?>
    </p>   
</footer>

</body>
</html>
