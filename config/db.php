<?php

  $host = 'localhost';
  $user = '';
  $password = '';
  $dbname = 'angular';

  $db = new mysqli($host,$user,$password,$dbname);

  if ($db->connect_error){
      echo "Error al conectar con la BD";

  }

?>
