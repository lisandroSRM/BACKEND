<?php

use FTP\Connection;

require_once realpath('../../vendor/autoload.php');
    $dotenv=Dotenv\Dotenv::createImmutable('../../');
    $dotenv->load();
    define ('SERVER',$_ENV['HOST']);
    define ('USER',$_ENV['USUARIO']);
    define ('PASS',$_ENV['PASSWORD']);
    define ('BD',$_ENV['BD']);
    define ('PORT',$_ENV['PUERTO']);
    class conexion{
        // cereamos claases privadas
        private static $conexion;
        // creamos funcion (static para acceder de manera rapida)
        public static function abrir_conexion(){
            if(!isset(self::$conexion)){
                try{
                    self::$conexion = new PDO('mysql:host ='.SERVER.';dbname='.BD,USER,PASS);
                    self::$conexion->exec('SET CHARACTER SET utf8'); 
                    return self::$conexion;
                }catch(PDOException $e){
                    echo "error en la conexion:". $e;
                    die();
                }
            }else{
                return self::$conexion;
            }
        }
    public static function obtener_conexion()
    {
        $conexion = self::abrir_conexion();
        return $conexion;
    }
    public static function cerrar_conexion()
    {
        self::$conexion = null;
    }
    public static function consulta()
    {
        $consulta = Conexion::obtener_conexion()->prepare("select * from t_ejemplo");
        if (!$consulta -> execute()){
            echo 'No se pudo realizar la consulta';
        } else {
            $dato = $consulta->fetchAll (PDO::FETCH_ASSOC);
            echo print_r($dato);
            echo 'Se completo la peticion';
        }
    }

    public static function agregar($nombre, $apellido){
        try {
            $stmt = self::obtener_conexion()->prepare("INSERT INTO t_ejemplo (nombre_ejemplo, apellido_ejemplo) VALUES (?, ?)");
            $stmt->execute([$nombre, $apellido]);
            echo "Registro agregado correctamente";
        } catch (PDOException $e) {
            echo "Error al agregar registro: " . $e->getMessage();
        }
    }

    public static function actualizar($nombre, $apellido, $id){
        try {
            $stmt = self::obtener_conexion()->prepare("UPDATE t_ejemplo SET nombre_ejemplo = ?, apellido_ejemplo = ? WHERE id = ?");
            $stmt->execute([$nombre, $apellido, $id]);
            echo"Se actualizo correctamente";
        } catch (PDOException $e){
            echo "Error al actualizar:" . $e ->getMessage();
        }
    }

    public static function eliminar($id)
    {
        try {
            $stmt = self::obtener_conexion()->prepare("DELETE FROM t_ejemplo WHERE id = ?");
            $stmt->execute([$id]);
            echo "Registro eliminado correctamente";
        } catch (PDOException $e) {
            echo "Error al eliminar registro: " . $e->getMessage();
        }
    }
   
}
Conexion::consulta();

//Conexion::agregar('angel', 'cerezo');

//Conexion::actualizar('salvador', 'mendiola', 1);

Conexion::eliminar(3);

Conexion::consulta();
?>