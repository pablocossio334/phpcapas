<?php

require_once __DIR__ . '/APP/PERSISTENCIA/Conexion.php';

$usuarios = [
    ['ana@instituto.edu', 'Ana1234!', 'alumno'],
    ['luis@instituto.edu', 'Luis1234!', 'alumno'],
    ['maria@instituto.edu', 'Maria1234!', 'alumno'],
    ['pablo@instituto.edu', 'Pablo1234!', 'docente'],
    ['laura@instituto.edu', 'Laura1234!', 'docente']
];

try {
    $conexion = Conexion::conectar();

    $consulta = $conexion->prepare(
        "INSERT INTO usuario (email, clave, rol)
         VALUES (:email, :clave, :rol)"
    );

    $conexion->beginTransaction();

    foreach ($usuarios as $usuario) {
        $consulta->execute([
            'email' => $usuario[0],
            'clave' => password_hash(
                $usuario[1],
                PASSWORD_DEFAULT
            ),
            'rol' => $usuario[2]
        ]);
    }

    $conexion->commit();

    echo 'Los 5 usuarios se agregaron correctamente.';

} catch (PDOException $error) {
    if (isset($conexion) && $conexion->inTransaction()) {
        $conexion->rollBack();
    }

    error_log($error->getMessage());

    echo 'No se pudieron agregar los usuarios. '
       . 'Revisá la conexión y que los emails no estén registrados.';
}