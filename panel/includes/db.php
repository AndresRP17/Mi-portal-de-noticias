<?php
//Se declaran las variables
$servidor = "localhost";
$usuario = "root";
$contraseña= "";
$BD = "tarea_programacion";


//Creamos la conexion
$conexion = mysqli_connect($servidor, $usuario, $contraseña, $BD);

//Verificamos si anda
if(!$conexion){
    echo "Algo salio mal";
    die("La conexion fallo: " .mysqli_connect_error());
}
else{
    echo "";
}

?>