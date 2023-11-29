<?php


require_once 'Database.php';
require_once 'head/header.php';
//require_once 'Gebruiker.php';

// $gebruiker = new BaseUser();

// if(isset($_POST['inloggen'])){
//     $gebruiker->inloggen($_POST['user_name'], $_POST['wachtwoord']);
// }

class BaseUser extends Database
{
    private $naam;
    private $user_name;
    private $wachtwoord;
    private $geboorte_datum;
    private $adres;
    private $telefoonnummer;
    private $db;




    public function __construct()
    {
        $this->db = new Database();
    }


    public function inloggen ($user_name, $wachtwoord)
    {
      try {
        $sql = "SELECT * FROM gebruiker WHERE user_name = :user_name";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':user_name', $user_name);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if ($result && password_verify($wachtwoord, $result->wachtwoord)) {
            session_start();
            $_SESSION['inloggen'] = true;
            $_SESSION['user_name'] = $result->user_name;
            $conn = null;
            header('Location: index.php');
      } else {
        $conn = null;
        throw new Exception("Combinatie onjuist");
      }
    }catch(Exception $e){
        echo $e->getMessage();
    }
    }

    






    public function uitloggen()
    {
    }



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


    <main>
        <label>Inloggen</label>
        <section class="formR">
            <form method="post">

                <label for="user_name">User name</label>
                <input type="text" name="user_name" id="user_name">
                <label for="wachtwoord">Wachtwoord</label>
                <input type="password" name="wachtwoord" id="wachtwoord">
                <input type="submit" name="inloggen" value="Inloggen">
            </form>
            <a href="Gebruiker.php">Registreren</a>
        </section>
    </main>
</body>

</html>