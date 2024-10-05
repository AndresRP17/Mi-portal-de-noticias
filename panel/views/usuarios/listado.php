<?php
//aca enlazas el archivo que creaste anteriormente y metes la variable//
include("../../includes/db.php");//Es por la ubicacion del archivo en PHP!!!
$resultado = $conexion->query("SELECT * FROM usuarios");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado</title>
</head>
<body>
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

<a href="/tareanueva/panel/views/usuarios/formulario.php">Agregar</a>
    <table><!-- Aca haces la tabla normal-->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>EMAIL</th>
                    <th>PASSWORD</th>
                </tr>
                <a href="/tareanueva/index.php">Volver</a>
            </thead>
            <tbody><!-- Aca repetis la tabla pero utilizando el bucle while para ir actualizando con php-->
            <?php while ($fila = $resultado->fetch_object()) { ?> 
                
                <tr>
                    <td> <?php echo $fila->id ?></td>
                    <td> <?php echo $fila->email ?></td>
                    <td> <?php echo $fila->password ?></td>
                    <td><a href="/tareanueva/panel/views/usuarios/formulario.php?id=<?php echo $fila->id ?>">Editar</a></td>
                    <td><a href="/tareanueva/panel/controlador/usuarios.php?operacion=delete&id=<?php echo $fila->id ?>" onclick="return confirm('¿Estas seguro de querer eliminar este usuario?');">Eliminar</a></td>
                </tr>
                
        <?php }?>
    </tbody>
    </table>



</body>
</html>