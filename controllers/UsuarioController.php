<?php
// controllers/UsuarioController.php
require_once __DIR__ . '/../models/UsuarioModel.php';

class UsuarioController {
    private $usuarioModel;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->usuarioModel = new UsuarioModel($db);
    }

    // LISTAR USUARIOS
    public function listar() {
        // Verificar permisos (solo admin puede ver todos los usuarios)
        if ($_SESSION['usuario_rol'] !== 'admin') {
            $_SESSION['error'] = "No tienes permisos para acceder a esta sección";
            header("Location: index.php?controller=dashboard");
            exit;
        }

        // Obtener usuarios
        $usuarios = $this->usuarioModel->listar();

        // Obtener estadísticas
        $estadisticas = $this->usuarioModel->obtenerEstadisticas();

        // Pasar datos a la vista
        $data = [
            'usuarios' => $usuarios,
            'totalUsuarios' => $estadisticas['total'] ?? 0,
            'usuariosActivos' => $estadisticas['activos'] ?? 0,
            'usuariosInactivos' => $estadisticas['inactivos'] ?? 0,
            'totalAdmins' => $estadisticas['admins'] ?? 0,
            'totalEditores' => $estadisticas['editores'] ?? 0,
            'totalViewers' => $estadisticas['viewers'] ?? 0
        ];

        extract($data);
        include(__DIR__ . '/../views/usuarios/listar.php');
    }


    public function cambiarPassword() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $password_actual = $_POST['password_actual'] ?? '';
        $nueva_password = $_POST['nueva_password'] ?? '';
        $confirmar_password = $_POST['confirmar_password'] ?? '';
        
        $this->usuarioModel->id = $_SESSION['usuario_id'];
        
        // Cargar datos actuales
        if ($this->usuarioModel->leerUno()) {
            // Verificar contraseña actual
            if ($password_actual === $this->usuarioModel->password) {
                // Verificar que las nuevas contraseñas coincidan
                if ($nueva_password === $confirmar_password) {
                    // Actualizar contraseña
                    $this->usuarioModel->password = $nueva_password;
                    
                    if ($this->usuarioModel->actualizarPassword()) {
                        $_SESSION['mensaje'] = "Contraseña cambiada correctamente";
                    } else {
                        $_SESSION['error'] = "Error al cambiar la contraseña";
                    }
                } else {
                    $_SESSION['error'] = "Las nuevas contraseñas no coinciden";
                }
            } else {
                $_SESSION['error'] = "La contraseña actual es incorrecta";
            }
        } else {
            $_SESSION['error'] = "Usuario no encontrado";
        }
    }
    
    header("Location: index.php?controller=usuarios&action=perfil");
    exit();
}

    // CREAR USUARIO
    public function crear() {
        // Verificar permisos (solo admin puede crear usuarios)
        if ($_SESSION['usuario_rol'] !== 'admin') {
            $_SESSION['error'] = "No tienes permisos para crear usuarios";
            header("Location: index.php?controller=usuarios&action=listar");
            exit;
        }

        $error = '';

        // Si se envió el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Asignar valores
            $this->usuarioModel->username = trim($_POST['username'] ?? '');
            $this->usuarioModel->email = trim($_POST['email'] ?? '');
            $this->usuarioModel->password = $_POST['password'] ?? '';
            $this->usuarioModel->nombre = trim($_POST['nombre'] ?? '');
            $this->usuarioModel->rol = $_POST['rol'] ?? 'viewer';
            $this->usuarioModel->activo = isset($_POST['activo']) ? 1 : 0;

            // Validaciones
            if (empty($this->usuarioModel->username)) {
                $error = "El nombre de usuario es requerido.";
            } elseif ($this->usuarioModel->usernameExiste()) {
                $error = "El nombre de usuario '{$this->usuarioModel->username}' ya está en uso.";
            } elseif (empty($this->usuarioModel->email)) {
                $error = "El email es requerido.";
            } elseif (!filter_var($this->usuarioModel->email, FILTER_VALIDATE_EMAIL)) {
                $error = "El formato del email no es válido.";
            } elseif ($this->usuarioModel->emailExiste()) {
                $error = "El email '{$this->usuarioModel->email}' ya está registrado.";
            } elseif (empty($this->usuarioModel->password) || strlen($this->usuarioModel->password) < 6) {
                $error = "La contraseña debe tener al menos 6 caracteres.";
            } else {
                // Crear usuario
                if ($this->usuarioModel->crear()) {
                    $_SESSION['mensaje'] = "Usuario creado exitosamente.";
                    header("Location: index.php?controller=usuarios&action=listar");
                    exit();
                } else {
                    $error = "Error al crear el usuario en la base de datos.";
                }
            }
        }

        // Mostrar formulario de creación
        include(__DIR__ . '/../views/usuarios/crear.php');
    }

    // EDITAR USUARIO
    public function editar() {
        // Verificar permisos (solo admin puede editar usuarios)
        if ($_SESSION['usuario_rol'] !== 'admin') {
            $_SESSION['error'] = "No tienes permisos para editar usuarios";
            header("Location: index.php?controller=usuarios&action=listar");
            exit;
        }

        $error = '';

        // Obtener ID del usuario
        $id = $_GET['id'] ?? 0;
        if (!$id) {
            $_SESSION['error'] = "ID de usuario no especificado";
            header("Location: index.php?controller=usuarios&action=listar");
            exit();
        }

        $this->usuarioModel->id = $id;

        // Obtener datos actuales
        if (!$this->usuarioModel->leerUno()) {
            $_SESSION['error'] = "Usuario no encontrado";
            header("Location: index.php?controller=usuarios&action=listar");
            exit();
        }

        // Si se envió el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Asignar valores
        $this->usuarioModel->username = trim($_POST['username'] ?? '');
        $this->usuarioModel->email = trim($_POST['email'] ?? '');
        $this->usuarioModel->nombre = trim($_POST['nombre'] ?? '');
        $this->usuarioModel->rol = $_POST['rol'] ?? 'viewer';
        $this->usuarioModel->activo = isset($_POST['activo']) ? 1 : 0;

        // Si se proporcionó una nueva contraseña, actualizarla
        if (!empty($_POST['password'])) {
            $this->usuarioModel->password = $_POST['password'];
        }

        // Actualizar usuario (con o sin contraseña)
        if ($this->usuarioModel->actualizar()) {
            $_SESSION['mensaje'] = "Usuario actualizado exitosamente.";
            header("Location: index.php?controller=usuarios&action=listar");
            exit();
        } else {
            $error = "Error al actualizar el usuario.";
        }
    }

        // Pasar el objeto usuario a la vista
        $usuario = $this->usuarioModel;
        include(__DIR__ . '/../views/usuarios/editar.php');
    }

    // ELIMINAR USUARIO
    public function eliminar() {
        // Verificar permisos (solo admin puede eliminar usuarios)
        if ($_SESSION['usuario_rol'] !== 'admin') {
            $_SESSION['error'] = "No tienes permisos para eliminar usuarios";
            header("Location: index.php?controller=usuarios&action=listar");
            exit;
        }

        $id = $_GET['id'] ?? 0;
        if (!$id) {
            $_SESSION['error'] = "ID de usuario no especificado";
            header("Location: index.php?controller=usuarios&action=listar");
            exit();
        }

        // No permitir eliminar el propio usuario
        if ($id == $_SESSION['usuario_id']) {
            $_SESSION['error'] = "No puedes eliminar tu propio usuario";
            header("Location: index.php?controller=usuarios&action=listar");
            exit();
        }

        $this->usuarioModel->id = $id;

        if ($this->usuarioModel->eliminar()) {
            $_SESSION['mensaje'] = "Usuario eliminado exitosamente.";
        } else {
            $_SESSION['error'] = "Error al eliminar el usuario.";
        }

        header("Location: index.php?controller=usuarios&action=listar");
        exit();
    }

    // PERFIL DE USUARIO
    public function perfil() {
    // Obtener datos del usuario logueado
    $this->usuarioModel->id = $_SESSION['usuario_id'];
    if (!$this->usuarioModel->leerUno()) {
        $_SESSION['error'] = "Usuario no encontrado";
        header("Location: index.php?controller=dashboard");
        exit();
    }

    $usuario = $this->usuarioModel;
    include(__DIR__ . '/../views/usuarios/perfil.php');
}

