<?php
session_start();
require_once 'head/header.php';
require_once 'Database.php';
require_once 'fpdf.php';

$user_name = $_SESSION['user_name'];

$conn = new PDO("mysql:host=localhost;dbname=kerkelanden", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dateRange'])) {
    $selectedDate = $_POST['dateRange'];
    $data = fetchDataForPDF($user_name, $selectedDate, $conn);
    generatePDF($data);
    exit();
}

// Haal de data van de gebruiker op die momenteel is ingelogd op de applicatie
function fetchDataForPDF($user_name, $selectedDate, $conn)
{
    try {
        
        $sql = "SELECT Naam, `Afspraak datum`, kosten FROM Afspraak 
                WHERE Gebruiker_id = (SELECT Gebruiker_id FROM Gebruiker WHERE user_name = :user_name)
                AND Datum = :selectedDate";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_name', $user_name);
        $stmt->bindParam(':selectedDate', $selectedDate);
        $stmt->execute();

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            $data = [
                ['Naam' => $userData['Naam'], 'Afspraak datum' => $userData['Afspraak datum'], 'kosten' => $userData['kosten']],
            ];
            return $data;
        } else {
            return [];
        }
    } catch (Exception $e) {
      
        return [];
    }
}
// genereert een PDF op basis van de naam, afspraak, datum en kosten 
function generatePDF($data)
{
    ob_start();
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(40, 10, 'Afspraak & behandelingen overzicht');

    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Naam', 1);
    $pdf->Cell(40, 10, 'Afspraak datum', 1);
    $pdf->Cell(40, 10, 'kosten', 1);

    $pdf->Ln();
    $pdf->SetFont('Arial', '', 12);
    foreach ($data as $row) {
        $pdf->Cell(40, 10, $row['Naam'], 1);
        $pdf->Cell(40, 10, $row['Afspraak datum'], 1);
        $pdf->Cell(40, 10, $row['kosten'], 1);
        $pdf->Ln();
    }

    $pdf->Output();
    ob_end_flush();
}
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
    <div class="formR">
        <h1>Factuur Bekijken</h1>
        <form action="" method="post">
            <label for="dateRange">Select Date Range:</label>
            <input type="date" id="dateRange" name="dateRange" required>
            <button type="submit">Factuur printen</button>
        </form>
        <div id="printMessage">

        </div>
    </div>
</body>

</html>
