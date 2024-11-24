<?php
require_once('../../tareanueva/panel/includes/db.php');

if (isset($_GET["id"])) {
    $id = $_GET["id"]; // Obtener el id de la noticia

    // Preparar y ejecutar la consulta para obtener la noticia
$sentencia = $conexion->prepare("SELECT * FROM noticias WHERE id= ?");

// Enlazar el parámetro utilizando `bind_param` de MySQLi
$sentencia->bind_param("i", $id);

// Ejecutar la consulta
$sentencia->execute();

// Obtener el resultado
$resultado = $sentencia->get_result();
$noticia = $resultado->fetch_assoc();


if (!$noticia) {
    echo "Noticia de mierda.";
    die(); // Detiene la ejecución aquí
}


    // Obtener la categoría de la noticia
    if ($noticia){
        $id_categoria = $noticia['id_categoria']; // Acceso como índice de array
        
        //Preparar y ejecutar la consulta para obtener las noticias relacionadas
        $sentencia2 = $conexion->prepare("
        SELECT noticias.*, categorias.nombre AS categoria_nombre
        FROM noticias 
        LEFT JOIN categorias ON categorias.id = noticias.id_categoria 
        WHERE noticias.id_categoria = ? AND noticias.id != ? 
        ORDER BY fecha 
        LIMIT 0, 4
    ");
    $sentencia2->bind_param("ii", $id_categoria, $id);
    $sentencia2->execute();
    $resultado2 = $sentencia2->get_result();
}    

else {
    die("ID de noticia no proporcionado.");
}


$sqlUsuarios = "SELECT noticias.*, usuarios.nombre AS autor_nombre
                FROM noticias
                INNER JOIN usuarios ON usuarios.id = noticias.id_usuario
                WHERE noticias.id = ?";
$stmt = $conexion->prepare($sqlUsuarios);

if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conexion->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();
$resultado3 = $stmt->get_result();

if ($resultado3->num_rows > 0) {
    $noticia = $resultado3->fetch_assoc();
    $autor = $noticia['autor_nombre']; // Accede al nombre del autor
} else {
    die("Noticia no puta.");
}

$stmt->close();



$sqlImagenes = "SELECT * FROM noticias_imagenes WHERE id_noticia = ?";
$stmt = $conexion->prepare($sqlImagenes);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado3 = $stmt->get_result();
$stmt->close();

$imagenes = [];
while ($imagen = $resultado3->fetch_object()) {
	$imagenes[] = $imagen;
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Noticia</title>
    <link rel="stylesheet" href="../estilos/estilo1.css">
    <link rel="stylesheet" href="../estilos/estilo2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


</head>

<body>

<header>
<nav class="navbar">
        <div class="logo">
        <img src="luffy.jpg"  class="luffy" alt="Logo de la empresa">
  
        <div>
        <h1 class="titulo"><a href="/tareanueva/viewsnoticias/index2.php">MI PORTAL DE NOTICIAS</a></h1>
        <h5 class="fechaa" id="fecha">Fecha y hora: </h5>
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
</header>

<nav class="barra">
    <ul>
    <li><a href="/tareanueva/viewsnoticias/categorias.php?id_categoria=3">ACCIDENTES</li></a>
    <li><a href="/tareanueva/viewsnoticias/categorias.php?id_categoria=1">DEPORTES</li></a>
    <li><a href="/tareanueva/viewsnoticias/categorias.php?id_categoria=6">ENTRETENIMIENTOS</li></a>
    <li><a href="/tareanueva/viewsnoticias/categorias.php?id_categoria=4">MUSICA</li></a>
    <li><a href="/tareanueva/viewsnoticias/categorias.php?id_categoria=5">POLITICA</li></a>
    <li><a href="/tareanueva/viewsnoticias/categorias.php?id_categoria=12">OTROS</li></a>
</ul>
</nav>

<div class="item">
    <div>
        <div style="text-align: center;">
            
        <h2><?php echo $noticia['titulo']; ?></h2> <!-- Acceder a 'titulo' como un índice de array -->
<a href="detalle.php?id=<?php echo $noticia['id']; ?>"> <!-- Acceder a 'id' como un índice de array -->
    <img width="600" src="<?php echo $noticia['imagen']; ?>" alt="<?php echo $noticia['titulo']; ?>"> <!-- Acceder a 'imagen' y 'titulo' como índices de array -->
</a>

</div>

<p><?php echo $noticia['descripcion']; ?></p> <!-- Acceder a 'contenido' como índice de array -->
<p><?php echo $noticia['texto']; ?></p> <!-- Acceder a 'categoria_nombre' como índice de array -->
<p>Autor/a: <?php echo $noticia['autor_nombre']; ?></p> <!-- Mostrar el autor -->

    </div>

            
        </div>
    </div>
</div>

<div class="contenedorGaleria">
		<?php foreach ($imagenes as $imagen) { ?>
			<div class="contenedorImagen">
				<img src="<?php echo $imagen->ruta_imagen ?>">
			</div>
		<?php } ?>
	</div>

<h2>Noticias Relacionadas</h2>
<div class="noticias-relacionadas">
    <?php while ($relacionada = $resultado2->fetch_object()) { ?>
        
        <div class="noticia-relacionada">
            <a href="detalle.php?id=<?php echo $relacionada->id; ?>">
            <h5 class="detalle-relacion"><?php echo $relacionada->categoria_nombre ?? "Sin categoría"; ?></h5> <!-- Muestra la categoría aquí -->
                <h3 class="titulo-relacion"><?php echo htmlspecialchars($relacionada->titulo); ?></h3>
                <img width="250" src="<?php echo htmlspecialchars($relacionada->imagen); ?>" alt="<?php echo htmlspecialchars($relacionada->titulo); ?>">
                <p><?php echo htmlspecialchars($relacionada->descripcion); ?></p>
                <p class="fecha-relacionada"><?php echo $relacionada->fecha; ?></p>
                <p class="leer-mas">Leer más</p>
            </a>
        </div>
    <?php } ?>
</div>


<script>
    // Mostrar la fecha y hora actual
function mostrarFecha() {
    const fechaElemento = document.getElementById("fecha");
    const fechaActual = new Date();
    fechaElemento.textContent = "Fecha y hora: " + fechaActual.toLocaleString();
}

mostrarFecha();

</script>

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