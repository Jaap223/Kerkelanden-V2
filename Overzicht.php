<?php
session_start();
require_once 'head/header.php';
require_once 'Database.php';

$user_name = $_SESSION['user_name'];

$conn = new PDO("mysql:host=localhost;dbname=kerkelanden", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM gebruiker WHERE user_name = :user_name";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_name', $user_name);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

// checkt of de gebruiker geen medewerker is, als de gebruiker een medewerker of klant is heeft hij geen toegang tot de app 
if ($result['Rol'] != 'medewerker') {
    header("Location: BaseUser.php");
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
        <h1>Overzicht Printen </h1>

        <?php




        ?>

    </div>

</body>

</html>