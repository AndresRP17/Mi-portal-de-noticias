<?php

include("../tareanueva/panel/includes/db.php");

if (isset($_GET["id"])){

    $id = $_GET["id"];//por get obtenes el id que vas a trabajar//
    $sentencia = $conexion->prepare("SELECT * FROM noticias WHERE id = ? ");//preparas sentencia
    $sentencia->bind_param("i", $id);//parametros con el que trabajas aca es un numeror por eso int
    $sentencia->execute();
    $resultado = $sentencia->get_result();
    $noticia = $resultado->fetch_object();

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
<a href="/tareanueva/index.php">Volver</a>

<div class="item">
    <div>

    
                <div>
                    <a href="detalle.php?id=<?php echo $noticia->id; ?>">
                     <img src="<?php echo $noticia->imagen; ?>">
                     </a>
                     <h2><?php echo $noticia->titulo ?></h2>
                     <h2><?php echo $noticia->descripcion ?></h2>
                     <h2><?php echo $noticia->texto ?></h2>
                     <h2><?php echo $noticia->fecha ?></h2>
                    </div>
                </div>
    
</div>
</body>
</html>
