<?php
include "../Models/connexion.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");
header('Content-Type: application/json');   

$connectObject = new Class_connexion('banque', 'localhost', 'root', '');
$result = $connectObject->connection->query( "SELECT MIN(solde) AS min, MAX(solde) AS max, SUM(solde) AS total FROM client");
$resultat = $result->fetchAll();
$tab = array();
foreach ($resultat as $element)
  {
    $tab[] = $element['min'];
    $tab[] = $element['max'];
    $tab[] = $element['total'];

  }
  $res = json_encode($tab);
  print_r($res);  


?>