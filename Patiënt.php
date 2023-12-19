<?php
require_once 'head/header.php';
require_once 'Database.php';
require_once 'Afspraak.php';

class Patiënt extends Afspraak
{

  

    public function afspraken_overzicht($Patiënt_id)
    {
        $afspraken = []; 
    
        try {
            $sql = "SELECT Afspraak_id, Gebruiker_id, Patiënt_id, Locatie_id, status, Datum, Tijd, Factuur_id FROM afspraak WHERE Patiënt_id = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $Patiënt_id, PDO::PARAM_INT);
            $stmt->execute();
    
            if ($stmt->errorCode() !== '00000') {
                throw new Exception("Error executing query: " . implode(", ", $stmt->errorInfo()));
            }
    
            $afspraken = $stmt->fetchAll(PDO::FETCH_ASSOC);
           // var_dump($afspraken);
        } catch (Exception $e) {
            error_log("Error executing query: " . $e->getMessage());
        }
    
        return $afspraken; 
    }
    


    
}
$patient = new Patiënt();
$patientId = 10; 
$afspraken = $patient->afspraken_overzicht($patientId);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>head</title>
</head>

<body>
<div class="overzichtTab">
        <h1>Overzicht Afspraken</h1>

        <?php if (!empty($afspraken)) : ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Status</th>
                        <th>Datum</th>
                        <th>Tijd</th>
                        <th>Verwijder afspraak</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($afspraken as $afspraak) : ?>
                        <tr>
                            <td><?= $afspraak['Afspraak_id'] ?></td>
                            <td><?= ucfirst(strtolower($afspraak['status'])) ?></td>
                            <td><?= date('d-m-Y', strtotime($afspraak['Datum'])) ?></td>
                            <td><?= $afspraak['Tijd'] ? date('H:i', strtotime($afspraak['Tijd'])) : '' ?></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="afspraak_id" value="<?= $afspraak['Afspraak_id'] ?>">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Weet u zeker dat u deze afspraak wilt verwijderen?')">Verwijder</button>
                                </form>
                                <form method="POST" action="">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="afspraak_id" value="<?= $afspraak['Afspraak_id'] ?>">
                                    <button type="submit" class="btn btn-update" onclick="return confirm('Weet u zeker dat u deze afspraak wilt wijzigen?')">Wijzig</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>Geen afspraken gevonden.</p>
        <?php endif; ?>
    </div>
</body>
</html>