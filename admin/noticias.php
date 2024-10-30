<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4; /* Color de fondo */
            margin: 20px;
        }

        table {
            width: 100%; /* Ancho de la tabla */
            border-collapse: collapse; /* Elimina los espacios entre las celdas */
            margin: 20px 0; /* Espacio alrededor de la tabla */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra para la tabla */
        }

        th, td {
            padding: 12px; /* Espacio interno de las celdas */
            text-align: left; /* Alineación del texto */
            border: 1px solid #dddddd; /* Borde de las celdas */
        }

        th {
            background-color: #4CAF50; /* Color de fondo de los encabezados */
            color: white; /* Color del texto en encabezados */
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Color de fondo para filas pares */
        }

        tr:hover {
            background-color: #ddd; /* Color de fondo al pasar el mouse */
        }
    </style>
<body>


<a href="/tareanueva/controlesnoti/subirnoti.php">Agregar</a>

<a href="/tareanueva/admin/index.php">Volver</a>


<?php
//aca enlazas el archivo que creaste anteriormente y metes la variable//
include("../panel/includes/db.php");//Es por la ubicacion del archivo en PHP!!!
$resultado = $conexion->query("SELECT * FROM noticias order by id DESC");
?>

<table><!-- Aca haces la tabla normal-->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>TITULO</th>
                    <th>DESCRIPCION</th>
                      <th>TEXTO</th>
                      <th>IMAGEN</th>
                      <th>FECHA</th>

            
                </tr>
                
            </thead>
     </tr>
                
            </thead>
            <tbody><!-- Aca repetis la tabla pero utilizando el bucle while para ir actualizando con php-->
            <?php while ($fila = $resultado->fetch_object()) { ?> 
                
                <tr>
                    <td> <?php echo $fila->id ?></td>
                    <td> <?php echo $fila->titulo ?></td>
                    <td> <?php echo $fila->descripcion ?></td>
                    <td> <?php echo $fila->texto ?></td>
                    <td><img width="100" src="<?php echo $fila->imagen; ?> " /></td>
                    <td> <?php echo $fila->fecha ?></td>
                    <td><a href="/tareanueva/controlesnoti/subirnoti.php?operacion=edit&id=<?php echo $fila->id ?>">Editar</a></td>
                    <td><a href="/tareanueva//controlesnoti/logicanoti.php?operacion=delete&id=<?php echo $fila->id ?>" onclick="return confirm('¿Estas seguro de querer eliminar esta noticia?');">Eliminar</a></td>
                </tr>
                <?php }?> 
    </tbody>
    </table>
</body>
</html>