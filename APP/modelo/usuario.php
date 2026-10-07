<?php

class Usuario {
    private string $email;
    private string $clave;
    private string $rol;

    public function __construct(
        string $email,
        string $clave,
        string $rol
    ) {
        $this->email = $email;
        $this->clave = $clave;
        $this->rol = $rol;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getClave(): string {
        return $this->clave;
    }

    public function getRol(): string {
        return $this->rol;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setClave(string $clave): void {
        $this->clave = $clave;
    }

    public function setRol(string $rol): void {
        $this->rol = $rol;
    }
}