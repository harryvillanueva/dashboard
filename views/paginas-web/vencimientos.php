<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Hosting por Vencer</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="index.php?controller=paginas-web">Páginas Web</a></li>
                        <li class="breadcrumb-item active">Vencimientos</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- Estadísticas de vencimientos -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3 id="contador-vencidos">0</h3>
                            <p>Hosting Vencidos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 id="contador-proximos">0</h3>
                            <p>Próximos a Vencer (30 días)</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 id="contador-activos">0</h3>
                            <p>Hosting Activos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3 id="contador-sin-fecha">0</h3>
                            <p>Sin Fecha Especificada</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de vencimientos -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Control de Vencimientos de Hosting</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 200px;">
                                    <input type="text" id="buscar-vencimientos" class="form-control float-right" placeholder="Buscar...">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($paginas)): ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="tabla-vencimientos">
                                        <thead>
                                            <tr>
                                                <th>Título</th>
                                                <th>Cliente</th>
                                                <th>URL</th>
                                                <th>Fecha Vencimiento</th>
                                                <th>Días Restantes</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $vencidos = 0;
                                            $proximos = 0;
                                            $activos = 0;
                                            $sin_fecha = 0;
                                            
                                            foreach ($paginas as $pagina): 
                                                if (empty($pagina['fecha_vencimiento_hosting'])) {
                                                    $estado = 'sin-fecha';
                                                    $texto_estado = 'Sin fecha';
                                                    $clase_badge = 'secondary';
                                                    $sin_fecha++;
                                                } else {
                                                    $fecha_venc = new DateTime($pagina['fecha_vencimiento_hosting']);
                                                    $hoy = new DateTime();
                                                    $dias_restantes = $hoy->diff($fecha_venc)->days;
                                                    
                                                    if ($fecha_venc < $hoy) {
                                                        $estado = 'vencido';
                                                        $texto_estado = 'Vencido';
                                                        $clase_badge = 'danger';
                                                        $vencidos++;
                                                    } elseif ($dias_restantes <= 30) {
                                                        $estado = 'proximo';
                                                        $texto_estado = 'Próximo a vencer';
                                                        $clase_badge = 'warning';
                                                        $proximos++;
                                                    } else {
                                                        $estado = 'activo';
                                                        $texto_estado = 'Activo';
                                                        $clase_badge = 'success';
                                                        $activos++;
                                                    }
                                                }
                                            ?>
                                            <tr class="fila-vencimiento" data-estado="<?= $estado ?>">
                                                <td><?= htmlspecialchars($pagina['titulo']) ?></td>
                                                <td><?= htmlspecialchars($pagina['cliente_nombre'] ?? 'Sin cliente') ?></td>
                                                <td>
                                                    <?php if (!empty($pagina['url'])): ?>
                                                        <a href="<?= $pagina['url'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-external-link-alt"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">No disponible</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($pagina['fecha_vencimiento_hosting'])): ?>
                                                        <?= $pagina['fecha_vencimiento_hosting'] ?>
                                                    <?php else: ?>
                                                        <span class="text-muted">No especificada</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($pagina['fecha_vencimiento_hosting'])): ?>
                                                        <?php if ($fecha_venc < $hoy): ?>
                                                            <span class="text-danger">-<?= $dias_restantes ?> días</span>
                                                        <?php else: ?>
                                                            <span class="text-success"><?= $dias_restantes ?> días</span>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge badge-<?= $clase_badge ?>">
                                                        <?= $texto_estado ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="index.php?controller=paginas-web&action=editar&id=<?= $pagina['id'] ?>" 
                                                       class="btn btn-sm btn-warning" title="Editar fecha">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="index.php?controller=paginas-web&action=ver&id=<?= $pagina['id'] ?>" 
                                                       class="btn btn-sm btn-info" title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Filtros -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-outline-danger btn-filtro" data-filtro="vencido">
                                                <i class="fas fa-calendar-times"></i> Vencidos
                                            </button>
                                            <button type="button" class="btn btn-outline-warning btn-filtro" data-filtro="proximo">
                                                <i class="fas fa-exclamation-triangle"></i> Próximos a Vencer
                                            </button>
                                            <button type="button" class="btn btn-outline-success btn-filtro" data-filtro="activo">
                                                <i class="fas fa-check-circle"></i> Activos
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary btn-filtro" data-filtro="sin-fecha">
                                                <i class="fas fa-question"></i> Sin Fecha
                                            </button>
                                            <button type="button" class="btn btn-outline-primary btn-filtro" data-filtro="todos">
                                                <i class="fas fa-list"></i> Mostrar Todos
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info text-center">
                                    <h4><i class="icon fas fa-info"></i> No hay páginas web registradas</h4>
                                    <p>No hay datos para mostrar en el control de vencimientos.</p>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Actualizar contadores
    document.getElementById('contador-vencidos').textContent = <?= $vencidos ?>;
    document.getElementById('contador-proximos').textContent = <?= $proximos ?>;
    document.getElementById('contador-activos').textContent = <?= $activos ?>;
    document.getElementById('contador-sin-fecha').textContent = <?= $sin_fecha ?>;

    // Filtros
    const btnFiltros = document.querySelectorAll('.btn-filtro');
    const filas = document.querySelectorAll('.fila-vencimiento');

    btnFiltros.forEach(btn => {
        btn.addEventListener('click', function() {
            const filtro = this.getAttribute('data-filtro');
            
            filas.forEach(fila => {
                if (filtro === 'todos' || fila.getAttribute('data-estado') === filtro) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });

            // Actualizar clase activa en botones
            btnFiltros.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Búsqueda en tiempo real
    const buscador = document.getElementById('buscar-vencimientos');
    buscador.addEventListener('keyup', function() {
        const termino = this.value.toLowerCase();
        
        filas.forEach(fila => {
            const textoFila = fila.textContent.toLowerCase();
            if (textoFila.includes(termino)) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    });
});
</script>

<?php include 'views/templates/footer.php'; ?>