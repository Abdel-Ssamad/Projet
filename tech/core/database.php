<?php

try
{
    $conn = new PDO('mysql:host=localhost;port=3306;dbname=asr_tech', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
}
catch (PDOException $e) 
{
      echo 'Echec de la connexion : ' . $e->getMessage();
      
      exit;
}

?>