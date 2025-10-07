<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Editar Usuario WordPress</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="index.php?controller=usuarios-wordpress&action=listar">Usuarios WordPress</a></li>
                        <li class="breadcrumb-item active">Editar Usuario</li>
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
                            <h3 class="card-title">Editando: <?= htmlspecialchars($usuario['username']) ?></h3>
                        </div>
                        <form action="index.php?controller=usuarios-wordpress&action=editar&id=<?= $usuario['id'] ?>" method="POST">
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
                                                <?= ($_POST['pagina_web_id'] ?? $usuario['pagina_web_id']) == $pagina['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($pagina['titulo']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="username">Nombre de Usuario *</label>
                                    <input type="text" class="form-control" id="username" name="username" 
                                           value="<?= $_POST['username'] ?? $usuario['username'] ?>" required 
                                           placeholder="Ingrese el nombre de usuario">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?= $_POST['email'] ?? $usuario['email'] ?>" required 
                                           placeholder="usuario@ejemplo.com">
                                </div>

                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" 
                                               placeholder="Dejar vacío para mantener la actual">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary toggle-password-form" type="button">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary generate-password" type="button" title="Generar contraseña segura">
                                                <i class="fas fa-key"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">
                                        Dejar vacío para mantener la contraseña actual
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label for="rol">Rol *</label>
                                    <select class="form-control" id="rol" name="rol" required>
                                        <option value="administrator" <?= ($_POST['rol'] ?? $usuario['rol']) == 'administrator' ? 'selected' : '' ?>>Administrador</option>
                                        <option value="editor" <?= ($_POST['rol'] ?? $usuario['rol']) == 'editor' ? 'selected' : '' ?>>Editor</option>
                                        <option value="author" <?= ($_POST['rol'] ?? $usuario['rol']) == 'author' ? 'selected' : '' ?>>Autor</option>
                                        <option value="contributor" <?= ($_POST['rol'] ?? $usuario['rol']) == 'contributor' ? 'selected' : '' ?>>Colaborador</option>
                                        <option value="subscriber" <?= ($_POST['rol'] ?? $usuario['rol']) == 'subscriber' ? 'selected' : '' ?>>Suscriptor</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="activo">Estado</label>
                                    <select class="form-control" id="activo" name="activo">
                                        <option value="1" <?= ($_POST['activo'] ?? $usuario['activo']) ? 'selected' : '' ?>>Activo</option>
                                        <option value="0" <?= !($_POST['activo'] ?? $usuario['activo']) ? 'selected' : '' ?>>Inactivo</option>
                                    </select>
                                </div>

                                <!-- Información actual -->
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-info-circle"></i> Información Actual</h6>
                                    <p><strong>Usuario:</strong> <?= htmlspecialchars($usuario['username']) ?></p>
                                    <p><strong>Email:</strong> <?= htmlspecialchars($usuario['email']) ?></p>
                                    <p><strong>Rol:</strong> <?= ucfirst($usuario['rol']) ?></p>
                                    <p><strong>Estado:</strong> <?= $usuario['activo'] ? 'Activo' : 'Inactivo' ?></p>
                                    <p><strong>Fecha creación:</strong> <?= date('d/m/Y H:i', strtotime($usuario['fecha_creacion'])) ?></p>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Actualizar Usuario
                                </button>
                                <a href="index.php?controller=usuarios-wordpress&action=ver&id=<?= $usuario['id'] ?>" class="btn btn-info">
                                    <i class="fas fa-eye"></i> Ver Usuario
                                </a>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar/ocultar contraseña en formulario
    const toggleBtn = document.querySelector('.toggle-password-form');
    const passwordInput = document.getElementById('password');
    
    if (toggleBtn && passwordInput) {
        toggleBtn.addEventListener('click', function() {
            const icon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                icon.className = 'fas fa-eye';
            }
        });
    }

    // Generar contraseña segura
    const generateBtn = document.querySelector('.generate-password');
    if (generateBtn && passwordInput) {
        generateBtn.addEventListener('click', function() {
            const length = 12;
            const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
            let password = "";
            
            for (let i = 0; i < length; i++) {
                password += charset.charAt(Math.floor(Math.random() * charset.length));
            }
            
            passwordInput.value = password;
            passwordInput.type = 'text';
            
            // Cambiar icono del botón de mostrar/ocultar
            const icon = document.querySelector('.toggle-password-form i');
            if (icon) {
                icon.className = 'fas fa-eye-slash';
            }
        });
    }
});
</script>

<?php include 'views/templates/footer.php'; ?>