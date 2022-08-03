<?php

$page_id = "prestation";
$page_name = "Prestations";

require_once("template/header.php");

if(!empty($_POST))
{
    $product_id = $_POST["product_id"];

    $req = $conn->prepare("SELECT id FROM products WHERE id = :id LIMIT 1");

    $req->execute(array(":id" => $product_id));

    if($req->rowCount() == 0)
    {
        exit;
    }

    if(isset($_SESSION["basket"]))
    {
        if(!in_array($product_id, $_SESSION["basket"]))
        {
            array_push($_SESSION["basket"], $product_id);
        }
    }
    else
    {
        $_SESSION["basket"] = array($product_id);
    }

    $success = "Votre panier a été mis à jour";
}

?>

<div class="main">

    <?php

    if(!empty($success))
    {
        echo '<div class="main-success">'.$success.'</div>';
    }

    ?>

    <h1 class="main-title">Nos prestations</h1>

    <ul class="products">

        <?php 

        $req = $conn->query("SELECT * FROM products ORDER BY id");

        $data = $req->fetchAll();

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

                <form method="post">

                    <input type="hidden" name="product_id" value="'.$row["id"].'">
                    <button type="submit">Commander</button>
                
                </form>
        
            </li>';

        }

        ?>
    
    </ul>

</div>

<?php

require_once("template/footer.php");

?>