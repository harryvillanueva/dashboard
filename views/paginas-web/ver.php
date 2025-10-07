<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detalle de Página Web</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="index.php?controller=paginas-web&action=listar">Páginas Web</a></li>
                        <li class="breadcrumb-item active">Detalle</li>
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
                            <h3 class="card-title"><?= htmlspecialchars($pagina['titulo']) ?></h3>
                            <div class="card-tools">
                                <a href="index.php?controller=paginas-web&action=editar&id=<?= $pagina['id'] ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <?php if ($pagina['imagen_path']): ?>
                                        <img src="<?= $pagina['imagen_path'] ?>" class="img-fluid img-thumbnail" alt="<?= htmlspecialchars($pagina['titulo']) ?>">
                                    <?php else: ?>
                                        <div class="bg-secondary text-center py-5">
                                            <i class="fas fa-image fa-3x text-white"></i>
                                            <p class="text-white mt-2">Sin imagen</p>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($pagina['url'])): ?>
                                        <a href="<?= $pagina['url'] ?>" target="_blank" class="btn btn-primary btn-block mt-3">
                                            <i class="fas fa-external-link-alt"></i> Visitar Sitio Web
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-8">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="30%">Título:</th>
                                            <td><?= htmlspecialchars($pagina['titulo']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Cliente:</th>
                                            <td><?= htmlspecialchars($pagina['cliente_nombre'] ?? 'No asignado') ?></td>
                                        </tr>
                                        <tr>
                                            <th>URL:</th>
                                            <td>
                                                <?php if (!empty($pagina['url'])): ?>
                                                    <a href="<?= $pagina['url'] ?>" target="_blank"><?= $pagina['url'] ?></a>
                                                <?php else: ?>
                                                    <span class="text-muted">No especificada</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Rubro:</th>
                                            <td><?= htmlspecialchars($pagina['rubro'] ?? 'No especificado') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Fecha Creación:</th>
                                            <td><?= $pagina['fecha_creacion'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Fecha Vencimiento Hosting:</th>
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
                                                        <?= $pagina['fecha_vencimiento_hosting'] ?> (<?= $texto ?>)
                                                    </span>
                                                <?php } else { ?>
                                                    <span class="badge badge-secondary">No especificada</span>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    </table>

                                    <?php if (!empty($pagina['descripcion'])): ?>
                                        <div class="mt-3">
                                            <h5>Descripción:</h5>
                                            <p class="text-justify"><?= nl2br(htmlspecialchars($pagina['descripcion'])) ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="index.php?controller=paginas-web&action=listar" class="btn btn-default">
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