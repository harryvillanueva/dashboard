<?php
class UsuarioController {
    private $usuarioModel;

    public function __construct($db) {
        $this->usuarioModel = new UsuarioModel($db);
    }

    public function listar() {
        $usuarios = $this->usuarioModel->listar();
        include 'views/usuarios/listar.php';
    }

    public function crear() {
        $mensaje = '';
        
        if ($_POST) {
            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'nombre' => trim($_POST['nombre']),
                'rol' => $_POST['rol']
            ];

            if ($this->usuarioModel->crear($data)) {
                header("Location: index.php?controller=usuarios&action=listar&mensaje=success:Usuario creado correctamente");
                exit;
            } else {
                $mensaje = 'error:Error al crear el usuario';
            }
        }
        
        include 'views/usuarios/crear.php';
    }

    public function editar() {
        $id = $_GET['id'] ?? 0;
        $usuario = $this->usuarioModel->obtenerPorId($id);
        $mensaje = '';

        if (!$usuario) {
            header("Location: index.php?controller=usuarios&action=listar&mensaje=error:Usuario no encontrado");
            exit;
        }

        if ($_POST) {
            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'nombre' => trim($_POST['nombre']),
                'rol' => $_POST['rol']
            ];

            if ($this->usuarioModel->actualizar($id, $data)) {
                header("Location: index.php?controller=usuarios&action=listar&mensaje=success:Usuario actualizado correctamente");
                exit;
            } else {
                $mensaje = 'error:Error al actualizar el usuario';
            }
        }
        
        include 'views/usuarios/editar.php';
    }

    public function eliminar() {
        $id = $_GET['id'] ?? 0;
        
        if ($this->usuarioModel->eliminar($id)) {
            header("Location: index.php?controller=usuarios&action=listar&mensaje=success:Usuario eliminado correctamente");
        } else {
            header("Location: index.php?controller=usuarios&action=listar&mensaje=error:Error al eliminar el usuario");
        }
        exit;
    }

    public function perfil() {
        $id = $_SESSION['usuario_id'] ?? 0;
        $usuario = $this->usuarioModel->obtenerPorId($id);
        
        if (!$usuario) {
            header("Location: index.php?controller=auth&action=logout");
            exit;
        }
        
        include 'views/usuarios/perfil.php';
    }
}
?>