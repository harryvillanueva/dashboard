<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Editar Página Web</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="index.php?controller=paginas-web&action=listar">Páginas Web</a></li>
                        <li class="breadcrumb-item active">Editar Página Web</li>
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
                            <h3 class="card-title">Editando: <?= htmlspecialchars($pagina['titulo']) ?></h3>
                        </div>
                        <form action="index.php?controller=paginas-web&action=editar&id=<?= $pagina['id'] ?>" method="POST" enctype="multipart/form-data">
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
                                    <label for="titulo">Título *</label>
                                    <input type="text" class="form-control" id="titulo" name="titulo" 
                                           value="<?= $_POST['titulo'] ?? $pagina['titulo'] ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="cliente_id">Cliente</label>
                                    <select class="form-control" id="cliente_id" name="cliente_id">
                                        <option value="">Seleccione un cliente</option>
                                        <?php foreach ($clientes as $cliente): ?>
                                            <option value="<?= $cliente['id'] ?>" 
                                                <?= ($_POST['cliente_id'] ?? $pagina['cliente_id']) == $cliente['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($cliente['nombre']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="url">URL</label>
                                    <input type="url" class="form-control" id="url" name="url" 
                                           value="<?= $_POST['url'] ?? $pagina['url'] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="rubro">Rubro</label>
                                    <input type="text" class="form-control" id="rubro" name="rubro" 
                                           value="<?= $_POST['rubro'] ?? $pagina['rubro'] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?= $_POST['descripcion'] ?? $pagina['descripcion'] ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="imagen">Imagen</label>
                                    <?php if ($pagina['imagen_path']): ?>
                                        <div class="mb-2">
                                            <img src="<?= $pagina['imagen_path'] ?>" width="100" class="img-thumbnail">
                                            <br>
                                            <small>Imagen actual</small>
                                        </div>
                                    <?php endif; ?>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="imagen" name="imagen" accept="image/*">
                                        <label class="custom-file-label" for="imagen">Seleccionar nueva imagen</label>
                                    </div>
                                    <small class="form-text text-muted">Dejar vacío para mantener la imagen actual</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha_creacion">Fecha de Creación</label>
                                            <input type="date" class="form-control" id="fecha_creacion" name="fecha_creacion" 
                                                   value="<?= $_POST['fecha_creacion'] ?? $pagina['fecha_creacion'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha_vencimiento_hosting">Fecha Vencimiento Hosting</label>
                                            <input type="date" class="form-control" id="fecha_vencimiento_hosting" name="fecha_vencimiento_hosting" 
                                                   value="<?= $_POST['fecha_vencimiento_hosting'] ?? $pagina['fecha_vencimiento_hosting'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Actualizar Página Web
                                </button>
                                <a href="index.php?controller=paginas-web&action=listar" class="btn btn-default">
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
    var fileName = document.getElementById("imagen").files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});
</script>

<?php include 'views/templates/footer.php'; ?>