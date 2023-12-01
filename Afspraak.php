<?php


require_once 'head/header.php';
require_once 'Database.php';



class Afspraak extends database
{

    public function afspraak_maken()
    {
        $sql = "INSERT INTO afspraak(gebruiker,patient,datum,tijd,locatie,`status`) VALUES (?, ?, ? ,? ,?,?)";
    }

    public function afspraak_wijzigen()
    {
    }


    public function afspraak_annuleren()
    {
    }

    public function behandeling_toevoegen()
    {
    }


    public function behandeling_verwijderen()
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
    <title>Afspraak Maken</title>
</head>

<body>

    <section class="formR">
        <form method="post">
            <h1>Afspraak Maken</h1>

            <label for="gebruiker">gebruiker</label>

            <input type="gebruiker" name="gebruiker" required>


            <label for="patient">patient</label>

            <input type="patient" name="patient" required>
            <label for="datum">datum</label>
            <input type="datum" name="datum" required>
            <label for="tijd">Tijd:</label>

            <input type="tijd" name="tijd" required>

            <label for="locatie">locatie</label>

            <input type="locatie" name="locatie" required>

            <label for="status">status</label>

            <input for="status" name="status" required>

            <button type="submit" name="submit">Maak Afspraak</button>

        </form>

    </section>
</body>

</html>