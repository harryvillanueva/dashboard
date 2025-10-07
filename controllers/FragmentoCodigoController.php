<?php
class FragmentoCodigoController {
    private $fragmentoCodigoModel;

    public function __construct($db) {
        $this->fragmentoCodigoModel = new FragmentoCodigoModel($db);
    }

    public function listar() {
        $fragmentos = $this->fragmentoCodigoModel->listar();
        include 'views/fragmentos-codigo/listar.php';
    }

    public function crear() {
        $mensaje = '';
        
        if ($_POST) {
            $data = [
                'titulo' => trim($_POST['titulo']),
                'codigo' => $_POST['codigo'],
                'lenguaje' => $_POST['lenguaje'],
                'categoria' => $_POST['categoria'],
                'descripcion' => trim($_POST['descripcion']),
                'tags' => trim($_POST['tags']),
                'usuario_id' => $_SESSION['usuario_id']
            ];

            // Validaciones
            if (empty($data['titulo'])) {
                $mensaje = 'error:El título es obligatorio';
            } elseif (empty($data['codigo'])) {
                $mensaje = 'error:El código es obligatorio';
            } else {
                if ($this->fragmentoCodigoModel->crear($data)) {
                    header("Location: index.php?controller=fragmentos-codigo&action=listar&mensaje=success:Fragmento creado correctamente");
                    exit;
                } else {
                    $mensaje = 'error:Error al crear el fragmento';
                }
            }
        }
        
        include 'views/fragmentos-codigo/crear.php';
    }

    public function editar() {
        $id = $_GET['id'] ?? 0;
        $fragmento = $this->fragmentoCodigoModel->obtenerPorId($id);
        $mensaje = '';

        if (!$fragmento) {
            header("Location: index.php?controller=fragmentos-codigo&action=listar&mensaje=error:Fragmento no encontrado");
            exit;
        }

        if ($_POST) {
            $data = [
                'titulo' => trim($_POST['titulo']),
                'codigo' => $_POST['codigo'],
                'lenguaje' => $_POST['lenguaje'],
                'categoria' => $_POST['categoria'],
                'descripcion' => trim($_POST['descripcion']),
                'tags' => trim($_POST['tags'])
            ];

            // Validaciones
            if (empty($data['titulo'])) {
                $mensaje = 'error:El título es obligatorio';
            } elseif (empty($data['codigo'])) {
                $mensaje = 'error:El código es obligatorio';
            } else {
                if ($this->fragmentoCodigoModel->actualizar($id, $data)) {
                    header("Location: index.php?controller=fragmentos-codigo&action=listar&mensaje=success:Fragmento actualizado correctamente");
                    exit;
                } else {
                    $mensaje = 'error:Error al actualizar el fragmento';
                }
            }
        }
        
        include 'views/fragmentos-codigo/editar.php';
    }

    public function eliminar() {
        $id = $_GET['id'] ?? 0;
        
        if ($this->fragmentoCodigoModel->eliminar($id)) {
            header("Location: index.php?controller=fragmentos-codigo&action=listar&mensaje=success:Fragmento eliminado correctamente");
        } else {
            header("Location: index.php?controller=fragmentos-codigo&action=listar&mensaje=error:Error al eliminar el fragmento");
        }
        exit;
    }

    public function ver() {
        $id = $_GET['id'] ?? 0;
        $fragmento = $this->fragmentoCodigoModel->obtenerPorId($id);

        if (!$fragmento) {
            header("Location: index.php?controller=fragmentos-codigo&action=listar&mensaje=error:Fragmento no encontrado");
            exit;
        }

        include 'views/fragmentos-codigo/ver.php';
    }

    public function buscar() {
        $termino = $_GET['q'] ?? '';
        $fragmentos = [];
        
        if (!empty($termino)) {
            $fragmentos = $this->fragmentoCodigoModel->buscar($termino);
        } else {
            // Si no hay término de búsqueda, mostrar todos los fragmentos
            $fragmentos = $this->fragmentoCodigoModel->listar();
        }
        
        include 'views/fragmentos-codigo/listar.php';
    }

    public function descargar() {
        $id = $_GET['id'] ?? 0;
        $fragmento = $this->fragmentoCodigoModel->obtenerPorId($id);

        if (!$fragmento) {
            header("Location: index.php?controller=fragmentos-codigo&action=listar&mensaje=error:Fragmento no encontrado");
            exit;
        }

        // Determinar la extensión del archivo según el lenguaje
        $extensiones = [
            'PHP' => 'php',
            'JavaScript' => 'js',
            'HTML' => 'html',
            'CSS' => 'css',
            'SQL' => 'sql',
            'Python' => 'py',
            'Java' => 'java'
        ];

        $extension = $extensiones[$fragmento['lenguaje']] ?? 'txt';
        $filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $fragmento['titulo']) . '.' . $extension;

        // Configurar headers para descarga
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . strlen($fragmento['codigo']));
        
        // Agregar información del fragmento como comentario
        $contenido = "/*\n";
        $contenido .= "Título: " . $fragmento['titulo'] . "\n";
        $contenido .= "Lenguaje: " . $fragmento['lenguaje'] . "\n";
        $contenido .= "Categoría: " . $fragmento['categoria'] . "\n";
        if (!empty($fragmento['tags'])) {
            $contenido .= "Tags: " . $fragmento['tags'] . "\n";
        }
        if (!empty($fragmento['descripcion'])) {
            $contenido .= "Descripción: " . $fragmento['descripcion'] . "\n";
        }
        $contenido .= "Creado: " . $fragmento['fecha_creacion'] . "\n";
        $contenido .= "Modificado: " . $fragmento['fecha_modificacion'] . "\n";
        $contenido .= "*/\n\n";
        $contenido .= $fragmento['codigo'];

        echo $contenido;
        exit;
    }

    public function copiar() {
        $id = $_GET['id'] ?? 0;
        $fragmento = $this->fragmentoCodigoModel->obtenerPorId($id);

        if (!$fragmento) {
            header("Location: index.php?controller=fragmentos-codigo&action=listar&mensaje=error:Fragmento no encontrado");
            exit;
        }

        // Esta función podría usarse para AJAX, pero actualmente la copia se maneja en el frontend
        // Podrías implementar aquí un contador de copias si lo deseas
        echo json_encode([
            'success' => true,
            'codigo' => $fragmento['codigo']
        ]);
        exit;
    }

    public function porLenguaje() {
        $lenguaje = $_GET['lenguaje'] ?? '';
        $fragmentos = [];
        
        if (!empty($lenguaje)) {
            // Buscar fragmentos por lenguaje
            $fragmentos = $this->fragmentoCodigoModel->buscar($lenguaje);
        } else {
            $fragmentos = $this->fragmentoCodigoModel->listar();
        }
        
        include 'views/fragmentos-codigo/listar.php';
    }

    public function porCategoria() {
        $categoria = $_GET['categoria'] ?? '';
        $fragmentos = [];
        
        if (!empty($categoria)) {
            // Buscar fragmentos por categoría
            $fragmentos = $this->fragmentoCodigoModel->buscar($categoria);
        } else {
            $fragmentos = $this->fragmentoCodigoModel->listar();
        }
        
        include 'views/fragmentos-codigo/listar.php';
    }
}
?>