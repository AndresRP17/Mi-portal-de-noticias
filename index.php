<?php
session_start(); // Reanudar la sesión

// Verificar si el usuario está logueado
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    header("Location: ../programacion2/login.php"); // Si no está logueado, redirigir al login
    exit();
}
?>

<?php
//aca enlazas el archivo que creaste anteriormente y metes la variable//
include("../tareanueva/panel/includes/db.php");//Es por la ubicacion del archivo en PHP!!!
$resultado = $conexion->query("SELECT * FROM noticias order by fecha");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    

</head>
<body>
    <nav class="navbar">
        <div class="logo">
    <h1 class="titulo"><a href="/tareanueva/index.php"><h1>Mi portal de noticias</h1></a></h1>
        </div>
        <ul class="nav-links">
    <li><a href="/tareanueva/noticias.php"><h1>Noticias</h1></a></li>
    <li><a href="/tareanueva/categoria.php"><h1>Categorias</h1></a></li>
    <li><a href="/tareanueva/panel/views/usuarios/listado.php"><h1>Usuarios</h1></a></li>
    <li><a href="/Programacion2/login.php"><h1>Cerrar sesion</h1> </a></li>
    </ul>
</nav>


</body>
</html>
