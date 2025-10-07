<?php
class AuthController {
    private $usuarioModel;

    public function __construct($db) {
        $this->usuarioModel = new UsuarioModel($db);
    }

    public function login() {
        $mensaje = '';

        if ($_POST) {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            
            // Validar campos
            if (empty($username) || empty($password)) {
                $error = "Por favor, ingresa usuario y contraseña";
            } else {
                // Buscar usuario por USERNAME
                $usuario = $this->usuarioModel->buscarPorUsername($username);
                
                if ($usuario) {
                    // Verificación en texto plano
                    if ($password === $usuario['password']) {
                        // Iniciar sesión
                        $_SESSION['usuario_id'] = $usuario['id'];
                        $_SESSION['usuario_nombre'] = $usuario['nombre'];
                        $_SESSION['usuario_email'] = $usuario['email'];
                        $_SESSION['usuario_rol'] = $usuario['rol'];
                        $_SESSION['usuario_username'] = $usuario['username'];
                        
                        // Redirigir al dashboard
                        header("Location: index.php?controller=dashboard");
                        exit();
                    } else {
                        $error = "Contraseña incorrecta";
                    }
                } else {
                    $error = "Usuario no encontrado o inactivo";
                }
            }
        }

        include 'views/auth/login.php';
    }

    public function logout() {
        // Destruir todas las variables de sesión
        $_SESSION = array();

        // Si se desea destruir la sesión completamente, borre también la cookie de sesión.
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finalmente, destruir la sesión
        session_destroy();

        // Redirigir al login
        header("Location: index.php?controller=auth&action=login");
        exit();
    }

    public function registro() {
        // Implementar registro si es necesario
        include 'views/auth/registro.php';
    }
}
?>