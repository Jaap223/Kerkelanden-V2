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

        return $stmt->fetchAll();
    }
}




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $behandeling = new Behandeling();

    $naam = $_POST['naam'];
    $behandeling_beschrijving = $_POST['beschrijving'];
    $kosten = $_POST['kosten'];

    $resultaat = $behandeling->invoeren($beschrijving, $kosten);
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
    <h1>Toevoegen behandeling</h1>
    <?php if (isset($resultaat)) : ?>
        <p><?php echo $resultaat; ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="naam">Naam behandeling</label>
        <input type="text" name="naam" required>
        <label for="kosten">Kosten behandeling</label>
        <input type="number" name="kosten" required>
        <label for="naam">Naam behandeling</label>
        <input type="submit" value="invoeren" required>

    </form>
</body>

</html>