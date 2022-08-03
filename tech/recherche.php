<?php

$page_id = "search";
$page_name = "Votre recherche";

require_once("template/header.php");

if(empty($_GET))
{
    header('Location: index.php');
}
else
{
    $value = $_GET["value"];

    $req = $conn->prepare("SELECT * FROM products WHERE name LIKE :value OR category LIKE :value OR description LIKE :value");

    $req->execute(array(":value" => '%'.$value.'%'));

    $data = $req->fetchAll();
}

?>

<div class="main">

    <h1 class="main-title">Résultat recherche:</h1>

    <?php 

    if(count($data) == 0)
    {
        echo '<p class="main-description">Mince non aucun résultat, clique <a href="javascript:history.back()">ici</a> pour revenir en arrière</p>';
    }
    else
    {

    ?>

    <ul class="products">

        <?php 

        $trad = array("developer" => "Développeur", "editor" => "Monteur vidéo", "graphic" => "Graphiste");

        foreach($data AS $row)
        {
            echo '

            <li class="product">

                <div class="product-thumb" style="background-image:url(img/'.$row["thumb"].'.png"> </div>

                <div class="product-information">

                    <div class="product-line">

                        <h2 class="product-title">'.$row["name"].'</h2>
                        <span class="product-category">'.$trad[$row["category"]].'</span>
                        <span class="product-price">'.$row["price"].' € / jour</span>

                    </div>

                    <p class="product-description">'.$row["description"].'</p>

                </div>

                <a href="prestation.php">Voir</a>
                          
            </li>';
        }

        ?>
    
    </ul>

    <?php } ?>

</div>

<?php

require_once("template/footer.php");

?>