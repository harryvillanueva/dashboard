<?php include 'templates/header.php'; ?>
<?php include 'templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $stats['total_paginas'] ?? 0 ?></h3>
                            <p>Páginas Web</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <a href="index.php?controller=paginas-web" class="small-box-footer">
                            Más info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $stats['total_clientes'] ?? 0 ?></h3>
                            <p>Clientes</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="index.php?controller=clientes" class="small-box-footer">
                            Más info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $stats['plugins_temas'] ?? 0 ?></h3>
                            <p>Plugins & Temas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-plug"></i>
                        </div>
                        <a href="index.php?controller=plugins" class="small-box-footer">
                            Más info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= $stats['vencimientos_proximos'] ?? 0 ?></h3>
                            <p>Hosting por Vencer</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                        <a href="index.php?controller=paginas-web&action=vencimientos" class="small-box-footer">
                            Más info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tabla de páginas web recientes -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Páginas Web Recientes</h3>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($paginas_recientes)): ?>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Título</th>
                                            <th>Cliente</th>
                                            <th>URL</th>
                                            <th>Fecha Creación</th>
                                            <th>Estado Hosting</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($paginas_recientes as $pagina): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($pagina['titulo']) ?></td>
                                                <td><?= htmlspecialchars($pagina['cliente_nombre']) ?></td>
                                                <td>
                                                    <a href="<?= $pagina['url'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-external-link-alt"></i> Visitar
                                                    </a>
                                                </td>
                                                <td><?= $pagina['fecha_creacion'] ?></td>
                                                <td>
                                                    <?php 
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
                                                    <span class="badge badge-<?= $clase ?>"><?= $texto ?></span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    No hay páginas web registradas. <a href="index.php?controller=paginas-web&action=crear">Crear la primera</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'templates/footer.php'; ?>