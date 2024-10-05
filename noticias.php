<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php


// Incluir db
  require_once('../tareanueva/panel/includes/db.php');

// Capturar error de datos mal ingresados
  $error = isset($_GET["error"]) ? intval($_GET["error"]) : 0;

// Capturar valor del hidden
 $form = isset($_POST["hidden"]) ? intval($_POST["hidden"]) : 0;
// Si hidden es 1 hacer la consulta
if ($form){
    // Capturar todos los valores de la noticia
    $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
    $texto = isset($_POST['texto']) ? trim($_POST['texto']) : '';
    $imagen = isset($_POST['imagen']) ? trim($_POST['imagen']) : '';
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
    $fecha = isset($_POST['fecha']) && !empty($_POST['fecha']) ? trim($_POST['fecha']) : date('Y-m-d H:i:s');
    // Preparar la consulta
    $stmt = $conexion->prepare('INSERT INTO noticias (titulo, texto, imagen, descripcion, fecha) VALUES (?,?,?,?,?)');
    // Hacer un bind de los valores de la peticion
    $stmt->bind_param('sssss', $titulo, $texto, $imagen, $descripcion, $fecha);

    if ($stmt->execute()) {
      header('Location: noticias.php');// Si stmt execute dio true redirigir a la misma pagina para seguir agregando
      exit;
    } else {
      echo 'Error al insertar el registro: ' . $stmt->error;
      header('Location: ../noticias.php?error=1');// Else hacer una redireccion a la misma pagina pero en la url decir error=1
      exit();
    }

    $stmt->close();
  };

?>

<?php
  if ($error) { ?>
    <h1>Error al cargar los datos, inténtelo nuevamente.</h1>
  <?php } ?>


  <a href="/tareanueva/index.php">Volver</a>

    <div>
    <form action="" method="post">

    <input type="text" name="titulo" placeholder="Ingrese un titulo" required><br>
    
    <input type="text" name="descripcion" placeholder="Ingrese una descripcion" required><br>
    
    <input type="text" name="texto" placeholder="Ingrese un texto" required><br>
    
    <input type="text" size="100"  name="imagen" placeholder="Ingrese una imagen" required><br>
    
    <input type="date" name="fecha" placeholder="Ingrese una fecha" required><br>

    <input type="submit" value="Enviar" required>

    <input type="hidden" name="hidden" value="1" required>
     </form>

     </div>

</body>
</html>