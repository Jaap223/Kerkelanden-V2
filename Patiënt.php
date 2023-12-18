<?php
require_once 'head/header.php';
require_once 'Database.php';
require_once 'Afspraak.php';

class Patiënt extends Afspraak
{
    public function afspraken_overzicht($Patiënt_id)
    {
        try {
            $sql =  "SELECT Afspraak_id, Gebruiker_id, Patiënt_id, Locatie_id, status, Datum, Tijd, Factuur_id, Notities FROM afspraak WHERE Patiënt_id = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $Patiënt_id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->errorCode() !== '00000') {
                throw new Exception("Error executing query: " . implode(", ", $stmt->errorInfo()));
            }

            $afspraken = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $afspraken;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

$patient = new Patiënt();
$patientId = 14;
$appointments = $patient->afspraken_overzicht($patientId);
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
    <section class="formR">
        <h2>Afspraken Overzicht</h2>
        <table>
            <thead>
                <tr>
                    <th>Datum</th>
                    <th>Tijd</th>
                   
                </tr>
            </thead>
            <tbody>
                <?php foreach ($afspraken as $afspraak) : ?>
                    <tr>
                        <td><?php echo $afspraak['Datum']; ?></td>
                        <td><?php echo $afspraak['Tijd']; ?></td>
                    
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</body>

</html>