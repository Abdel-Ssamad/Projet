<?php

$page_id = "login";
$page_name = "Connexion";

require_once("template/header.php");

if(!empty($_SESSION["id"]))
{
    header('Location: compte.php');

    exit;
}

if(!empty($_POST))
{
    $mail = $_POST["mail"];
    $password = $_POST["password"];

    try 
    {
        if(empty($mail))
        {
            throw new Exception("Merci d'indiquer un e-mail");
        }

        if(empty($password))
        {
            throw new Exception("Merci d'indiquer un mot de passe");
        }

        $req = $conn->prepare("SELECT id, firstname FROM users WHERE mail = :mail AND password = :password LIMIT 1");

        $req->execute(array(":mail" => $mail, ":password" => $password));

        if($req->rowCount() != 1)
        {
            throw new Exception("Identifiants incorrects");
        }

        $row = $req->fetch();

        $_SESSION["id"] = $row["id"];

        $_SESSION["success"] = "Bonjour ".$row["firstname"]." c'est un plaisir de vous revoir";

        header('Location: index.php');

        exit;
    } 
    catch (Exception $e) 
    {
        $error = $e->getMessage();
    }
}

?>

<div class="main">

    <?php 

    if(!empty($error))
    {
        echo '<div class="main-error">'.$error.'</div>';
    }

    ?>

    <div class="box">

        <h1 class="box-title">Connexion</h1>

        <hr class="box-hr">

        <form class="box-form" method="post">

            <input class="box-input" type="text" name="mail" placeholder="E-mail" required>
            <input class="box-input" type="password" name="password" placeholder="Mot de passe" required>
            <button class="box-button" type="submit">Se connecter</button>

        </form>

    </div>

</div>

<?php

require_once("template/footer.php");

?>
