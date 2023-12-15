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
  
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(40, 10, 'Hello World!');
    $pdf->Output();
    exit();
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


            <button type="submit">Generate PDF</button>
        </form>
        =
        <div id="printMessage"></div>

    </div>

</body>

</html>