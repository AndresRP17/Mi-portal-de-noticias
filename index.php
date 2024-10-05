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
    <title>Noticias web</title>
    <link rel="stylesheet" href="diseño.css">

</head>
<body>
    <nav class="navbar">
        <div class="logo">
    <h1 class="titulo"><a href="/tareanueva/index.php">Mi portal de noticias</a></h1>
        </div>
        <ul class="nav-links">
    <li><a href="/tareanueva/noticias.php">Noticias</a></li>
    <li><a href="/tareanueva/categoria.php">Categorias</a></li>
    <li><a href="/tareanueva/panel/views/usuarios/listado.php">Usuarios</a></li>
    <li><a href="/Programacion2/login.php">Cerrar sesion</a></li>
    </ul>
</nav>

            
            <!-- Aca repetis la tabla pero utilizando el bucle while para ir actualizando con php-->
            <?php while ($noticia = $resultado->fetch_object()) { ?> 
                <div class="item">
                <div>
                    <a href="detalle.php?id=<?php echo $noticia->id; ?>">
                     <img src="<?php echo $noticia->imagen; ?>">
                     <h2><?php echo $noticia->titulo ?></h2>
                    </div>
                </div>
            </a>
        <?php }?>
    </tbody>
    </table>


    <footer class="footer">
    <div class="footer-content">
        <div class="footer-section about">
            <h2>Mi portal de noticias</h2>
            <p>Una plataforma para mantenerte informado sobre noticias y eventos en la ciudad de Chacabuco.</p>
        </div>
        <div class="footer-section links">
            <h2>Enlaces Útiles</h2>
            <ul>
                <li><a href="/tareanueva/noticias.php">Noticias</a></li>
                <li><a href="/tareanueva/categoria.php">Categorias</a></li>
                <li><a href="/tareanueva/panel/views/usuarios/listado.php">Usuarios</a></li>
                <li><a href="/Programacion2/login.php">Cerrar sesion</a></li>
            </ul>
        </div>
        <div class="footer-section contact">
            <h2>Contacto</h2>
            <p><a href="https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox?compose=new">Email: andresfer179@gmail.com</a></p>
            <p>Teléfono: 2352-507913</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2024 Mi portal de noticias. Todos los derechos reservados.</p>
    </div>
</footer>

</body>
</html>
