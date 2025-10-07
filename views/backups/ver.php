<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Información del Backup</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="index.php?controller=backups&action=listar">Backups</a></li>
                        <li class="breadcrumb-item active">Ver Backup</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Backup: <?= htmlspecialchars($backup['nombre_archivo']) ?></h3>
                            <div class="card-tools">
                                <?php if (file_exists($backup['ruta_archivo'])): ?>
                                    <a href="index.php?controller=backups&action=descargar&id=<?= $backup['id'] ?>" 
                                       class="btn btn-success btn-sm">
                                        <i class="fas fa-download"></i> Descargar
                                    </a>
                                <?php endif; ?>
                                <a href="index.php?controller=backups&action=editar&id=<?= $backup['id'] ?>" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="40%">Nombre del Archivo:</th>
                                            <td><?= htmlspecialchars($backup['nombre_archivo']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tipo:</th>
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
                                        </tr>
                                        <tr>
                                            <th>Categoría:</th>
                                            <td>
                                                <span class="badge badge-secondary">
                                                    <?= htmlspecialchars($backup['categoria'] ?? 'General') ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tamaño:</th>
                                            <td><?= htmlspecialchars($backup['tamaño'] ?? 'N/A') ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="40%">Sitio Web:</th>
                                            <td><?= htmlspecialchars($backup['pagina_web_titulo'] ?? 'No asignado') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Enlace al Sitio:</th>
                                            <td>
                                                <?php if (!empty($backup['pagina_web_url'])): ?>
                                                    <a href="<?= $backup['pagina_web_url'] ?>" target="_blank" 
                                                       class="btn btn-sm btn-primary">
                                                        <i class="fas fa-external-link-alt"></i> Visitar Sitio
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">No disponible</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Fecha Backup:</th>
                                            <td><?= date('d/m/Y H:i', strtotime($backup['fecha_backup'])) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Estado del Archivo:</th>
                                            <td>
                                                <?php if (file_exists($backup['ruta_archivo'])): ?>
                                                    <span class="badge badge-success">
                                                        <i class="fas fa-check"></i> Disponible
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-danger">
                                                        <i class="fas fa-exclamation-triangle"></i> No encontrado
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <?php if (!empty($backup['descripcion'])): ?>
                                <div class="mt-3">
                                    <h5>Descripción:</h5>
                                    <div class="callout callout-info">
                                        <p><?= nl2br(htmlspecialchars($backup['descripcion'])) ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Información del archivo -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-file"></i> Información del Archivo
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Ruta en servidor:</strong><br>
                                                    <code class="text-sm"><?= htmlspecialchars($backup['ruta_archivo']) ?></code>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Última modificación:</strong><br>
                                                    <?php if (file_exists($backup['ruta_archivo'])): ?>
                                                        <?= date('d/m/Y H:i', filemtime($backup['ruta_archivo'])) ?>
                                                    <?php else: ?>
                                                        <span class="text-muted">No disponible</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Acciones rápidas -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-bolt"></i> Acciones Rápidas
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="btn-group">
                                                <?php if (file_exists($backup['ruta_archivo'])): ?>
                                                    <a href="index.php?controller=backups&action=descargar&id=<?= $backup['id'] ?>" 
                                                       class="btn btn-outline-success">
                                                        <i class="fas fa-download"></i> Descargar Backup
                                                    </a>
                                                <?php endif; ?>
                                                <a href="index.php?controller=backups&action=editar&id=<?= $backup['id'] ?>" 
                                                   class="btn btn-outline-warning">
                                                    <i class="fas fa-edit"></i> Editar Información
                                                </a>
                                                <?php if (!empty($backup['pagina_web_url'])): ?>
                                                    <a href="<?= $backup['pagina_web_url'] ?>" target="_blank" 
                                                       class="btn btn-outline-primary">
                                                        <i class="fas fa-external-link-alt"></i> Ir al Sitio Web
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="index.php?controller=backups&action=listar" class="btn btn-default">
                                <i class="fas fa-arrow-left"></i> Volver a la lista
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'views/templates/footer.php'; ?>