<?php
// views/usuarios/ver.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Usuario - Agencia Web</title>
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
        .info-card {
            border-left: 4px solid #007bff;
            background-color: #f8f9fa;
        }
        .password-field {
            font-family: monospace;
            background-color: #f8f9fa;
            border: 1px dashed #dc3545;
            font-weight: bold;
        }
        .password-container {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
        }
        .security-warning {
            border-left: 4px solid #dc3545;
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
                        <h1>Detalles del Usuario</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="index.php?controller=usuarios&action=listar">Usuarios Sistema</a></li>
                            <li class="breadcrumb-item active">Ver Usuario</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10 mx-auto">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-user-circle me-2"></i>
                                    Información Detallada del Usuario
                                </h3>
                                <div class="card-tools">
                                    <a href="index.php?controller=usuarios&action=editar&id=<?php echo $usuario->id; ?>" 
                                       class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit me-1"></i> Editar
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Avatar y Información Básica -->
                                <div class="row mb-4">
                                    <div class="col-md-12 text-center">
                                        <div class="user-avatar-large">
                                            <?php echo strtoupper(substr($usuario->nombre, 0, 1)); ?>
                                        </div>
                                        <h3><?php echo htmlspecialchars($usuario->nombre); ?></h3>
                                        <p class="text-muted">ID: #<?php echo $usuario->id; ?></p>
                                        <span class="badge bg-<?php 
                                            echo $usuario->rol == 'admin' ? 'danger' : 
                                                 ($usuario->rol == 'editor' ? 'warning' : 'secondary');
                                        ?> me-2">
                                            <?php echo ucfirst($usuario->rol); ?>
                                        </span>
                                        <span class="badge bg-<?php echo $usuario->activo ? 'success' : 'secondary'; ?>">
                                            <?php echo $usuario->activo ? 'Activo' : 'Inactivo'; ?>
                                        </span>
                                    </div>
                                </div>

                                <!-- Alerta de Seguridad IMPORTANTE -->
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <div class="alert alert-danger security-warning">
                                            <h5><i class="fas fa-exclamation-triangle me-2"></i>ADVERTENCIA DE SEGURIDAD</h5>
                                            <p class="mb-1">
                                                <strong>Las contraseñas se están mostrando en texto plano.</strong> 
                                                Esta es una práctica de seguridad muy peligrosa. 
                                                En un entorno de producción, las contraseñas deben estar encriptadas y 
                                                <strong>nunca</strong> ser visibles para nadie, incluidos los administradores.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Información de Cuenta -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card info-card mb-3">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <i class="fas fa-user me-2"></i>Información de Cuenta
                                                </h5>
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td width="40%"><strong>Username:</strong></td>
                                                        <td><?php echo htmlspecialchars($usuario->username); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Email:</strong></td>
                                                        <td><?php echo htmlspecialchars($usuario->email); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Rol:</strong></td>
                                                        <td>
                                                            <span class="badge bg-<?php 
                                                                echo $usuario->rol == 'admin' ? 'danger' : 
                                                                     ($usuario->rol == 'editor' ? 'warning' : 'secondary');
                                                            ?>">
                                                                <?php echo ucfirst($usuario->rol); ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Estado:</strong></td>
                                                        <td>
                                                            <span class="badge bg-<?php echo $usuario->activo ? 'success' : 'secondary'; ?>">
                                                                <?php echo $usuario->activo ? 'Activo' : 'Inactivo'; ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card info-card mb-3">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <i class="fas fa-calendar me-2"></i>Información de Registro
                                                </h5>
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td width="40%"><strong>Fecha Creación:</strong></td>
                                                        <td><?php echo date('d/m/Y H:i:s', strtotime($usuario->fecha_creacion)); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>ID Usuario:</strong></td>
                                                        <td>#<?php echo $usuario->id; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Contraseña:</strong></td>
                                                        <td>
                                                            <div class="password-container">
                                                                <input type="password" class="form-control form-control-sm password-field" 
                                                                       id="passwordField" 
                                                                       value="<?php echo htmlspecialchars($usuario->password); ?>" 
                                                                       readonly>
                                                                <button type="button" class="password-toggle" id="togglePassword">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                            </div>
                                                            <small class="form-text text-danger">
                                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                                Contraseña visible - Riesgo de seguridad
                                                            </small>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Acciones Rápidas -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card info-card">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <i class="fas fa-key me-2"></i>Gestión de Contraseña
                                                </h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="d-grid gap-2">
                                                            <button type="button" class="btn btn-outline-primary" onclick="copyPassword()">
                                                                <i class="fas fa-copy me-2"></i>Copiar Contraseña
                                                            </button>
                                                            <button type="button" class="btn btn-outline-info" onclick="showPasswordInfo()">
                                                                <i class="fas fa-info-circle me-2"></i>Información de la Contraseña
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card bg-light">
                                                            <div class="card-body">
                                                                <h6 class="card-title">
                                                                    <i class="fas fa-shield-alt me-2"></i>Estadísticas de Contraseña
                                                                </h6>
                                                                <table class="table table-sm table-borderless">
                                                                    <tr>
                                                                        <td><strong>Longitud:</strong></td>
                                                                        <td><?php echo strlen($usuario->password); ?> caracteres</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Fortaleza:</strong></td>
                                                                        <td>
                                                                            <?php 
                                                                                $length = strlen($usuario->password);
                                                                                if ($length >= 12) echo '<span class="badge bg-success">Fuerte</span>';
                                                                                elseif ($length >= 8) echo '<span class="badge bg-warning">Media</span>';
                                                                                else echo '<span class="badge bg-danger">Débil</span>';
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Tipo:</strong></td>
                                                                        <td>Texto plano</td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Información Adicional -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="card info-card">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <i class="fas fa-info-circle me-2"></i>Información Adicional
                                                </h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Nombre Completo:</strong><br>
                                                        <?php echo htmlspecialchars($usuario->nombre); ?>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Email de Contacto:</strong><br>
                                                        <a href="mailto:<?php echo htmlspecialchars($usuario->email); ?>">
                                                            <?php echo htmlspecialchars($usuario->email); ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
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
                                    <div>
                                        <a href="index.php?controller=usuarios&action=editar&id=<?php echo $usuario->id; ?>" 
                                           class="btn btn-warning me-2">
                                            <i class="fas fa-edit me-1"></i>Editar Usuario
                                        </a>
                                        <a href="index.php?controller=usuarios&action=eliminar&id=<?php echo $usuario->id; ?>" 
                                           class="btn btn-danger"
                                           onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                            <i class="fas fa-trash me-1"></i>Eliminar
                                        </a>
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
    
    // Toggle para mostrar/ocultar contraseña
    $('#togglePassword').click(function() {
        const passwordField = $('#passwordField');
        const type = passwordField.attr('type');
        const icon = $(this).find('i');
        
        if (type === 'password') {
            passwordField.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
});

// Función para copiar la contraseña al portapapeles
function copyPassword() {
    const passwordField = document.getElementById('passwordField');
    passwordField.select();
    passwordField.setSelectionRange(0, 99999); // Para dispositivos móviles
    
    try {
        const successful = document.execCommand('copy');
        if (successful) {
            // Mostrar mensaje de éxito
            alert('✅ Contraseña copiada al portapapeles');
        }
    } catch (err) {
        console.error('Error al copiar: ', err);
        alert('Error al copiar la contraseña');
    }
}

// Función para mostrar información de la contraseña
function showPasswordInfo() {
    const password = '<?php echo htmlspecialchars($usuario->password); ?>';
    const passwordLength = password.length;
    
    let strength = '';
    if (passwordLength >= 12) strength = 'Fuerte';
    else if (passwordLength >= 8) strength = 'Media';
    else strength = 'Débil';
    
    alert(`Información de la Contraseña:\n\n` +
          `Contraseña: ${password}\n` +
          `Longitud: ${passwordLength} caracteres\n` +
          `Fortaleza: ${strength}\n\n` +
          `⚠️ ADVERTENCIA: Esta contraseña está en texto plano.\n` +
          `En un entorno seguro, debería estar encriptada.`);
}

// Seleccionar automáticamente la contraseña al hacer clic en el campo
$('#passwordField').click(function() {
    this.select();
});
</script>
</body>
</html>