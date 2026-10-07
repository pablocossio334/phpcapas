<h2>LISTADO DE USUARIOS</h2>
<?php
require_once __DIR__ . '/../../APP/negocio/UsuarioServicio.php';
$usuarios = [];
$error = '';


    $servicio = new UsuarioServicio();
    $usuarios = $servicio->listarUsuarios();

foreach ($usuarios as $usuario){
echo $usuario->getEmail();
?>
</br>
<?php
}
?>    

