<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Editar Correo</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="index.php?controller=correos&action=listar">Correos</a></li>
                        <li class="breadcrumb-item active">Editar Correo</li>
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
                            <h3 class="card-title">Editando: <?= htmlspecialchars($correo['email']) ?></h3>
                        </div>
                        <form action="index.php?controller=correos&action=editar&id=<?= $correo['id'] ?>" method="POST">
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
                                                <?= ($_POST['pagina_web_id'] ?? $correo['pagina_web_id']) == $pagina['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($pagina['titulo']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="email">Dirección de Correo *</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?= $_POST['email'] ?? $correo['email'] ?>" required 
                                           placeholder="usuario@dominio.com">
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
                                    <label for="quota">Cuota de Almacenamiento</label>
                                    <select class="form-control" id="quota" name="quota">
                                        <option value="100 MB" <?= ($_POST['quota'] ?? $correo['quota']) == '100 MB' ? 'selected' : '' ?>>100 MB</option>
                                        <option value="500 MB" <?= ($_POST['quota'] ?? $correo['quota']) == '500 MB' ? 'selected' : '' ?>>500 MB</option>
                                        <option value="1 GB" <?= ($_POST['quota'] ?? $correo['quota']) == '1 GB' ? 'selected' : '' ?>>1 GB</option>
                                        <option value="2 GB" <?= ($_POST['quota'] ?? $correo['quota']) == '2 GB' ? 'selected' : '' ?>>2 GB</option>
                                        <option value="5 GB" <?= ($_POST['quota'] ?? $correo['quota']) == '5 GB' ? 'selected' : '' ?>>5 GB</option>
                                        <option value="10 GB" <?= ($_POST['quota'] ?? $correo['quota']) == '10 GB' ? 'selected' : '' ?>>10 GB</option>
                                        <option value="Ilimitada" <?= ($_POST['quota'] ?? $correo['quota']) == 'Ilimitada' ? 'selected' : '' ?>>Ilimitada</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="fecha_creacion">Fecha de Creación</label>
                                    <input type="date" class="form-control" id="fecha_creacion" name="fecha_creacion" 
                                           value="<?= $_POST['fecha_creacion'] ?? $correo['fecha_creacion'] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="activo">Estado</label>
                                    <select class="form-control" id="activo" name="activo">
                                        <option value="1" <?= ($_POST['activo'] ?? $correo['activo']) ? 'selected' : '' ?>>Activo</option>
                                        <option value="0" <?= !($_POST['activo'] ?? $correo['activo']) ? 'selected' : '' ?>>Inactivo</option>
                                    </select>
                                </div>

                                <!-- Información actual -->
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-info-circle"></i> Información Actual</h6>
                                    <p><strong>Email:</strong> <?= htmlspecialchars($correo['email']) ?></p>
                                    <p><strong>Cuota:</strong> <?= htmlspecialchars($correo['quota'] ?? 'Ilimitada') ?></p>
                                    <p><strong>Estado:</strong> <?= $correo['activo'] ? 'Activo' : 'Inactivo' ?></p>
                                    <p><strong>Fecha creación:</strong> <?= date('d/m/Y H:i', strtotime($correo['fecha_creacion'])) ?></p>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Actualizar Correo
                                </button>
                                <a href="index.php?controller=correos&action=ver&id=<?= $correo['id'] ?>" class="btn btn-info">
                                    <i class="fas fa-eye"></i> Ver Correo
                                </a>
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