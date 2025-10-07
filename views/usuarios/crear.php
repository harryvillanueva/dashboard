<?php
// views/usuarios/crear.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario - Agencia Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <style>
        .content-wrapper {
            background-color: #f4f6f9;
            min-height: 100vh;
        }
        .card {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0,0,0,.125);
        }
        .main-header {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }
        .input-group-text {
            background-color: #f8f9fa;
            border-color: #ced4da;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <?php include(__DIR__ . '/../templates/sidebar.php'); ?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Crear Nuevo Usuario</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="index.php?controller=usuarios&action=listar">Usuarios Sistema</a></li>
                            <li class="breadcrumb-item active">Crear Usuario</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <?php if (isset($error) && !empty($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-user-plus me-2"></i>
                                    Información del Nuevo Usuario
                                </h3>
                            </div>
                            <!-- Form start -->
                            <form method="POST" id="formCrearUsuario">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="username" class="form-label">Username *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-user"></i>
                                                    </span>
                                                    <input type="text" class="form-control" id="username" name="username" 
                                                           value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" 
                                                           required 
                                                           minlength="3"
                                                           maxlength="50"
                                                           placeholder="Ingrese el nombre de usuario">
                                                </div>
                                                <small class="form-text text-muted">Mínimo 3 caracteres, solo letras y números</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="email" class="form-label">Email *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-envelope"></i>
                                                    </span>
                                                    <input type="email" class="form-control" id="email" name="email" 
                                                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" 
                                                           required
                                                           placeholder="usuario@ejemplo.com">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="nombre" class="form-label">Nombre Completo *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-id-card"></i>
                                                    </span>
                                                    <input type="text" class="form-control" id="nombre" name="nombre" 
                                                           value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>" 
                                                           required
                                                           placeholder="Nombre y apellido completo">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="password" class="form-label">Contraseña *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-lock"></i>
                                                    </span>
                                                    <input type="password" class="form-control" id="password" name="password" 
                                                           required 
                                                           minlength="6"
                                                           placeholder="Mínimo 6 caracteres">
                                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                <small class="form-text text-muted">La contraseña se almacenará encriptada</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="rol" class="form-label">Rol *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-user-tag"></i>
                                                    </span>
                                                    <select class="form-select" id="rol" name="rol" required>
                                                        <option value="">Seleccionar rol...</option>
                                                        <option value="viewer" <?php echo ($_POST['rol'] ?? '') == 'viewer' ? 'selected' : ''; ?>>Viewer (Solo lectura)</option>
                                                        <option value="editor" <?php echo ($_POST['rol'] ?? '') == 'editor' ? 'selected' : ''; ?>>Editor (Puede editar)</option>
                                                        <option value="admin" <?php echo ($_POST['rol'] ?? '') == 'admin' ? 'selected' : ''; ?>>Administrador (Acceso total)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Estado del Usuario</label>
                                                <div class="input-group mt-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="activo" name="activo" 
                                                               <?php echo !isset($_POST['activo']) || $_POST['activo'] ? 'checked' : ''; ?> 
                                                               value="1">
                                                        <label class="form-check-label" for="activo">
                                                            Usuario activo
                                                        </label>
                                                    </div>
                                                </div>
                                                <small class="form-text text-muted">Los usuarios inactivos no pueden iniciar sesión</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <div class="d-flex justify-content-between">
                                        <a href="index.php?controller=usuarios&action=listar" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left me-1"></i>Volver a la lista
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i>Crear Usuario
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Main Footer -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Versión</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2024 Agencia Web.</strong> Todos los derechos reservados.
    </footer>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>

<script>
// Inicializar AdminLTE
$(document).ready(function() {
    $('[data-widget="pushmenu"]').PushMenu('toggle');
    
    // Mostrar/ocultar contraseña
    $('#togglePassword').click(function() {
        const passwordField = $('#password');
        const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
        passwordField.attr('type', type);
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });
    
    // Validación de formulario
    $('#formCrearUsuario').on('submit', function(e) {
        const password = $('#password').val();
        if (password.length < 6) {
            e.preventDefault();
            alert('La contraseña debe tener al menos 6 caracteres.');
            $('#password').focus();
            return false;
        }
        
        const username = $('#username').val();
        if (username.length < 3) {
            e.preventDefault();
            alert('El nombre de usuario debe tener al menos 3 caracteres.');
            $('#username').focus();
            return false;
        }
        
        return true;
    });
});
</script>
</body>
</html>