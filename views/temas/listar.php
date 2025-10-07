<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestión de Temas</h1>
                </div>
                <div class="col-sm-6">
                    <a href="index.php?controller=temas&action=crear" class="btn btn-success float-right">
                        <i class="fas fa-plus"></i> Nuevo Tema
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

            <!-- Tabla de temas -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Lista de Temas</h3>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($temas)): ?>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Versión</th>
                                            <th>Categoría</th>
                                            <th>Archivo</th>
                                            <th>Fecha Subida</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($temas as $tema): ?>
                                        <tr>
                                            <td><?= $tema['id'] ?></td>
                                            <td><?= htmlspecialchars($tema['nombre']) ?></td>
                                            <td><?= htmlspecialchars($tema['version'] ?? '1.0') ?></td>
                                            <td><?= htmlspecialchars($tema['categoria'] ?? 'General') ?></td>
                                            <td>
                                                <?php if ($tema['archivo_path']): ?>
                                                    <span class="badge badge-success">
                                                        <i class="fas fa-file-archive"></i> Disponible
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-warning">Sin archivo</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= date('d/m/Y', strtotime($tema['fecha_subida'])) ?></td>
                                            <td>
                                                <?php if ($tema['archivo_path']): ?>
                                                    <a href="index.php?controller=temas&action=descargar&id=<?= $tema['id'] ?>" 
                                                       class="btn btn-sm btn-success" title="Descargar">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <a href="index.php?controller=temas&action=editar&id=<?= $tema['id'] ?>" 
                                                   class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="index.php?controller=temas&action=eliminar&id=<?= $tema['id'] ?>" 
                                                   class="btn btn-sm btn-danger" 
                                                   onclick="return confirm('¿Estás seguro de eliminar este tema?')"
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
                                    <h4><i class="icon fas fa-info"></i> No hay temas registrados</h4>
                                    <p>Comienza agregando tu primer tema.</p>
                                    <a href="index.php?controller=temas&action=crear" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Agregar Primer Tema
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