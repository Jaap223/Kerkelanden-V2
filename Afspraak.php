<?php


session_start();

require_once 'head/header.php';
require_once 'Database.php';

class Afspraak extends database
{
    public function afspraak_maken($gebruikerId, $patientId, $tijd, $datum, $locatie, $status)
    {
        try {
            $sql = "INSERT INTO afspraak(Gebruiker_id, Patiënt_id, Datum , Tijd,  Locatie_id, status) VALUES (?, ?, ?, ?, ?, ?)";
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

    public function afspraak_wijzigen()
    {
        $sql = "UPDATE afspraak SET Gebruiker_id = ?, Patiënt_id = ?, Datum = ? WHERE behandeling_id = ? LIMIT 1";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $_POST['Gebruiker_id'], PDO::PARAM_INT);
        $stmt->bindParam(2, $_POST['Patiënt_id'], PDO::PARAM_INT);
        $stmt->bindParam(3, $_POST['datum'], PDO::PARAM_STR);
        $stmt->bindParam(4, $_POST['behandeling_id'], PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
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

    public function afspraak_annuleren($afspraakId)
    {

        try {
            $sql = "DELETE FROM afspraak WHERE afspraak_id = ? LIMIT 1";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $afspraakId, PDO::PARAM_INIT);
            $stmt->connect();

            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function behandeling_toevoegen()
    {
        $sql = "INSERT INTO Behandeling (behandeling_beschrijving, kosten) VALUES (:behandeling_beschrijving, :kosten)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':behandeling_beschrijving', $_POST['behandeling_beschrijving']);
        $stmt->bindParam(':kosten', $_POST['kosten']);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function behandeling_verwijderen($afspraakId)
    {
        if (isset($_POST['action']) && $_POST['action'] === 'behandeling_verwijderen') {
            $afspraakId = $_POST['afspraak_id'];


            $sql = "DELETE FROM afspraak WHERE afspraak_id = :afspraak_id LIMIT 1";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':afspraak_id', $afspraak_id);
            $stmt->execute();

            //header("Location: OmgevingKlant.php");
            exit();
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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    print_r($_POST);

    $afspraak = new Afspraak();

    if ($_POST['action'] == 'delete') {
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
        </form>
    </section>
</body>

</html>