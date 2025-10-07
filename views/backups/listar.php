<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestión de Backups</h1>
                </div>
                <div class="col-sm-6">
                    <a href="index.php?controller=backups&action=crear" class="btn btn-success float-right">
                        <i class="fas fa-plus"></i> Nuevo Backup
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
                            <h3><?= $estadisticas['total_backups'] ?? 0 ?></h3>
                            <p>Total Backups</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-database"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $estadisticas['sitios_con_backup'] ?? 0 ?></h3>
                            <p>Sitios con Backup</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-globe"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $estadisticas['backups_wordpress'] ?? 0 ?></h3>
                            <p>Backups WordPress</p>
                        </div>
                        <div class="icon">
                            <i class="fab fa-wordpress"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= $estadisticas['backups_database'] ?? 0 ?></h3>
                            <p>Backups Base de Datos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-server"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros rápidos -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Filtros Rápidos</h5>
                        </div>
                        <div class="card-body">
                            <div class="btn-group">
                                <a href="index.php?controller=backups&action=listar" class="btn btn-outline-secondary">Todos</a>
                                <a href="index.php?controller=backups&action=porTipo&tipo=wordpress" class="btn btn-outline-primary">WordPress</a>
                                <a href="index.php?controller=backups&action=porTipo&tipo=database" class="btn btn-outline-success">Base de Datos</a>
                                <a href="index.php?controller=backups&action=porTipo&tipo=zip" class="btn btn-outline-info">Archivos ZIP</a>
                            </div>
                            <div class="btn-group ml-2">
                                <a href="index.php?controller=backups&action=porCategoria&categoria=Completo" class="btn btn-outline-warning">Completos</a>
                                <a href="index.php?controller=backups&action=porCategoria&categoria=Base de datos" class="btn btn-outline-danger">Solo BD</a>
                                <a href="index.php?controller=backups&action=porCategoria&categoria=Archivos" class="btn btn-outline-dark">Solo Archivos</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de backups -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Lista de Backups</h3>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($backups)): ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nombre Archivo</th>
                                                <th>Tipo</th>
                                                <th>Categoría</th>
                                                <th>Sitio Web</th>
                                                <th>Tamaño</th>
                                                <th>Fecha Backup</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($backups as $backup): ?>
                                            <tr>
                                                <td>
                                                    <strong><?= htmlspecialchars($backup['nombre_archivo']) ?></strong>
                                                    <?php if (!empty($backup['descripcion'])): ?>
                                                        <br><small class="text-muted"><?= htmlspecialchars(substr($backup['descripcion'], 0, 50)) ?>...</small>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge badge-<?= 
                                                        $backup['tipo'] == 'wordpress' ? 'primary' : 
                                                        ($backup['tipo'] == 'database' ? 'success' : 'info')
                                                    ?>">
                                                        <i class="fas fa-<?= 
                                                            $backup['tipo'] == 'wordpress' ? 'wordpress' : 
                                                            ($backup['tipo'] == 'database' ? 'database' : 'file-archive')
                                                        ?>"></i>
                                                        <?= ucfirst($backup['tipo']) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-secondary">
                                                        <?= htmlspecialchars($backup['categoria'] ?? 'General') ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?= htmlspecialchars($backup['pagina_web_titulo'] ?? 'No asignado') ?>
                                                    <?php if (!empty($backup['pagina_web_url'])): ?>
                                                        <br>
                                                        <a href="<?= $backup['pagina_web_url'] ?>" target="_blank" class="btn btn-xs btn-outline-primary btn-sm">
                                                            <i class="fas fa-external-link-alt"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge badge-light">
                                                        <?= htmlspecialchars($backup['tamaño'] ?? 'N/A') ?>
                                                    </span>
                                                </td>
                                                <td><?= date('d/m/Y H:i', strtotime($backup['fecha_backup'])) ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <?php if (file_exists($backup['ruta_archivo'])): ?>
                                                            <a href="index.php?controller=backups&action=descargar&id=<?= $backup['id'] ?>" 
                                                               class="btn btn-sm btn-success" title="Descargar backup">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                        <?php else: ?>
                                                            <button class="btn btn-sm btn-secondary" disabled title="Archivo no disponible">
                                                                <i class="fas fa-exclamation-triangle"></i>
                                                            </button>
                                                        <?php endif; ?>
                                                        <a href="index.php?controller=backups&action=ver&id=<?= $backup['id'] ?>" 
                                                           class="btn btn-sm btn-info" title="Ver información">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="index.php?controller=backups&action=editar&id=<?= $backup['id'] ?>" 
                                                           class="btn btn-sm btn-warning" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="index.php?controller=backups&action=eliminar&id=<?= $backup['id'] ?>" 
                                                           class="btn btn-sm btn-danger" 
                                                           onclick="return confirm('¿Estás seguro de eliminar este backup? Esta acción no se puede deshacer.')"
                                                           title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info text-center">
                                    <h4><i class="icon fas fa-info"></i> No hay backups registrados</h4>
                                    <p>Comienza agregando tu primer backup.</p>
                                    <a href="index.php?controller=backups&action=crear" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Agregar Primer Backup
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