<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestión de Páginas Web</h1>
                </div>
                <div class="col-sm-6">
                    <a href="index.php?controller=paginas-web&action=crear" class="btn btn-success float-right">
                        <i class="fas fa-plus"></i> Nueva Página Web
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

            <!-- Tabla de páginas web -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Lista de Páginas Web</h3>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($paginas)): ?>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Imagen</th>
                                            <th>Título</th>
                                            <th>URL</th>
                                            <th>Cliente</th>
                                            <th>Rubro</th>
                                            <th>Fecha Vencimiento</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($paginas as $pagina): ?>
                                        <tr>
                                            <td><?= $pagina['id'] ?></td>
                                            <td>
                                                <?php if ($pagina['imagen_path']): ?>
                                                    <img src="<?= $pagina['imagen_path'] ?>" width="50" height="50" class="img-thumbnail">
                                                <?php else: ?>
                                                    <div class="bg-secondary text-center" style="width:50px;height:50px;line-height:50px;">
                                                        <i class="fas fa-image text-white"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= htmlspecialchars($pagina['titulo']) ?></td>
                                            <td>
                                                <?php if (!empty($pagina['url'])): ?>
                                                    <a href="<?= $pagina['url'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-external-link-alt"></i> Visitar
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">No disponible</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= htmlspecialchars($pagina['cliente_nombre'] ?? 'Sin cliente') ?></td>
                                            <td><?= htmlspecialchars($pagina['rubro'] ?? 'No especificado') ?></td>
                                            <td>
                                                <?php 
                                                    if (!empty($pagina['fecha_vencimiento_hosting'])) {
                                                        $fecha_venc = new DateTime($pagina['fecha_vencimiento_hosting']);
                                                        $hoy = new DateTime();
                                                        $dias_restantes = $hoy->diff($fecha_venc)->days;
                                                        
                                                        if ($fecha_venc < $hoy) {
                                                            $clase = 'danger';
                                                            $texto = 'Vencido';
                                                        } elseif ($dias_restantes <= 30) {
                                                            $clase = 'warning';
                                                            $texto = 'Próximo a vencer';
                                                        } else {
                                                            $clase = 'success';
                                                            $texto = 'Activo';
                                                        }
                                                ?>
                                                    <span class="badge badge-<?= $clase ?>">
                                                        <?= $pagina['fecha_vencimiento_hosting'] ?>
                                                    </span>
                                                <?php } else { ?>
                                                    <span class="badge badge-secondary">No especificada</span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <a href="index.php?controller=paginas-web&action=ver&id=<?= $pagina['id'] ?>" 
                                                   class="btn btn-sm btn-info" title="Ver detalle">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="index.php?controller=paginas-web&action=editar&id=<?= $pagina['id'] ?>" 
                                                   class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="index.php?controller=paginas-web&action=eliminar&id=<?= $pagina['id'] ?>" 
                                                   class="btn btn-sm btn-danger" 
                                                   onclick="return confirm('¿Estás seguro de eliminar esta página web?')"
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
                                    <h4><i class="icon fas fa-info"></i> No hay páginas web registradas</h4>
                                    <p>Comienza agregando tu primera página web.</p>
                                    <a href="index.php?controller=paginas-web&action=crear" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Agregar Primera Página Web
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