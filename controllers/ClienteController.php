<?php
class ClienteController {
    private $clienteModel;

    public function __construct($db) {
        $this->clienteModel = new ClienteModel($db);
    }

    // Listar todos los clientes
    public function listar() {
        $clientes = $this->clienteModel->listar();
        $estadisticas = $this->clienteModel->obtenerEstadisticas();
        
        include 'views/clientes/listar.php';
    }

    // Mostrar formulario de creación
    public function crear() {
        $mensaje = '';
        
        if ($_POST) {
            $data = [
                'nombre' => trim($_POST['nombre']),
                'email' => trim($_POST['email']),
                'telefono' => trim($_POST['telefono']),
                'empresa' => trim($_POST['empresa']),
                'direccion' => trim($_POST['direccion'])
            ];

            // Validaciones
            if (empty($data['nombre'])) {
                $mensaje = 'error:El nombre es obligatorio';
            } elseif ($this->clienteModel->emailExiste($data['email'])) {
                $mensaje = 'error:El email ya está registrado';
            } else {
                if ($this->clienteModel->crear($data)) {
                    header("Location: index.php?controller=clientes&action=listar&mensaje=success:Cliente creado correctamente");
                    exit;
                } else {
                    $mensaje = 'error:Error al crear el cliente';
                }
            }
        }
        
        include 'views/clientes/crear.php';
    }

    // Mostrar formulario de edición
    public function editar() {
        $id = $_GET['id'] ?? 0;
        $cliente = $this->clienteModel->obtenerPorId($id);
        $mensaje = '';

        if (!$cliente) {
            header("Location: index.php?controller=clientes&action=listar&mensaje=error:Cliente no encontrado");
            exit;
        }

        if ($_POST) {
            $data = [
                'nombre' => trim($_POST['nombre']),
                'email' => trim($_POST['email']),
                'telefono' => trim($_POST['telefono']),
                'empresa' => trim($_POST['empresa']),
                'direccion' => trim($_POST['direccion'])
            ];

            // Validaciones
            if (empty($data['nombre'])) {
                $mensaje = 'error:El nombre es obligatorio';
            } elseif ($this->clienteModel->emailExiste($data['email'], $id)) {
                $mensaje = 'error:El email ya está registrado en otro cliente';
            } else {
                if ($this->clienteModel->actualizar($id, $data)) {
                    header("Location: index.php?controller=clientes&action=listar&mensaje=success:Cliente actualizado correctamente");
                    exit;
                } else {
                    $mensaje = 'error:Error al actualizar el cliente';
                }
            }
        }
        
        include 'views/clientes/editar.php';
    }

    // Eliminar cliente
    public function eliminar() {
        $id = $_GET['id'] ?? 0;
        
        if ($this->clienteModel->eliminar($id)) {
            header("Location: index.php?controller=clientes&action=listar&mensaje=success:Cliente eliminado correctamente");
        } else {
            header("Location: index.php?controller=clientes&action=listar&mensaje=error:Error al eliminar el cliente");
        }
        exit;
    }

    // Buscar clientes
   public function buscar() {
    $termino = $_GET['q'] ?? '';
    $clientes = [];
    
    if (!empty($termino)) {
        $clientes = $this->clienteModel->buscar($termino);
    }
    
    include 'views/clientes/buscar.php';
}

    // Ver detalle del cliente
    public function ver() {
        $id = $_GET['id'] ?? 0;
        $cliente = $this->clienteModel->obtenerPorId($id);

        if (!$cliente) {
            header("Location: index.php?controller=clientes&action=listar&mensaje=error:Cliente no encontrado");
            exit;
        }

        include 'views/clientes/ver.php';
    }
}
?>