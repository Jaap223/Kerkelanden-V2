<?php

require_once 'head/header.php';
require_once 'head/footer.php';
require_once 'Database.php';

class behandeling extends database
{


    public function invoeren()
    {
        $sql = "INSERT INTO Behandeling (behandeling_beschrijving, kosten) VALUES (:behandeling_beschrijving, :kosten)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':behandeling_beschrijving', $_POST['behandeling_beschrijving']);
        $stmt->bindParam(':kosten', $_POST['kosten']);
        $stmt->execute();

        return $stmt->rowCount();
    }



    public function update()
    {
        $sql = "UPDATE behandeling SET behandeling_beschrijving = :behandeling_beschrijving, kosten = :kosten  WHERE behandeling_id = :behandeling_id LIMIT 1";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':behandeling_beschrijving', $_POST['behandeling_beschrijving']);
        $stmt->bindParam(':kosten', $_POST['kosten']);
        $stmt->bindParam(':behandeling_id', $_POST['behandeling_id']);
        $stmt->execute();
        return $stmt->rowCount();
    }


    public function delete()
    {
        $sql = "DELETE FROM behandeling WHERE behandeling_id = :behandeling_id LIMIT 1";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':behandeling_id', $behandeling_id);
        $stmt->execute();
    }


    public function bekijken()
    {
        $sql = "SELECT * FROM behandeling WHERE behandeling_id = :behandeling_id LIMIT 1";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':behandeling_id', $_GET['behandeling_id']);
        $stmt->execute();
        return $stmt->fetch();
    }
}





if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $behandeling = new Behandeling();

    $naam = $_POST['naam'];
    $behandeling_beschrijving = $_POST['behandeling_beschrijving'];
    $kosten = $_POST['kosten'];

    $resultaat = $behandeling->invoeren($behandeling_beschrijving, $kosten);
}

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
</body>

</html>