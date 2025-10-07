<?php
class UsuarioWordPressController {
    private $usuarioWordPressModel;
    private $paginaWebModel;

    public function __construct($db) {
        $this->usuarioWordPressModel = new UsuarioWordPressModel($db);
        $this->paginaWebModel = new PaginaWebModel($db);
    }

    public function listar() {
        $usuarios = $this->usuarioWordPressModel->listar();
        include 'views/usuarios-wordpress/listar.php';
    }

    public function crear() {
        $mensaje = '';
        $paginas_web = $this->paginaWebModel->listar();
        
        if ($_POST) {
            $data = [
                'pagina_web_id' => $_POST['pagina_web_id'],
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password_encrypted' => base64_encode($_POST['password']),
                'rol' => $_POST['rol']
            ];

            if ($this->usuarioWordPressModel->crear($data)) {
                header("Location: index.php?controller=usuarios-wordpress&action=listar&mensaje=success:Usuario WordPress creado correctamente");
                exit;
            } else {
                $mensaje = 'error:Error al crear el usuario WordPress';
            }
        }
        
        include 'views/usuarios-wordpress/crear.php';
    }

    public function editar() {
        $id = $_GET['id'] ?? 0;
        $usuario = $this->usuarioWordPressModel->obtenerPorId($id);
        $paginas_web = $this->paginaWebModel->listar();
        $mensaje = '';

        if (!$usuario) {
            header("Location: index.php?controller=usuarios-wordpress&action=listar&mensaje=error:Usuario WordPress no encontrado");
            exit;
        }

        if ($_POST) {
            $data = [
                'pagina_web_id' => $_POST['pagina_web_id'],
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'rol' => $_POST['rol'],
                'activo' => $_POST['activo']
            ];

            // Si se proporcionó nueva contraseña, actualizarla
            if (!empty($_POST['password'])) {
                $data['password_encrypted'] = base64_encode($_POST['password']);
            }

            if ($this->usuarioWordPressModel->actualizar($id, $data)) {
                header("Location: index.php?controller=usuarios-wordpress&action=listar&mensaje=success:Usuario WordPress actualizado correctamente");
                exit;
            } else {
                $mensaje = 'error:Error al actualizar el usuario WordPress';
            }
        }
        
        include 'views/usuarios-wordpress/editar.php';
    }

    public function eliminar() {
        $id = $_GET['id'] ?? 0;
        
        if ($this->usuarioWordPressModel->eliminar($id)) {
            header("Location: index.php?controller=usuarios-wordpress&action=listar&mensaje=success:Usuario WordPress eliminado correctamente");
        } else {
            header("Location: index.php?controller=usuarios-wordpress&action=listar&mensaje=error:Error al eliminar el usuario WordPress");
        }
        exit;
    }

    public function ver() {
        $id = $_GET['id'] ?? 0;
        $usuario = $this->usuarioWordPressModel->obtenerPorId($id);

        if (!$usuario) {
            header("Location: index.php?controller=usuarios-wordpress&action=listar&mensaje=error:Usuario WordPress no encontrado");
            exit;
        }

        include 'views/usuarios-wordpress/ver.php';
    }
}
?>