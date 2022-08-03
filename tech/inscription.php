<?php

$page_id = "register";
$page_name = "Inscription";

require_once("template/header.php");

if(!empty($_SESSION["id"]))
{
    header('Location: compte.php');

    exit;
}

if(!empty($_POST))
{
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $mail = $_POST["mail"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $password_confirm = $_POST["password_confirm"];
    $birthday = $_POST["birthday"];

    try 
    {
        if(empty($firstname))
        {
            throw new Exception("Merci d'indiquer un prénom");
        }

        if(empty($lastname))
        {
            throw new Exception("Merci d'indiquer un nom");
        }

        if(empty($mail))
        {
            throw new Exception("Merci d'indiquer un e-mail");
        }

        if(empty($password))
        {
            throw new Exception("Merci d'indiquer un mot de passe");
        }

        if(empty($password_confirm))
        {
            throw new Exception("Merci de confirmer votre mot de passe");
        }

        if(empty($birthday))
        {
            throw new Exception("Merci d'indiquer une date de naissance");
        }

        if(!preg_match('/^[A-Za-zéè\- ]+$/', $firstname))
        {
            throw new Exception("Votre prénom n'est pas valide");
        }

        if(!preg_match('/^[A-Za-zéè\- ]+$/', $lastname))
        {
            throw new Exception("Votre nom n'est pas valide");
        }

        if(!preg_match('/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/', $mail))
        {
            throw new Exception("Votre adresse e-mail n'est pas valide");
        }

        $phone = str_replace("+33", "0", $phone);

        $phone = preg_replace('/\D/', "", $phone);

        if(!empty($phone) && !preg_match('/^0[1-9][0-9]{8}$/', $phone))
        {
            throw new Exception("Votre numéro de téléphone n'est pas valide");
        }


        if($password != $password_confirm)
        {
            throw new Exception("Vos mots de passe ne correspondent pas");
        }

        if(!preg_match('/^(?=.*[a-z])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/', $password))
        {
            throw new Exception("Votre mot de passe doit contenir minumum 8 caractères dont des chiffres et des majuscules");
        }

        if (stripos($password, $firstname) !== false || stripos($password, $lastname) !== false)
        {
            throw new Exception("Votre mot de passe ne doit pas contenir votre nom ou prénom");
        }

        //Transformer le format de la DDN dans la base de données
        $split = explode('-', $birthday);

        if( ($split[1] < 1 || $split[1] > 12) || ($split[2] < 1 || $split[2] > 31) || $split[0] < 1900 )
        {
            throw new Exception("Date d'anniversaire incorrecte");
        }

        $birthday = $split[2].'-'.$split[1].'-'.$split[0];

        $req = $conn->prepare("SELECT id FROM users WHERE mail = :mail LIMIT 1");

        $req->execute(array(":mail" => $mail));

        if($req->rowCount() == 1)
        {
            throw new Exception("Un compte est déjà enregistré avec cette adresse e-mail");
        }

        $req = $conn->prepare("INSERT INTO users (firstname, lastname, mail, phone, password, birthday) VALUES (:firstname, :lastname, :mail, :phone, :password, :birthday)");

        $req->execute(array(":firstname" => $firstname, ":lastname" => $lastname, ":mail" => $mail, "phone" => $phone, ":password" => $password, "birthday" => $birthday));

        $_SESSION["id"] = $conn->lastInsertId();

        $_SESSION["success"] = "Votre inscription est validée, vous êtes désormais connecté";

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

        <h1 class="box-title">Inscription</h1>

        <hr class="box-hr">

        <form class="box-form" method="post" onsubmit="return inscription()">

            <input class="box-input" type="text" id="firstname" name="firstname" placeholder="Prénom" required>

            <input class="box-input" type="text" id="lastname" name="lastname" placeholder="Nom" required>

            <input class="box-input" type="text" id="mail" name="mail" placeholder="E-mail"required >

            <input class="box-input" type="text" id="phone" name="phone" placeholder="Tel (facultatif)">

            <input class="box-input" type="password" id="password" name="password" placeholder="Mot de passe" required>

            <input class="box-input" type="password" id="password_confirm" name="password_confirm" placeholder="Confirmation" required>

            <label class="box-label" for="birthday">Date de naissance</label>

            <input class="box-input" type="date" id="birthday" name="birthday" required>

            <button class="box-button" type="submit">S'inscrire</button>

        </form>

    </div>

</div>

<?php

require_once("template/footer.php");

?>

