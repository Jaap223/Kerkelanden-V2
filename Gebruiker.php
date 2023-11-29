<?php
require_once 'Database.php';
require_once 'head/header.php';
//require_once 'Gebruiker.php';


class Gebruiker extends Database
{
    public function gebruiker_toevoegen()
    {
    }

    public function klant_registreren($user_name, $wachtwoord, $naam, $geboortedatum, $tel_nr, $adres, $rol)
    {
        try {
            $options = ['cost' => 6];
            $passwordCrypt = password_hash($wachtwoord, PASSWORD_BCRYPT, $options);
    
            $sql = "INSERT INTO gebruiker (user_name, wachtwoord, naam, geboortedatum, tel_nr, adres, rol) VALUES (:user_name, :wachtwoord, :naam, :geboortedatum, :tel_nr, :adres, :rol)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':user_name', $user_name);
            $stmt->bindParam(':wachtwoord', $passwordCrypt);
            $stmt->bindParam(':naam', $naam);
            $stmt->bindParam(':geboortedatum', $geboortedatum);
            $stmt->bindParam(':tel_nr', $tel_nr);
            $stmt->bindParam(':adres', $adres);
            $stmt->bindParam(":rol", $rol);
    
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

    echo $reg->klant_registreren($_POST['adres'], $_POST['wachtwoord'], $_POST['naam'], $_POST['geboortedatum'], $_POST['tel_nr'], $_POST['user_name'], $_POST['rol']);
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
                <input type="date" name="geboortedatum" id="geboortedatum">
                <label for="tel_nr">Telefoonnummer</label>
                <input type="text" name="tel_nr" id="tel_nr">
                <label for="adres">Adres</label>
                <label for="rol">Rol</label>
                <select name="rol" id="rol">
                    <option value="klant">Klant</option>
                    <option value="medewerker">Medewerker</option>                 
                </select>
                <input type="text" name="adres" id="adres">
                <input type="submit" name="klant_registreren" value="klant_registreren">
            </form>
            <a href="BaseUser.php">Inloggen</a>
        </section>
    </main>
</body>

</html>