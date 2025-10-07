<?php
// views/usuarios/perfil.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Agencia Web</title>
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
        .user-avatar-large {
            width: 120px;
            height: 120px;
            background: linear-gradient(45deg, #007bff, #6610f2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            font-weight: bold;
            margin: 0 auto 20px;
        }
        .profile-stats {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0;
        }
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
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
                        <h1>Mi Perfil</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Mi Perfil</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Alert Messages -->
                <?php if (isset($_SESSION['mensaje'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?php echo htmlspecialchars($_SESSION['mensaje']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['mensaje']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <?php echo htmlspecialchars($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-4">
                        <!-- Información del Usuario -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-user me-2"></i>
                                    Información Personal
                                </h3>
                            </div>
                            <div class="card-body text-center">
                                <div class="user-avatar-large">
                                    <?php echo strtoupper(substr($usuario->nombre, 0, 1)); ?>
                                </div>
                                <h4><?php echo htmlspecialchars($usuario->nombre); ?></h4>
                                <p class="text-muted"><?php echo htmlspecialchars($usuario->email); ?></p>
                                
                                <div class="row mt-4">
                                    <div class="col-6">
                                        <div class="border rounded p-2">
                                            <div class="stat-number">#<?php echo $usuario->id; ?></div>
                                            <div class="stat-label">ID Usuario</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="border rounded p-2">
                                            <div class="stat-number">
                                                <span class="badge bg-<?php 
                                                    echo $usuario->rol == 'admin' ? 'danger' : 
                                                         ($usuario->rol == 'editor' ? 'warning' : 'secondary');
                                                ?>">
                                                    <?php echo ucfirst($usuario->rol); ?>
                                                </span>
                                            </div>
                                            <div class="stat-label">Rol</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Estadísticas Rápidas -->
                        <div class="card card-info mt-3">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-bar me-2"></i>
                                    Mi Actividad
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        Sesión activa
                                        <span class="badge bg-success">Activa</span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        Miembro desde
                                        <span class="text-muted"><?php echo date('d/m/Y', strtotime($usuario->fecha_creacion)); ?></span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        Estado de cuenta
                                        <span class="badge bg-<?php echo $usuario->activo ? 'success' : 'secondary'; ?>">
                                            <?php echo $usuario->activo ? 'Activa' : 'Inactiva'; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <!-- Editar Perfil -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-edit me-2"></i>
                                    Editar Información
                                </h3>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="index.php?controller=usuarios&action=actualizarPerfil">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="nombre" class="form-label">Nombre Completo *</label>
                                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                                       value="<?php echo htmlspecialchars($usuario->nombre); ?>" 
                                                       required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="email" class="form-label">Email *</label>
                                                <input type="email" class="form-control" id="email" name="email" 
                                                       value="<?php echo htmlspecialchars($usuario->email); ?>" 
                                                       required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="username" class="form-label">Usuario *</label>
                                                <input type="text" class="form-control" id="username" name="username" 
                                                       value="<?php echo htmlspecialchars($usuario->username); ?>" 
                                                       required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Fecha de Registro</label>
                                                <input type="text" class="form-control" 
                                                       value="<?php echo date('d/m/Y H:i', strtotime($usuario->fecha_creacion)); ?>" 
                                                       readonly disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-warning">
                                                <i class="fas fa-save me-1"></i>Actualizar Perfil
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Cambiar Contraseña -->
                        <div class="card card-danger mt-3">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-key me-2"></i>
                                    Cambiar Contraseña
                                </h3>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="index.php?controller=usuarios&action=cambiarPassword">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="password_actual" class="form-label">Contraseña Actual</label>
                                                <input type="password" class="form-control" id="password_actual" name="password_actual" 
                                                       required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="nueva_password" class="form-label">Nueva Contraseña</label>
                                                <input type="password" class="form-control" id="nueva_password" name="nueva_password" 
                                                       required minlength="6">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label for="confirmar_password" class="form-label">Confirmar Nueva Contraseña</label>
                                                <input type="password" class="form-control" id="confirmar_password" name="confirmar_password" 
                                                       required minlength="6">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-key me-1"></i>Cambiar Contraseña
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Información de Seguridad -->
                        <div class="card card-info mt-3">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-shield-alt me-2"></i>
                                    Seguridad
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Importante:</strong> Por seguridad, cambia tu contraseña regularmente y no la compartas con nadie.
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Última actividad:</h6>
                                        <p class="text-muted"><?php echo date('d/m/Y H:i:s'); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>IP de conexión:</h6>
                                        <p class="text-muted"><?php echo $_SERVER['REMOTE_ADDR']; ?></p>
                                    </div>
                                </div>
                            </div>
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
    
    // Validación de cambio de contraseña
    $('form[action*="cambiarPassword"]').on('submit', function(e) {
        const nuevaPassword = $('#nueva_password').val();
        const confirmarPassword = $('#confirmar_password').val();
        
        if (nuevaPassword !== confirmarPassword) {
            e.preventDefault();
            alert('Las contraseñas no coinciden. Por favor, verifica.');
            $('#confirmar_password').focus();
            return false;
        }
        
        if (nuevaPassword.length < 6) {
            e.preventDefault();
            alert('La contraseña debe tener al menos 6 caracteres.');
            $('#nueva_password').focus();
            return false;
        }
        
        return confirm('¿Estás seguro de que deseas cambiar tu contraseña?');
    });
    
    // Validación de actualización de perfil
    $('form[action*="actualizarPerfil"]').on('submit', function(e) {
        const email = $('#email').val();
        const username = $('#username').val();
        
        if (!email || !username) {
            e.preventDefault();
            alert('Por favor, completa todos los campos obligatorios.');
            return false;
        }
        
        return confirm('¿Estás seguro de que deseas actualizar tu perfil?');
    });
});
</script>
</body>
</html>