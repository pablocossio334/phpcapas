<?php
require_once "Conexion.php";
class Conexion {
    private static $servidor = 'localhost';
    private static $base = 'instituto2';
    private static $usuario = 'root';
    private static $clave = '';

    public static function conectar() {
        try {
            $servidor = self::$servidor;
            $base = self::$base;

            $conexion = new PDO(
                "mysql:host=$servidor;dbname=$base;charset=utf8mb4",
                self::$usuario,
                self::$clave
            );

            return $conexion;

        } catch (PDOException $error) {
            exit("No se pudo conectar");
        }
    }
}

$conexion = Conexion::conectar();

