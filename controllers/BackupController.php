<?php
class BackupController {
    private $backupModel;
    private $paginaWebModel;

    public function __construct($db) {
        $this->backupModel = new BackupModel($db);
        $this->paginaWebModel = new PaginaWebModel($db);
    }

    public function listar() {
        $backups = $this->backupModel->listar();
        $estadisticas = $this->backupModel->obtenerEstadisticas();
        include 'views/backups/listar.php';
    }

    public function crear() {
        $mensaje = '';
        $paginas_web = $this->paginaWebModel->listar();
        
        if ($_POST) {
            $archivo_path = $this->subirArchivo($_FILES['archivo']);
            
            if (!$archivo_path) {
                $mensaje = 'error:Error al subir el archivo. Verifica que sea válido y no exceda el tamaño máximo.';
            } else {
                $data = [
                    'pagina_web_id' => $_POST['pagina_web_id'],
                    'nombre_archivo' => trim($_POST['nombre_archivo']),
                    'tipo' => $_POST['tipo'],
                    'categoria' => $_POST['categoria'],
                    'ruta_archivo' => $archivo_path,
                    'tamaño' => $this->formatearTamaño($_FILES['archivo']['size']),
                    'descripcion' => trim($_POST['descripcion'])
                ];

                if ($this->backupModel->crear($data)) {
                    header("Location: index.php?controller=backups&action=listar&mensaje=success:Backup creado correctamente");
                    exit;
                } else {
                    $mensaje = 'error:Error al crear el backup';
                    // Eliminar el archivo subido si falla la creación en la BD
                    if (file_exists($archivo_path)) {
                        unlink($archivo_path);
                    }
                }
            }
        }
        
        include 'views/backups/crear.php';
    }

    public function editar() {
    $id = $_GET['id'] ?? 0;
    $backup = $this->backupModel->obtenerPorId($id);
    $paginas_web = $this->paginaWebModel->listar();
    $mensaje = '';

    if (!$backup) {
        header("Location: index.php?controller=backups&action=listar&mensaje=error:Backup no encontrado");
        exit;
    }

    if ($_POST) {
        $data = [
            'pagina_web_id' => $_POST['pagina_web_id'],
            'nombre_archivo' => trim($_POST['nombre_archivo']),
            'tipo' => $_POST['tipo'],
            'categoria' => $_POST['categoria'],
            'descripcion' => trim($_POST['descripcion'])
        ];

        // Si se subió un nuevo archivo, reemplazar el existente
        if (!empty($_FILES['nuevo_archivo']['name'])) {
            $nuevo_archivo_path = $this->subirArchivo($_FILES['nuevo_archivo']);
            
            if ($nuevo_archivo_path) {
                // Eliminar el archivo anterior
                if (file_exists($backup['ruta_archivo'])) {
                    unlink($backup['ruta_archivo']);
                }
                
                $data['ruta_archivo'] = $nuevo_archivo_path;
                $data['tamaño'] = $this->formatearTamaño($_FILES['nuevo_archivo']['size']);
            } else {
                $mensaje = 'error:Error al subir el nuevo archivo. Verifica que sea válido.';
            }
        }

        if (empty($mensaje)) {
            if ($this->backupModel->actualizar($id, $data)) {
                header("Location: index.php?controller=backups&action=listar&mensaje=success:Backup actualizado correctamente");
                exit;
            } else {
                $mensaje = 'error:Error al actualizar el backup';
            }
        }
    }
    
    include 'views/backups/editar.php';
}
    public function eliminar() {
        $id = $_GET['id'] ?? 0;
        
        if ($this->backupModel->eliminar($id)) {
            header("Location: index.php?controller=backups&action=listar&mensaje=success:Backup eliminado correctamente");
        } else {
            header("Location: index.php?controller=backups&action=listar&mensaje=error:Error al eliminar el backup");
        }
        exit;
    }

    public function descargar() {
        $id = $_GET['id'] ?? 0;
        $backup = $this->backupModel->obtenerPorId($id);

        if (!$backup) {
            header("Location: index.php?controller=backups&action=listar&mensaje=error:Backup no encontrado");
            exit;
        }

        if (!file_exists($backup['ruta_archivo'])) {
            header("Location: index.php?controller=backups&action=listar&mensaje=error:Archivo no encontrado en el servidor");
            exit;
        }

        // Configurar headers para descarga
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($backup['ruta_archivo']) . '"');
        header('Content-Length: ' . filesize($backup['ruta_archivo']));
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        
        readfile($backup['ruta_archivo']);
        exit;
    }

    public function ver() {
        $id = $_GET['id'] ?? 0;
        $backup = $this->backupModel->obtenerPorId($id);

        if (!$backup) {
            header("Location: index.php?controller=backups&action=listar&mensaje=error:Backup no encontrado");
            exit;
        }

        include 'views/backups/ver.php';
    }

    public function porTipo() {
        $tipo = $_GET['tipo'] ?? '';
        $backups = [];
        
        if (!empty($tipo)) {
            $backups = $this->backupModel->obtenerPorTipo($tipo);
        } else {
            $backups = $this->backupModel->listar();
        }
        
        $estadisticas = $this->backupModel->obtenerEstadisticas();
        include 'views/backups/listar.php';
    }

    public function porCategoria() {
        $categoria = $_GET['categoria'] ?? '';
        $backups = [];
        
        if (!empty($categoria)) {
            $backups = $this->backupModel->obtenerPorCategoria($categoria);
        } else {
            $backups = $this->backupModel->listar();
        }
        
        $estadisticas = $this->backupModel->obtenerEstadisticas();
        include 'views/backups/listar.php';
    }

    private function subirArchivo($archivo) {
    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    // Validar tipo de archivo - permitir .zip y .wpress
    $extensiones_permitidas = ['zip', 'wpress', 'sql', 'gz', 'tar', 'bak', 'wp'];
    $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
    
    if (!in_array($extension, $extensiones_permitidas)) {
        return null;
    }

    // Validar tamaño (máximo 2GB para backups grandes)
    $tamaño_maximo = 2 * 1024 * 1024 * 1024; // 2GB en bytes
    if ($archivo['size'] > $tamaño_maximo) {
        return null;
    }

    $uploadDir = 'assets/uploads/backups/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Generar nombre único para el archivo
    $fileName = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $archivo['name']);
    $uploadFile = $uploadDir . $fileName;
    
    if (move_uploaded_file($archivo['tmp_name'], $uploadFile)) {
        return $uploadFile;
    }
    
    return null;
}

    

    private function formatearTamaño($bytes) {
        $unidades = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($unidades) - 1);
        $bytes /= pow(1024, $pow);
        
        return round($bytes, 2) . ' ' . $unidades[$pow];
    }




    
}
?>