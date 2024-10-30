<?php
// Conectar a la base de datos
include("../../tareanueva/panel/includes/db.php");

$offset = 3;
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
    <link rel="stylesheet" href="../diseños/diseño.css">
    <link rel="stylesheet" href="../diseños/diseño2.css">
    <style>
        /* Estilo inicial para el buscador */
        #buscador { 
            display: none; /* Ocultamos el buscador por defecto */
        }
        #icono-busqueda {
            cursor: pointer;
            width: 40px; /* Ajusta el tamaño aquí */
            height: 50px; /* Ajusta el tamaño aquí */
        }
        #boton-buscar {
            display: none;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="logo">
        <h1 class="titulo"><a href="/tareanueva/viewsnoticias/index2.php">Mi portal de noticias</a></h1>
        <form action="index2.php" method="get">
            <img src="../viewsnoticias/hola.jpg" id="icono-busqueda" alt="Buscar" style="cursor: pointer;">
            <input type="text" id="buscador" name="buscador" placeholder="Inserte una búsqueda">
            <button id="boton-buscar">Buscar</button>
        </form>
    </div>

    <div class="menu" id="menu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>

    <div class="menu_container" id="categories">
        <ul class="nav-links">
            <li><a href="/tareanueva/viewsnoticias/categorias.php?id_categoria=6">Entretenimientos</a></li>
            <li><a href="/tareanueva/viewsnoticias/categorias.php?id_categoria=1">Deportes</a></li>
            <li><a href="/tareanueva/viewsnoticias/categorias.php?id_categoria=4">Música</a></li>
            <li><a href="/tareanueva/viewsnoticias/categorias.php?id_categoria=12">Otros</a></li>
        </ul>
    </div>
</nav>

<script>
    // JavaScript para mostrar/ocultar el buscador
    const iconoBusqueda = document.getElementById('icono-busqueda');
    const buscador = document.getElementById('buscador'); // ID del input
    const botonBuscar = document.getElementById('boton-buscar');

    iconoBusqueda.addEventListener('click', function() {
        if (buscador.style.display === 'none' || buscador.style.display === '') {
            botonBuscar.style.display = 'block';
            buscador.style.display = 'block'; // Muestra el buscador
            buscador.focus(); // Coloca el foco en el buscador
        } else {
            buscador.style.display = 'none'; // Oculta el buscador
            botonBuscar.style.display = 'none'; // Oculta el botón de búsqueda
        }
    });

    // JavaScript para el menú hamburguesa
    const menu = document.getElementById('menu');
    const categories = document.getElementById('categories');

    menu.addEventListener('click', () => {
        menu.classList.toggle('active'); // Cambia la clase del menú
        // Alternar la visibilidad de las categorías
        if (categories.style.display === 'flex') {
            categories.style.display = 'none'; // Ocultar categorías
        } else {
            categories.style.display = 'flex'; // Mostrar categorías
        }
    });
</script>

</body>
</html>

<?php while ($noticia = $resultado->fetch_object()) { ?> 
    <div class="noticia">
        <h2 class="titulo-noticia"><?php echo $noticia->titulo; ?></h2>
        <img src="<?php echo $noticia->imagen; ?>" alt="<?php echo $noticia->titulo; ?>" class="imagen-noticiaa">
        <p class="descripcion-noticia"><?php echo $noticia->descripcion; ?></p>
        <a href="/tareanueva/viewsnoticias/detalle.php?id=<?php echo $noticia->id; ?>" class="leer-mas">Leer más</a>
    </div>
<?php } ?>

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
