<?php
require_once 'Database.php';
require_once 'head/header.php';

if (isset($_POST['klant_registreren'])) {
    echo $reg->registreren($_POST['adres'], $_POST['wachtwoord'], $_POST['naam'], $_POST['geboorte_datum'], $_POST['tel_nr'], $_POST['user_name']);
}

class Gebruiker extends Database
{



    public function gebruiker_toevoegen()
    {
    }

    public function klant_registreren($user_name, $wachtwoord, $naam, $geboortedatum, $tel_nr, $adres)
    {
        try {
            if($wachtwoord == $wachtwoordCon){
                $options = ['cost' => 12];

                $passwordCrypt = password_hash($wachtwoord, PASSWORD_BCRYPT, $options);

                $sql = "INSERT INTO gebruiker (user_name, wachtwoord, naam, geboortedatum, tel_nr, adres)";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindParam(':user_name', $user_name);
                $stmt->bindParam(':wachtwoord', $passwordCrypt);
                $stmt->bindParam(':naam', $naam);
                $stmt->bindParam(':geboortedatum', $geboortedatum);
                $stmt->bindParam(':tel_nr', $tel_nr);
                $stmt->bindParam(':adres', $adres);
                if($stmt->execute()){
                    
                }
                
            }
        }
    }

    public function overzicht_printen()
    {
    }

    public function alle_afspraken_overzicht()
    {
    }
}






?>


<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>head</title>
</head>





<body>


    <main>
        <label>Klant registreren</label>
        <section class="formR">
            <form method="post">
                <label for="naam">Naam</label>
                <input type="text" name="naam" id="naam">
                <label for="user_name">User name</label>
                <input type="text" name="user_name" id="user_name">
                <label for="wachtwoord">Wachtwoord</label>
                <input type="password" name="wachtwoord" id="wachtwoord">
                <label for="geboorte_datum">Geboorte datum</label>
                <input type="date" name="geboorte_datum" id="geboorte_datum">
                <label for="adres">Adres</label>
                <input type="text" name="adres" id="adres">
            </form>
            <a href="BaseUser.php">Inloggen</a>
        </section>
    </main>
</body>

</html>