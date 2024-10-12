<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4; /* Color de fondo */
            margin: 20px;
        }

        table {
            width: 100%; /* Ancho de la tabla */
            border-collapse: collapse; /* Elimina los espacios entre las celdas */
            margin: 20px 0; /* Espacio alrededor de la tabla */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra para la tabla */
        }

        th, td {
            padding: 12px; /* Espacio interno de las celdas */
            text-align: left; /* Alineación del texto */
            border: 1px solid #dddddd; /* Borde de las celdas */
        }

        th {
            background-color: #4CAF50; /* Color de fondo de los encabezados */
            color: white; /* Color del texto en encabezados */
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Color de fondo para filas pares */
        }

        tr:hover {
            background-color: #ddd; /* Color de fondo al pasar el mouse */
        }
    </style>
<body>
<?php


// Incluir db
require_once('../tareanueva/panel/includes/db.php');

// Capturar error de datos mal ingresados
$error = isset($_GET["error"]) ? intval($_GET["error"]) : 0;

// Capturar valor del hidden
$form = isset($_POST["hidden"]) ? intval($_POST["hidden"]) : 0;

// Si hidden es 1 hacer la consulta
if ($form) {
    // Capturar todos los valores de la noticia
    $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
    $texto = isset($_POST['texto']) ? trim($_POST['texto']) : '';
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
    $fecha = isset($_POST['fecha']) && !empty($_POST['fecha']) ? trim($_POST['fecha']) : date('Y-m-d H:i:s');

    // Verificar si hay una imagen y si no hubo errores en la subida
    if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $nombreArchivo = $_FILES['imagen']['name'];
        $archivoTmp = $_FILES['imagen']['tmp_name'];
        $carpetaDestino = 'uploads/'; // Carpeta donde se guardarán las imágenes

        // Crear la ruta completa del archivo
        $rutaArchivo = $carpetaDestino . basename($nombreArchivo);

        // Mover el archivo al directorio destino
        if(move_uploaded_file($archivoTmp, $rutaArchivo)) {
            // Si el archivo se movió correctamente, insertar la ruta en la base de datos
            $imagen = $rutaArchivo;
        } else {
            echo "Error al subir la imagen.";
            exit();
        }
    } else {
        $imagen = ''; // Si no hay imagen, guardar vacío o lo que decidas.
    }

    // Preparar la consulta
    $stmt = $conexion->prepare('INSERT INTO noticias (titulo, texto, imagen, descripcion, fecha) VALUES (?,?,?,?,?)');
    
    // Hacer un bind de los valores de la petición
    $stmt->bind_param('sssss', $titulo, $texto, $imagen, $descripcion, $fecha);

    if ($stmt->execute()) {
        header('Location: noticias.php'); // Si stmt execute dio true, redirigir
        exit;
    } else {
        echo 'Error al insertar el registro: ' . $stmt->error;
        header('Location: ../noticias.php?error=1'); // Si hay error, redirigir a la misma página con error
        exit();
    }

    $stmt->close();
}

?>

<?php
  if ($error) { ?>
    <h1>Error al cargar los datos, inténtelo nuevamente.</h1>
  <?php } ?>

  <a href="/tareanueva/subirnoti.php">Agregar</a>

  <a href="/tareanueva/index.php">Volver</a>


<?php
//aca enlazas el archivo que creaste anteriormente y metes la variable//
include("../tareanueva/panel/includes/db.php");//Es por la ubicacion del archivo en PHP!!!
$resultado = $conexion->query("SELECT * FROM noticias order by fecha");
?>

<table><!-- Aca haces la tabla normal-->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>TITULO</th>
                    <th>DESCRIPCION</th>
                      <th>TEXTO</th>
                      <th>IMAGEN</th>
                      <th>FECHA</th>

            
                </tr>
                
            </thead>
     </tr>
                
            </thead>
            <tbody><!-- Aca repetis la tabla pero utilizando el bucle while para ir actualizando con php-->
            <?php while ($fila = $resultado->fetch_object()) { ?> 
                
                <tr>
                    <td> <?php echo $fila->id ?></td>
                    <td> <?php echo $fila->titulo ?></td>
                    <td> <?php echo $fila->descripcion ?></td>
                    <td> <?php echo $fila->texto ?></td>
                    <td><img width="100" src="<?php echo $fila->imagen; ?> " /></td>
                    <td> <?php echo $fila->fecha ?></td>
                    <td><a href="/tareanueva/editarnoti.php?id=<?php echo $fila->id ?>">Editar</a></td>
                    <td><a href="/tareanueva/eliminarnoti.php?id=<?php echo $fila->id ?>" onclick="return confirm('¿Estas seguro de querer eliminar esta noticia?');">Eliminar</a></td>
                </tr>
                <?php }?> 
    </tbody>
    </table>
</body>
</html>