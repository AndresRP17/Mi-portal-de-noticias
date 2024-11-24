<?php

include("../../includes/db.php");

if (isset($_GET["id"])){

    $id = $_GET["id"];//por get obtenes el id que vas a trabajar//
    $sentencia = $conexion->prepare("SELECT * FROM usuarios WHERE id = ? ");//preparas sentencia
    $sentencia->bind_param("i", $id);//parametros con el que trabajas aca es un numeror por eso int
    $sentencia->execute();
    $resultado = $sentencia->get_result();
    $usuario = $resultado->fetch_object();

} else {

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php if (isset($_GET["id"])) { ?>
        <h1>Editar usuario</h1>
    <?php } else { ?>
        <h1>Nuevo usuario</h1>
    <?php }?>

    <form action="/tareanueva/panel/controlador/usuarios.php?operacion=<?php echo (isset($_GET['id'])) ? 'edit' : 'new'; ?>" method="post">
    <input type="hidden" name="id" value="<?php echo (isset($_GET["id"])) ? $usuario->id : "" ?>"> <!-- aca se hace que si tiene ID es edit o new-->
    
        <div>
                <label>NOMBRE</label>
                <input type="text" class="input" name="nombre" value="<?php echo (isset($_GET["id"])) ? $usuario->nombre : "" ?>">
                
        </div>
       
        <button class="guardado">Guardar</button>

    </form>

    <style>
        body{
            background-color: blue;
        }
        .input{
            border-radius: 5px solid black ;
            color: red;
            padding: 10px 20px;
        }

        .guardado {
    padding: 10px 20px;
    font-size: 16px;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.2s;
}

button:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

button:active {
    transform: scale(0.98);
}


        
    </style>

</body>
</html>