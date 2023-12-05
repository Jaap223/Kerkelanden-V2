<?php

require_once 'head/header.php';
require_once 'Database.php';
require_once 'Behandeling.php';

$overzicht = new Behandeling();
$behandeling = $overzicht->bekijken();

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

        <?php if ($behandeling) : ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Naam behandeling</th>
                        <th>Beschrijving behandeling</th>
                        <th>Kosten behandeling</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $behandeling['Behandeling_id'] ?></td>
                        <td><?= $behandeling['naam'] ?></td>
                        <td><?= $behandeling['behandeling_beschrijving'] ?></td>
                        <td><?= $behandeling['kosten'] ?></td>
                    </tr>
                </tbody>
            </table>
        <?php else : ?>
            <p>Geen behandelingen gevonden.</p>
        <?php endif; ?>

    </div>

</body>

</html>