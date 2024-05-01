<?php
include "../Models/connexion.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");
header('Content-Type: application/json');   

//$keyOfSearch = json_decode(file_get_contents("php://input"), true);
$keyOfSearch = $_GET['search'];
//error_log($keyOfSearch);
//$keyOfSearch = "Toavina";

$connectObject = new Class_connexion('banque', 'localhost', 'root', '');
$pdoStatement = $connectObject->connection->prepare("SELECT * FROM client WHERE numCompte LIKE ? OR nom LIKE ?");
$pdoStatement->execute(['%' . $keyOfSearch . '%', '%' . $keyOfSearch . '%']);

$result = $pdoStatement->fetchAll();
// Parcours du tableau
foreach ($result as $key => $item) {
    // Création d'un nouveau tableau pour stocker les éléments sans clé numérique
    $newItem = [];
    // Parcours des éléments de l'item actuel
    foreach ($item as $innerKey => $value) {
        // Vérification si la clé est numérique
        if (!is_numeric($innerKey)) {
            // Ajout de l'élément dans le nouveau tableau
            $newItem[$innerKey] = $value;
        }
    }
    // Remplacement de l'élément actuel par le nouveau tableau
    $result[$key] = $newItem;
}

    foreach ($result as &$element)
     {
         if ($element['solde'] < 1000) $element['Observation'] = "Insuffisant";
         elseif ($element['solde'] > 5000) $element['Observation'] = "Elevé";
         else $element['Observation'] = "Moyen";
    }

  echo json_encode($result);

?>