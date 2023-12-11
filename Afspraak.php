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

    public function afspraak_annuleren()
    {
        $sql = "DELETE FROM afspraak WHERE Gebruiker_id = ? AND Patiënt_id = ? AND Datum = ? LIMIT 1";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $_POST['Gebruiker_id'], PDO::PARAM_INT);
        $stmt->bindParam(2, $_POST['Patiënt_id'], PDO::PARAM_INT);
        $stmt->bindParam(3, $_POST['datum'], PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
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

    public function behandeling_verwijderen($behandeling_id)
    {
        $sql = "DELETE FROM behandeling WHERE behandeling_id = :behandeling_id LIMIT 1";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':behandeling_id', $_POST['behandeling_id']);
        $stmt->execute();
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
    $gebruikerId = $_POST["Gebruiker_id"];
    $patientId = $_POST["Patient_id"];
    $datum = $_POST["datum"];
    $tijd = $_POST["tijd"];
    $locatie = $_POST["locatie"];
    $status = $_POST["status"];

    if (empty($gebruikerId) || empty($patientId) || empty($tijd) || empty($datum) || empty($locatie) || empty($status)) {
        echo "Vul alle velden in alstublieft";
    } else {
        $afspraak = new Afspraak();
        // print_r($_POST);
        $result = $afspraak->afspraak_maken($gebruikerId, $patientId, $tijd, $datum, $locatie, $status);

        if ($result > 0) {
            echo "Afspraak gemaakt op $datum";
        } else {
            echo "Er ging iets fout met het afspraak maken";
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
    </section>
</body>

</html>