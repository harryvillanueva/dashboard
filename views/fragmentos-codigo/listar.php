<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestión de Fragmentos de Código</h1>
                </div>
                <div class="col-sm-6">
                    <a href="index.php?controller=fragmentos-codigo&action=crear" class="btn btn-success float-right">
                        <i class="fas fa-plus"></i> Nuevo Fragmento
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

            <!-- Barra de búsqueda -->
            <div class="row mb-3">
                <div class="col-12">
                    <form action="index.php?controller=fragmentos-codigo&action=buscar" method="GET" class="form-inline">
                        <input type="hidden" name="controller" value="fragmentos-codigo">
                        <input type="hidden" name="action" value="buscar">
                        <div class="input-group" style="width: 100%;">
                            <input type="text" name="q" class="form-control" placeholder="Buscar fragmentos por título, descripción o tags..." value="<?= $_GET['q'] ?? '' ?>">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Filtros rápidos -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="btn-group" role="group">
                        <a href="index.php?controller=fragmentos-codigo&action=listar" class="btn btn-outline-secondary">Todos</a>
                        <a href="index.php?controller=fragmentos-codigo&action=buscar&q=PHP" class="btn btn-outline-primary">PHP</a>
                        <a href="index.php?controller=fragmentos-codigo&action=buscar&q=JavaScript" class="btn btn-outline-warning">JavaScript</a>
                        <a href="index.php?controller=fragmentos-codigo&action=buscar&q=HTML" class="btn btn-outline-danger">HTML</a>
                        <a href="index.php?controller=fragmentos-codigo&action=buscar&q=CSS" class="btn btn-outline-info">CSS</a>
                        <a href="index.php?controller=fragmentos-codigo&action=buscar&q=SQL" class="btn btn-outline-success">SQL</a>
                    </div>
                </div>
            </div>

            <!-- Tabla de fragmentos -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Lista de Fragmentos de Código</h3>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($fragmentos)): ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Título</th>
                                                <th>Lenguaje</th>
                                                <th>Categoría</th>
                                                <th>Tags</th>
                                                <th>Vista Previa</th>
                                                <th>Usuario</th>
                                                <th>Fecha</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($fragmentos as $fragmento): ?>
                                            <tr>
                                                <td>
                                                    <strong><?= htmlspecialchars($fragmento['titulo']) ?></strong>
                                                    <?php if (!empty($fragmento['descripcion'])): ?>
                                                        <br><small class="text-muted"><?= htmlspecialchars(substr($fragmento['descripcion'], 0, 50)) ?>...</small>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge badge-language-<?= strtolower($fragmento['lenguaje'] ?? 'php') ?>">
                                                        <?= htmlspecialchars($fragmento['lenguaje'] ?? 'PHP') ?>
                                                    </span>
                                                </td>
                                                <td><?= htmlspecialchars($fragmento['categoria'] ?? 'General') ?></td>
                                                <td>
                                                    <?php if (!empty($fragmento['tags'])): ?>
                                                        <?php 
                                                            $tags = explode(',', $fragmento['tags']);
                                                            foreach (array_slice($tags, 0, 3) as $tag): 
                                                        ?>
                                                            <span class="badge badge-secondary"><?= trim($tag) ?></span>
                                                        <?php endforeach; ?>
                                                        <?php if (count($tags) > 3): ?>
                                                            <span class="badge badge-light">+<?= count($tags) - 3 ?> más</span>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <code class="text-sm" style="max-width: 200px; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                        <?= htmlspecialchars(substr($fragmento['codigo'], 0, 50)) ?>...
                                                    </code>
                                                </td>
                                                <td><?= htmlspecialchars($fragmento['usuario_nombre'] ?? 'Sistema') ?></td>
                                                <td><?= date('d/m/Y', strtotime($fragmento['fecha_creacion'])) ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-info btn-copiar" 
                                                                data-codigo="<?= htmlspecialchars($fragmento['codigo']) ?>" 
                                                                title="Copiar código">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
                                                        <a href="index.php?controller=fragmentos-codigo&action=ver&id=<?= $fragmento['id'] ?>" 
                                                           class="btn btn-sm btn-primary" title="Ver código">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="index.php?controller=fragmentos-codigo&action=editar&id=<?= $fragmento['id'] ?>" 
                                                           class="btn btn-sm btn-warning" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="index.php?controller=fragmentos-codigo&action=eliminar&id=<?= $fragmento['id'] ?>" 
                                                           class="btn btn-sm btn-danger" 
                                                           onclick="return confirm('¿Estás seguro de eliminar este fragmento?')"
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
                                    <h4><i class="icon fas fa-info"></i> No hay fragmentos de código registrados</h4>
                                    <p>Comienza agregando tu primer fragmento de código.</p>
                                    <a href="index.php?controller=fragmentos-codigo&action=crear" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Agregar Primer Fragmento
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

<style>
.badge-language-php { background-color: #4F5D95; color: white; }
.badge-language-javascript { background-color: #F7DF1E; color: black; }
.badge-language-html { background-color: #E34F26; color: white; }
.badge-language-css { background-color: #1572B6; color: white; }
.badge-language-sql { background-color: #4479A1; color: white; }
.badge-language-python { background-color: #3776AB; color: white; }
.badge-language-java { background-color: #007396; color: white; }
.badge-language-otro { background-color: #6c757d; color: white; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Función para copiar código al portapapeles
    function copiarCodigo(codigo) {
        navigator.clipboard.writeText(codigo).then(function() {
            // Mostrar notificación de éxito
            const toast = document.createElement('div');
            toast.className = 'alert alert-success alert-dismissible fade show position-fixed';
            toast.style.top = '20px';
            toast.style.right = '20px';
            toast.style.zIndex = '9999';
            toast.innerHTML = `
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>¡Éxito!</strong> Código copiado al portapapeles.
            `;
            document.body.appendChild(toast);
            
            // Auto-eliminar después de 2 segundos
            setTimeout(() => {
                toast.remove();
            }, 2000);
        }).catch(function(err) {
            console.error('Error al copiar: ', err);
            alert('Error al copiar al portapapeles');
        });
    }

    // Botones de copiar
    document.querySelectorAll('.btn-copiar').forEach(btn => {
        btn.addEventListener('click', function() {
            const codigo = this.getAttribute('data-codigo');
            copiarCodigo(codigo);
        });
    });
});
</script>

<?php include 'views/templates/footer.php'; ?>