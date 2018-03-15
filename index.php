<?php

require 'config/routes.php';


$app->get('/welcome', function() use($app, $db) {

    $result = array ('saludo'=>'Bienvenido a la aplicacion');

    echo json_encode($result);

});

$app->run();

?>
