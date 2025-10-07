<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Nuevo Backup</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="index.php?controller=backups&action=listar">Backups</a></li>
                        <li class="breadcrumb-item active">Nuevo Backup</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Subir Nuevo Backup</h3>
                        </div>
                        <form action="index.php?controller=backups&action=crear" method="POST" enctype="multipart/form-data">
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
                                                <?= ($_POST['pagina_web_id'] ?? '') == $pagina['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($pagina['titulo']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="nombre_archivo">Nombre del Backup *</label>
                                    <input type="text" class="form-control" id="nombre_archivo" name="nombre_archivo" 
                                           value="<?= $_POST['nombre_archivo'] ?? '' ?>" required 
                                           placeholder="Ej: backup-sitio-web-2024-01-01">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tipo">Tipo de Backup *</label>
                                            <select class="form-control" id="tipo" name="tipo" required>
                                                <option value="wordpress" <?= ($_POST['tipo'] ?? '') == 'wordpress' ? 'selected' : '' ?>>WordPress</option>
                                                <option value="database" <?= ($_POST['tipo'] ?? '') == 'database' ? 'selected' : '' ?>>Base de Datos</option>
                                                <option value="zip" <?= ($_POST['tipo'] ?? '') == 'zip' ? 'selected' : '' ?>>Archivo ZIP</option>
                                                <option value="wpress" <?= ($_POST['tipo'] ?? '') == 'wpress' ? 'selected' : '' ?>>Archivo WPRESS</option>
                                                <option value="completo" <?= ($_POST['tipo'] ?? '') == 'completo' ? 'selected' : '' ?>>Completo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="categoria">Categoría *</label>
                                            <select class="form-control" id="categoria" name="categoria" required>
                                                <option value="Completo" <?= ($_POST['categoria'] ?? '') == 'Completo' ? 'selected' : '' ?>>Completo</option>
                                                <option value="Base de datos" <?= ($_POST['categoria'] ?? '') == 'Base de datos' ? 'selected' : '' ?>>Base de datos</option>
                                                <option value="Archivos" <?= ($_POST['categoria'] ?? '') == 'Archivos' ? 'selected' : '' ?>>Archivos</option>
                                                <option value="Temas" <?= ($_POST['categoria'] ?? '') == 'Temas' ? 'selected' : '' ?>>Temas</option>
                                                <option value="Plugins" <?= ($_POST['categoria'] ?? '') == 'Plugins' ? 'selected' : '' ?>>Plugins</option>
                                                <option value="Uploads" <?= ($_POST['categoria'] ?? '') == 'Uploads' ? 'selected' : '' ?>>Uploads</option>
                                                <option value="Personalizado" <?= ($_POST['categoria'] ?? '') == 'Personalizado' ? 'selected' : '' ?>>Personalizado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="archivo">Archivo de Backup *</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="archivo" name="archivo" 
                                               accept=".zip,.wpress,.sql,.gz,.tar,.bak,.wp" required>
                                        <label class="custom-file-label" for="archivo" id="archivo-label">
                                            Seleccionar archivo (.zip, .wpress, .sql, etc.)
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">
                                        Formatos permitidos: ZIP, WPRESS, SQL, GZ, TAR, BAK, WP<br>
                                        Tamaño máximo: 2GB
                                    </small>
                                    <div class="mt-2" id="info-archivo" style="display: none;">
                                        <div class="alert alert-info py-2">
                                            <i class="fas fa-info-circle"></i>
                                            <span id="info-texto"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" 
                                              rows="3" placeholder="Describe el contenido de este backup, fecha de creación, notas importantes..."><?= $_POST['descripcion'] ?? '' ?></textarea>
                                </div>

                                <!-- Información sobre tipos de archivo -->
                                <div class="alert alert-warning">
                                    <h6><i class="fas fa-lightbulb"></i> Tipos de Archivo Soportados</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>.ZIP:</strong> Archivos comprimidos estándar<br>
                                            <strong>.WPRESS:</strong> Backups de All-in-One WP Migration<br>
                                            <strong>.SQL:</strong> Exportaciones de base de datos
                                        </div>
                                        <div class="col-md-6">
                                            <strong>.GZ:</strong> Archivos comprimidos con gzip<br>
                                            <strong>.TAR:</strong> Archivos tar sin comprimir<br>
                                            <strong>.BAK:</strong> Backups generales
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload"></i> Subir Backup
                                </button>
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
document.addEventListener('DOMContentLoaded', function() {
    const archivoInput = document.getElementById('archivo');
    const archivoLabel = document.getElementById('archivo-label');
    const infoArchivo = document.getElementById('info-archivo');
    const infoTexto = document.getElementById('info-texto');
    const tipoSelect = document.getElementById('tipo');

    // Actualizar label cuando se selecciona un archivo
    archivoInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            archivoLabel.textContent = file.name;
            
            // Mostrar información del archivo
            const tamaño = formatearTamaño(file.size);
            const extension = file.name.split('.').pop().toLowerCase();
            infoTexto.textContent = `Archivo: ${file.name} | Tamaño: ${tamaño} | Tipo: ${extension.toUpperCase()}`;
            infoArchivo.style.display = 'block';
            
            // Auto-detectar tipo basado en la extensión
            autoDetectarTipo(extension);
        } else {
            archivoLabel.textContent = 'Seleccionar archivo (.zip, .wpress, .sql, etc.)';
            infoArchivo.style.display = 'none';
        }
    });

    // Función para formatear tamaño
    function formatearTamaño(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Auto-detectar tipo basado en la extensión
    function autoDetectarTipo(extension) {
        const tipoMap = {
            'wpress': 'wordpress',
            'zip': 'zip',
            'sql': 'database',
            'gz': 'zip',
            'tar': 'zip',
            'bak': 'completo',
            'wp': 'wordpress'
        };
        
        if (tipoMap[extension]) {
            tipoSelect.value = tipoMap[extension];
            
            // Mostrar notificación de auto-detección
            const toast = document.createElement('div');
            toast.className = 'alert alert-info alert-dismissible fade show mt-2';
            toast.innerHTML = `
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>¡Tipo detectado!</strong> Se ha establecido automáticamente el tipo: ${tipoMap[extension].toUpperCase()}
            `;
            infoArchivo.parentNode.insertBefore(toast, infoArchivo.nextSibling);
            
            // Auto-eliminar después de 5 segundos
            setTimeout(() => {
                toast.remove();
            }, 5000);
        }
    }

    // Validación de tipo de archivo antes de enviar
    document.querySelector('form').addEventListener('submit', function(e) {
        if (archivoInput.files.length > 0) {
            const file = archivoInput.files[0];
            const extension = file.name.split('.').pop().toLowerCase();
            const extensionesPermitidas = ['zip', 'wpress', 'sql', 'gz', 'tar', 'bak', 'wp'];
            
            if (!extensionesPermitidas.includes(extension)) {
                e.preventDefault();
                alert('Error: Tipo de archivo no permitido. Use: ' + extensionesPermitidas.join(', '));
                return false;
            }
            
            // Validar tamaño máximo (2GB)
            const tamañoMaximo = 2 * 1024 * 1024 * 1024; // 2GB
            if (file.size > tamañoMaximo) {
                e.preventDefault();
                alert('Error: El archivo es demasiado grande. Tamaño máximo: 2GB');
                return false;
            }
        }
    });
});
</script>

<?php include 'views/templates/footer.php'; ?>