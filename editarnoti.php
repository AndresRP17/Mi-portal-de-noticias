<?php require_once('../tareanueva/panel/includes/db.php');
$id = $_GET["id"];
$sentencia = $conexion->prepare("SELECT * from noticias where id = ? ");
$sentencia->bind_param("i", $id);
$sentencia->execute();
$resultado = $sentencia->get_result();
$noticia = $resultado->fetch_object();
?>

<h1>EDITAR NOTICIA</h1>
<form action="/tareanueva/guardarnoti.php" method="post">
    <input type="hidden" name="id" value="<?php echo $noticia->id ?>"><br>

    <label>TITULO</label>
    <input type="text" name="titulo" value="<?php echo $noticia->titulo ?>"><br>
    <label>DESCRIPCION</label>
    <input type="text" name="descripcion" value="<?php echo $noticia->descripcion ?>"><br>
    <label>TEXTO</label>
    <input type="text" name="texto" value="<?php echo $noticia->texto ?>"><br>
    <label>IMAGEN</label>
    <input type= "file" name="imagen" value="<?php echo $noticia->imagen ?>"><br>
    <label>GALERIA DE IMAGENES</label>
    <input type= "file" name="imagen" value="<?php echo $noticia->imagen ?>"><br>
    <label>FECHA</label>
    <input type="date" name="fecha" value="<?php echo (isset($noticia->fecha)) ? date('Y-m-d', strtotime($noticia->fecha)) : ""; ?>" required><br>
    <label>INSERTE UNA CATEGORIA</label>
    <select name="id_categoria" id="categoria">

    <option value="6">Entretenimientos</option>

    <option value="1">Deportes</option>

    <option value="4">Musica</option>

    <option value="12">Otros</option>

    </select><br>
<button type="submit">Guardar</button>
</form>