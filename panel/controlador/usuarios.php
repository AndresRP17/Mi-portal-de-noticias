<?php
include_once("../includes/db.php");
$operacion = $_GET["operacion"];

if ($operacion == "new") {
    $email = $_POST["email"];
    $contraseña = $_POST["password"];
    $sentencia = $conexion->prepare("INSERT INTO usuarios (email, password) VALUES (?,?) ");
    $sentencia->bind_param("ss", $email, $contraseña);
    $sentencia->execute();

} else if ($operacion == "edit") {
    $id = $_POST["id"];
    $email = $_POST["email"];
    $contraseña = $_POST["password"];
    $sentencia = $conexion->prepare("UPDATE usuarios SET email = ?, password = ? WHERE id = ?");
    $sentencia->bind_param("ssi" , $email, $contraseña, $id);
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