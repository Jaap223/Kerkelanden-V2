<?php

require_once 'head/header.php';
require_once 'head/footer.php';
require_once 'Database.php';

class behandeling extends database
{


    public function invoeren()
    {
    }
}




if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $behandeling = new behandeling();

    $naam = $_POST['naam'];
    $kosten = $_POST['kosten'];


    $resultaat = $behandeling->invoeren($naam, $kosten);
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