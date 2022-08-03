<?php

session_start();

require_once("core/database.php");

?>

<html>

    <head>

        <title>Asr-tech : <?php echo $page_name; ?></title>
        
        <meta charset="UTF-8">

        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/footer.css">

       <?php 

       /* CSS */

       if($page_id == "index")
       {
           echo '<link rel="stylesheet" href="css/index.css">';
       }

       if($page_id == "basket")
       {
           echo '<link rel="stylesheet" href="css/basket.css">';
       }

       if($page_id == "prestation" || $page_id == "basket" || $page_id == "search")
       {
           echo '<link rel="stylesheet" href="css/prestation.css">';
       }

       /* JS */

       if($page_id == "register")
       {
           echo '<script src="js/inscription.js"></script>';
       }

       ?>

    </head>

    <body>

        <header>

            <a class="header-logo" href="index.php"> </a>

            <form class="header-search" method="get" action="recherche.php">
        
                <input class="search-input" type="search" name="value" placeholder="Recherche" required>
                
                <button class="search-button" type="submit"></button>

            </form>

            <nav class="header-nav" role="navigation">

                <a href="index.php" class="nav-link">Accueil</a>
                <a href="prestation.php" class="nav-link">Prestations</a>
                <a href="connexion.php" class="nav-link">Connexion</a>
                <a href="inscription.php" class="nav-link">Inscription</a>
                <a href="compte.php" class="nav-link">Compte</a>
                <a href="panier.php" class="nav-link basket" title="Panier"></a>

            </nav>

        </header>