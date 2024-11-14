<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias</title>
    <link rel="stylesheet" href="../estilos/estilo1.css">
    <link rel="stylesheet" href="../estilos/estilo2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        
<nav class="navbar">
        <div class="logo">
        <img src="luffy.jpg"  class="luffy" alt="Logo de la empresa">
        <div>
        <h1 class="titulo"><a href="/tareanueva/viewsnoticias/index2.php">MI PORTAL DE NOTICIAS</a></h1>
        <h5 class="fechaa" id="fecha">Fecha y hora: </h5>
    </div>
    </div>
      
</div>


        <div class="redes-sociales">

<a href="https://www.facebook.com/tuperfil" target="_blank">
    <i class="fab fa-facebook fa-2x" style="color: white;"></i></a>

    <a href="#" target="_blank">
    <i class="fa-brands fa-twitter fa-2x" style="color: white; vertical-align:inherit"></i></a>


<a href="https://www.instagram.com/tuperfil" target="_blank" aria-label="Ver mi perfil de Instagram">
<i class="fab fa-instagram fa-2x" style="color: white;"></i>
</a>


<a href="https://wa.me/numero" target="_blank">
    <i class="fab fa-youtube fa-2x" style="color: white;"></i></a>
    

<a href="#" target="_blank">
    <i class="fab fa-whatsapp fa-2x" style="color: white;"></i></a>

<a href="#" target="_blank">
    <i class="fab fa-telegram fa-2x" style="color: white;"></i></a>

<a href="#" target="_blank">
<i class="fa-brands fa-tiktok fa-2x" style="color:white;"></i></a>
</div>



        <ul class="nav-links2">
    <li><a href="/tareanueva/viewsnoticias/index2.php">Volver</a></li>
</nav>
</head>

<nav class="barra">
    <ul>
    <li><a href="/tareanueva/viewsnoticias/categorias.php?id_categoria=3">ACCIDENTES</a></li>
    <li><a href="/tareanueva/viewsnoticias/categorias.php?id_categoria=1">DEPORTES</a></li>
    <li><a href="/tareanueva/viewsnoticias/categorias.php?id_categoria=6" class="activo">ENTRETENIMIENTOS</a></li>
    <li><a href="/tareanueva/viewsnoticias/categorias.php?id_categoria=4">MUSICA</a></li>
    <li><a href="/tareanueva/viewsnoticias/categorias.php?id_categoria=5">POLITICA</a></li>
    <li><a href="/tareanueva/viewsnoticias/categorias.php?id_categoria=12">OTROS</a></li>
</ul>
</nav>

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


<script>

    // Mostrar la fecha y hora actual
function mostrarFecha() {
    const fechaElemento = document.getElementById("fecha");
    const fechaActual = new Date();
    fechaElemento.textContent = "Fecha y hora: " + fechaActual.toLocaleString();
}

// Obtener y mostrar la ubicación
function mostrarUbicacion() {
    const ubicacionElemento = document.getElementById("ubicacion");

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(posicion) {
                const latitud = posicion.coords.latitude.toFixed(2);
                const longitud = posicion.coords.longitude.toFixed(2);
                ubicacionElemento.textContent = "Ubicación: Latitud " + latitud + ", Longitud " + longitud;
            },
            function(error) {
                ubicacionElemento.textContent = "No se pudo obtener la ubicación.";
            }
        );
    } else {
        ubicacionElemento.textContent = "Geolocalización no es compatible con este navegador.";
    }
}

 document.addEventListener("DOMContentLoaded", function() {
  const links = document.querySelectorAll(".barra ul li a"); // Selecciona todos los enlaces
  
  // Elimina la clase 'activo' de todos los enlaces
  links.forEach(link => {
    link.classList.remove("activo");
  });
  
  // Extrae el id_categoria de la URL
  const urlParams = new URLSearchParams(window.location.search);
  const currentCategoryId = urlParams.get('id_categoria'); // Obtiene el id_categoria de la URL
  
  // Verifica si el id_categoria del enlace coincide con el de la URL
  links.forEach(link => {
    const linkCategoryId = new URLSearchParams(link.search).get('id_categoria');
    
    if (linkCategoryId === currentCategoryId) { // Si coinciden, agrega la clase 'activo'
      link.classList.add("activo");
    }
  });
});



</script>

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
