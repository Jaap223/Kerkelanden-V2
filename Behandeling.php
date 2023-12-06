<?php

require_once 'head/header.php';
require_once 'head/footer.php';
require_once 'Database.php';


class behandeling extends database
{
    public function invoeren()
    {
        $message = "";

        try {
            $sql = "INSERT INTO Behandeling (behandeling_beschrijving, kosten) VALUES (:behandeling_beschrijving, :kosten)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':behandeling_beschrijving', $_POST['behandeling_beschrijving']);
            $stmt->bindParam(':kosten', $_POST['kosten']);
            $stmt->execute();
            if ($stmt->execute()) {
                $message = "Behandeling opgeslagen, u wordt doorverwezen naar de volgende pagina.";
                header("Refresh: 3; URL=Overzicht.php");
            } else {
                throw new Exception("Er ging iets fout met de behandeling aanmaken.");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }



        return $message;
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if (isset($_POST['behandeling_beschrijving'], $_POST['kosten'], $_POST['behandeling_id'])) {

                    if (!is_numeric($_POST['kosten'])) {
                        throw new Exception("Invalid input for 'kosten'. Please provide a numeric value.");
                    }

                    $sql = "UPDATE behandeling SET behandeling_beschrijving = :behandeling_beschrijving, kosten = :kosten  WHERE behandeling_id = :behandeling_id LIMIT 1";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->bindParam(':behandeling_beschrijving', $_POST['behandeling_beschrijving']);
                    $stmt->bindParam(':kosten', $_POST['kosten']);
                    $stmt->bindParam(':behandeling_id', $_POST['behandeling_id']);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        $_SESSION['success_message'] = "Behandeling bijgewerkt";
                        header("Location: Overzicht.php");
                        exit();
                    } else {
                        throw new Exception("Geen wijzigingen aangebracht aan de behandeling. Mogelijk is het opgegeven ID niet gevonden.");
                    }
                } else {
                    throw new Exception("Niet alle vereiste velden zijn ingevuld.");
                }
            } catch (Exception $e) {
                error_log($e->getMessage(), 0);
                header("Location: error.php?message=" . urlencode($e->getMessage()));
                exit();
            }
        }
    }



    public function delete($behandeling_id)
    {


        if (isset($_POST['action']) && $_POST['action'] === 'delete') {
            $behandeling_id = $_POST['behandeling_id'];


            $sql = "DELETE FROM behandeling WHERE Behandeling_id = :behandeling_id LIMIT 1";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':behandeling_id', $behandeling_id);
            $stmt->execute();




            header("Location: Overzicht.php");
            exit();
        }
    }


    public function bekijken()
    {
        try {
            $sql = "SELECT * FROM Behandeling";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage(), 0);
            return false;
        }
    }
}


// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $behandeling = new Behandeling();

//     $naam = $_POST['naam'];
//     $behandeling_beschrijving = $_POST['behandeling_beschrijving'];
//     $kosten = $_POST['kosten'];

//     $resultaat = $behandeling->invoeren($behandeling_beschrijving, $kosten);
// }

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toevoegen Behandeling</title>
</head>

<body>

    <?php if (isset($resultaat)) : ?>
        <p><?php echo $resultaat; ?></p>
    <?php endif; ?>

    <form method="post">
        <div class="formR">
            <h1>Toevoegen behandeling</h1>
            <label for="naam">Naam behandeling</label>
            <input type="text" name="naam" required>
            <label for="behandeling_beschrijving">Beschrijving behandeling</label>
            <input type="text" name="behandeling_beschrijving" required>
            <label for="kosten">Kosten behandeling</label>
            <input type="number" name="kosten" required>
            <input type="submit" value="invoeren" required>
        </div>
    </form>


    <?php if (isset($resultaat)) : ?>
        <p><?php echo $resultaat; ?></p>
    <?php endif; ?>

    <form method="post">
        <div class="formR">
            <label for="behandeling_id">Selecteer behandeling voor update:</label>
            <select name="behandeling_id" required>
                <?php foreach ($behandelingen as $behandeling) : ?>
                    <option value="<?= $behandeling['Behandeling_id'] ?>"><?= $behandeling['behandeling_beschrijving'] ?></option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="action" value="update">
            <label for="behandeling_beschrijving">Nieuwe beschrijving behandeling</label>
            <input type="text" name="behandeling_beschrijving" required>
            <label for="kosten">Nieuwe kosten behandeling</label>
            <input type="number" name="kosten" required>
            <input type="submit" value="Bijwerken">
        </div>
    </form>
</body>

</html>