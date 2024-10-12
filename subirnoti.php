<?php

include("../tareanueva/panel/includes/db.php");

if (isset($_GET["id"])){

    $id = $_GET["id"];//por get obtenes el id que vas a trabajar//
    $sentencia = $conexion->prepare("SELECT * FROM noticias WHERE id = ? ");//preparas sentencia
    $sentencia->bind_param("i", $id);//parametros con el que trabajas aca es un numeror por eso int
    $sentencia->execute();
    $resultado = $sentencia->get_result();
    $usuario = $resultado->fetch_object();

} else {

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <div>
    <form action="/tareanueva/noticias.php?operacion=<?php echo (isset($_GET['id']))  ?>"  method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo (isset($_GET["id"])) ? $noticia->id : "" ?>"> <!-- aca se hace que si tiene ID es edit o new-->
    <h1>NUEVA NOTICIA</h1>
    <input type="text" name="titulo"  value="<?php echo (isset($_GET["id"])) ? $noticia->titulo : "" ?>"placeholder="Ingrese un titulo" required><br>
    
    <input type="text" name="descripcion" placeholder="Ingrese una descripcion" required><br>
    
    <input type="text" name="texto" placeholder="Ingrese un texto" required><br>
    
    <input type="file"  name="imagen"  required><br>
    
    <input type="date" name="fecha" placeholder="Ingrese una fecha" required><br>

    <input type="submit" value="Enviar" required>

    <input type="hidden" name="hidden" value="1" required>
 </form>

    </div>


</body>
</html>