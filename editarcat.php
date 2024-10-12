<?php require_once('../tareanueva/panel/includes/db.php');
$id = $_GET["id"];
$sentencia = $conexion->prepare("SELECT * from categorias where id = ? ");
$sentencia->bind_param("i", $id);
$sentencia->execute();
$resultado = $sentencia->get_result();
$categoria = $resultado->fetch_object();
?>

<h1>EDITAR CATEGORIA</h1>
<form action="/tareanueva/guardarcat.php" method="post">
    <input type="hidden" name="id" value="<?php echo $categoria->id ?>">
<input type="text" name="categoria" value="<?php echo $categoria->nombre ?>">
<button type="submit">Guardar</button>
</form>






