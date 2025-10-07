<?php
// views/usuarios/listar.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Sistema - Agencia Web</title>
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
            margin-bottom: 1rem;
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0,0,0,.125);
        }
        .main-header {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
        }
        .badge {
            font-size: 0.75em;
        }
        .table th {
            border-top: none;
        }
        .user-avatar {
            width: 35px;
            height: 35px;
            background: linear-gradient(45deg, #007bff, #6610f2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 10px;
        }
        .btn-group .btn {
            margin: 0 2px;
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
                        <h1>Usuarios del Sistema</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Usuarios Sistema</li>
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

                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?php echo $totalUsuarios; ?></h3>
                                <p>Total Usuarios</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?php echo $usuariosActivos; ?></h3>
                                <p>Usuarios Activos</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-check"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><?php echo $usuariosInactivos; ?></h3>
                                <p>Usuarios Inactivos</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-clock"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?php echo $totalAdmins; ?></h3>
                                <p>Administradores</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-shield"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3><?php echo $totalEditores; ?></h3>
                                <p>Editores</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-edit"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3><?php echo $totalViewers; ?></h3>
                                <p>Viewers</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-users-cog me-2"></i>
                            Lista de Usuarios del Sistema
                        </h3>
                        <div class="card-tools">
                            <a href="index.php?controller=usuarios&action=crear" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i> Nuevo Usuario
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Usuario</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Estado</th>
                                        <th>Fecha Registro</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($usuarios) && is_array($usuarios)): ?>
                                        <?php foreach ($usuarios as $usuario): ?>
                                        <tr>
                                            <td>#<?php echo $usuario['id']; ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="user-avatar">
                                                        <?php echo strtoupper(substr($usuario['nombre'], 0, 1)); ?>
                                                    </div>
                                                    <strong><?php echo htmlspecialchars($usuario['username']); ?></strong>
                                                </div>
                                            </td>
                                            <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                            <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                                            <td>
                                                <span class="badge bg-<?php 
                                                    echo $usuario['rol'] == 'admin' ? 'danger' : 
                                                         ($usuario['rol'] == 'editor' ? 'warning' : 'secondary');
                                                ?>">
                                                    <?php echo ucfirst($usuario['rol']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php echo $usuario['activo'] ? 'success' : 'secondary'; ?>">
                                                    <?php echo $usuario['activo'] ? 'Activo' : 'Inactivo'; ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($usuario['fecha_creacion'])); ?></td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="index.php?controller=usuarios&action=ver&id=<?php echo $usuario['id']; ?>" 
                                                       class="btn btn-info" title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="index.php?controller=usuarios&action=editar&id=<?php echo $usuario['id']; ?>" 
                                                       class="btn btn-warning" title="Editar usuario">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="index.php?controller=usuarios&action=eliminar&id=<?php echo $usuario['id']; ?>" 
                                                       class="btn btn-danger" title="Eliminar usuario"
                                                       onclick="return confirm('¿Estás seguro de eliminar al usuario <?php echo htmlspecialchars($usuario['nombre']); ?>?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No hay usuarios registrados</h5>
                                                <p class="text-muted">Comienza agregando el primer usuario al sistema.</p>
                                                <a href="index.php?controller=usuarios&action=crear" class="btn btn-primary">
                                                    <i class="fas fa-plus me-1"></i>Agregar Primer Usuario
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
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
// Auto-ocultar alerts después de 5 segundos
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(alert => {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);

// Inicializar AdminLTE
$(document).ready(function() {
    $('[data-widget="pushmenu"]').PushMenu('toggle');
});
</script>
</body>
</html>