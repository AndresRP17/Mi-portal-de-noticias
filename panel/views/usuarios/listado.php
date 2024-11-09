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
     /* Estilos generales */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f7fa;
    margin: 0;
    padding: 0;
}

/* Contenedor principal */
.container {
    width: 80%;
    margin: 30px auto;
    padding: 20px;
    background-color: white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

/* Estilo del enlace 'Agregar' */
a {
    text-decoration: none;
    color: white;
    background-color: blue;
    padding: 10px 20px;
    border-radius: 5px;
    margin-bottom: 20px;
    display: inline-block;
    font-weight: bold;
    transition: background-color 0.3s ease;
}


/* Estilo del enlace 'Volver' */
a.volver {
    color: white;
    font-size: 16px;
    margin-top: 20px;
    display: inline-block;
    text-decoration: none;
    font-weight: bold;
}

a.volver:hover {
    text-decoration: underline;
}

/* Estilos para la tabla */
table {
    width: 70%;
    border-collapse: collapse;
    margin-top: 20px;
}

/* Encabezados de la tabla */
th {
    background-color: #4CAF50;
    color: white;
    padding: 12px;
    text-align: left;
    font-size: 18px;
}

th, td {
    border-bottom: 1px solid #ddd;
}

/* Filas de la tabla */
td {
    padding: 10px;
    font-size: 16px;
}

tr:hover {
    background-color: #f5f5f5;
}

/* Enlaces de la tabla */
td a {
    text-decoration: none;
    color: white;
    background-color: black;
    padding: 10px 10px;
    text-align: center;
    border-radius: 5px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

td a:hover {
    background-color: #1976D2;
}

/* Estilo del botón eliminar */
td a:nth-child(2) {
    background-color: #f44336;
}

td a:nth-child(2):hover {
    background-color: #e53935;
}

/* Mensaje de confirmación */
td a:active {
    transform: scale(0.98);
}

    </style>

<a href="/tareanueva/panel/views/usuarios/formulario.php">Agregar</a>
    <table><!-- Aca haces la tabla normal-->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NOMBRE</th>
                    <th>ACCIONES</th>
                </tr>
                <a href="/tareanueva/admin/noticias.php">Volver</a>
            </thead>
            <tbody><!-- Aca repetis la tabla pero utilizando el bucle while para ir actualizando con php-->
            <?php while ($fila = $resultado->fetch_object()) { ?> 
                
                <tr>
                    <td> <?php echo $fila->id ?></td>
                    <td> <?php echo $fila->nombre ?></td>
                    <td><a href="/tareanueva/panel/views/usuarios/formulario.php?id=<?php echo $fila->id ?>">Editar</a></td>
                    <td><a href="/tareanueva/panel/controlador/usuarios.php?operacion=delete&id=<?php echo $fila->id ?>" onclick="return confirm('¿Estas seguro de querer eliminar este usuario?');">Eliminar</a></td>
                </tr>
                
        <?php }?>
    </tbody>
    </table>



</body>
</html>