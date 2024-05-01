<?php
include "../Models/connexion.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");
header('Content-Type: application/json');   

$updatedClientData = json_decode(file_get_contents("php://input"), true);
$connectObject = new Class_connexion('banque', 'localhost', 'root', '');    
$pdoStatement = $connectObject->updateFromTable('client', $updatedClientData, 'numCompte',$updatedClientData['numCompte']);

?>