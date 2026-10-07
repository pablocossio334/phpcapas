<body>
    <header>
        
           <?php
           include_once __DIR__."/presentacion/componentes/header.php";



           ?>            
              
    </header>

    

    <main>
        


        <?php if ($sesionIniciada):
            
            include_once __DIR__."/presentacion/paginas/menu.php";
            
            ?>
            <?php
            if(isset($_GET['pagina']))
        $pagina=$_GET['pagina'];
    else 
        $pagina="login";
         switch ($pagina) {
        case 'login':
            //require __DIR__ . '/presentacion/paginas/login.php';
            echo "LOGIN";
            break;

        case 'listar':
            require __DIR__ . '/presentacion/paginas/listar.php';
             
            break;

        case 'insertar':
           require __DIR__ . '/presentacion/paginas/insertar.php';
           
            break;

        case 'eliminar':
            require __DIR__ . '/presentacion/paginas/eliminar.php';
            
            break;

        case 'modificar':
          //  require __DIR__ . '/presentacion/paginas/modificar.php';
          echo "modificar";
            break;

        default:
            echo '<h2>Bienvenido</h2>';
            break;
    }
    ?>
            
        <?php else: ?>
            <?php
            include_once __DIR__."/presentacion/paginas/login.php";
            ?>
        <?php endif; ?>
    </main>
</body>
</html> 
devolvemelo con comentarios
…

<?php
// Inicia o recupera la sesión.
// Debe ejecutarse antes de enviar HTML al navegador.
session_start();

// Comprueba si hay un usuario guardado en la sesión.
$sesionIniciada = isset($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <!-- Adapta la página a pantallas de celulares y computadoras. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Administración de alumnos</title>

    <!-- Carga los estilos mediante una ruta desde la raíz del sitio. -->
    <link rel="stylesheet" href="/presentacion/assets/css/estilos.css">
</head>

<body>
    <header>
        <?php
        // Incluye el encabezado común.
        // __DIR__ es la carpeta donde está este index.php.
        // include_once evita incluir el archivo más de una vez.
        include_once __DIR__ . "/presentacion/componentes/header.php";
        ?>
    </header>

    <main>
        <?php if ($sesionIniciada): ?>
            <?php
            // El menú se muestra solamente si hay sesión iniciada.
            include_once __DIR__ . "/presentacion/paginas/menu.php";

            // Lee la página solicitada en la URL.
            // Ejemplo: index.php?pagina=listar
            // Si no existe el parámetro, usa "login".
            $pagina = $_GET['pagina'] ?? 'login';

            // Carga el contenido correspondiente dentro del main.
            // Solo se permiten los archivos indicados en estos casos.
            switch ($pagina) {
                case 'login':
                    // Por ahora muestra un texto.
                    // Para cargar el formulario, descomentá el require
                    // y quitá el echo.
                    // require __DIR__ . '/presentacion/paginas/login.php';
                    echo 'LOGIN';
                    break;

                case 'listar':
                    // Muestra la lista de usuarios.
                    require __DIR__ . '/presentacion/paginas/listar.php';
                    break;

                case 'insertar':
                    // Muestra el formulario para agregar un usuario.
                    require __DIR__ . '/presentacion/paginas/insertar.php';
                    break;

                case 'eliminar':
                    // Muestra el formulario para eliminar un usuario.
                    require __DIR__ . '/presentacion/paginas/eliminar.php';
                    break;

                case 'modificar':
                    // La página de modificación todavía está pendiente.
                    // require __DIR__ . '/presentacion/paginas/modificar.php';
                    echo 'modificar';
                    break;

                default:
                    // Se muestra si el valor de "pagina" no coincide
                    // con ninguno de los casos anteriores.
                    echo '<h2>Bienvenido</h2>';
                    break;
            }
            ?>

        <?php else: ?>
            <?php
            // Si no hay sesión, muestra el formulario de login.
            // No carga el menú ni las páginas del CRUD.
            include_once __DIR__ . "/presentacion/paginas/login.php";
            ?>
        <?php endif; ?>
    </main>
</body>
</html>