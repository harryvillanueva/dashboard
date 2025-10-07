<?php
class CredencialHostingController {
    private $credencialHostingModel;
    private $paginaWebModel;

    public function __construct($db) {
        $this->credencialHostingModel = new CredencialHostingModel($db);
        $this->paginaWebModel = new PaginaWebModel($db);
    }

    public function listar() {
        $credenciales = $this->credencialHostingModel->listar();
        include 'views/credenciales-hosting/listar.php';
    }

    public function crear() {
        $mensaje = '';
        $paginas_web = $this->paginaWebModel->listar();
        
        if ($_POST) {
            $data = [
                'pagina_web_id' => $_POST['pagina_web_id'],
                'url_cpanel' => trim($_POST['url_cpanel']),
                'usuario' => trim($_POST['usuario']),
                'password_encrypted' => base64_encode($_POST['password']),
                'fecha_compra' => $_POST['fecha_compra'],
                'fecha_caducidad' => $_POST['fecha_caducidad'],
                'proveedor' => trim($_POST['proveedor']),
                'plan_hosting' => trim($_POST['plan_hosting'])
            ];

            if ($this->credencialHostingModel->crear($data)) {
                header("Location: index.php?controller=credenciales-hosting&action=listar&mensaje=success:Credencial cPanel creada correctamente");
                exit;
            } else {
                $mensaje = 'error:Error al crear la credencial cPanel';
            }
        }
        
        include 'views/credenciales-hosting/crear.php';
    }

    public function editar() {
        $id = $_GET['id'] ?? 0;
        $credencial = $this->credencialHostingModel->obtenerPorId($id);
        $paginas_web = $this->paginaWebModel->listar();
        $mensaje = '';

        if (!$credencial) {
            header("Location: index.php?controller=credenciales-hosting&action=listar&mensaje=error:Credencial cPanel no encontrada");
            exit;
        }

        if ($_POST) {
            $data = [
                'pagina_web_id' => $_POST['pagina_web_id'],
                'url_cpanel' => trim($_POST['url_cpanel']),
                'usuario' => trim($_POST['usuario']),
                'fecha_compra' => $_POST['fecha_compra'],
                'fecha_caducidad' => $_POST['fecha_caducidad'],
                'proveedor' => trim($_POST['proveedor']),
                'plan_hosting' => trim($_POST['plan_hosting'])
            ];

            // Si se proporcionó nueva contraseña, actualizarla
            if (!empty($_POST['password'])) {
                $data['password_encrypted'] = base64_encode($_POST['password']);
            }

            if ($this->credencialHostingModel->actualizar($id, $data)) {
                header("Location: index.php?controller=credenciales-hosting&action=listar&mensaje=success:Credencial cPanel actualizada correctamente");
                exit;
            } else {
                $mensaje = 'error:Error al actualizar la credencial cPanel';
            }
        }
        
        include 'views/credenciales-hosting/editar.php';
    }

    public function eliminar() {
        $id = $_GET['id'] ?? 0;
        
        if ($this->credencialHostingModel->eliminar($id)) {
            header("Location: index.php?controller=credenciales-hosting&action=listar&mensaje=success:Credencial cPanel eliminada correctamente");
        } else {
            header("Location: index.php?controller=credenciales-hosting&action=listar&mensaje=error:Error al eliminar la credencial cPanel");
        }
        exit;
    }
}
?>