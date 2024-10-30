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

  <form action="/tareanueva/controlesnoti/logicacat.php?operacion=<?php echo (isset($_GET['id'])) ? 'edit' : 'new' ?>" method="post">
    <a href="/tareanueva/admin/index.php">Volver</a>
    <div>
        <input type="text" name="categoria" value="<?php echo (isset($_GET["id"]) && isset($categoria->nombre)) ? $categoria->nombre : "" ?>" placeholder="Inserte una categoria" required>
        <input type="submit" name="enviar">
        <input type="hidden" name="hidden" value="<?php echo (isset($_GET["id"]) && isset($categoria->id)) ? $categoria->id : "" ?>">
    </div>
</form>

     </div>
     <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NOMBRE</th>
            
                </tr>
                
            </thead>
     </tr>
                
            </thead>
            <tbody><!-- Aca repetis la tabla pero utilizando el bucle while para ir actualizando con php-->
            <?php while ($fila = $resultado->fetch_object()) { ?> 
                
                <tr>
                    <td> <?php echo $fila->id ?></td>
                    <td> <?php echo $fila->nombre ?></td>
                  
                    <td><a href="/tareanueva/admin/categoria.php?operacion=edit&id=<?php echo $fila->id ?>">Editar</a></td>
                    <td><a href="/tareanueva/controlesnoti/logicacat.php?operacion=delete&id=<?php echo $fila->id ?>" onclick="return confirm('¿Estas seguro de querer eliminar esta categoria?');">Eliminar</a></td>
                </tr>
                <?php }?> 

<style>
        a{
            text-decoration: none;
            color: #007bff;
            padding: 5px 10px;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }
        a:hover {
            background-color: #007bff;
            color: #fff;
        }
        
    </style>
</body>
</html>