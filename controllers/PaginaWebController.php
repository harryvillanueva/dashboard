<?php
class PaginaWebController {
    private $paginaWebModel;
    private $clienteModel;

    public function __construct($db) {
        $this->paginaWebModel = new PaginaWebModel($db);
        $this->clienteModel = new ClienteModel($db);
    }

    public function listar() {
        $paginas = $this->paginaWebModel->listar();
        include 'views/paginas-web/listar.php';
    }

    public function crear() {
        $mensaje = '';
        $clientes = $this->clienteModel->listar();
        
        if ($_POST) {
            $data = [
                'cliente_id' => $_POST['cliente_id'] ?: null,
                'titulo' => trim($_POST['titulo']),
                'url' => trim($_POST['url']),
                'rubro' => trim($_POST['rubro']),
                'descripcion' => trim($_POST['descripcion']),
                'imagen_path' => $this->subirImagen($_FILES['imagen']),
                'fecha_creacion' => $_POST['fecha_creacion'],
                'fecha_vencimiento_hosting' => $_POST['fecha_vencimiento_hosting']
            ];

            if (empty($data['titulo'])) {
                $mensaje = 'error:El título es obligatorio';
            } else {
                if ($this->paginaWebModel->crear($data)) {
                    header("Location: index.php?controller=paginas-web&action=listar&mensaje=success:Página web creada correctamente");
                    exit;
                } else {
                    $mensaje = 'error:Error al crear la página web';
                }
            }
        }
        
        include 'views/paginas-web/crear.php';
    }

    public function editar() {
        $id = $_GET['id'] ?? 0;
        $pagina = $this->paginaWebModel->obtenerPorId($id);
        $clientes = $this->clienteModel->listar();
        $mensaje = '';

        if (!$pagina) {
            header("Location: index.php?controller=paginas-web&action=listar&mensaje=error:Página web no encontrada");
            exit;
        }

        if ($_POST) {
            $data = [
                'cliente_id' => $_POST['cliente_id'] ?: null,
                'titulo' => trim($_POST['titulo']),
                'url' => trim($_POST['url']),
                'rubro' => trim($_POST['rubro']),
                'descripcion' => trim($_POST['descripcion']),
                'fecha_vencimiento_hosting' => $_POST['fecha_vencimiento_hosting']
            ];

            // Si se subió nueva imagen, actualizar
            if ($_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $data['imagen_path'] = $this->subirImagen($_FILES['imagen']);
            } else {
                $data['imagen_path'] = $pagina['imagen_path'];
            }

            if (empty($data['titulo'])) {
                $mensaje = 'error:El título es obligatorio';
            } else {
                if ($this->paginaWebModel->actualizar($id, $data)) {
                    header("Location: index.php?controller=paginas-web&action=listar&mensaje=success:Página web actualizada correctamente");
                    exit;
                } else {
                    $mensaje = 'error:Error al actualizar la página web';
                }
            }
        }
        
        include 'views/paginas-web/editar.php';
    }

    public function eliminar() {
        $id = $_GET['id'] ?? 0;
        
        if ($this->paginaWebModel->eliminar($id)) {
            header("Location: index.php?controller=paginas-web&action=listar&mensaje=success:Página web eliminada correctamente");
        } else {
            header("Location: index.php?controller=paginas-web&action=listar&mensaje=error:Error al eliminar la página web");
        }
        exit;
    }

    public function ver() {
        $id = $_GET['id'] ?? 0;
        $pagina = $this->paginaWebModel->obtenerPorId($id);

        if (!$pagina) {
            header("Location: index.php?controller=paginas-web&action=listar&mensaje=error:Página web no encontrada");
            exit;
        }

        include 'views/paginas-web/ver.php';
    }

    public function vencimientos() {
    $paginas = $this->paginaWebModel->listar();
    include 'views/paginas-web/vencimientos.php';
}

    public function portafolioPublico() {
        // Portafolio público
        $paginas = $this->paginaWebModel->listar();
        include 'views/portafolio/publico.php';
    }

    private function subirImagen($imagen) {
        if ($imagen['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'assets/uploads/paginas-web/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileName = uniqid() . '_' . basename($imagen['name']);
            $uploadFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($imagen['tmp_name'], $uploadFile)) {
                return $uploadFile;
            }
        }
        return null;
    }
    
}
?>