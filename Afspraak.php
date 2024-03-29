<?php

session_start();

require_once 'head/header.php';
require_once 'Database.php';


class Afspraak extends Database
{
    public function afspraak_maken($gebruikerId, $patientId, $tijd, $datum, $locatie, $status)
    {
        try {
            $sql = "INSERT INTO afspraak(Gebruiker_id, Patiënt_id, Datum, Tijd, Locatie_id, Status) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);

            $stmt->bindParam(1, $gebruikerId, PDO::PARAM_INT);
            $stmt->bindParam(2, $patientId, PDO::PARAM_INT);
            $stmt->bindParam(3, $datum, PDO::PARAM_STR);
            $stmt->bindParam(4, $tijd, PDO::PARAM_STR);
            $stmt->bindParam(5, $locatie, PDO::PARAM_STR);
            $stmt->bindParam(6, $status, PDO::PARAM_STR);

            $stmt->execute();
            $rowCount = $stmt->rowCount();

            return $rowCount;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function afspraak_wijzigen($updateData = null)
    {
        try {
            if ($updateData) {
                $sql = "UPDATE afspraak SET Gebruiker_id = ?, Patiënt_id = ?, Datum = ?, Tijd = ?, Locatie_id = ?, Status = ? WHERE afspraak_id = ? LIMIT 1";
                $stmt = $this->connect()->prepare($sql);
                
                $stmt->bindParam(1, $updateData['Gebruiker_id'], PDO::PARAM_INT);
                $stmt->bindParam(2, $updateData['Patiënt_id'], PDO::PARAM_INT);
                $stmt->bindParam(3, $updateData['datum'], PDO::PARAM_STR);
                $stmt->bindParam(4, $updateData['tijd'], PDO::PARAM_STR);
                $stmt->bindParam(5, $updateData['locatie'], PDO::PARAM_STR);
                $stmt->bindParam(6, $updateData['status'], PDO::PARAM_STR);
                $stmt->bindParam(7, $updateData['afspraak_id'], PDO::PARAM_INT);

                $stmt->execute();
                return $stmt->rowCount();

            } else {

                $sql = "SELECT afspraak_id FROM afspraak";
                $stmt = $this->connect()->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function afspraak_annuleren($afspraakId)
    {
        try {
            $sql = "DELETE FROM afspraak WHERE afspraak_id = ? LIMIT 1";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $afspraakId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function behandeling_toevoegen()
    {
        try {
            $sql = "INSERT INTO Behandeling (behandeling_beschrijving, kosten) VALUES (:behandeling_beschrijving, :kosten)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':behandeling_beschrijving', $_POST['behandeling_beschrijving']);
            $stmt->bindParam(':kosten', $_POST['kosten']);
            $stmt->execute();

            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function behandeling_verwijderen($afspraakId)
    {
        try {
            if (isset($_POST['action']) && $_POST['action'] === 'behandeling_verwijderen') {
                $afspraakId = $_POST['afspraak_id'];

                $sql = "DELETE FROM afspraak WHERE afspraak_id = :afspraak_id LIMIT 1";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindParam(':afspraak_id', $afspraakId, PDO::PARAM_INT);
                $stmt->execute();

                //header("Location: OmgevingKlant.php");
                exit();
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}

$user_name = $_SESSION['user_name'];
$conn = new PDO("mysql:host=localhost;dbname=kerkelanden", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM gebruiker WHERE user_name = :user_name";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_name', $user_name);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result['Rol'] != 'assistent') {
    header("location: BaseUser.php");
    exit();
}


$afspraak = new Afspraak();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //print_r($_POST);

    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $afspraakId = $_POST['afspraak_id'];
        if (!empty($afspraakId)) {
            $result = $afspraak->afspraak_annuleren($afspraakId);
            echo $result > 0 ? "Afspraak met ID $afspraakId is geannuleerd" : "Er ging iets fout met het annuleren van de afspraak";
        } else {
            echo "Ongeldige aanvraag voor annulering";
        }
    } else {
        $fields = ['Gebruiker_id', 'Patient_id', 'datum', 'tijd', 'locatie', 'status'];
        $values = array_map(fn ($field) => $_POST[$field] ?? null, $fields);

        if (in_array(null, $values, true)) {
            echo "Vul alle velden in alstublieft";
        } else {
            $result = $afspraak->afspraak_maken(...$values);
            echo $result > 0 ? "Afspraak gemaakt op {$_POST['datum']}" : "Er ging iets fout met het afspraak maken";
        }
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
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <h1>A
                <h1>Afspraak Maken</h1>

                <label for="gebruiker">Gebruiker</label>
                <input type="text" name="Gebruiker_id">

                <label for="patient">Patiënt</label>
                <input type="text" name="Patient_id">

                <label for="tijd">Tijd</label>
                <input type="time" name="tijd" required>

                <label for="datum">Datum</label>
                <input type="date" name="datum" required>

                <label for="locatie">Locatie</label>
                <input type="text" name="locatie" required>

                <label for="status">Status</label>
                <input type="text" name="status" required>

                <button type="submit" name="afspraak_maken">Maak Afspraak</button>
        </form>
    </section>

    <?php if (isset($resultaat)) : ?>
        <p><?php echo $resultaat; ?></p>
    <?php endif; ?>

    <?php
    $afspraken = $afspraak->afspraak_wijzigen();
    ?>

    <section class="formR">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <h1>Afspraak Wijzigen</h1>

            <label for="afspraak_id">Selecteer afspraak voor update:</label>
            <select name="afspraak_id" required>
                <?php foreach ($afspraken as $afspraak) : ?>
                    <option value="<?= $afspraak['afspraak_id'] ?>"><?= $afspraak['afspraak_id'] ?></option>
                <?php endforeach; ?>
            </select>

            <input type="hidden" name="action" value="update">
            <label for="gebruiker">Gebruiker</label>
            <input type="text" name="Gebruiker_id">

            <label for="patient">Patiënt</label>
            <input type="text" name="Patient_id">

            <label for="tijd">Tijd</label>
            <input type="time" name="tijd" required>

            <label for="datum">Datum</label>
            <input type="date" name="datum" required>

            <label for="locatie">Locatie</label>
            <input type="text" name="locatie" required>

            <label for="status">Status</label>
            <input type="text" name="status" required>

            <button type="submit" name="action" value="update">Update Afspraak</button>
        </form>
    </section>

</body>

</html>