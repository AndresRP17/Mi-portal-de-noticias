<?php
require_once('../tareanueva/panel/includes/db.php');?>
<?php
    $id = $_GET["id"];
    $sentencia = $conexion->prepare("DELETE FROM noticias WHERE id = ?");
    $sentencia->bind_param("i" , $id);
    $sentencia->execute();
    
    header("location: /tareanueva/noticias.php");
    ?>