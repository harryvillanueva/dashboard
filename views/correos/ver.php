<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Información de Correo</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="index.php?controller=correos&action=listar">Correos</a></li>
                        <li class="breadcrumb-item active">Ver Correo</li>
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
                            <h3 class="card-title">Correo: <?= htmlspecialchars($correo['email']) ?></h3>
                            <div class="card-tools">
                                <a href="index.php?controller=correos&action=editar&id=<?= $correo['id'] ?>" 
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
                                            <th width="40%">Dirección de Correo:</th>
                                            <td>
                                                <a href="mailto:<?= htmlspecialchars($correo['email']) ?>">
                                                    <?= htmlspecialchars($correo['email']) ?>
                                                </a>
                                                <button class="btn btn-sm btn-outline-secondary btn-copiar" 
                                                        data-text="<?= htmlspecialchars($correo['email']) ?>" 
                                                        title="Copiar email">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Contraseña:</th>
                                            <td>
                                                <?php if (!empty($correo['password_encrypted'])): ?>
                                                    <div class="input-group input-group-sm">
                                                        <input type="password" class="form-control" 
                                                               value="<?= base64_decode($correo['password_encrypted']) ?>" 
                                                               readonly id="password-view">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary toggle-password" 
                                                                    type="button" data-target="password-view">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            <button class="btn btn-outline-secondary btn-copiar" 
                                                                    data-text="<?= base64_decode($correo['password_encrypted']) ?>" 
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
                                            <th>Cuota:</th>
                                            <td>
                                                <span class="badge badge-info">
                                                    <?= htmlspecialchars($correo['quota'] ?? 'Ilimitada') ?>
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="40%">Sitio Web:</th>
                                            <td><?= htmlspecialchars($correo['pagina_web_titulo'] ?? 'No asignado') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Enlace al Sitio:</th>
                                            <td>
                                                <?php 
                                                // Obtener URL del sitio web
                                                $url_sitio = '';
                                                if (!empty($correo['pagina_web_id'])) {
                                                    $url_sitio = 'https://sitio' . $correo['pagina_web_id'] . '.com';
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
                                            <td><?= date('d/m/Y H:i', strtotime($correo['fecha_creacion'])) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Estado:</th>
                                            <td>
                                                <span class="badge badge-<?= $correo['activo'] ? 'success' : 'secondary' ?>">
                                                    <?= $correo['activo'] ? 'Activo' : 'Inactivo' ?>
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
                                                <button class="btn btn-outline-success btn-copiar-credenciales" 
                                                        data-email="<?= htmlspecialchars($correo['email']) ?>" 
                                                        data-password="<?= !empty($correo['password_encrypted']) ? base64_decode($correo['password_encrypted']) : '' ?>">
                                                    <i class="fas fa-copy"></i> Copiar Credenciales
                                                </button>
                                                <?php if (!empty($url_sitio)): ?>
                                                    <a href="<?= $url_sitio ?>/webmail" target="_blank" 
                                                       class="btn btn-outline-primary">
                                                        <i class="fas fa-envelope"></i> Acceder al Webmail
                                                    </a>
                                                <?php endif; ?>
                                                <a href="index.php?controller=correos&action=editar&id=<?= $correo['id'] ?>" 
                                                   class="btn btn-outline-warning">
                                                    <i class="fas fa-edit"></i> Editar Correo
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Información adicional -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="callout callout-info">
                                        <h5><i class="fas fa-info-circle"></i> Información del Servidor de Correo</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Servidor IMAP:</strong> mail.<?= !empty($url_sitio) ? parse_url($url_sitio, PHP_URL_HOST) : 'dominio.com' ?><br>
                                                <strong>Puerto IMAP:</strong> 993 (SSL)<br>
                                                <strong>Servidor SMTP:</strong> mail.<?= !empty($url_sitio) ? parse_url($url_sitio, PHP_URL_HOST) : 'dominio.com' ?>
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Puerto SMTP:</strong> 465 (SSL)<br>
                                                <strong>Autenticación:</strong> Requerida<br>
                                                <strong>Seguridad:</strong> SSL/TLS
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="index.php?controller=correos&action=listar" class="btn btn-default">
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
            const email = this.getAttribute('data-email');
            const password = this.getAttribute('data-password');
            const credenciales = `Email: ${email}\nContraseña: ${password}\n\nConfiguración IMAP/SMTP:\nServidor IMAP: mail.${email.split('@')[1]}\nPuerto IMAP: 993\nServidor SMTP: mail.${email.split('@')[1]}\nPuerto SMTP: 465`;
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