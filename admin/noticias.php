<?php
session_start(); // Reanudar la sesión

// Verificar si el usuario está logueado
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    header("Location: ../programacion2/login.php"); // Si no está logueado, redirigir al login
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../estilos/estilo3.css">
</head>
<style>
        body {
            font-family: sans-serif;
            background-color:white;
            margin: 0px;
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
            background-color: blue; /* Color de fondo de los encabezados */
            color: white; /* Color del texto en encabezados */
        }

        tr:hover {
            background-color: #ddd; /* Color de fondo al pasar el mouse */
        }
    </style>
<body>

<?php
//aca enlazas el archivo que creaste anteriormente y metes la variable//
include("../panel/includes/db.php");//Es por la ubicacion del archivo en PHP!!!
$resultado = $conexion->query("SELECT * FROM noticias order by id DESC");
?>

<header>
    <a href="#" class="logo">
        <img src="luffy.jpg" alt="Logo de la empresa">
        <h2>Mi portal de noticias</h2>
    </a>

    <nav>
        <a href="/tareanueva/viewsnoticias/index2.php" class="nav link">Pagina de noticias</a>
        <a href="/tareanueva/admin/categoria.php" class="nav link">Categorias</a>
        <a href="/tareanueva/panel/views/usuarios/listado.php" class="nav link">Autores</a>
        <a href="/programacion2" class="nav link">Cerrar sesion</a>

    </nav>
</header>


<div class="menu_container" id="categories">
        <ul class="nav-links">
            <li><a href="/tareanueva/viewsnoticias/categorias.php?id_categoria=3">Accidentes</a></li>
            <li><a href="/tareanueva/viewsnoticias/categorias.php?id_categoria=1">Deportes</a></li>
            <li><a href="/tareanueva/viewsnoticias/categorias.php?id_categoria=6">Entretenimientos</a></li>
            <li><a href="/tareanueva/viewsnoticias/categorias.php?id_categoria=4">Música</a></li>
            <li><a href="/tareanueva/viewsnoticias/categorias.php?id_categoria=5">Politica</a></li>
            <li><a href="/tareanueva/viewsnoticias/categorias.php?id_categoria=12">Otros</a></li>
        </ul>
    </div>


<style>
    header{
        display: flex;
        justify-content: space-between;
        min-height: 70px;
        background-color: blue;
        align-items: center;
        padding: 10px;
    }

    a{
        text-decoration: none;
        color: white;
        padding-right: 20px;
    }

    nav a{
        color: white;
        padding-right: 10px;
    }

    nav a:hover{
        color: black;
    }
    .logo {
        display: flex;
        align-items: center;
        color: white;
    }

    .logo img{
        height: 50px;
        margin-right: 10px;
    }

    @media (max-width: 700px){
        header{
            flex-direction: column; 
        }
    }
</style>

<div>
<a class="agregarnoticia" href="/tareanueva/controlesnoti/subirnoti.php">Agregar</a>
</div>
<table><!-- Aca haces la tabla normal-->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>TITULO</th>
                    <th>DESCRIPCION</th>
                      <th>TEXTO</th>
                      <th>IMAGEN</th>
                      <th>FECHA</th>
                      <th>NUMERO DE CATEGORIA</th>
                      <th>NUMERO DE AUTOR</th>
                      <th>ACCIONES</th>
                      <th>ACCIONES</th>

            
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
                    <td> <?php echo $fila->id_categoria ?></td>
                    <td><?php echo $fila->id_usuario ?></td>
                    <td><a class="editarnoti" href="/tareanueva/controlesnoti/subirnoti.php?operacion=edit&id=<?php echo $fila->id ?>">Editar</a></td>
                    <td><a class="eliminarnoti" href="/tareanueva/controlesnoti/logicanoti.php?operacion=delete&id=<?php echo $fila->id ?>" onclick="return confirm('¿Estas seguro de querer eliminar esta noticia?');">Eliminar</a></td>
                </tr>
                <?php }?> 
    </tbody>
    </table>
</body>
</html>