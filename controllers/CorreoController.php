<?php
class CorreoController {
    private $correoModel;
    private $paginaWebModel;

    public function __construct($db) {
        $this->correoModel = new CorreoModel($db);
        $this->paginaWebModel = new PaginaWebModel($db);
    }

    public function listar() {
        $correos = $this->correoModel->listar();
        include 'views/correos/listar.php';
    }

    public function crear() {
        $mensaje = '';
        $paginas_web = $this->paginaWebModel->listar();
        
        if ($_POST) {
            $data = [
                'pagina_web_id' => $_POST['pagina_web_id'],
                'email' => trim($_POST['email']),
                'password_encrypted' => base64_encode($_POST['password']),
                'quota' => trim($_POST['quota']),
                'fecha_creacion' => $_POST['fecha_creacion']
            ];

            if ($this->correoModel->crear($data)) {
                header("Location: index.php?controller=correos&action=listar&mensaje=success:Correo creado correctamente");
                exit;
            } else {
                $mensaje = 'error:Error al crear el correo';
            }
        }
        
        include 'views/correos/crear.php';
    }

    public function editar() {
        $id = $_GET['id'] ?? 0;
        $correo = $this->correoModel->obtenerPorId($id);
        $paginas_web = $this->paginaWebModel->listar();
        $mensaje = '';

        if (!$correo) {
            header("Location: index.php?controller=correos&action=listar&mensaje=error:Correo no encontrado");
            exit;
        }

        if ($_POST) {
            $data = [
                'pagina_web_id' => $_POST['pagina_web_id'],
                'email' => trim($_POST['email']),
                'quota' => trim($_POST['quota']),
                'fecha_creacion' => $_POST['fecha_creacion'],
                'activo' => $_POST['activo']
            ];

            // Si se proporcionó nueva contraseña, actualizarla
            if (!empty($_POST['password'])) {
                $data['password_encrypted'] = base64_encode($_POST['password']);
            }

            if ($this->correoModel->actualizar($id, $data)) {
                header("Location: index.php?controller=correos&action=listar&mensaje=success:Correo actualizado correctamente");
                exit;
            } else {
                $mensaje = 'error:Error al actualizar el correo';
            }
        }
        
        include 'views/correos/editar.php';
    }

    public function eliminar() {
        $id = $_GET['id'] ?? 0;
        
        if ($this->correoModel->eliminar($id)) {
            header("Location: index.php?controller=correos&action=listar&mensaje=success:Correo eliminado correctamente");
        } else {
            header("Location: index.php?controller=correos&action=listar&mensaje=error:Error al eliminar el correo");
        }
        exit;
    }

    public function ver() {
        $id = $_GET['id'] ?? 0;
        $correo = $this->correoModel->obtenerPorId($id);

        if (!$correo) {
            header("Location: index.php?controller=correos&action=listar&mensaje=error:Correo no encontrado");
            exit;
        }

        include 'views/correos/ver.php';
    }
}
?>