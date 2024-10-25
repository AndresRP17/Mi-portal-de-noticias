<?php
require_once('../tareanueva/panel/includes/db.php');?>
<?php
    $id = $_POST["id"];
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $texto = $_POST["texto"];
    $imagen = $_POST["imagen"];
    $fecha = isset($_POST['fecha']) && !empty($_POST['fecha']) ? $_POST['fecha'] : date('Y-m-d');

    
    $sentencia = $conexion->prepare("UPDATE noticias SET titulo = ?, descripcion = ?, texto = ?,  imagen = ?, fecha = ? WHERE id = ?");
    $sentencia->bind_param("sssssi" , $titulo, $descripcion, $texto, $imagen, $fecha, $id);
    $sentencia->execute();
    echo $sentencia;