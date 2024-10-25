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
    <form action="/tareanueva/agregarnoti.php"  method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="1"> <!-- aca se hace que si tiene ID es edit o new-->
    <h1>NUEVA NOTICIA</h1>

    <labeL>TITULO</label>
    <input type="text" name="titulo" placeholder="Ingrese un titulo" required><br>
    
    <label>DESCRIPCION</label>
    <input type="text" name="descripcion" placeholder="Ingrese una descripcion" required><br>
    
    <label>TEXTO</label>
    <input type="text" name="texto" placeholder="Ingrese un texto"><br>
    
    <label>IMAGEN</label>
    <input type="file"  name="imagen"  required><br>

    <label>GALERIA DE IMAGENES</label>
    <input type="file" name="upload[]" multiple  /><br>
    
    <label>FECHA</label>
    <input type="date" name="fecha" placeholder="Ingrese una fecha" required><br>

    <label>INSERTE UNA CATEGORIA</label>
    <select name="id_categoria" id="categoria">

    <option value="6">Entretenimientos</option>

    <option value="1">Deportes</option>

    <option value="4">Musica</option>

    <option value="12">Otros</option>

    </select><br>

    <input type="submit" value="Enviar" required>

 </form>

    </div>


</body>
</html>