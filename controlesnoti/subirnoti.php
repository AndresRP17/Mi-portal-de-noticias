<?php
include("../panel/includes/db.php");

$noticia = null;
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sentencia = $conexion->prepare("SELECT * FROM noticias WHERE id = ?");
    $sentencia->bind_param("i", $id);
    $sentencia->execute();
    $resultado = $sentencia->get_result();
    $noticia = $resultado->fetch_object();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($noticia) ? "EDITAR NOTICIA" : "EDITAR NOTICIA"; ?></title>
</head>
<body>

<h1><?php echo isset($noticia) ? "EDITAR NOTICIA" : "NUEVA NOTICIA"; ?></h1>

<div>
    <form action="/tareanueva/controlesnoti/logicanoti.php?operacion=<?php echo isset($noticia) ? 'edit' : 'new'; ?>" method="post" enctype="multipart/form-data">

        <input type="hidden" name="hidden" value="<?php echo isset($noticia->id) ? $noticia->id : ""; ?>">

        <label>TITULO</label>
        <input type="text" name="titulo" value="<?php echo isset($noticia->titulo) ? htmlspecialchars($noticia->titulo) : ""; ?>" placeholder="Ingrese un título" required><br>

        <label>DESCRIPCIÓN</label>
        <input type="text" name="descripcion" value="<?php echo isset($noticia->descripcion) ? htmlspecialchars($noticia->descripcion) : ""; ?>" placeholder="Ingrese una descripción" required><br>

        <label>TEXTO</label>
        <input type="text" name="texto" value="<?php echo isset($noticia->texto) ? htmlspecialchars($noticia->texto) : ""; ?>" placeholder="Ingrese un texto"><br>

        <label>IMAGEN</label>
        <input type="file" name="imagen"><br>

        <label>GALERÍA DE IMÁGENES</label>
        <input type="file" name="upload[]" multiple><br>

        <label>FECHA</label>
        <input type="datetime-local" name="fecha" value="<?php echo isset($noticia->fecha) ? date('Y-m-d\TH:i', strtotime($noticia->fecha)) : ""; ?>" required><br>


        <label>INSERTE UNA CATEGORÍA</label>
        <select name="id_categoria" id="categoria">
            <option value="3" <?php echo (isset($noticia->id_categoria) && $noticia->id_categoria == 3) ? 'selected' : ''; ?>>Accidentes</option>
            <option value="5" <?php echo (isset($noticia->id_categoria) && $noticia->id_categoria == 5) ? 'selected' : ''; ?>>Politica</option>
            <option value="6" <?php echo (isset($noticia->id_categoria) && $noticia->id_categoria == 6) ? 'selected' : ''; ?>>Entretenimientos</option>
            <option value="1" <?php echo (isset($noticia->id_categoria) && $noticia->id_categoria == 1) ? 'selected' : ''; ?>>Deportes</option>
            <option value="4" <?php echo (isset($noticia->id_categoria) && $noticia->id_categoria == 4) ? 'selected' : ''; ?>>Música</option>
            <option value="12" <?php echo (isset($noticia->id_categoria) && $noticia->id_categoria == 12) ? 'selected' : ''; ?>>Otros</option>
        </select><br>

        <input type="submit" value="Enviar">
    </form>
</div>

</body>
</html>
