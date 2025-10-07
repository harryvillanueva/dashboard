<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestión de Clientes</h1>
                </div>
                <div class="col-sm-6">
                    <a href="index.php?controller=clientes&action=crear" class="btn btn-success float-right">
                        <i class="fas fa-plus"></i> Nuevo Cliente
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- Mostrar mensajes -->
            <?php if (isset($_GET['mensaje'])): 
                $mensaje = explode(':', $_GET['mensaje']);
                $tipo = $mensaje[0];
                $texto = $mensaje[1];
            ?>
                <div class="alert alert-<?= $tipo == 'success' ? 'success' : 'danger' ?> alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?= htmlspecialchars($texto) ?>
                </div>
            <?php endif; ?>

            <!-- Estadísticas -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $estadisticas['total_clientes'] ?? 0 ?></h3>
                            <p>Total Clientes</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $estadisticas['total_empresas'] ?? 0 ?></h3>
                            <p>Empresas Diferentes</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-building"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Barra de búsqueda -->
            <div class="row mb-3">
                <div class="col-12">
                    <form action="index.php?controller=clientes&action=buscar" method="GET" class="form-inline">
                        <input type="hidden" name="controller" value="clientes">
                        <input type="hidden" name="action" value="buscar">
                        <div class="input-group" style="width: 100%;">
                            <input type="text" name="q" class="form-control" placeholder="Buscar clientes por nombre, email o empresa..." value="<?= $_GET['q'] ?? '' ?>">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de clientes -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Lista de Clientes</h3>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($clientes)): ?>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Teléfono</th>
                                            <th>Empresa</th>
                                            <th>Fecha Registro</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($clientes as $cliente): ?>
                                        <tr>
                                            <td><?= $cliente['id'] ?></td>
                                            <td><?= htmlspecialchars($cliente['nombre']) ?></td>
                                            <td>
                                                <?php if (!empty($cliente['email'])): ?>
                                                    <a href="mailto:<?= $cliente['email'] ?>">
                                                        <?= htmlspecialchars($cliente['email']) ?>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">No especificado</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($cliente['telefono'])): ?>
                                                    <a href="tel:<?= $cliente['telefono'] ?>">
                                                        <?= htmlspecialchars($cliente['telefono']) ?>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">No especificado</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?= !empty($cliente['empresa']) ? htmlspecialchars($cliente['empresa']) : '<span class="text-muted">No especificada</span>' ?>
                                            </td>
                                            <td><?= date('d/m/Y', strtotime($cliente['fecha_registro'])) ?></td>
                                            <td>
                                                <a href="index.php?controller=clientes&action=ver&id=<?= $cliente['id'] ?>" 
                                                   class="btn btn-sm btn-info" title="Ver detalle">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="index.php?controller=clientes&action=editar&id=<?= $cliente['id'] ?>" 
                                                   class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="index.php?controller=clientes&action=eliminar&id=<?= $cliente['id'] ?>" 
                                                   class="btn btn-sm btn-danger" 
                                                   onclick="return confirm('¿Estás seguro de eliminar este cliente?')"
                                                   title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div class="alert alert-info text-center">
                                    <h4><i class="icon fas fa-info"></i> No hay clientes registrados</h4>
                                    <p>Comienza agregando tu primer cliente.</p>
                                    <a href="index.php?controller=clientes&action=crear" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Agregar Primer Cliente
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'views/templates/footer.php'; ?>