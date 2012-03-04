<?php

$host = 'localhost';
$dbname = 'fit_dev';
$user = 'fit';
$pass = 'fit';

try {  
  $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);  
  $DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );  
}  
catch(PDOException $e) {  
  echo $e->getMessage();  
} 

//$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );



?> 
