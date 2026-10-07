<?php

require_once __DIR__ . '/Conexion.php';
require_once __DIR__ . '/../modelo/Usuario.php';

class UsuarioDAO {

    public static function obtenerPorEmail(string $email): ?Usuario {
        $conexion = Conexion::conectar();

        $consulta = $conexion->prepare(
            "SELECT email, clave, rol
             FROM usuario
             WHERE email = :email"
        );

        $consulta->execute([
            'email' => $email
        ]);

        $fila = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($fila === false) {
            return null;
        }

        return new Usuario(
            $fila['email'],
            $fila['clave'],
            $fila['rol']
        );
    }

    public static function listarUsuarios(): array {
        $conexion = Conexion::conectar();

        $resultado = $conexion->query(
            "SELECT email, clave, rol
             FROM usuario
             ORDER BY email"
        );

        $usuarios = [];

        while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $usuarios[] = new Usuario(
                $fila['email'],
                $fila['clave'],
                $fila['rol']
            );
        }

        return $usuarios;
    }
public function eliminarUsuario(string $email): bool {
    $conexion = Conexion::conectar();

    $consulta = $conexion->prepare(
        "DELETE FROM usuario WHERE email = :email"
    );

    $consulta->execute([
        'email' => $email
    ]);

    return $consulta->rowCount() > 0;
}
    public static function agregarUsuario(Usuario $usuario): bool {
        $conexion = Conexion::conectar();

        $consulta = $conexion->prepare(
            "INSERT INTO usuario (email, clave, rol)
             VALUES (:email, :clave, :rol)"
        );

        return $consulta->execute([
            'email' => $usuario->getEmail(),
            'clave' => $usuario->getClave(),
            'rol' => $usuario->getRol()
        ]);
    }
}