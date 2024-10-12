<?php
require_once('../tareanueva/panel/includes/db.php');?>
<?php
    $id = $_POST["id"];
    $categoria = $_POST["categoria"];
    $sentencia = $conexion->prepare("UPDATE categorias SET nombre = ? WHERE id = ?");
    $sentencia->bind_param("si" , $categoria, $id);
    $sentencia->execute();
    
    header("location: /tareanueva/categoria.php");
    ?>

    