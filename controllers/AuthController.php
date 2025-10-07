<?php
class AuthController {
    private $usuarioModel;

    public function __construct($db) {
        $this->usuarioModel = new UsuarioModel($db);
    }

    public function login() {
        $mensaje = '';

        if ($_POST) {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            $usuario = $this->usuarioModel->login($username, $password);

            if ($usuario) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['usuario_rol'] = $usuario['rol'];
                $_SESSION['usuario_username'] = $usuario['username'];

                header("Location: index.php");
                exit;
            } else {
                $mensaje = 'error:Usuario o contraseña incorrectos';
            }
        }

        include 'views/auth/login.php';
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?controller=auth&action=login");
        exit;
    }

    public function registro() {
        // Implementar registro si es necesario
        include 'views/auth/registro.php';
    }
}
?>