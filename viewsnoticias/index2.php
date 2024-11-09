<?php
// Conectar a la base de datos
include("../../tareanueva/panel/includes/db.php");

$offset = 6;
$pagina = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
$buscador = isset($_GET["buscador"]) ? $_GET["buscador"] : "";
$limit = ($pagina - 1) * $offset;

// Consulta para las noticias
$sql = "SELECT noticias.*, categorias.nombre AS categoria_nombre FROM noticias LEFT JOIN categorias ON categorias.id = noticias.id_categoria ";
$where = [];
$params = [];

// Agregar condición de búsqueda si hay un buscador
if (!empty($buscador)) {
    $where[] = "(titulo LIKE ? OR categorias.nombre LIKE ?)";
    $params[] = "%" . $buscador . "%"; // Para el LIKE
    $params[] = "%" . $buscador . "%"; // Para el LIKE
}

// Si hay condiciones, añadirlas a la consulta
if (count($where) > 0) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

// Añadir orden y límites
$sql .= " ORDER BY fecha DESC LIMIT ?, ?";
$params[] = $limit;   // Para el límite de la página
$params[] = $offset;   // Para el tamaño de la página

// Preparar la consulta
$stmt = $conexion->prepare($sql);
if ($stmt === false) {
    die("Error en la consulta SQL: " . $conexion->error);
}

// Crear el tipo de parámetros
$types = str_repeat("s", count($params) - 2) . "ii"; // 's' para strings, 'i' para enteros

// Enlazar parámetros
$stmt->bind_param($types, ...$params); // Usar el operador de propagación para pasar el array

// Ejecutar la consulta
$stmt->execute();
$resultado = $stmt->get_result();
if (!$resultado) {
    die("Error en la consulta SQL: " . $conexion->error);
}

// Consulta para la paginación
$sql2 = "SELECT COUNT(*) AS cantidad FROM noticias LEFT JOIN categorias ON (categorias.id = noticias.id_categoria)";
if (!empty($buscador)) {
    $sql2 .= " WHERE titulo LIKE ? OR categorias.nombre LIKE ?";
}

// Preparar la consulta de conteo
$stmt2 = $conexion->prepare($sql2);
if ($stmt2 === false) {
    die("Error en la consulta de conteo SQL: " . $conexion->error);
}

// Si hay buscador, añadir los parámetros
if (!empty($buscador)) {
    $likeBuscador = "%" . $buscador . "%";
    $stmt2->bind_param("ss", $likeBuscador, $likeBuscador);
}

// Ejecutar la consulta de conteo
$stmt2->execute();
$resultado2 = $stmt2->get_result();
$total = $resultado2->fetch_object();
$ultima_pagina = ceil($total->cantidad / $offset);

// Cerrar sentencias
$stmt->close();
$stmt2->close();

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi portal de noticias</title>
    <link rel="stylesheet" href="../estilos/estilo1.css">
    <link rel="stylesheet" href="../estilos/estilo2.css">  
</head>



<body>

<nav class="navbar">
    <div class="logo">
        <h1 class="titulo"><a href="/tareanueva/viewsnoticias/index2.php">Mi portal de noticias</a></h1>
        
    </div>

    </div>

    <div class="menu" id="menu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>

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
</nav>

<script>

/// Obtiene el botón de menú y el contenedor del menú
const menuButton = document.getElementById('menu');
const menuContainer = document.getElementById('categories');

// Escucha el evento de clic en el botón de menú
menuButton.addEventListener('click', () => {
    // Alterna la clase 'active' para el botón de menú y el contenedor del menú
    menuButton.classList.toggle('active');
    menuContainer.classList.toggle('active'); // Cambia la visibilidad usando la clase

    // Alterna la visibilidad del menú
    if (menuContainer.classList.contains('active')) {
        menuContainer.style.display = "flex"; // Muestra el menú
    } else {
        menuContainer.style.display = "none"; // Oculta el menú
    }
})
</script>

        <form action="index2.php" method="get">
            <input type="text" id="buscador"  class="input" name="buscador" placeholder="Inserte una búsqueda">
        </form>


        <div class="contenedor-noticias">
    <?php while ($noticia = $resultado->fetch_object()) { ?> 
        <a href="/tareanueva/viewsnoticias/detalle.php?id=<?php echo $noticia->id; ?>" class="noticia">
        <h4 class="titulo-categoria"><?php echo $noticia->categoria_nombre ?? "Sin categoría"; ?></h4> <!-- Muestra la categoría aquí -->
        <h2 class="titulo-noticia"><?php echo $noticia->titulo; ?></h2>
        <img src="<?php echo $noticia->imagen; ?>" alt="<?php echo $noticia->titulo; ?>" class="imagen-noticia">
         <h2 class="fecha"><?php echo $noticia->fecha; ?></h2>
        <p class="descripcion-noticia"><?php echo $noticia->descripcion; ?></p>
        <p class="leer-mas1">Leer más</p>
        </a>
    <?php } ?>
</div>

<div class="paginacion">
    <?php if ($pagina > 1) { ?>
        <a href="index2.php?page=<?php echo $pagina - 1 ?>&buscador=<?php echo htmlspecialchars($buscador); ?>">Anterior</a>
    <?php } ?>
    <?php if ($ultima_pagina > 1) { ?>
        <?php for ($i = 1; $i <= $ultima_pagina; $i++) { ?>
            <?php if ($i == $pagina) { ?>
                <span><?php echo $i ?></span>
            <?php } else { ?>
                <a href="index2.php?page=<?php echo $i ?>&buscador=<?php echo htmlspecialchars($buscador); ?>"><?php echo $i ?></a>
            <?php } ?>
        <?php } ?>
    <?php } ?>
    <?php if ($pagina < $ultima_pagina) { ?>
        <a href="index2.php?page=<?php echo $pagina + 1 ?>&buscador=<?php echo htmlspecialchars($buscador); ?>">Siguiente</a>
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
