<?php

class Class_connexion
{
    public  $connection;
    private $db_Name_host_Name;
    private $db_User;
    private $db_PassWord;

    public function __construct($db_name, $host_name, $user, $passWord)
     { 
        $this->db_Name_host_Name = 'mysql:dbname=' . $db_name . ';' . 'host=' . $host_name;
        $this->db_User = $user;
        $this->db_PassWord = $passWord;
        try
         {
            $this->connection=new PDO($this->db_Name_host_Name, $this->db_User, $this->db_PassWord);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         } 
     catch(PDOException $error)
        {
         echo 'Erreur de connexion : ' . $error->getMessage();
        }
     }
     
   public function insertIntoTable($table, $columnsOfTable) // permet inserer des valeurs dans une table
      {      
        $arrayOfValues = array(); //tableau contenant les valeurs à inserer dans la table 
        $arrayOfColumnName = array(); //tableau contenant les noms des colonnes de la table 
        $valuesToString = ""; 
        $columnNameToString = "";
        if( count($columnsOfTable) == 0 ) echo "Aucune donnée trouvée dans le tableau!!";
        else 
        {
         forEach( $columnsOfTable as $columnName => $valueOfColumn )
             {
                $arrayOfColumnName[] = $columnName;
                $arrayOfValues[] = "'" . $valueOfColumn . "'";
             }
                $columnNameToString = implode(",", $arrayOfColumnName); // joindre les élements de $arrayOfColumnName par un virgule pour les transformer en string
                $valuesToString = implode(",", $arrayOfValues); // joindre les élements de $arrayOfValues par un virgule pour les transformer en string
        }  
        $pdoStatement = $this->connection->prepare("INSERT INTO $table ( $columnNameToString ) VALUES ( $valuesToString );");
        $pdoStatement->execute(); 
      }

   public function selectFromTable($table, $arrayOfColumnToSelect = NULL, $keyColumn = NULL, $keyValue = NULL)
      {
         $arrayOfColumns = array();
         if( isset($arrayOfColumnToSelect) ) 
            {
               forEach( $arrayOfColumnToSelect as $columnName)
                 {
                    $arrayOfColumns[] = $columnName;
                 }
               $arrayOfColumnsToString = implode(",", $arrayOfColumns);
               if( !( isset($keyColumn) && isset($keyValue) ) )
                 {
                  $pdoStatement = $this->connection->prepare("SELECT $arrayOfColumnsToString FROM $table");  
                  $pdoStatement->execute(); 
                  $row = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);   
                 }
               else
                 {
                  $keyValue = str_replace(' ', '', $keyValue);
                  $pdoStatement = $this->connection->prepare("SELECT $arrayOfColumnsToString FROM $table WHERE $keyColumn = ?");  
                  $pdoStatement->execute([$keyValue]); 
                  $row = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
                 }
                 print_r($row);
               return $row;  
            } 
         else
           {
              $pdoStatement = $this->connection->query("SELECT * FROM $table");
              $row = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
             
              return $row;       
           }   
      }   
   
   public function deleteFromTable($table, $keyColumn, $keyValue)
      {
         $pdoStatement = $this->connection->prepare("DELETE FROM $table WHERE $keyColumn = ?");
         $pdoStatement->execute([$keyValue]);
      }  

   public function updateFromTable($table, $newValuesArray, $keyColumn, $keyValue)
      {
         $arrayOfColumnToUpdate = array();
         forEach($newValuesArray as $columnName => $newValue)
            {
               $columnName .= " = ";
               $newValue =  "'" . $newValue . "'";
               $columnName .= $newValue;
               $arrayOfColumnToUpdate[] = $columnName;
            }
         $columnToUpdate = implode(",", $arrayOfColumnToUpdate);
         $pdoStatement = $this->connection->prepare("UPDATE $table SET $columnToUpdate WHERE $keyColumn = ?"); 
         $pdoStatement->execute([$keyValue]);
      }    
}
//$test = new Class_connexion('banque', 'localhost', 'root', '');
//  $arrayC = ['nom'];
  //$test->deleteFromTable('client', 'numCompte', '1111');
?>