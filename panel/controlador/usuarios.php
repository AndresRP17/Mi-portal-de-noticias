<?php
include_once("../includes/db.php");
$operacion = $_GET["operacion"];

if ($operacion == "new") {
    $nombre = $_POST["nombre"];
    $sentencia = $conexion->prepare("INSERT INTO usuarios (nombre) VALUES (?) ");
    $sentencia->bind_param("s", $nombre);
    $sentencia->execute();

} else if ($operacion == "edit") {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $sentencia = $conexion->prepare("UPDATE usuarios SET nombre = ? WHERE id = ?");
    $sentencia->bind_param("si" , $nombre, $id);
    $sentencia->execute();

} else if ($operacion == "delete"){
    
    $id = $_GET["id"];
    $sentencia = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
    $sentencia->bind_param("i", $id);
    $sentencia->execute();
    
}

header("Location: /tareanueva/panel/views/usuarios/listado.php");
//aca van a estar todas las operaciones que podes realizar en el formulario
exit();
?>