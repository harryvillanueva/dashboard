<?php
class PluginController {
    private $pluginModel;

    public function __construct($db) {
        $this->pluginModel = new PluginModel($db);
    }

    public function listar() {
        $plugins = $this->pluginModel->listar();
        include 'views/plugins/listar.php';
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

            if ($this->pluginModel->crear($data)) {
                header("Location: index.php?controller=plugins&action=listar&mensaje=success:Plugin creado correctamente");
                exit;
            } else {
                $mensaje = 'error:Error al crear el plugin';
            }
        }
        
        include 'views/plugins/crear.php';
    }

    public function editar() {
        $id = $_GET['id'] ?? 0;
        $plugin = $this->pluginModel->obtenerPorId($id);
        $mensaje = '';

        if (!$plugin) {
            header("Location: index.php?controller=plugins&action=listar&mensaje=error:Plugin no encontrado");
            exit;
        }

        if ($_POST) {
            $data = [
                'nombre' => trim($_POST['nombre']),
                'version' => trim($_POST['version']),
                'descripcion' => trim($_POST['descripcion']),
                'categoria' => $_POST['categoria']
            ];

            if ($this->pluginModel->actualizar($id, $data)) {
                header("Location: index.php?controller=plugins&action=listar&mensaje=success:Plugin actualizado correctamente");
                exit;
            } else {
                $mensaje = 'error:Error al actualizar el plugin';
            }
        }
        
        include 'views/plugins/editar.php';
    }

    public function eliminar() {
        $id = $_GET['id'] ?? 0;
        
        if ($this->pluginModel->eliminar($id)) {
            header("Location: index.php?controller=plugins&action=listar&mensaje=success:Plugin eliminado correctamente");
        } else {
            header("Location: index.php?controller=plugins&action=listar&mensaje=error:Error al eliminar el plugin");
        }
        exit;
    }

    public function descargar() {
        $id = $_GET['id'] ?? 0;
        $plugin = $this->pluginModel->obtenerPorId($id);

        if ($plugin && file_exists($plugin['archivo_path'])) {
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . basename($plugin['archivo_path']) . '"');
            readfile($plugin['archivo_path']);
            exit;
        } else {
            header("Location: index.php?controller=plugins&action=listar&mensaje=error:Archivo no encontrado");
        }
    }

    public function subir() {
        // Implementar subida de archivos
        $this->crear();
    }

    private function subirArchivo($archivo) {
        if ($archivo['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'assets/uploads/plugins/';
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