<?php
session_start();
require_once 'head/header.php';
require_once 'Database.php';
require_once 'fpdf.php';

$user_name = $_SESSION['user_name'];

$conn = new PDO("mysql:host=localhost;dbname=kerkelanden", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM gebruiker WHERE user_name = :user_name";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_name', $user_name);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dateRange'])) {
    $selectedDate = $_POST['dateRange'];

    
    $data = fetchDataForPDF($selectedDate);

   
    generatePDF($data);

    exit();
}

function fetchDataForPDF($selectedDate) {

    $data = [
        ['Name' => 'John Doe', 'AppointmentDate' => '2023-01-01', 'OtherField' => 'Value'],
        ['Name' => 'Jane Smith', 'AppointmentDate' => '2023-01-02', 'OtherField' => 'Another Value'],
       
    ];

    return $data;
}

function generatePDF($data) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(40, 10, 'Appointment Overview');


    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Name', 1);
    $pdf->Cell(40, 10, 'Appointment Date', 1);
    $pdf->Cell(40, 10, 'Other Field', 1);

  
    $pdf->Ln();
    $pdf->SetFont('Arial', '', 12);
    foreach ($data as $row) {
        $pdf->Cell(40, 10, $row['Name'], 1);
        $pdf->Cell(40, 10, $row['AppointmentDate'], 1);
        $pdf->Cell(40, 10, $row['OtherField'], 1);
        $pdf->Ln();
    }

    $pdf->Output();
}
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

    <div class="formR">
        <h1>Overzicht Printen</h1>

        <form action="" method="post">

            <label for="dateRange">Select Date Range:</label>
            <input type="date" id="dateRange" name="dateRange" required>

            <button type="submit">Overzicht afspraken</button>
        </form>

        <div id="printMessage"></div>

    </div>

</body>

</html>
