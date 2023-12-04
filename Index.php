<?php
session_start();



require_once 'head/header.php';
require_once 'Database.php';
require_once 'head/footer.php';


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

    <?php echo 'Welcome, ' . $_SESSION['user_name'] . '!'; ?>
    <?php
    if (isset($_SESSION['inloggen']) && $_SESSION['inloggen']) {
    echo '<a href="BaseUser.php">Logout</a>';
    
}
 ?>
</body>
<main>
    <section>
        <article class="info">

        </article>
    </section>

</main>