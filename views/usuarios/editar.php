<?php
// views/usuarios/editar.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - Agencia Web</title>
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
        .user-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, #007bff, #6610f2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: bold;
            margin: 0 auto;
        }
        .password-note {
            font-size: 0.875rem;
            color: #6c757d;
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
                        <h1>Editar Usuario</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="index.php?controller=usuarios&action=listar">Usuarios Sistema</a></li>
                            <li class="breadcrumb-item active">Editar Usuario</li>
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
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-edit me-2"></i>
                                    Editando Usuario: <?php echo htmlspecialchars($usuario->nombre); ?>
                                </h3>
                            </div>
                            <!-- Form start -->
                            <form method="POST" id="formEditarUsuario">
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-12 text-center">
                                            <div class="user-avatar">
                                                <?php echo strtoupper(substr($usuario->nombre, 0, 1)); ?>
                                            </div>
                                            <h5 class="mt-2"><?php echo htmlspecialchars($usuario->nombre); ?></h5>
                                            <p class="text-muted">ID: #<?php echo $usuario->id; ?></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="username" class="form-label">Username *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-user"></i>
                                                    </span>
                                                    <input type="text" class="form-control" id="username" name="username" 
                                                           value="<?php echo htmlspecialchars($usuario->username); ?>" 
                                                           required>
                                                </div>
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
                                                           value="<?php echo htmlspecialchars($usuario->email); ?>" 
                                                           required>
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
                                                           value="<?php echo htmlspecialchars($usuario->nombre); ?>" 
                                                           required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="rol" class="form-label">Rol *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-user-tag"></i>
                                                    </span>
                                                    <select class="form-select" id="rol" name="rol" required>
                                                        <option value="viewer" <?php echo $usuario->rol == 'viewer' ? 'selected' : ''; ?>>Viewer (Solo lectura)</option>
                                                        <option value="editor" <?php echo $usuario->rol == 'editor' ? 'selected' : ''; ?>>Editor (Puede editar)</option>
                                                        <option value="admin" <?php echo $usuario->rol == 'admin' ? 'selected' : ''; ?>>Administrador (Acceso total)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="password" class="form-label">Nueva Contraseña</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-lock"></i>
                                                    </span>
                                                    <input type="password" class="form-control" id="password" name="password" 
                                                           minlength="6"
                                                           placeholder="Dejar en blanco para mantener la actual">
                                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                <small class="form-text text-muted password-note">
                                                    Si deseas cambiar la contraseña, ingresa una nueva (mínimo 6 caracteres). 
                                                    Deja este campo en blanco para mantener la contraseña actual.
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Estado del Usuario</label>
                                                <div class="input-group mt-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="activo" name="activo" 
                                                               <?php echo $usuario->activo ? 'checked' : ''; ?> 
                                                               value="1">
                                                        <label class="form-check-label" for="activo">
                                                            Usuario activo
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label">Fecha de Registro</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar"></i>
                                                    </span>
                                                    <input type="text" class="form-control" 
                                                           value="<?php echo date('d/m/Y H:i', strtotime($usuario->fecha_creacion)); ?>" 
                                                           readonly disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <div class="d-flex justify-content-between">
                                        <a href="index.php?controller=usuarios&action=listar" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left me-1"></i>Cancelar
                                        </a>
                                        <div>
                                            <a href="index.php?controller=usuarios&action=ver&id=<?php echo $usuario->id; ?>" 
                                               class="btn btn-info me-2">
                                                <i class="fas fa-eye me-1"></i>Ver Detalles
                                            </a>
                                            <button type="submit" class="btn btn-warning">
                                                <i class="fas fa-save me-1"></i>Actualizar Usuario
                                            </button>
                                        </div>
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
    $('#formEditarUsuario').on('submit', function(e) {
        const password = $('#password').val();
        if (password && password.length < 6) {
            e.preventDefault();
            alert('La contraseña debe tener al menos 6 caracteres si decides cambiarla.');
            $('#password').focus();
            return false;
        }
        
        if (!confirm('¿Estás seguro de que deseas actualizar la información de este usuario?')) {
            e.preventDefault();
            return false;
        }
        return true;
    });
});
</script>
</body>
</html>