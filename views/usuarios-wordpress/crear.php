<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Nuevo Usuario WordPress</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="index.php?controller=usuarios-wordpress&action=listar">Usuarios WordPress</a></li>
                        <li class="breadcrumb-item active">Nuevo Usuario</li>
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
                            <h3 class="card-title">Información del Usuario WordPress</h3>
                        </div>
                        <form action="index.php?controller=usuarios-wordpress&action=crear" method="POST">
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
                                    <label for="username">Nombre de Usuario *</label>
                                    <input type="text" class="form-control" id="username" name="username" 
                                           value="<?= $_POST['username'] ?? '' ?>" required 
                                           placeholder="Ingrese el nombre de usuario">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?= $_POST['email'] ?? '' ?>" required 
                                           placeholder="usuario@ejemplo.com">
                                </div>

                                <div class="form-group">
                                    <label for="password">Contraseña *</label>
                                    <input type="password" class="form-control" id="password" name="password" 
                                           value="<?= $_POST['password'] ?? '' ?>" required 
                                           placeholder="Ingrese la contraseña">
                                </div>

                                <div class="form-group">
                                    <label for="rol">Rol *</label>
                                    <select class="form-control" id="rol" name="rol" required>
                                        <option value="administrator" <?= ($_POST['rol'] ?? '') == 'administrator' ? 'selected' : '' ?>>Administrador</option>
                                        <option value="editor" <?= ($_POST['rol'] ?? '') == 'editor' ? 'selected' : '' ?>>Editor</option>
                                        <option value="author" <?= ($_POST['rol'] ?? '') == 'author' ? 'selected' : '' ?>>Autor</option>
                                        <option value="contributor" <?= ($_POST['rol'] ?? '') == 'contributor' ? 'selected' : '' ?>>Colaborador</option>
                                        <option value="subscriber" <?= ($_POST['rol'] ?? '') == 'subscriber' ? 'selected' : '' ?>>Suscriptor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Guardar Usuario
                                </button>
                                <a href="index.php?controller=usuarios-wordpress&action=listar" class="btn btn-default">
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