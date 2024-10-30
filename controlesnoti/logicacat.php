<?php
require_once('../panel/includes/db.php');

$operacion = $_GET["operacion"] ?? '';

if ($operacion === "new") {
    // Capturar el valor del campo 'categoria' enviado desde el formulario
    $categoria = isset($_POST['categoria']) ? trim($_POST['categoria']) : '';

    if ($categoria) {
        // Preparar la consulta
        $stmt = $conexion->prepare('INSERT INTO categorias (nombre) VALUES (?)');
        $stmt->bind_param('s', $categoria);
        $stmt->execute();
    }
    
    // Redirigir y salir
    header("Location: /tareanueva/admin/categoria.php");
    exit();
}

if ($operacion === "edit") {
    // Capturar el ID y el valor de la categoría
    $id = isset($_POST["hidden"]) ? intval($_POST["hidden"]) : 0;
    $categoria = isset($_POST["categoria"]) ? trim($_POST["categoria"]) : '';

    if ($id && $categoria) {
        // Preparar la consulta de actualización
        $sentencia = $conexion->prepare("UPDATE categorias SET nombre = ? WHERE id = ?");
        $sentencia->bind_param("si", $categoria, $id);
        $sentencia->execute();
    }

    // Redirigir y salir
    header("Location: /tareanueva/admin/categoria.php");
    exit();
}

if ($operacion === "delete") {
    // Capturar el ID de la categoría a eliminar
    $id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

    if ($id) {
        // Preparar la consulta de eliminación
        $sentencia = $conexion->prepare("DELETE FROM categorias WHERE id = ?");
        $sentencia->bind_param("i", $id);
        $sentencia->execute();
    }

    // Redirigir y salir
    header("Location: /tareanueva/admin/categoria.php");
    exit();
}
?>
