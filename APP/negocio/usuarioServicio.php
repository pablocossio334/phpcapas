<?php

require_once __DIR__ . '/../PERSISTENCIA/UsuarioDAO.php';

class UsuarioServicio {

    public function obtenerPorEmail(string $email): ?Usuario {
        return UsuarioDAO::obtenerPorEmail(trim($email));
    }

    public function listarUsuarios(): array {
        return UsuarioDAO::listarUsuarios();
    }

    public function agregarUsuario(
        string $email,
        string $clave,
        string $rol
    ): bool {
        $email = trim($email);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('El email no es válido.');
        }

        if ($clave === '') {
            throw new InvalidArgumentException('Ingresá una contraseña.');
        }

        if (!in_array($rol, ['alumno', 'docente'], true)) {
            throw new InvalidArgumentException('El rol no es válido.');
        }

        if ($this->obtenerPorEmail($email) !== null) {
            throw new InvalidArgumentException('El usuario ya existe.');
        }

        $hash = password_hash($clave, PASSWORD_DEFAULT);

        $usuario = new Usuario($email, $hash, $rol);

        return UsuarioDAO::agregarUsuario($usuario);
    }
public function eliminarUsuario(string $email): bool {
    $email = trim($email);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException('El email no es válido.');
    }

    return (new UsuarioDAO())->eliminarUsuario($email);
}
    public function iniciarSesion(
        string $email,
        string $clave
    ): ?Usuario {
        $usuario = $this->obtenerPorEmail($email);

        if ($usuario === null) {
            return null;
        }

        if (!password_verify($clave, $usuario->getClave())) {
            return null;
        }

        return $usuario;
    }
}