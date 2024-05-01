<?php
include "../Models/connexion.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");
header('Content-Type: application/json');   


$connectObject = new Class_connexion('banque', 'localhost', 'root', '');
$result = $connectObject->selectFromTable('client');

   foreach ($result as &$element)
    {
        if ($element['solde'] < 1000) $element['Observation'] = "Insuffisant";
        elseif ($element['solde'] > 5000) $element['Observation'] = "Elevé";
        else $element['Observation'] = "Moyen";
   }

 echo json_encode($result);


?>