<?php

$page_id = "index";
$page_name = "Bienvenue sur Asrtech";

require_once("template/header.php");

?>

<div class="main" style="width: 65%;">

    <?php

    if(!empty($_SESSION["success"]))
    {
        echo '<div class="main-success">'.$_SESSION["success"].'</div>';

        unset($_SESSION["success"]);
    }

    ?>

    <h1 class="main-title">Bienvenue sur Asrtech</h1>

    <p class="main-description">ASR-TECH propose aux professionnels et aux particuliers l'ensemble des services nécessaire à la création de tout vos projets.</p>

    <div class="index-slider">

        <div class="slides">

            <input type="radio" name="r" id="r1">
            <input type="radio" name="r" id="r2">
            <input type="radio" name="r" id="r3">

            <div class="slide s1">
                <img src="img/developpeur.jpeg">
            </div>

            <div class="slide">
                <img src="img/graphiste.jpg">
            </div>

            <div class="slide">
                <img src="img/monteur.jpg">
            </div>

        </div>

        <div class="slider-nav">

            <label for="r1" class="bar"></label>
            <label for="r2" class="bar"></label>
            <label for="r3" class="bar"></label>

        </div>

    </div>
     <hr>
    <a class="index-button" href="prestation.php">Voir nos prestations</a>

</div>

<?php

require_once("template/footer.php");

?>