<?php
require_once realpath('./vendor/autoload.php');
    $dotenv=Dotenv\Dotenv::createImmutable('./');
    $dotenv->load();
    echo $_ENV['MI_VARIABLE_DE_ENTORNO'];
    $puerto = $_ENV['PUERTO'];
    $usuario = $_ENV['USUARIO'];
    $password = $_ENV['PASSWORD'];
    $bd = $_ENV['BD'];
    $host= $_ENV['HOST'];


    $conexion = new PDO("mysql:host=$host;port=$puerto;dbname=$bd",$usuario,$password);

    if ($conexion != True) {
        echo "CONEXION FALLIDA";
    }else {
        echo "CONEXION EXITOSA";
    }
?>