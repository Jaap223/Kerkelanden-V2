<?php
require_once 'Database.php';
require_once 'head/header.php';
//require_once 'Gebruiker.php';


class Gebruiker extends Database
{
    public function gebruiker_toevoegen()
    {
    }

    public function klant_registreren($naam, $adres, $wachtwoord, $geboortedatum, $tel_nr, $rol, $user_name)
    {
        try {
            $options = ['cost' => 6];
            $passwordCrypt = password_hash($wachtwoord, PASSWORD_BCRYPT, $options);
    
            $sql = "INSERT INTO gebruiker (Naam, Adres, Wachtwoord, Geboortedatum, Tel_nr, Rol, user_name) VALUES (:naam, :adres, :wachtwoord, :geboortedatum, :tel_nr, :rol, :user_name)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':naam', $naam);
            $stmt->bindParam(':adres', $adres);
            $stmt->bindParam(':wachtwoord', $passwordCrypt);
            $stmt->bindParam(':geboortedatum', $geboortedatum);
            $stmt->bindParam(':tel_nr', $tel_nr);
            $stmt->bindParam(':rol', $rol);
            $stmt->bindParam(':user_name', $user_name);
    
            if ($stmt->execute()) {
                header("Location: BaseUser.php");
            } else {
                throw new Exception("Er ging iets fout met het account aanmaken.");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function overzicht_printen()
    {
    }

    public function alle_afspraken_overzicht()
    {
    }
}

$reg = new Gebruiker();

if (isset($_POST['klant_registreren'])) {
    echo $reg->klant_registreren(
        $_POST['naam'],
        $_POST['adres'],
        $_POST['wachtwoord'],
        $_POST['geboortedatum'],
        $_POST['tel_nr'],
        $_POST['rol'],
        $_POST['user_name']
    );
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
                
                <label for="adres">Adres</label>
                <input type="text" name="adres" id="adres">

                <label for="wachtwoord">Wachtwoord</label>
                <input type="password" name="wachtwoord" id="wachtwoord">

                <label for="geboortedatum">Geboorte datum</label>
                <input type="date" name="geboortedatum" id="geboortedatum">

                <label for="tel_nr">Telefoonnummer</label>
                <input type="text" name="tel_nr" id="tel_nr">

                <label for="rol">Kies rol</label>
                <select name="rol" id="rol">
                    <option value="klant">Klant</option>
                    <option value="medewerker">Medewerker</option>
                </select>

                <label for="user_name">User name</label>
                <input type="text" name="user_name" id="user_name">


           

                <input type="submit" name="klant_registreren" value="klant_registreren">
            </form>
            <a href="BaseUser.php">Inloggen</a>
        </section>


    </main>
</body>

</html>