<?php
require_once('../tareanueva/panel/includes/db.php');

if (isset($_GET["id"])) {
    $id = $_GET["id"]; // Obtener el id de la noticia

    // Preparar y ejecutar la consulta para obtener la noticia
    $sentencia = $conexion->prepare("SELECT * FROM noticias WHERE id = ?");
    $sentencia->bind_param("i", $id);
    $sentencia->execute();
    $resultado = $sentencia->get_result();
    $noticia = $resultado->fetch_object();

    // Obtener la categoría de la noticia
    $id_categoria = $noticia->id_categoria; // Asumiendo que tienes este campo en tu tabla

    //Preparar y ejecutar la consulta para obtener las noticias relacionadas
    $sentencia2 = $conexion->prepare("SELECT * FROM noticias WHERE id_categoria = ? AND id != ?");
    $sentencia2->bind_param("ii", $id_categoria, $id);
    $sentencia2->execute();
    $resultado2 = $sentencia2->get_result();

} else {
    die("ID de noticia no proporcionado.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Noticia</title>
    <link rel="stylesheet" href="diseño.css">
    <link rel="stylesheet" href="diseño2.css">

</head>

<body>

<nav class="navbar">
        <div class="logo">
    <h1 class="titulo"><a href="">Mi portal de noticias</a></h1>
        </div>

<ul class="nav-links">
    <li><a href="/tareanueva/index2.php">Volver</a></li>

</nav>



<div class="item">
    <div>
        <div>
            <a href="detalle.php?id=<?php echo $noticia->id; ?>">
                <img width = "800" src="<?php echo $noticia->imagen; ?>" alt="<?php echo $noticia->titulo; ?>">
            </a>
            <h2><?php echo $noticia->titulo; ?></h2>
            <p><?php echo $noticia->descripcion; ?></p>
            <p><?php echo $noticia->texto; ?></p>
            <p><?php echo $noticia->fecha; ?></p>
        </div>
    </div>
</div>

<h2>Noticias Relacionadas</h2>
<div class="noticias-relacionadas">
    <?php while ($relacionada = $resultado2->fetch_object()) { ?>
        <div class="noticia-relacionada">
            <h3><?php echo htmlspecialchars($relacionada->titulo); ?></h3>
            <img width="450" src="<?php echo htmlspecialchars($relacionada->imagen); ?>" alt="<?php echo htmlspecialchars($relacionada->titulo); ?>">
            <p><?php echo htmlspecialchars($relacionada->descripcion); ?></p>
            <a href="detalle.php?id=<?php echo $relacionada->id; ?>" class="leer-mas">Leer más</a>
        </div>
    <?php } ?>
</div>

</body>

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





