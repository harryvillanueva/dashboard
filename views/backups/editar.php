<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Editar Backup</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="index.php?controller=backups&action=listar">Backups</a></li>
                        <li class="breadcrumb-item active">Editar Backup</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Editando: <?= htmlspecialchars($backup['nombre_archivo']) ?></h3>
                        </div>
                        <form action="index.php?controller=backups&action=editar&id=<?= $backup['id'] ?>" method="POST">
                            <div class="card-body">
                                <?php if (!empty($mensaje)): 
                                    $tipo = explode(':', $mensaje)[0];
                                    $texto = explode(':', $mensaje)[1];
                                ?>
                                    <div class="alert alert-<?= $tipo == 'success' ? 'success' : 'danger' ?>">
                                        <?= htmlspecialchars($texto) ?>
                                    </div>
                                <?php endif; ?>

                                <div class="form-group">
                                    <label for="pagina_web_id">Sitio Web *</label>
                                    <select class="form-control" id="pagina_web_id" name="pagina_web_id" required>
                                        <option value="">Seleccione un sitio web</option>
                                        <?php foreach ($paginas_web as $pagina): ?>
                                            <option value="<?= $pagina['id'] ?>" 
                                                <?= ($_POST['pagina_web_id'] ?? $backup['pagina_web_id']) == $pagina['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($pagina['titulo']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="nombre_archivo">Nombre del Backup *</label>
                                    <input type="text" class="form-control" id="nombre_archivo" name="nombre_archivo" 
                                           value="<?= $_POST['nombre_archivo'] ?? $backup['nombre_archivo'] ?>" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tipo">Tipo de Backup *</label>
                                            <select class="form-control" id="tipo" name="tipo" required>
                                                <option value="wordpress" <?= ($_POST['tipo'] ?? $backup['tipo']) == 'wordpress' ? 'selected' : '' ?>>WordPress</option>
                                                <option value="database" <?= ($_POST['tipo'] ?? $backup['tipo']) == 'database' ? 'selected' : '' ?>>Base de Datos</option>
                                                <option value="zip" <?= ($_POST['tipo'] ?? $backup['tipo']) == 'zip' ? 'selected' : '' ?>>Archivo ZIP</option>
                                                <option value="wpress" <?= ($_POST['tipo'] ?? $backup['tipo']) == 'wpress' ? 'selected' : '' ?>>Archivo WPRESS</option>
                                                <option value="completo" <?= ($_POST['tipo'] ?? $backup['tipo']) == 'completo' ? 'selected' : '' ?>>Completo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="categoria">Categoría *</label>
                                            <select class="form-control" id="categoria" name="categoria" required>
                                                <option value="Completo" <?= ($_POST['categoria'] ?? $backup['categoria']) == 'Completo' ? 'selected' : '' ?>>Completo</option>
                                                <option value="Base de datos" <?= ($_POST['categoria'] ?? $backup['categoria']) == 'Base de datos' ? 'selected' : '' ?>>Base de datos</option>
                                                <option value="Archivos" <?= ($_POST['categoria'] ?? $backup['categoria']) == 'Archivos' ? 'selected' : '' ?>>Archivos</option>
                                                <option value="Temas" <?= ($_POST['categoria'] ?? $backup['categoria']) == 'Temas' ? 'selected' : '' ?>>Temas</option>
                                                <option value="Plugins" <?= ($_POST['categoria'] ?? $backup['categoria']) == 'Plugins' ? 'selected' : '' ?>>Plugins</option>
                                                <option value="Uploads" <?= ($_POST['categoria'] ?? $backup['categoria']) == 'Uploads' ? 'selected' : '' ?>>Uploads</option>
                                                <option value="Personalizado" <?= ($_POST['categoria'] ?? $backup['categoria']) == 'Personalizado' ? 'selected' : '' ?>>Personalizado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" 
                                              rows="3"><?= $_POST['descripcion'] ?? $backup['descripcion'] ?></textarea>
                                </div>

                                <!-- Información del archivo actual -->
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-info-circle"></i> Información del Archivo Actual</h6>
                                    <p><strong>Archivo:</strong> <?= htmlspecialchars(basename($backup['ruta_archivo'])) ?></p>
                                    <p><strong>Tamaño:</strong> <?= htmlspecialchars($backup['tamaño'] ?? 'N/A') ?></p>
                                    <p><strong>Fecha de subida:</strong> <?= date('d/m/Y H:i', strtotime($backup['fecha_backup'])) ?></p>
                                    <?php if (file_exists($backup['ruta_archivo'])): ?>
                                        <p><strong>Estado:</strong> <span class="badge badge-success">Disponible</span></p>
                                        <a href="index.php?controller=backups&action=descargar&id=<?= $backup['id'] ?>" 
                                           class="btn btn-sm btn-success">
                                            <i class="fas fa-download"></i> Descargar Archivo Actual
                                        </a>
                                    <?php else: ?>
                                        <p><strong>Estado:</strong> <span class="badge badge-danger">Archivo no encontrado</span></p>
                                    <?php endif; ?>
                                </div>

                                <!-- Opción para reemplazar archivo -->
                                <div class="form-group">
                                    <label for="nuevo_archivo">Reemplazar Archivo (Opcional)</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="nuevo_archivo" name="nuevo_archivo" 
                                               accept=".zip,.wpress,.sql,.gz,.tar,.bak,.wp">
                                        <label class="custom-file-label" for="nuevo_archivo">
                                            Seleccionar nuevo archivo (.zip, .wpress, etc.)
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">
                                        Dejar vacío para mantener el archivo actual. Formatos: ZIP, WPRESS, SQL, GZ, TAR, BAK, WP
                                    </small>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Actualizar Backup
                                </button>
                                <a href="index.php?controller=backups&action=ver&id=<?= $backup['id'] ?>" class="btn btn-info">
                                    <i class="fas fa-eye"></i> Ver Backup
                                </a>
                                <a href="index.php?controller=backups&action=listar" class="btn btn-default">
                                    <i class="fas fa-arrow-left"></i> Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
// Script para mostrar el nombre del archivo seleccionado
document.addEventListener('DOMContentLoaded', function() {
    const nuevoArchivoInput = document.getElementById('nuevo_archivo');
    const nuevoArchivoLabel = nuevoArchivoInput.nextElementSibling;

    nuevoArchivoInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            nuevoArchivoLabel.textContent = this.files[0].name;
        } else {
            nuevoArchivoLabel.textContent = 'Seleccionar nuevo archivo (.zip, .wpress, etc.)';
        }
    });
});
</script>

<?php include 'views/templates/footer.php'; ?>