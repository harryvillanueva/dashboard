<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Nueva Credencial de Hosting</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="index.php?controller=credenciales-hosting&action=listar">Credenciales Hosting</a></li>
                        <li class="breadcrumb-item active">Nueva Credencial</li>
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
                            <h3 class="card-title">Información de la Credencial de Hosting</h3>
                        </div>
                        <form action="index.php?controller=credenciales-hosting&action=crear" method="POST">
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
                                    <label for="proveedor">Proveedor de Hosting *</label>
                                    <input type="text" class="form-control" id="proveedor" name="proveedor" 
                                           value="<?= $_POST['proveedor'] ?? '' ?>" required 
                                           placeholder="Ej: GoDaddy, Hostinger, SiteGround">
                                </div>

                                <div class="form-group">
                                    <label for="url_cpanel">URL cPanel</label>
                                    <input type="url" class="form-control" id="url_cpanel" name="url_cpanel" 
                                           value="<?= $_POST['url_cpanel'] ?? '' ?>" 
                                           placeholder="https://cpanel.ejemplo.com">
                                </div>

                                <div class="form-group">
                                    <label for="usuario">Usuario cPanel *</label>
                                    <input type="text" class="form-control" id="usuario" name="usuario" 
                                           value="<?= $_POST['usuario'] ?? '' ?>" required 
                                           placeholder="Nombre de usuario del cPanel">
                                </div>

                                <div class="form-group">
                                    <label for="password">Contraseña cPanel *</label>
                                    <input type="password" class="form-control" id="password" name="password" 
                                           value="<?= $_POST['password'] ?? '' ?>" required 
                                           placeholder="Contraseña del cPanel">
                                </div>

                                <div class="form-group">
                                    <label for="plan_hosting">Plan de Hosting</label>
                                    <input type="text" class="form-control" id="plan_hosting" name="plan_hosting" 
                                           value="<?= $_POST['plan_hosting'] ?? '' ?>" 
                                           placeholder="Ej: Plan Básico, Plan Premium">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha_compra">Fecha de Compra</label>
                                            <input type="date" class="form-control" id="fecha_compra" name="fecha_compra" 
                                                   value="<?= $_POST['fecha_compra'] ?? date('Y-m-d') ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha_caducidad">Fecha de Caducidad</label>
                                            <input type="date" class="form-control" id="fecha_caducidad" name="fecha_caducidad" 
                                                   value="<?= $_POST['fecha_caducidad'] ?? '' ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Guardar Credencial
                                </button>
                                <a href="index.php?controller=credenciales-hosting&action=listar" class="btn btn-default">
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