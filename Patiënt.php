<?php 

require_once 'head/header.php';

require_once 'Database.php';



class Patiënt extends Afspraak{


    public function afspraken_overzicht()
    {
        $sql = "SELECT * FROM afspraak WHERE Patiënt_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $Patiënt_id, PDO::PARAM_INT);
        $stmt->execute();


        $afspraken = $stmt->fetchAll(PDO::FETCH_ASSOC);



        return $afspraken;
    }
    
}
$patient = new Patiënt();
$patientId = 14; 
$appointments = $patient->afspraken_overzicht($patientId);



?>