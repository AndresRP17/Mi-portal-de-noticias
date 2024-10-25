<?php
include('../tareanueva/panel/includes/db.php');

$error = isset($_GET["error"]) ? intval($_GET["error"]) : 0;
$form = isset($_POST["id"]) ? intval($_POST["id"]) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $form) {
    $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
    $texto = isset($_POST['texto']) ? trim($_POST['texto']) : '';
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
    $fecha = isset($_POST['fecha']) && !empty($_POST['fecha']) ? trim($_POST['fecha']) : date('Y-m-d');
    $id_categoria = isset($_POST['id_categoria']) ? intval($_POST['id_categoria']) : 0;


    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        // Validar tipo y tamaño de la imagen destacada aquí
        $nombreArchivo = $_FILES['imagen']['name'];
        $archivoTmp = $_FILES['imagen']['tmp_name'];
        $carpetaDestino = 'uploads/';
        $rutaArchivo = $carpetaDestino . basename($nombreArchivo);

        if (move_uploaded_file($archivoTmp, $rutaArchivo)) {
            $imagen = $rutaArchivo;
        } else {
            header("Location: agregar_noti.php?error=imagen"); // Redirigir con error
            exit();
        }
    } else {
        header("Location: agregar_noti.php?error=no_imagen"); // Redirigir con error
        exit();
    }

    $stmt = $conexion->prepare('INSERT INTO noticias (titulo, texto, id_categoria, imagen, descripcion, fecha) VALUES (?, ?, ?, ?, ?, ?)');
    if (!$stmt) {
        echo 'Error al preparar la consulta: ' . $conexion->error;
        exit();
    }

    $stmt->bind_param('ssisss', $titulo, $texto, $id_categoria, $imagen, $descripcion, $fecha);
    if (!$stmt->execute()) {
        echo 'Error al ejecutar la consulta: ' . $stmt->error;
        exit();
    }

    $id_noticia = $stmt->insert_id;
    $stmt->close();


    // Obtenemos la cantidad de archivos de la galeria de imagenes
    $cantidadArchivos = count($_FILES["upload"]["name"]);
    for ($i = 0; $i < $cantidadArchivos; $i++) {
        if ($_FILES["upload"]["error"][$i] == 0) {
            $archivoEnCache = $_FILES["upload"]["tmp_name"][$i];
            $nuevaRuta = generarNombreRuta($_FILES["upload"]["name"][$i]);
            
            $resultado = subirImagen($archivoEnCache, $nuevaRuta);
            
            if ($resultado) {
                $sql = "INSERT INTO noticias_imagenes (id_noticia, ruta_imagen) VALUES (?, ?)";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("is", $id_noticia, $nuevaRuta);
                
                if (!$stmt->execute()) {
                    echo 'Error al insertar la imagen en la base de datos: ' . $stmt->error;
                }
                $stmt->close();
         
    }
    }}
    header("Location: /tareanueva/noticias.php");
exit();
}    
function generarNombreRuta($nombreArchivo) {
    $carpeta = "uploads/";
    return $carpeta . date("YmdHis") . "_" . basename($nombreArchivo);
}

function subirImagen($archivoEnCache, $nuevaRuta) {
    if (empty($archivoEnCache)) {
        return false;
    }

    $mimeType = mime_content_type($archivoEnCache);
    //if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif', 'image/jph', 'image/avif'])) { // Permitir más tipos de imágenes
      //  return false;
    //}

    return move_uploaded_file($archivoEnCache, $nuevaRuta);
}
?>