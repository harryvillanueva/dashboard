<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Nuevo Correo</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="index.php?controller=correos&action=listar">Correos</a></li>
                        <li class="breadcrumb-item active">Nuevo Correo</li>
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
                            <h3 class="card-title">Información del Correo</h3>
                        </div>
                        <form action="index.php?controller=correos&action=crear" method="POST">
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
                                    <label for="email">Dirección de Correo *</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?= $_POST['email'] ?? '' ?>" required 
                                           placeholder="usuario@dominio.com">
                                </div>

                                <div class="form-group">
                                    <label for="password">Contraseña *</label>
                                    <input type="password" class="form-control" id="password" name="password" 
                                           value="<?= $_POST['password'] ?? '' ?>" required 
                                           placeholder="Ingrese la contraseña">
                                </div>

                                <div class="form-group">
                                    <label for="quota">Cuota de Almacenamiento</label>
                                    <select class="form-control" id="quota" name="quota">
                                        <option value="500 MB" <?= ($_POST['quota'] ?? '') == '500 MB' ? 'selected' : '' ?>>500 MB</option>
                                        <option value="1 GB" <?= ($_POST['quota'] ?? '') == '1 GB' ? 'selected' : '' ?>>1 GB</option>
                                        <option value="2 GB" <?= ($_POST['quota'] ?? '') == '2 GB' ? 'selected' : '' ?>>2 GB</option>
                                        <option value="5 GB" <?= ($_POST['quota'] ?? '') == '5 GB' ? 'selected' : '' ?>>5 GB</option>
                                        <option value="Ilimitada" <?= ($_POST['quota'] ?? '') == 'Ilimitada' ? 'selected' : '' ?>>Ilimitada</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="fecha_creacion">Fecha de Creación</label>
                                    <input type="date" class="form-control" id="fecha_creacion" name="fecha_creacion" 
                                           value="<?= $_POST['fecha_creacion'] ?? date('Y-m-d') ?>">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Guardar Correo
                                </button>
                                <a href="index.php?controller=correos&action=listar" class="btn btn-default">
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

<?php include 'views/templates/footer.php'; ?>