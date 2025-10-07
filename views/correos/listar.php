<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestión de Correos</h1>
                </div>
                <div class="col-sm-6">
                    <a href="index.php?controller=correos&action=crear" class="btn btn-success float-right">
                        <i class="fas fa-plus"></i> Nuevo Correo
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- Mostrar mensajes -->
            <?php if (isset($_GET['mensaje'])): 
                $mensaje = explode(':', $_GET['mensaje']);
                $tipo = $mensaje[0];
                $texto = $mensaje[1];
            ?>
                <div class="alert alert-<?= $tipo == 'success' ? 'success' : 'danger' ?> alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?= htmlspecialchars($texto) ?>
                </div>
            <?php endif; ?>

            <!-- Tabla de correos -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Lista de Correos</h3>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($correos)): ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Email</th>
                                                <th>Contraseña</th>
                                                <th>Cuota</th>
                                                <th>Sitio Web</th>
                                                <th>Enlace al Sitio</th>
                                                <th>Fecha Creación</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($correos as $correo): ?>
                                            <tr>
                                                <td>
                                                    <strong><?= htmlspecialchars($correo['email']) ?></strong>
                                                </td>
                                                <td>
                                                    <?php if (!empty($correo['password_encrypted'])): ?>
                                                        <div class="input-group input-group-sm">
                                                            <input type="password" class="form-control password-field" 
                                                                   value="<?= base64_decode($correo['password_encrypted']) ?>" 
                                                                   readonly id="password-<?= $correo['id'] ?>">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-outline-secondary toggle-password" 
                                                                        type="button" data-target="password-<?= $correo['id'] ?>">
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
                                                <td>
                                                    <span class="badge badge-info">
                                                        <?= htmlspecialchars($correo['quota'] ?? 'Ilimitada') ?>
                                                    </span>
                                                </td>
                                                <td><?= htmlspecialchars($correo['pagina_web_titulo'] ?? 'No asignado') ?></td>
                                                <td>
                                                    <?php 
                                                    // Obtener URL del sitio web
                                                    $url_sitio = '';
                                                    if (!empty($correo['pagina_web_id'])) {
                                                        // En una implementación real, deberías obtener esta información del modelo
                                                        $url_sitio = 'https://sitio' . $correo['pagina_web_id'] . '.com';
                                                    }
                                                    ?>
                                                    <?php if (!empty($url_sitio)): ?>
                                                        <a href="<?= $url_sitio ?>" target="_blank" 
                                                           class="btn btn-sm btn-outline-primary" title="Ir al sitio web">
                                                            <i class="fas fa-external-link-alt"></i> Visitar Sitio
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">No disponible</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= date('d/m/Y', strtotime($correo['fecha_creacion'])) ?></td>
                                                <td>
                                                    <span class="badge badge-<?= $correo['activo'] ? 'success' : 'secondary' ?>">
                                                        <?= $correo['activo'] ? 'Activo' : 'Inactivo' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="index.php?controller=correos&action=ver&id=<?= $correo['id'] ?>" 
                                                           class="btn btn-sm btn-info" title="Ver información completa">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="index.php?controller=correos&action=editar&id=<?= $correo['id'] ?>" 
                                                           class="btn btn-sm btn-warning" title="Editar correo">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="index.php?controller=correos&action=eliminar&id=<?= $correo['id'] ?>" 
                                                           class="btn btn-sm btn-danger" 
                                                           onclick="return confirm('¿Estás seguro de eliminar este correo?')"
                                                           title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info text-center">
                                    <h4><i class="icon fas fa-info"></i> No hay correos registrados</h4>
                                    <p>Comienza agregando tu primer correo.</p>
                                    <a href="index.php?controller=correos&action=crear" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Agregar Primer Correo
                                    </a>
                                </div>
                            <?php endif; ?>
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
                <strong>¡Copiado!</strong> Contraseña copiada al portapapeles.
            `;
            document.body.appendChild(toast);
            
            // Auto-eliminar después de 2 segundos
            setTimeout(() => {
                toast.remove();
            }, 2000);
        }).catch(function(err) {
            console.error('Error al copiar: ', err);
            alert('Error al copiar al portapapeles');
        });
    }

    // Botones de copiar
    document.querySelectorAll('.btn-copiar').forEach(btn => {
        btn.addEventListener('click', function() {
            const texto = this.getAttribute('data-text');
            copiarAlPortapapeles(texto);
        });
    });

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