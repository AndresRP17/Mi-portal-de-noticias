<?php
//aca enlazas el archivo que creaste anteriormente y metes la variable//
include("../panel/includes/db.php");//Es por la ubicacion del archivo en PHP!!!
$resultado = $conexion->query("SELECT * FROM categorias");

if (isset($_GET["id"])) {

  $id = $_GET["id"];
  $sentencia = $conexion->prepare("SELECT * from categorias where id = ? ");
  $sentencia->bind_param("i", $id);
  $sentencia->execute();
  $resultado = $sentencia->get_result();
  $categoria = $resultado->fetch_object();

} else {

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categoria</title>
</head>
<body>

  <?php if (isset($_GET["id"])) { ?>
    <h1>EDITAR CATEGORIA</h1>
  <?php } else  ?>

  <form action="/tareanueva/controlesnoti/logicacat.php?operacion=<?php echo (isset($_GET['id'])) ? 'edit' : 'new' ?>" method="post" class="formulario">
    <a href="/tareanueva/admin/noticias.php" class="volver">Volver</a>
    <div class="form-group">
        <input type="text" name="categoria" value="<?php echo (isset($_GET["id"]) && isset($categoria->nombre)) ? $categoria->nombre : "" ?>" placeholder="Inserte una categoría" required>
        <input type="submit" name="enviar" value="Guardar" class="btn-enviar">
        <input type="hidden" name="hidden" value="<?php echo (isset($_GET["id"]) && isset($categoria->id)) ? $categoria->id : "" ?>">
    </div>
</form>

<table class="tabla-categorias">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($fila = $resultado->fetch_object()) { ?>
            <tr>
                <td> <?php echo $fila->id ?></td>
                <td> <?php echo $fila->nombre ?></td>
                <td>
                    <a href="/tareanueva/admin/categoria.php?operacion=edit&id=<?php echo $fila->id ?>" class="btn-editar">Editar</a>
                    <a href="/tareanueva/controlesnoti/logicacat.php?operacion=delete&id=<?php echo $fila->id ?>" class="btn-eliminar" onclick="return confirm('¿Estás seguro de querer eliminar esta categoría?');">Eliminar</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<style>
    /* Estilos generales */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f7fb;
        margin: 0;
        padding: 0;
        color: #333;
    }

    /* Estilo para el formulario */
    .formulario {
        background-color: #fff;
        padding: 20px;
        margin: 20px auto;
        max-width: 600px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .formulario a.volver {
        text-decoration: none;
        color: #007bff;
        font-size: 16px;
        margin-bottom: 15px;
        display: inline-block;
        transition: color 0.3s;
    }

    .formulario a.volver:hover {
        color: #0056b3;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group input[type="text"] {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .form-group input[type="submit"] {
        background-color: #007bff;
        color: white;
        font-size: 16px;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .form-group input[type="submit"]:hover {
        background-color: #0056b3;
    }

    /* Estilos para la tabla */
    .tabla-categorias {
        width: 100%;
        margin: 20px 0;
        border-collapse: collapse;
    }

    .tabla-categorias th, .tabla-categorias td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .tabla-categorias th {
        background-color: #007bff;
        color: white;
    }

    .tabla-categorias tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .tabla-categorias tr:hover {
        background-color: #f1f1f1;
    }

    /* Estilo para los enlaces de acción */
    .tabla-categorias .btn-editar, .tabla-categorias .btn-eliminar {
        text-decoration: none;
        padding: 5px 10px;
        color: white;
        border-radius: 5px;
        font-size: 14px;
    }

    .tabla-categorias .btn-editar {
        background-color: #28a745;
    }

    .tabla-categorias .btn-editar:hover {
        background-color: #218838;
    }

    .tabla-categorias .btn-eliminar {
        background-color: #dc3545;
    }

    .tabla-categorias .btn-eliminar:hover {
        background-color: #c82333;
    }
</style>
