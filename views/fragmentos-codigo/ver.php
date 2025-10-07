<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ver Fragmento de Código</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="index.php?controller=fragmentos-codigo&action=listar">Fragmentos</a></li>
                        <li class="breadcrumb-item active">Ver Fragmento</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title"><?= htmlspecialchars($fragmento['titulo']) ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool btn-copiar-todo" title="Copiar código completo">
                                    <i class="fas fa-copy"></i> Copiar
                                </button>
                                <a href="index.php?controller=fragmentos-codigo&action=editar&id=<?= $fragmento['id'] ?>" 
                                   class="btn btn-tool text-warning" title="Editar fragmento">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Información del fragmento -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <table class="table table-bordered table-sm">
                                        <tr>
                                            <th width="30%">Lenguaje:</th>
                                            <td>
                                                <span class="badge badge-language-<?= strtolower($fragmento['lenguaje'] ?? 'php') ?>">
                                                    <?= htmlspecialchars($fragmento['lenguaje'] ?? 'PHP') ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Categoría:</th>
                                            <td><?= htmlspecialchars($fragmento['categoria'] ?? 'General') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tags:</th>
                                            <td>
                                                <?php if (!empty($fragmento['tags'])): ?>
                                                    <?php 
                                                        $tags = explode(',', $fragmento['tags']);
                                                        foreach ($tags as $tag): 
                                                    ?>
                                                        <span class="badge badge-secondary"><?= trim($tag) ?></span>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <span class="text-muted">Sin tags</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered table-sm">
                                        <tr>
                                            <th width="30%">Creado por:</th>
                                            <td><?= htmlspecialchars($fragmento['usuario_nombre'] ?? 'Sistema') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Fecha creación:</th>
                                            <td><?= date('d/m/Y H:i', strtotime($fragmento['fecha_creacion'])) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Última modificación:</th>
                                            <td><?= date('d/m/Y H:i', strtotime($fragmento['fecha_modificacion'])) ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Descripción -->
                            <?php if (!empty($fragmento['descripcion'])): ?>
                                <div class="callout callout-info">
                                    <h5><i class="fas fa-info-circle"></i> Descripción</h5>
                                    <p><?= nl2br(htmlspecialchars($fragmento['descripcion'])) ?></p>
                                </div>
                            <?php endif; ?>

                            <!-- Código -->
                            <div class="card">
                                <div class="card-header bg-dark">
                                    <h5 class="card-title text-light mb-0">
                                        <i class="fas fa-code"></i> Código
                                    </h5>
                                </div>
                                <div class="card-body p-0">
                                    <pre class="m-0"><code class="language-<?= strtolower($fragmento['lenguaje'] ?? 'php') ?>" id="codigo-completo"><?= htmlspecialchars($fragmento['codigo']) ?></code></pre>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-success btn-sm btn-copiar-codigo">
                                        <i class="fas fa-copy"></i> Copiar Código
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm btn-descargar" data-filename="<?= htmlspecialchars($fragmento['titulo']) ?>.<?= strtolower($fragmento['lenguaje'] ?? 'txt') ?>">
                                        <i class="fas fa-download"></i> Descargar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="index.php?controller=fragmentos-codigo&action=listar" class="btn btn-default">
                                <i class="fas fa-arrow-left"></i> Volver a la lista
                            </a>
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

pre {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 4px;
    padding: 1rem;
    max-height: 600px;
    overflow-y: auto;
    font-family: 'Courier New', monospace;
    font-size: 14px;
    line-height: 1.4;
    white-space: pre-wrap;
    word-wrap: break-word;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const codigoCompleto = document.getElementById('codigo-completo');
    const btnCopiar = document.querySelector('.btn-copiar-codigo');
    const btnCopiarTodo = document.querySelector('.btn-copiar-todo');
    const btnDescargar = document.querySelector('.btn-descargar');

    // Función para copiar código
    function copiarCodigo() {
        const codigo = codigoCompleto.textContent;
        navigator.clipboard.writeText(codigo).then(function() {
            // Mostrar notificación
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
            
            setTimeout(() => {
                toast.remove();
            }, 2000);
        }).catch(function(err) {
            console.error('Error al copiar: ', err);
            alert('Error al copiar al portapapeles');
        });
    }

    // Botón copiar en el footer
    if (btnCopiar) {
        btnCopiar.addEventListener('click', copiarCodigo);
    }

    // Botón copiar en el header
    if (btnCopiarTodo) {
        btnCopiarTodo.addEventListener('click', copiarCodigo);
    }

    // Descargar código como archivo
    if (btnDescargar) {
        btnDescargar.addEventListener('click', function() {
            const codigo = codigoCompleto.textContent;
            const filename = this.getAttribute('data-filename');
            const blob = new Blob([codigo], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        });
    }
});
</script>

<?php include 'views/templates/footer.php'; ?>