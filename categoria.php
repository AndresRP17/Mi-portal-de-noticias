<?php
//aca enlazas el archivo que creaste anteriormente y metes la variable//
include("../tareanueva/panel/includes/db.php");//Es por la ubicacion del archivo en PHP!!!
$resultado = $conexion->query("SELECT * FROM categorias");
?>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Incluir db
  require_once('../tareanueva/panel/includes/db.php');

// Capturar error de datos mal ingresados
  $error = isset($_GET["error"]) ? intval($_GET["error"]) : 0;

// Capturar valor del hidden
 $form = isset($_POST["hidden"]) ? intval($_POST["hidden"]) : 0;
// Si hidden es 1 hacer la consulta
if ($form){
    // Capturar todos los valores de la noticia
    $categoria = isset($_POST['categoria']) ? trim($_POST['categoria']) : '';
    
    // Preparar la consulta
    $stmt = $conexion->prepare('INSERT INTO categorias (nombre) VALUES (?)');
    // Hacer un bind de los valores de la peticion
    $stmt->bind_param('s', $categoria);

    if ($stmt->execute()) {
      header('Location: categoria.php');// Si stmt execute dio true redirigir a la misma pagina para seguir agregando
      exit;
    } else {
      echo 'Error al insertar el registro: ' . $stmt->error;
      header('Location: ../categoria.php?error=1');// Else hacer una redireccion a la misma pagina pero en la url decir error=1
      exit();
    }

    $stmt->close();
  };

?>

<?php
  if ($error) { ?>
    <h1>Error al cargar los datos, inténtelo nuevamente.</h1>
  <?php } ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categoria</title>
</head>
<body>
    <form action="" method="post">

    <a href="/tareanueva/index.php">Volver</a>

    <div>
    <input type="text" name="categoria" placeholder="Inserte una categoria porfi" required>
   
    <input type="submit" name="enviar">
    <input type="hidden" name="hidden" value="1">
     </form>
     </div>



  

</body>
</html>