<?php

  $host = 'localhost';
  $user = '';
  $password = '';
  $dbname = 'my-db';

  $db = new mysqli($host,$user,$password,$dbname);

  if ($db->connect_error){
      echo "Error al conectar con la BD";

  }

?>
