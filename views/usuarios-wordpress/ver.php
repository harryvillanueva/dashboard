<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Información de Usuario WordPress</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="index.php?controller=usuarios-wordpress&action=listar">Usuarios WordPress</a></li>
                        <li class="breadcrumb-item active">Ver Usuario</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Usuario: <?= htmlspecialchars($usuario['username']) ?></h3>
                            <div class="card-tools">
                                <a href="index.php?controller=usuarios-wordpress&action=editar&id=<?= $usuario['id'] ?>" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="40%">Nombre de Usuario:</th>
                                            <td>
                                                <code><?= htmlspecialchars($usuario['username']) ?></code>
                                                <button class="btn btn-sm btn-outline-secondary btn-copiar" 
                                                        data-text="<?= htmlspecialchars($usuario['username']) ?>" 
                                                        title="Copiar usuario">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Email:</th>
                                            <td>
                                                <a href="mailto:<?= htmlspecialchars($usuario['email']) ?>">
                                                    <?= htmlspecialchars($usuario['email']) ?>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Contraseña:</th>
                                            <td>
                                                <?php if (!empty($usuario['password_encrypted'])): ?>
                                                    <div class="input-group input-group-sm">
                                                        <input type="password" class="form-control" 
                                                               value="<?= base64_decode($usuario['password_encrypted']) ?>" 
                                                               readonly id="password-view">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary toggle-password" 
                                                                    type="button" data-target="password-view">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            <button class="btn btn-outline-secondary btn-copiar" 
                                                                    data-text="<?= base64_decode($usuario['password_encrypted']) ?>" 
                                                                    title="Copiar contraseña">
                                                                <i class="fas fa-copy"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted">No configurada</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Rol:</th>
                                            <td>
                                                <span class="badge badge-<?= 
                                                    $usuario['rol'] == 'administrator' ? 'danger' : 
                                                    ($usuario['rol'] == 'editor' ? 'warning' : 
                                                    ($usuario['rol'] == 'author' ? 'info' : 
                                                    ($usuario['rol'] == 'contributor' ? 'primary' : 'secondary'))) 
                                                ?>">
                                                    <?= ucfirst($usuario['rol']) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="40%">Sitio Web:</th>
                                            <td><?= htmlspecialchars($usuario['pagina_web_titulo'] ?? 'No asignado') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Enlace al Sitio:</th>
                                            <td>
                                                <?php 
                                                // Obtener URL del sitio web
                                                $url_sitio = '';
                                                if (!empty($usuario['pagina_web_id'])) {
                                                    $url_sitio = 'https://sitio' . $usuario['pagina_web_id'] . '.com';
                                                }
                                                ?>
                                                <?php if (!empty($url_sitio)): ?>
                                                    <a href="<?= $url_sitio ?>" target="_blank" 
                                                       class="btn btn-sm btn-primary">
                                                        <i class="fas fa-external-link-alt"></i> Ir al Sitio Web
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">No disponible</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Fecha Creación:</th>
                                            <td><?= date('d/m/Y H:i', strtotime($usuario['fecha_creacion'])) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Estado:</th>
                                            <td>
                                                <span class="badge badge-<?= $usuario['activo'] ? 'success' : 'secondary' ?>">
                                                    <?= $usuario['activo'] ? 'Activo' : 'Inactivo' ?>
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Acciones rápidas -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-bolt"></i> Acciones Rápidas
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="btn-group">
                                                <?php if (!empty($url_sitio)): ?>
                                                    <a href="<?= $url_sitio ?>/wp-admin" target="_blank" 
                                                       class="btn btn-outline-primary">
                                                        <i class="fas fa-sign-in-alt"></i> Acceder al WordPress
                                                    </a>
                                                <?php endif; ?>
                                                <button class="btn btn-outline-success btn-copiar-credenciales" 
                                                        data-usuario="<?= htmlspecialchars($usuario['username']) ?>" 
                                                        data-password="<?= !empty($usuario['password_encrypted']) ? base64_decode($usuario['password_encrypted']) : '' ?>">
                                                    <i class="fas fa-copy"></i> Copiar Credenciales
                                                </button>
                                                <a href="index.php?controller=usuarios-wordpress&action=editar&id=<?= $usuario['id'] ?>" 
                                                   class="btn btn-outline-warning">
                                                    <i class="fas fa-edit"></i> Editar Usuario
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="index.php?controller=usuarios-wordpress&action=listar" class="btn btn-default">
                                <i class="fas fa-arrow-left"></i> Volver a la lista
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Función para copiar texto al portapapeles
    function copiarAlPortapapeles(texto) {
        navigator.clipboard.writeText(texto).then(function() {
            // Mostrar notificación de éxito
            const toast = document.createElement('div');
            toast.className = 'alert alert-success alert-dismissible fade show position-fixed';
            toast.style.top = '20px';
            toast.style.right = '20px';
            toast.style.zIndex = '9999';
            toast.innerHTML = `
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>¡Copiado!</strong> Texto copiado al portapapeles.
            `;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 2000);
        }).catch(function(err) {
            console.error('Error al copiar: ', err);
            alert('Error al copiar al portapapeles');
        });
    }

    // Botones de copiar individuales
    document.querySelectorAll('.btn-copiar').forEach(btn => {
        btn.addEventListener('click', function() {
            const texto = this.getAttribute('data-text');
            copiarAlPortapapeles(texto);
        });
    });

    // Copiar credenciales completas
    const btnCopiarCredenciales = document.querySelector('.btn-copiar-credenciales');
    if (btnCopiarCredenciales) {
        btnCopiarCredenciales.addEventListener('click', function() {
            const usuario = this.getAttribute('data-usuario');
            const password = this.getAttribute('data-password');
            const credenciales = `Usuario: ${usuario}\nContraseña: ${password}`;
            copiarAlPortapapeles(credenciales);
        });
    }

    // Mostrar/ocultar contraseña
    document.querySelectorAll('.toggle-password').forEach(btn => {
        btn.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
            }
        });
    });
});
</script>

<?php include 'views/templates/footer.php'; ?>