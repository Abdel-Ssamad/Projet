<?php

$page_id = "basket";
$page_name = "Panier";

require_once("template/header.php");

if(!empty($_POST))
{
    if($_POST["action"] == "delete")
    {
        $product_id = $_POST["product_id"];

        if(!empty($_SESSION["basket"]))
        {
            if(($key = array_search($product_id, $_SESSION["basket"])) !== false) 
            {
                unset($_SESSION["basket"][$key]);
            }
        }
    }

    if($_POST["action"] == "buy")
    {
        if(empty($_SESSION["id"]))
        {
            header('Location: connexion.php');

            exit;
        }

        $price = $_POST["price"];

        $req = $conn->prepare("INSERT INTO orders (user_id, products, price, date) VALUES (:user_id, :products, :price, now())");

        $req->execute(array(":user_id" => $_SESSION["id"], ":products" => implode(',', $_SESSION["basket"]), ":price" => $price));

        unset($_SESSION["basket"]);

        $_SESSION["success"] = "Votre commande a été validée avec succès, merci !";

        header('Location: index.php');

        exit;
    }
}

?>

<div class="main">

    <h1 class="main-title">Mon Panier</h1>

    <?php 

        if(empty($_SESSION["basket"]))
        {
            echo '<p class="main-description">Oh non ton panier est vide, clique <a href="prestation.php">ici</a> pour trouver ton bonheur</p>';
        }
        else
        {
            $total_price = 0;

            foreach($_SESSION["basket"] AS $product_id)
            {
                $req = $conn->prepare("SELECT * FROM products WHERE id = :id LIMIT 1");

                $req->execute(array(":id" => $product_id));

                if($req->rowCount() != 1)
                {
                    continue;
                }

                $row = $req->fetch();

                $total_price += $row["price"];

                $trad = array("developer" => "Développeur", "editor" => "Monteur vidéo", "graphic" => "Graphiste");

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

                        <input type="hidden" name="action" value="delete">  
                        <input type="hidden" name="product_id" value="'.$row["id"].'">
                        <button type="submit">Supprimer</button>
                    
                    </form>
            
                </li>';
            }

            echo '
            
            <hr class="basket-hr">
            
            <div class="basket-information">
            
                <span class="basket-price">Prix total: '.$total_price.' € / jour</span>

                <p class="basket-disclaimer">En poursuivant votre commande vous acceptez nos conditions d\'utilisation et nos conditions de vente</p>

                <form method="post">

                    <input type="hidden" name="action" value="buy"> 
                    <input type="hidden" name="price" value="'.$total_price.'"> 

                    <button class="basket-button" type="submit" style="
                    margin-top: 28px;
                    float: right;
                    ">'.(!empty($_SESSION["id"]) ? "Commander" : "Connexion").'</button>

                </form>

            </div>';
            
        }

    ?>

</div>

<?php

require_once("template/footer.php");

?>