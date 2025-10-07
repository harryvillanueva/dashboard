<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Nuevo Tema</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="index.php?controller=temas&action=listar">Temas</a></li>
                        <li class="breadcrumb-item active">Nuevo Tema</li>
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
                            <h3 class="card-title">Información del Tema</h3>
                        </div>
                        <form action="index.php?controller=temas&action=crear" method="POST" enctype="multipart/form-data">
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
                                    <label for="nombre">Nombre del Tema *</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" 
                                           value="<?= $_POST['nombre'] ?? '' ?>" required 
                                           placeholder="Ingrese el nombre del tema">
                                </div>

                                <div class="form-group">
                                    <label for="version">Versión</label>
                                    <input type="text" class="form-control" id="version" name="version" 
                                           value="<?= $_POST['version'] ?? '1.0' ?>" 
                                           placeholder="Ej: 1.0.0">
                                </div>

                                <div class="form-group">
                                    <label for="categoria">Categoría</label>
                                    <select class="form-control" id="categoria" name="categoria">
                                        <option value="General" <?= ($_POST['categoria'] ?? '') == 'General' ? 'selected' : '' ?>>General</option>
                                        <option value="E-commerce" <?= ($_POST['categoria'] ?? '') == 'E-commerce' ? 'selected' : '' ?>>E-commerce</option>
                                        <option value="Blog" <?= ($_POST['categoria'] ?? '') == 'Blog' ? 'selected' : '' ?>>Blog</option>
                                        <option value="Portafolio" <?= ($_POST['categoria'] ?? '') == 'Portafolio' ? 'selected' : '' ?>>Portafolio</option>
                                        <option value="Corporate" <?= ($_POST['categoria'] ?? '') == 'Corporate' ? 'selected' : '' ?>>Corporate</option>
                                        <option value="Personalizado" <?= ($_POST['categoria'] ?? '') == 'Personalizado' ? 'selected' : '' ?>>Personalizado</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" 
                                              rows="3" placeholder="Descripción del tema y sus características"><?= $_POST['descripcion'] ?? '' ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="archivo">Archivo del Tema *</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="archivo" name="archivo" accept=".zip,.rar,.tar.gz" required>
                                        <label class="custom-file-label" for="archivo">Seleccionar archivo .zip</label>
                                    </div>
                                    <small class="form-text text-muted">Formatos: ZIP, RAR, TAR.GZ. Tamaño máximo: 50MB</small>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Guardar Tema
                                </button>
                                <a href="index.php?controller=temas&action=listar" class="btn btn-default">
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
// Mostrar nombre del archivo seleccionado
document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = document.getElementById("archivo").files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});
</script>

<?php include 'views/templates/footer.php'; ?>