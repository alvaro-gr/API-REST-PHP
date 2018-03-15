<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require 'config/db.php';

$app = new \Slim\Slim();

//Insertar un producto
$app->post('/productos/add', function() use($app, $db){
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

//Listar un producto
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


//Listar un producto
$app->post('/productos/delete', function() use($app, $db){
      $json = $app->request->post('json');
      $data = json_decode($json, true);
      $var =  (int) $data['id'];

      $sql = "DELETE FROM productos WHERE id = $var;";

      $query = $db->query($sql);

      if($query){
        $result = array(
              'status' => 'ok',
              'code' => 200,
              'data' => 'Producto eliminado correctamente'
        );
      }else{
        $result = array(
              'status' => 'no',
              'code' => 404,
              'data' => 'No se ha podedido eliminar el producto'
        );
      }

      echo json_encode($result); //Devolvemos un JSON
});

//Actualizar un producto
$app->post('/productos/update', function() use($app, $db){
      $json = $app->request->post('json');
      $data = json_decode($json, true);

      $id =  $data['id'];
      $nombre = $data['nombre'];
      $descripcion = $data['descripcion'];
      $precio = $data['precio'];

      $sql = "UPDATE productos SET nombre = '$nombre', descripcion = '$descripcion', precio = $precio WHERE id = $id;";

      $query = $db->query($sql);

      if($query){
        $result = array(
          'status' => 'ok',
          'code' => 200,
          'data' => 'Producto actualizado correctamente'
        );
      }else{
        $result = array(
          'status' => 'no',
          'code' => 404,
          'data' => 'No se ha podedido actualizar el producto'
        );
      }

      echo json_encode($result); //Devolvemos un JSON

});

//Subir una imagen a un producto


 ?>
