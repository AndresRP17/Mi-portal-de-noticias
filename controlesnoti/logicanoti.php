<?php


require_once('../panel/includes/db.php');



$operacion = $_GET["operacion"] ?? '';

if ($operacion === "new") {
    // Verifica si se ha enviado el formulario
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Recibe y valida datos del formulario
        $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
        $texto = isset($_POST['texto']) ? trim($_POST['texto']) : '';
        $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
        $fecha = isset($_POST['fecha']) && !empty($_POST['fecha']) ? trim($_POST['fecha']) : date('Y-m-d H:i:s');
        $id_categoria = isset($_POST['id_categoria']) ? intval($_POST['id_categoria']) : 0; 

        // Manejo de la imagen destacada
        $imagen = '';
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $nombreArchivo = $_FILES['imagen']['name'];
            $archivoTmp = $_FILES['imagen']['tmp_name'];
            $carpetaDestino = '../viewsnoticias/uploads/';
            $rutaArchivo = $carpetaDestino . basename($nombreArchivo);

            if (move_uploaded_file($archivoTmp, $rutaArchivo)) {
                $imagen = $rutaArchivo; // Solo asignar si se movió correctamente
            } else {
                echo 'Error al mover la imagen destacada.';
            }
        } else {
            echo 'Error en la carga de la imagen destacada.';
        }

        // Inserta en la base de datos
        if (!empty($imagen) && $id_categoria != 0) { // Verifica que la imagen no esté vacía y que la categoría sea válida
            $stmt = $conexion->prepare('INSERT INTO noticias (titulo, texto, id_categoria, imagen, descripcion, fecha) VALUES (?, ?, ?, ?, ?, ?)');
            if (!$stmt) {
                echo 'Error al preparar la consulta: ' . $conexion->error;
                exit();
            }

            $stmt->bind_param('ssisss', $titulo, $texto, $id_categoria, $imagen, $descripcion, $fecha);
            if ($stmt->execute()) {
                // Obtener el ID de la noticia recién insertada
                $id_noticia = $stmt->insert_id; 

                // Manejo de la galería de imágenes
                if (isset($_FILES["upload"]) && count($_FILES["upload"]["name"]) > 0) {
                    $cantidadArchivos = count($_FILES["upload"]["name"]);
                    for ($i = 0; $i < $cantidadArchivos; $i++) {
                        if ($_FILES["upload"]["error"][$i] == 0) {
                            $archivoEnCache = $_FILES["upload"]["tmp_name"][$i];
                            $nuevaRuta = generarNombreRuta($_FILES["upload"]["name"][$i]);

                            if (subirImagen($archivoEnCache, $nuevaRuta)) {
                                // Inserta en la tabla de imágenes de la noticia
                                $sql = "INSERT INTO noticias_imagenes (id_noticia, ruta_imagen) VALUES (?, ?)";
                                $stmt_imagen = $conexion->prepare($sql);
                                $stmt_imagen->bind_param("is", $id_noticia, $nuevaRuta);
                                
                                if (!$stmt_imagen->execute()) {
                                    echo 'Error al insertar la imagen en la base de datos: ' . $stmt_imagen->error;
                                }
                            }
                        }
                    }
                }
                // Redirigir después de insertar
                header("Location: /tareanueva/admin/noticias.php");
                exit();
            } else {
                echo 'Error al ejecutar la consulta: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            echo 'No se ha cargado una imagen válida o la categoría es inválida.';
        }
    }

} else if ($operacion == "edit") {
    $id = isset($_POST["hidden"]) ? intval($_POST["hidden"]) : 0; 
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $texto = $_POST["texto"];
    $fecha = isset($_POST['fecha']) && !empty($_POST['fecha']) ? $_POST['fecha'] : date('Y-m-d H:i:s');

    // Inicializa la variable de imagen
    $imagen = '';

    // Verifica si se subió una nueva imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        // Procesa la nueva imagen
        $nombreArchivo = $_FILES['imagen']['name'];
        $archivoTmp = $_FILES['imagen']['tmp_name'];
        $carpetaDestino = '../viewsnoticias/uploads/';
        $rutaArchivo = $carpetaDestino . basename($nombreArchivo);

        if (move_uploaded_file($archivoTmp, $rutaArchivo)) {
            $imagen = $rutaArchivo; // Nueva imagen
        } else {
            echo 'Error al mover la nueva imagen destacada.';
        }
    }

    // Si no se subió una nueva imagen, obtén la imagen actual de la base de datos
    if (empty($imagen)) {
        $sentencia = $conexion->prepare("SELECT imagen FROM noticias WHERE id = ?");
        $sentencia->bind_param("i", $id);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $noticia = $resultado->fetch_object();
        $imagen = $noticia->imagen; // Mantén la imagen existente
    }

    // Ahora actualiza la base de datos
    $sentencia = $conexion->prepare("UPDATE noticias SET titulo = ?, descripcion = ?, texto = ?, imagen = ?, fecha = ? WHERE id = ?");
    $sentencia->bind_param("ssissi", $titulo, $descripcion, $texto, $imagen, $fecha, $id);
    
    if ($sentencia->execute()) {
        // Ahora manejar la galería de imágenes
        if (isset($_FILES["upload"]) && count($_FILES["upload"]["name"]) > 0) {
            $cantidadArchivos = count($_FILES["upload"]["name"]);
            for ($i = 0; $i < $cantidadArchivos; $i++) {
                if ($_FILES["upload"]["error"][$i] == 0) {
                    $archivoEnCache = $_FILES["upload"]["tmp_name"][$i];
                    $nuevaRuta = generarNombreRuta($_FILES["upload"]["name"][$i]);

                    if (subirImagen($archivoEnCache, $nuevaRuta)) {
                        // Inserta en la tabla de imágenes de la noticia
                        $sql = "INSERT INTO noticias_imagenes (id_noticia, ruta_imagen) VALUES (?, ?)";
                        $stmt_imagen = $conexion->prepare($sql);
                        $stmt_imagen->bind_param("is", $id, $nuevaRuta); // Cambia $id_noticia por $id
                        
                        if (!$stmt_imagen->execute()) {
                            echo 'Error al insertar la imagen en la base de datos: ' . $stmt_imagen->error;
                        }
                    }
                }
            }
        }

        // Redirigir después de actualizar
        header("Location: /tareanueva/admin/noticias.php");
        exit();
    } else {
        echo 'Error al ejecutar la actualización: ' . $sentencia->error;
    }

    
} else if ($operacion === "delete") {
    $id = intval($_GET["id"]);
    $sentencia = $conexion->prepare("DELETE FROM noticias WHERE id = ?");
    $sentencia->bind_param("i", $id);
    $sentencia->execute();

    header("Location: /tareanueva/admin/noticias.php");
    exit();
}

// Funciones para manejar nombres y carga de imágenes
function generarNombreRuta($nombreArchivo) {
    $carpeta = "../viewsnoticias/uploads/";
    return $carpeta . date("YmdHis") . "_" . basename($nombreArchivo);
}

function subirImagen($archivoEnCache, $nuevaRuta) {
    if (empty($archivoEnCache)) {
        return false;
    }

    return move_uploaded_file($archivoEnCache, $nuevaRuta);
}
?>
