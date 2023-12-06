<?php

require_once 'head/header.php';
require_once 'Database.php';
require_once 'Behandeling.php';

$overzicht = new Behandeling();
$behandelingen = $overzicht->bekijken();

$verwijderObj = new behandeling();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {

    $verwijderObj->delete($_POST['behandeling_id']);

    header("Location: Overzicht.php");
    exit();
}

$overzicht = new Behandeling();
$behandelingen = $overzicht->bekijken();



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Overzicht Behandeling</title>
</head>

<body>

    <div class="overzichtTab">
        <h1>Overzicht Behandelingen</h1>

        <?php if (!empty($behandelingen)) : ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Beschrijving behandeling</th>
                        <th>Kosten behandeling</th>
                        <th>verwijder behandeling</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($behandelingen as $behandeling) : ?>
                        <tr>
                            <td><?= $behandeling['Behandeling_id'] ?></td>
                            <td><?= $behandeling['behandeling_beschrijving'] ?></td>
                            <td><?= $behandeling['kosten'] ?></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="behandeling_id" value="<?= $behandeling['Behandeling_id'] ?>">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Weet u zeker dat u deze behandeling wilt verwijderen?')">Verwijder</button>

                                </form>

                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>Geen behandelingen gevonden.</p>
        <?php endif; ?>

    </div>

</body>

</html>