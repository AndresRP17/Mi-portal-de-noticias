<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias</title>
    <link rel="stylesheet" href="../diseños/diseño.css">
    <link rel="stylesheet" href="../diseños/diseño2.css">
        
<nav class="navbar">
        <div class="logo">
    <h1 class="titulo"><a href="/tareanueva/viewsnoticias/index2.php">Mi portal de noticias</a></h1>
        </div>

        <ul class="nav-links2">
    <li><a href="/tareanueva/viewsnoticias/index2.php">Volver</a></li>
</nav>
</head>
<body>
    <?php
// Conexión a la base de datos
include("../panel/includes/db.php");

// Verificar si el id_categoria está presente en la URL
$id_categoria = isset($_GET['id_categoria']) ? intval($_GET['id_categoria']) : 0;

if ($id_categoria > 0) {
    // Obtener el número de página actual
    $pagina = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = 2; // Número de noticias por página
    $limit = ($pagina - 1) * $offset;

    // Consultar las noticias de la categoría seleccionada
    $sql = "SELECT * FROM noticias WHERE id_categoria = ? ORDER BY fecha DESC LIMIT ?, ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iii", $id_categoria, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    // Consulta para contar las noticias en la categoría
    $sqlCount = "SELECT COUNT(*) AS cantidad FROM noticias WHERE id_categoria = ?";
    $stmtCount = $conexion->prepare($sqlCount);
    $stmtCount->bind_param("i", $id_categoria);
    $stmtCount->execute();
    $resultCount = $stmtCount->get_result();
    $total = $resultCount->fetch_object();
    $ultima_pagina = ceil($total->cantidad / $offset);

    // Recorrer las noticias
    while ($noticia = $result->fetch_object()) {
        echo "<div class='item'>";
        echo "<div style='text-align: center;'>";
        echo "<h2>" . $noticia->titulo . "</h2>";
        echo "<a href='detalle.php?id=" . $noticia->id . "'>";
        echo "<img width='800' src='" . $noticia->imagen . "' alt='" . $noticia->titulo . "'>";
        echo "</a>";
        echo "</div>";
        echo "<p>" . $noticia->fecha . "</p>";
        echo "<p>" . $noticia->descripcion . "</p>";

        // Consultar las imágenes relacionadas con esta noticia
        $sqlImagenes = "SELECT * FROM noticias_imagenes WHERE id_noticia = ?";
        $stmt_imagenes = $conexion->prepare($sqlImagenes);
        $stmt_imagenes->bind_param("i", $noticia->id);
        $stmt_imagenes->execute();
        $resultado_imagenes = $stmt_imagenes->get_result();
        
        // Mostrar las imágenes
        echo "<div class='contenedorGaleria'>";
        while ($imagen = $resultado_imagenes->fetch_object()) {
            echo "<div class='contenedorImagen'>";
            echo "<img src='" . $imagen->ruta_imagen . "'>";
            echo "</div>";
        }
        echo "</div>"; // Fin de contenedorGaleria

        $stmt_imagenes->close();
        echo "</div>"; // Fin de item
    }

    $stmt->close();
    $stmtCount->close();

    // Paginación
    echo '<div class="paginacion1">';
    if ($pagina > 1) {
        echo '<a href="?id_categoria=' . $id_categoria . '&page=' . ($pagina - 1) . '">Anterior</a>';
    }

    if ($ultima_pagina > 1) {
        for ($i = 1; $i <= $ultima_pagina; $i++) {
            if ($i == $pagina) {
                echo '<span>' . $i . '</span>'; // Página actual
            } else {
                echo '<a href="?id_categoria=' .  $id_categoria .  '&page=' . $i . '">' . $i . '</a>';
            }
        }
    }

    if ($pagina < $ultima_pagina) {
        echo '<a href="?id_categoria=' .  $id_categoria . '&page=' . ($pagina + 1) . '">Siguiente</a>';
    }
    echo '</div>'; // Fin de paginacion
}
?>

<style>
    .contenedorImagen{
	display: inline-block;
	width: 20%;
	height: 200px;
}

.contenedorImagen img{
	width: 100%;
	height: 100%;
	object-fit: cover;
}

</style>
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

