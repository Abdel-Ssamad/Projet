<?php

$page_id = "account";
$page_name = "Mon compte";

require_once("template/header.php");

if(empty($_SESSION["id"]))
{
    header('Location: connexion.php');

    exit;
}

$req = $conn->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");

$req->execute(array(":id" => $_SESSION["id"]));

if($req->rowCount() != 1)
{
    exit;
}

$data = $req->fetch();

if(!empty($_POST))
{
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $mail = $_POST["mail"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $password_confirm = $_POST["password_confirm"];
    $password_current = $_POST["password_current"];

    try 
    {
        if($data["password"] != $password_current)
        {
            throw new Exception("Mot de passe actuel incorrect");
        }

        if($data["firstname"] != $firstname)
        {
            if(empty($firstname))
            {
                throw new Exception("Merci d'indiquer un prénom");
            }

            if(!preg_match('/^[A-Za-zéè\- ]+$/', $firstname))
            {
                throw new Exception("Votre prénom n'est pas valide");
            }

            $data["firstname"] = $firstname;
        }

        if($data["lastname"] != $lastname)
        {
            if(empty($lastname))
            {
                throw new Exception("Merci d'indiquer un nom");
            }

            if(!preg_match('/^[A-Za-zéè\- ]+$/', $lastname))
            {
                throw new Exception("Votre nom n'est pas valide");
            }

            $data["lastname"] = $lastname;
        }

        if($data["mail"] != $mail)
        {
            if(empty($mail))
            {
                throw new Exception("Merci d'indiquer un e-mail");
            }

            if(!preg_match('/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/', $mail))
            {
                throw new Exception("Votre adresse e-mail n'est pas valide");
            }

            $data["mail"] = $mail;
        }

        if($data["phone"] != $phone)
        {
            $phone = str_replace("+33", "0", $phone);

            $phone = preg_replace('/\D/', "", $phone);

            if(!empty($phone) && !preg_match('/^0[1-9][0-9]{8}$/', $phone))
            {
                throw new Exception("Votre numéro de téléphone n'est pas valide");
            }

            $data["phone"] = $phone;
        }

        if(!empty($password))
        {
            if($data["password"] == $password)
            {
                throw new Exception("Votre d'indiquer un mot de passe différent de l'actuel");
            }

            if(empty($password_confirm))
            {
                throw new Exception("Merci de confirmer votre nouveau mot de passe");
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

            $data["password"] = $password;
        }

        $req = $conn->prepare("UPDATE users SET firstname = :firstname, lastname = :lastname, mail = :mail, phone = :phone, password = :password WHERE id = :id LIMIT 1");

        $req->execute(array(":firstname" => $data["firstname"], ":lastname" => $data["lastname"], ":mail" => $data["mail"], ":phone" => $data["phone"], ":password" => $data["password"], ":id" => $data["id"]));

        $success = "Vos données ont été modifiées avec succès";

    } 
    catch (Exception $e) 
    {
        $error = $e->getMessage();
    }
}

?>

<div class="main">

    <?php 

    if(!empty($success))
    {
        echo '<div class="main-success">'.$success.'</div>';
    }

    if(!empty($error))
    {
        echo '<div class="main-error">'.$error.'</div>';
    }

    ?>

    <div class="box">

        <h1 class="box-title">Mon compte</h1>

        <hr class="box-hr">

        <form class="box-form" method="post" onsubmit="return account()">

            <input class="box-input" type="text" id="firstname" name="firstname" placeholder="Prénom" value="<?php echo $data["firstname"]; ?>">
            <input class="box-input" type="text" id="lastname" name="lastname" placeholder="Nom" value="<?php echo $data["lastname"]; ?>">
            <input class="box-input" type="text" id="mail" name="mail" placeholder="E-mail" value="<?php echo $data["mail"]; ?>">
            <input class="box-input" type="text" id="phone" name="phone" placeholder="Tel (facultatif)" value="<?php echo $data["phone"]; ?>">
            <input class="box-input" type="password" id="password" name="password" placeholder="Nouveau mot de passe">
            <input class="box-input" type="password" id="password_confirm" name="password_confirm" placeholder="Confirmation">

            <hr>

            <input class="box-input" type="password" name="password_current" placeholder="Mot de passe actuel" required>

            <button class="box-button" type="submit">Modifier</button>

        </form>

        <a class="box-link" href="deconnexion.php">Déconnexion</a>

    </div>

</div>

<?php

require_once("template/footer.php");

?>
