<?php
session_start();

// Incluir archivos de configuración y modelos
require_once 'config/database.php';
require_once 'models/Database.php';

// Incluir todos los modelos
require_once 'models/PaginaWebModel.php';
require_once 'models/ClienteModel.php';
require_once 'models/UsuarioModel.php';
require_once 'models/FragmentoCodigoModel.php';
require_once 'models/PluginModel.php';
require_once 'models/TemaModel.php';
require_once 'models/BackupModel.php';
require_once 'models/CorreoModel.php';
require_once 'models/CredencialHostingModel.php';
require_once 'models/UsuarioWordPressModel.php';

// Incluir todos los controladores
require_once 'controllers/AuthController.php';
require_once 'controllers/PaginaWebController.php';
require_once 'controllers/ClienteController.php';
require_once 'controllers/UsuarioController.php';
require_once 'controllers/FragmentoCodigoController.php';
require_once 'controllers/PluginController.php';
require_once 'controllers/TemaController.php';
require_once 'controllers/BackupController.php';
require_once 'controllers/CorreoController.php';
require_once 'controllers/CredencialHostingController.php';
require_once 'controllers/UsuarioWordPressController.php';

// Inicializar conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Verificar autenticación (excepto para login)
$action = $_GET['action'] ?? 'dashboard';
$controller = $_GET['controller'] ?? '';

// Si no está logueado y no está en la página de login, redirigir al login
if (!isset($_SESSION['usuario_id']) && $controller !== 'auth') {
    header("Location: index.php?controller=auth&action=login");
    exit;
}

// Inicializar modelos para el dashboard
$paginaWebModel = new PaginaWebModel($db);
$clienteModel = new ClienteModel($db);

// Datos para el dashboard (solo si está logueado)
if (isset($_SESSION['usuario_id'])) {
    $stats = [
        'total_paginas' => count($paginaWebModel->listar()),
        'total_clientes' => count($clienteModel->listar()),
        'plugins_temas' => 0,
        'vencimientos_proximos' => 0
    ];

    $paginas_recientes = array_slice($paginaWebModel->listar(), 0, 5);
} else {
    $stats = [
        'total_paginas' => 0,
        'total_clientes' => 0,
        'plugins_temas' => 0,
        'vencimientos_proximos' => 0
    ];
    $paginas_recientes = [];
}

