<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$app = new \Slim\Slim();

$db = new mysqli('localhost','','','angular');

  if ($db->connect_error){
    echo "Error al conectar con la BD";
  }

$app->get('/hello', function() use($app, $db) {

    echo "hola mundo";

    var_dump($db);
    });

//Insertar un producto
$app->post('/productos', function() use($app, $db){
      $json = $app->request->post('json');
      $data = json_decode($json, true);

      if (!isset($data['nombre'])){
        $data['nombre']=null;
      }
      if (!isset($data['descripcion'])){
        $data['descripcion']=null;
      }
      if (!isset($data['precio'])){
        $data['precio']=null;
      }
      if (!isset($data['imagen'])){
        $data['imagen']=null;
      }

      $sql = "INSERT INTO productos VALUES (NULL,".
                              "'{$data['nombre']}',".
                              "'{$data['descripcion']}',".
                              "'{$data['precio']}',".
                              "'{$data['imagen']}'".
                              ");";

      $query = $db->query($sql);

      $result = array(
            'status' => 'ok',
            'code' => 404,
            'mensaje' => 'Producto no creado'
      );

      if($query){
        $result = array(
              'status' => 'ok',
              'code' => 200,
              'mensaje' => 'Producto creado correctamente'
        );
      }
    //  var_dump($query);

    echo json_encode($result); //Devolvemos un JSON

});

//Listar productos
$app->get('/productos', function() use($app, $db){
    $sql = "SELECT * FROM productos;";

    $query = $db->query($sql);

    if($query){
        $productos = array();
        while ($producto = $query->fetch_assoc()) {
          $productos[] = $producto;
        }
        $result = array(
              'status' => 'ok',
              'code' => 200,
              'data' => $productos
        );
     }else{
       $result = array(
             'status' => 'no',
             'code' => 404,
             'data' => "Error en la consulta"
       );
     }

    echo json_encode($result); //Devolvemos un JSON
});

//Listar un productos
$app->post('/productos/one', function() use($app, $db){
      $json = $app->request->post('json');
      $data = json_decode($json, true);
      $var =  (int) $data['id'];

      $sql = "SELECT * FROM productos WHERE id = $var;";

      $query = $db->query($sql);

      if($query->num_rows==1){
        $producto = $query->fetch_assoc();
        $result = array(
              'status' => 'ok',
              'code' => 200,
              'data' => $producto
        );
      }else{
        $result = array(
              'status' => 'no',
              'code' => 404,
              'data' => 'Producto no disponible'
        );
      }
      echo json_encode($result); //Devolvemos un JSON
});

//Eliminar un producto

//Actualizar un producto

//Subir una imagen a un producto

$app->run();

?>
