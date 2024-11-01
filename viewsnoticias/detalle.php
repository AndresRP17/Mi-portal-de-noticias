<?php
require_once('../../tareanueva/panel/includes/db.php');

if (isset($_GET["id"])) {
    $id = $_GET["id"]; // Obtener el id de la noticia

    // Preparar y ejecutar la consulta para obtener la noticia
    $sentencia = $conexion->prepare("SELECT * FROM noticias  WHERE id = ? ");
    $sentencia->bind_param("i", $id);
    $sentencia->execute();
    $resultado = $sentencia->get_result();
    $noticia = $resultado->fetch_object();

    if ($noticia) {
        // Continúa con el resto del código
    } else {
        die("Noticia no encontrada.");
    }
} else {
    die("ID de noticia no proporcionado.");
}


    // Obtener la categoría de la noticia
    if ($noticia){
        $id_categoria = $noticia->id_categoria; 
        
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Noticia</title>
    <link rel="stylesheet" href="../diseños/diseño.css">
    <link rel="stylesheet" href="../diseños/diseño2.css">

</head>

<body>



<header>
<nav class="navbar">
        <div class="logo">
    <h1 class="titulo"><a href="/tareanueva/viewsnoticias/index2.php">Mi portal de noticias</a></h1>
        </div>

<ul class="nav-links2">
    <li><a href="/tareanueva/viewsnoticias/index2.php">Volver</a></li>

</nav>
</header>


<div class="item">
    <div>
        <div style="text-align: center;">
            
            <h2><?php echo $noticia->titulo; ?></h2>
            <a href="detalle.php?id=<?php echo $noticia->id; ?>">
                <img  width = "600" src="<?php echo $noticia->imagen; ?>" alt="<?php echo $noticia->titulo;  ?>">
            </a>
        </div>
        
    </div>
            <p><?php echo $noticia->fecha; ?></p>
            <p><?php echo $noticia->descripcion; ?></p>
            <p><?php echo $noticia->texto; ?></p>
            
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

    .noticias-relacionadas {
    display: flex;
    gap: 25px; /* Espacio entre las noticias */
    text-decoration: none;
    color: inherit; /* Hereda el color del texto del contenedor */
    background-color: rgb(200, 212, 235);
    text-align: center;

}

.noticia-relacionada {
    background-color: white; /* Fondo individual de cada noticia */
    box-shadow: 0px 0px 10px rgb(200, 212, 235);
    ; /* Sombra para simular separación */
    border-radius: 5px; /* Bordes redondeados para un estilo limpio */
    padding: 15px; /* Espacio interno en cada tarjeta */
    width: 100%; /* Puedes ajustar según el diseño deseado */
    max-width: 300px; /* Tamaño máximo para mantener consistencia */
}

.noticia-relacionada img {
    width: 100%; /* O usa un tamaño específico, como 250px */
    height: 200px; /* Ajusta el alto según tus necesidades */
    object-fit:fill;
}

h2{
    text-align: center;
}

.leer-mas{
    text-align: end;
}

.noticia-relacionada a {
        text-decoration: none; /* Elimina la subrayado de todos los enlaces */
        color: inherit; /* Hereda el color del texto del contenedor */
    }

    .detalle-relacion {
        color: #fff1f1;
    display: inline;
    background-color: #0f0f12;
    }

</style>

<h2>Noticias Relacionadas</h2>
<div class="noticias-relacionadas">
    <?php while ($relacionada = $resultado2->fetch_object()) { ?>
        <div class="noticia-relacionada">
            <a href="detalle.php?id=<?php echo $relacionada->id; ?>">
            <h5 class="detalle-relacion"><?php echo $relacionada->categoria_nombre ?? "Sin categoría"; ?></h5> <!-- Muestra la categoría aquí -->

                <h3><?php echo htmlspecialchars($relacionada->titulo); ?></h3>
                <img width="250" src="<?php echo htmlspecialchars($relacionada->imagen); ?>" alt="<?php echo htmlspecialchars($relacionada->titulo); ?>">
                <p><?php echo htmlspecialchars($relacionada->descripcion); ?></p>
                <p class="leer-mas">Leer más</p>
            </a>
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