<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Editar Credencial cPanel</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="index.php?controller=credenciales-hosting&action=listar">cPanel</a></li>
                        <li class="breadcrumb-item active">Editar Credencial</li>
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
                            <h3 class="card-title">Editando Credencial cPanel</h3>
                        </div>
                        <form action="index.php?controller=credenciales-hosting&action=editar&id=<?= $credencial['id'] ?>" method="POST">
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
                                                <?= ($_POST['pagina_web_id'] ?? $credencial['pagina_web_id']) == $pagina['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($pagina['titulo']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="proveedor">Proveedor de Hosting *</label>
                                    <input type="text" class="form-control" id="proveedor" name="proveedor" 
                                           value="<?= $_POST['proveedor'] ?? $credencial['proveedor'] ?>" required 
                                           placeholder="Ej: GoDaddy, Hostinger, SiteGround">
                                </div>

                                <div class="form-group">
                                    <label for="url_cpanel">URL cPanel *</label>
                                    <input type="url" class="form-control" id="url_cpanel" name="url_cpanel" 
                                           value="<?= $_POST['url_cpanel'] ?? $credencial['url_cpanel'] ?>" required 
                                           placeholder="https://cpanel.ejemplo.com">
                                </div>

                                <div class="form-group">
                                    <label for="usuario">Usuario cPanel *</label>
                                    <input type="text" class="form-control" id="usuario" name="usuario" 
                                           value="<?= $_POST['usuario'] ?? $credencial['usuario'] ?>" required 
                                           placeholder="Nombre de usuario del cPanel">
                                </div>

                                <div class="form-group">
                                    <label for="password">Contraseña cPanel</label>
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
                                    <label for="plan_hosting">Plan de Hosting</label>
                                    <input type="text" class="form-control" id="plan_hosting" name="plan_hosting" 
                                           value="<?= $_POST['plan_hosting'] ?? $credencial['plan_hosting'] ?>" 
                                           placeholder="Ej: Plan Básico, Plan Premium">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha_compra">Fecha de Compra</label>
                                            <input type="date" class="form-control" id="fecha_compra" name="fecha_compra" 
                                                   value="<?= $_POST['fecha_compra'] ?? $credencial['fecha_compra'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha_caducidad">Fecha de Caducidad *</label>
                                            <input type="date" class="form-control" id="fecha_caducidad" name="fecha_caducidad" 
                                                   value="<?= $_POST['fecha_caducidad'] ?? $credencial['fecha_caducidad'] ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Información actual (solo lectura) -->
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-info-circle"></i> Información Actual</h6>
                                    <p><strong>Usuario:</strong> <?= htmlspecialchars($credencial['usuario']) ?></p>
                                    <p><strong>URL cPanel:</strong> 
                                        <?php if (!empty($credencial['url_cpanel'])): ?>
                                            <a href="<?= $credencial['url_cpanel'] ?>" target="_blank"><?= $credencial['url_cpanel'] ?></a>
                                        <?php else: ?>
                                            No configurada
                                        <?php endif; ?>
                                    </p>
                                    <p><strong>Proveedor:</strong> <?= htmlspecialchars($credencial['proveedor'] ?? 'No especificado') ?></p>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Actualizar Credencial
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