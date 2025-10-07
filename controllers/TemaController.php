<?php
class TemaController {
    private $temaModel;

    public function __construct($db) {
        $this->temaModel = new TemaModel($db);
    }

    public function listar() {
        $temas = $this->temaModel->listar();
        include 'views/temas/listar.php';
    }

    public function crear() {
        $mensaje = '';
        
        if ($_POST) {
            $archivo_path = $this->subirArchivo($_FILES['archivo']);
            
            $data = [
                'nombre' => trim($_POST['nombre']),
                'archivo_path' => $archivo_path,
                'version' => trim($_POST['version']),
                'descripcion' => trim($_POST['descripcion']),
                'categoria' => $_POST['categoria']
            ];

            if ($this->temaModel->crear($data)) {
                header("Location: index.php?controller=temas&action=listar&mensaje=success:Tema creado correctamente");
                exit;
            } else {
                $mensaje = 'error:Error al crear el tema';
            }
        }
        
        include 'views/temas/crear.php';
    }

    public function editar() {
        $id = $_GET['id'] ?? 0;
        $tema = $this->temaModel->obtenerPorId($id);
        $mensaje = '';

        if (!$tema) {
            header("Location: index.php?controller=temas&action=listar&mensaje=error:Tema no encontrado");
            exit;
        }

        if ($_POST) {
            $data = [
                'nombre' => trim($_POST['nombre']),
                'version' => trim($_POST['version']),
                'descripcion' => trim($_POST['descripcion']),
                'categoria' => $_POST['categoria']
            ];

            if ($this->temaModel->actualizar($id, $data)) {
                header("Location: index.php?controller=temas&action=listar&mensaje=success:Tema actualizado correctamente");
                exit;
            } else {
                $mensaje = 'error:Error al actualizar el tema';
            }
        }
        
        include 'views/temas/editar.php';
    }

    public function eliminar() {
        $id = $_GET['id'] ?? 0;
        
        if ($this->temaModel->eliminar($id)) {
            header("Location: index.php?controller=temas&action=listar&mensaje=success:Tema eliminado correctamente");
        } else {
            header("Location: index.php?controller=temas&action=listar&mensaje=error:Error al eliminar el tema");
        }
        exit;
    }

    public function descargar() {
        $id = $_GET['id'] ?? 0;
        $tema = $this->temaModel->obtenerPorId($id);

        if ($tema && file_exists($tema['archivo_path'])) {
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . basename($tema['archivo_path']) . '"');
            readfile($tema['archivo_path']);
            exit;
        } else {
            header("Location: index.php?controller=temas&action=listar&mensaje=error:Archivo no encontrado");
        }
    }

    public function subir() {
        $this->crear();
    }

    private function subirArchivo($archivo) {
        if ($archivo['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'assets/uploads/temas/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileName = uniqid() . '_' . basename($archivo['name']);
            $uploadFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($archivo['tmp_name'], $uploadFile)) {
                return $uploadFile;
            }
        }
        return null;
    }
}
?>