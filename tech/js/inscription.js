function inscription()
{
    var regex_name = /^[A-Za-zéè\- ]+$/;

    var firstname = document.getElementById("firstname").value;

    if (firstname.match(regex_name) == null) 
    {
        alert('Seules les lettre sont autorisées dans le prénom');
        
        return false;
    }

    var lastname = document.getElementById("lastname").value;

    if (lastname.match(regex_name) == null) 
    {
        alert('Seules les lettres sont autorisées dans le nom');

        return false;
    }

    var regex_mail = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    var mail = document.getElementById("mail").value;

    if (mail.match(regex_mail) == null) 
    {
        alert("L'e-mail doit contenir un @ et un nom de domaine valide");
        
        return false;
    }

    var regex_phone = /^(0|\+33)[1-9][0-9]{8}$/;

    var phone = document.getElementById("phone").value;

    if (phone != "" && phone.match(regex_phone) == null)
    {
        alert("Numéro invalide (format français seulement)");

        return false;
    }

    var password = document.getElementById("password").value;
    var password_confirm = document.getElementById("password_confirm").value;

    if (password !== password_confirm)
    {
        alert("Les mots de passe ne correspondent pas");
        
        return false;
    }

    var birthday = document.getElementById("birthday").value.split('-');

    if( (birthday[1] < 1 || birthday[1] > 12) || (birthday[2] < 1 || birthday[2] > 31) || birthday[0] < 1900 )
    {
        alert("Format de date incorrect");

        return false;
    }

    var current_year = 2022;

    if(current_year - birthday[0] < 18)
    {
        alert("Tu dois avoir 18 ans minimum");

        return false;
    }






    return true;
}