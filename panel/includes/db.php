<?php
//Se declaran las variables
$servidor = "localhost";
$usuario = "root";
$contraseña= "";
$BD = "tarea_programacion";


error_reporting(E_ALL);

// Habilitar la visualización de errores
ini_set('display_errors', 1);

//Creamos la conexion
$conexion = mysqli_connect($servidor, $usuario, $contraseña, $BD);

//Verificamos si anda
if(!$conexion){
    echo "MMMMMMMMM";
    die("La conexion fallo: " .mysqli_connect_error());
}
else{
    echo "";
}

?>