// Router principal
switch($controller) {
    case 'auth':
        $authController = new AuthController($db);
        switch($action) {
            case 'login':
                $authController->login();
                break;
            case 'logout':
                $authController->logout();
                break;
            case 'registro':
                $authController->registro();
                break;
            default:
                $authController->login();
        }
        break;

    case 'paginas-web':
        $paginaWebController = new PaginaWebController($db);
        switch($action) {
            case 'crear':
                $paginaWebController->crear();
                break;
            case 'editar':
                $paginaWebController->editar();
                break;
            case 'eliminar':
                $paginaWebController->eliminar();
                break;
            case 'vencimientos':
                $paginaWebController->vencimientos();
                break;
            case 'ver':
                $paginaWebController->ver();
                break;
            default:
                $paginaWebController->listar();
        }
        break;
        
    case 'clientes':
        $clienteController = new ClienteController($db);
        switch($action) {
            case 'crear':
                $clienteController->crear();
                break;
            case 'editar':
                $clienteController->editar();
                break;
            case 'eliminar':
                $clienteController->eliminar();
                break;
            case 'ver':
                $clienteController->ver();
                break;
            case 'buscar':
                $clienteController->buscar();
                break;
            default:
                $clienteController->listar();
        }
        break;

    case 'usuarios':
        $usuarioController = new UsuarioController($db);
        switch($action) {
            case 'crear':
                $usuarioController->crear();
                break;
            case 'editar':
                $usuarioController->editar();
                break;
            case 'eliminar':
                $usuarioController->eliminar();
                break;
            case 'perfil':
                $usuarioController->perfil();
                break;
            default:
                $usuarioController->listar();
        }
        break;

    case 'fragmentos-codigo':
    $fragmentoCodigoController = new FragmentoCodigoController($db);
    switch($action) {
        case 'crear':
            $fragmentoCodigoController->crear();
            break;
        case 'editar':
            $fragmentoCodigoController->editar();
            break;
        case 'eliminar':
            $fragmentoCodigoController->eliminar();
            break;
        case 'ver':
            $fragmentoCodigoController->ver();
            break;
        case 'buscar':
            $fragmentoCodigoController->buscar();
            break;
        case 'descargar':
            $fragmentoCodigoController->descargar();
            break;
        case 'copiar':
            $fragmentoCodigoController->copiar();
            break;
        case 'por-lenguaje':
            $fragmentoCodigoController->porLenguaje();
            break;
        case 'por-categoria':
            $fragmentoCodigoController->porCategoria();
            break;
        default:
            $fragmentoCodigoController->listar();
    }
    break;

    case 'plugins':
        $pluginController = new PluginController($db);
        switch($action) {
            case 'crear':
                $pluginController->crear();
                break;
            case 'editar':
                $pluginController->editar();
                break;
            case 'eliminar':
                $pluginController->eliminar();
                break;
            case 'descargar':
                $pluginController->descargar();
                break;
            case 'subir':
                $pluginController->subir();
                break;
            default:
                $pluginController->listar();
        }
        break;

    case 'temas':
        $temaController = new TemaController($db);
        switch($action) {
            case 'crear':
                $temaController->crear();
                break;
            case 'editar':
                $temaController->editar();
                break;
            case 'eliminar':
                $temaController->eliminar();
                break;
            case 'descargar':
                $temaController->descargar();
                break;
            case 'subir':
                $temaController->subir();
                break;
            default:
                $temaController->listar();
        }
        break;

    case 'backups':
    $backupController = new BackupController($db);
    switch($action) {
        case 'crear':
            $backupController->crear();
            break;
        case 'editar':
            $backupController->editar();
            break;
        case 'eliminar':
            $backupController->eliminar();
            break;
        case 'descargar':
            $backupController->descargar();
            break;
        case 'ver':
            $backupController->ver();
            break;
        case 'porTipo':
            $backupController->porTipo();
            break;
        case 'porCategoria':
            $backupController->porCategoria();
            break;
        default:
            $backupController->listar();
    }
    break;

    case 'correos':
    $correoController = new CorreoController($db);
    switch($action) {
        case 'crear':
            $correoController->crear();
            break;
        case 'editar':
            $correoController->editar();
            break;
        case 'eliminar':
            $correoController->eliminar();
            break;
        case 'ver':
            $correoController->ver();
            break;
        default:
            $correoController->listar();
    }
    break;

    case 'credenciales-hosting':
        $credencialHostingController = new CredencialHostingController($db);
        switch($action) {
            case 'crear':
                $credencialHostingController->crear();
                break;
            case 'editar':
                $credencialHostingController->editar();
                break;
            case 'eliminar':
                $credencialHostingController->eliminar();
                break;
            default:
                $credencialHostingController->listar();
        }
        break;

    case 'usuarios-wordpress':
    $usuarioWordPressController = new UsuarioWordPressController($db);
    switch($action) {
        case 'crear':
            $usuarioWordPressController->crear();
            break;
        case 'editar':
            $usuarioWordPressController->editar();
            break;
        case 'eliminar':
            $usuarioWordPressController->eliminar();
            break;
        case 'ver':
            $usuarioWordPressController->ver();
            break;
        default:
            $usuarioWordPressController->listar();
    }
    break;

    case 'portafolio':
        // Portafolio público (no requiere login)
        $paginaWebController = new PaginaWebController($db);
        $paginaWebController->portafolioPublico();
        break;

    case 'dashboard':
    default:
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
        include 'views/dashboard.php';
        break;
}

// Función para mostrar errores 404
function mostrarError404() {
    http_response_code(404);
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Página no encontrada</title>
        <style>
            body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
            h1 { color: #dc3545; }
        </style>
    </head>
    <body>
        <h1>Error 404 - Página no encontrada</h1>
        <p>La página que buscas no existe.</p>
        <a href='index.php'>Volver al inicio</a>
    </body>
    </html>";
    exit;
}
?>