<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias</title>
    <link rel="stylesheet" href="/tareanueva/diseño.css">
    <link rel="stylesheet" href="/tareanueva/diseño2.css">
        
<nav class="navbar">
        <div class="logo">
    <h1 class="titulo"><a href="/tareanueva/index2.php">Mi portal de noticias</a></h1>
        </div>

        <ul class="nav-links">
    <li><a href="/tareanueva/index2.php">Volver</a></li>
</nav>
</head>
<body>
    
<?php
// Conexión a la base de datos
include("../tareanueva/panel/includes/db.php");

// Verificar si el id_categoria está presente en la URL
$id_categoria = isset($_GET['id_categoria']) ? intval($_GET['id_categoria']) : 0;

if ($id_categoria > 0) {
   // Preparar la consulta para obtener las noticias que pertenezcan a la categoría seleccionada
    $stmt = $conexion->prepare('SELECT * FROM noticias WHERE id_categoria = ? ORDER BY fecha DESC');
    $stmt->bind_param('i', $id_categoria);
    $stmt->execute();
    $result = $stmt->get_result();

    // Mostrar las noticias
    if ($result->num_rows > 0) {
        while ($fila = $result->fetch_object()) {
            echo "<h2>" . $fila->titulo . "</h2>";
            echo "<p>" . $fila->descripcion . "</p>";
            echo "<img src='" . $fila->imagen . "' alt='Imagen de la noticia'>";
            echo "<hr>";
            echo "<a href='detalle.php?id=" . $fila->id . "' class='leer-mas'>Leer más</a>";
        }
    } else {
        echo "No hay noticias en esta categoría.";
    }if (!$stmt) {
        echo "Error en la consulta: " . $conexion->error;
    }
}    
?>

</body>
</html> 



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