public function actualizarPerfil() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $this->usuarioModel->id = $_SESSION['usuario_id'];
        
        // Cargar datos actuales
        if ($this->usuarioModel->leerUno()) {
            // Actualizar datos
            $this->usuarioModel->nombre = trim($_POST['nombre'] ?? '');
            $this->usuarioModel->email = trim($_POST['email'] ?? '');
            $this->usuarioModel->username = trim($_POST['username'] ?? '');
            
            if ($this->usuarioModel->actualizar()) {
                // Actualizar datos en sesión
                $_SESSION['usuario_nombre'] = $this->usuarioModel->nombre;
                $_SESSION['usuario_email'] = $this->usuarioModel->email;
                $_SESSION['usuario_username'] = $this->usuarioModel->username;
                
                $_SESSION['mensaje'] = "Perfil actualizado correctamente";
            } else {
                $_SESSION['error'] = "Error al actualizar el perfil";
            }
        } else {
            $_SESSION['error'] = "Usuario no encontrado";
        }
    }
    
    header("Location: index.php?controller=usuarios&action=perfil");
    exit();
}

    public function ver() {
        // Verificar permisos (solo admin puede ver detalles de usuarios)
        if ($_SESSION['usuario_rol'] !== 'admin') {
            $_SESSION['error'] = "No tienes permisos para ver detalles de usuarios";
            header("Location: index.php?controller=usuarios&action=listar");
            exit;
        }

        // Obtener ID del usuario
        $id = $_GET['id'] ?? 0;
        if (!$id) {
            $_SESSION['error'] = "ID de usuario no especificado";
            header("Location: index.php?controller=usuarios&action=listar");
            exit();
        }

        $this->usuarioModel->id = $id;

        // Obtener datos del usuario
        if (!$this->usuarioModel->leerUno()) {
            $_SESSION['error'] = "Usuario no encontrado";
            header("Location: index.php?controller=usuarios&action=listar");
            exit();
        }

        // Pasar el objeto usuario a la vista
        $usuario = $this->usuarioModel;
        include(__DIR__ . '/../views/usuarios/ver.php');
    }
}
?>