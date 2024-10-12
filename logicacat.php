<?php
include_once("../includes/db.php");
$operacion = $_GET["operacion"];

if ($operacion == "edit") {

    $id = $_POST["id"];
    $categoria = $_POST["categoria"];
    $sentencia = $conexion->prepare("UPDATE categorias SET nombre = ? WHERE id = ?");
    $sentencia->bind_param("si" , $categoria, $id);
    $sentencia->execute();
    
} else if ($operacion == "delete"){
    
    $id = $_GET["id"];
    $sentencia = $conexion->prepare("DELETE FROM categorias WHERE id = ?");
    $sentencia->bind_param("i" , $id);
    $sentencia->execute();
    
}

header("Location: /tareanueva/panel/views/usuarios/listado.php");
//aca van a estar todas las operaciones que podes realizar en el formulario
exit();
?>