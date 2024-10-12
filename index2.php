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
    <title>Mi portal de noticias</title>
    <link rel="stylesheet" href="diseño.css">
    <link rel="stylesheet" href="diseño2.css">

</head>
<body>

<nav class="navbar">
        <div class="logo">
    <h1 class="titulo"><a href="/tareanueva/index2.php">Mi portal de noticias</a></h1>
        </div>

        <ul class="nav-links">
    <li><a href="/tareanueva/categorias.php?id_categoria=6">Entretenimientos</a></li>
    <li><a href="/tareanueva/categorias.php?id_categoria=1">Deportes</a></li>
    <li><a href="/tareanueva/categorias.php?id_categoria=4">Musica</a></li>
    <li><a href="/tareanueva/categorias.php?id_categoria=12">Otros</a></li>


</nav>

<?php while ($noticia = $resultado->fetch_object()) { ?> 
    <div class="noticia">
        <h2 class="titulo-noticia"><?php echo $noticia->titulo; ?></h2>
        <img width="450" src="<?php echo $noticia->imagen; ?>" alt="<?php echo $noticia->titulo; ?>" class="imagen-noticia">
        <p class="descripcion-noticia"><?php echo $noticia->descripcion; ?></p>
        <a href="/tareanueva/detalle.php?id=<?php echo $noticia->id; ?>" class="leer-mas">Leer más</a>
    </div>
<?php } ?>

<footer class="footer">
    <div class="footer-content">
        <div class="footer-section about">
            <h2>Mi portal de noticias</h2>
            <p>Una plataforma para mantenerte informado sobre noticias y eventos en la ciudad de Chacabuco.</p>
        </div>
        <div class="footer-section links">
            <h2>Enlaces Útiles</h2>
            <ul>
                <li><a href="/tareanueva/noticias.php"></a></li>
                <li><a href="/tareanueva/categoria.php"></a></li>
                
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



</html>
