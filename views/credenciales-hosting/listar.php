<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Usuarios cPanel</h1>
                </div>
                <div class="col-sm-6">
                    <a href="index.php?controller=credenciales-hosting&action=crear" class="btn btn-success float-right">
                        <i class="fas fa-plus"></i> Nueva Credencial cPanel
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

            <!-- Tabla de credenciales cPanel -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Lista de Credenciales cPanel</h3>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($credenciales)): ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Título</th>
                                                <th>Cliente</th>
                                                <th>URL</th>
                                                <th>Usuario cPanel</th>
                                                <th>Contraseña cPanel</th>
                                                <th>Enlace cPanel</th>
                                                <th>Fecha Creación</th>
                                                <th>Estado Hosting</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($credenciales as $credencial): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($credencial['pagina_web_titulo'] ?? 'No asignado') ?></td>
                                                <td>
                                                    <?php 
                                                    // Obtener nombre del cliente desde la página web
                                                    $cliente_nombre = 'No asignado';
                                                    if (!empty($credencial['pagina_web_id'])) {
                                                        // En una implementación real, deberías tener esta información en el modelo
                                                        // Por ahora usamos un placeholder
                                                        $cliente_nombre = 'Cliente ' . $credencial['pagina_web_id'];
                                                    }
                                                    ?>
                                                    <?= htmlspecialchars($cliente_nombre) ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($credencial['url_cpanel'])): ?>
                                                        <a href="<?= $credencial['url_cpanel'] ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                                            <i class="fas fa-external-link-alt"></i> URL
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">No disponible</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <code><?= htmlspecialchars($credencial['usuario']) ?></code>
                                                    <button class="btn btn-sm btn-outline-secondary btn-copiar" data-text="<?= htmlspecialchars($credencial['usuario']) ?>" title="Copiar usuario">
                                                        <i class="fas fa-copy"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <?php if (!empty($credencial['password_encrypted'])): ?>
                                                        <div class="input-group input-group-sm">
                                                            <input type="password" class="form-control password-field" 
                                                                   value="<?= base64_decode($credencial['password_encrypted']) ?>" 
                                                                   readonly id="password-<?= $credencial['id'] ?>">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-outline-secondary toggle-password" 
                                                                        type="button" data-target="password-<?= $credencial['id'] ?>">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                                <button class="btn btn-outline-secondary btn-copiar" 
                                                                        data-text="<?= base64_decode($credencial['password_encrypted']) ?>" 
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
                                                    <?php if (!empty($credencial['url_cpanel'])): ?>
                                                        <a href="<?= $credencial['url_cpanel'] ?>" target="_blank" 
                                                           class="btn btn-sm btn-primary" title="Acceder al cPanel">
                                                            <i class="fas fa-sign-in-alt"></i> Acceder cPanel
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">No disponible</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($credencial['fecha_compra'])): ?>
                                                        <?= date('d/m/Y', strtotime($credencial['fecha_compra'])) ?>
                                                    <?php else: ?>
                                                        <span class="text-muted">No especificada</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    if (!empty($credencial['fecha_caducidad'])) {
                                                        $fecha_cad = new DateTime($credencial['fecha_caducidad']);
                                                        $hoy = new DateTime();
                                                        $dias_restantes = $hoy->diff($fecha_cad)->days;
                                                        
                                                        if ($fecha_cad < $hoy) {
                                                            $clase = 'danger';
                                                            $texto = 'Vencido';
                                                        } elseif ($dias_restantes <= 30) {
                                                            $clase = 'warning';
                                                            $texto = 'Próximo a vencer';
                                                        } else {
                                                            $clase = 'success';
                                                            $texto = 'Activo';
                                                        }
                                                    ?>
                                                        <span class="badge badge-<?= $clase ?>">
                                                            <?= $credencial['fecha_caducidad'] ?>
                                                        </span>
                                                        <br>
                                                        <small class="text-<?= $clase ?>">
                                                            <?= $dias_restantes ?> días
                                                        </small>
                                                    <?php } else { ?>
                                                        <span class="badge badge-secondary">No especificada</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="index.php?controller=credenciales-hosting&action=editar&id=<?= $credencial['id'] ?>" 
                                                           class="btn btn-sm btn-warning" title="Editar credencial">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="index.php?controller=credenciales-hosting&action=eliminar&id=<?= $credencial['id'] ?>" 
                                                           class="btn btn-sm btn-danger" 
                                                           onclick="return confirm('¿Estás seguro de eliminar esta credencial de cPanel?')"
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
                                    <h4><i class="icon fas fa-info"></i> No hay credenciales de cPanel registradas</h4>
                                    <p>Comienza agregando tu primera credencial de cPanel.</p>
                                    <a href="index.php?controller=credenciales-hosting&action=crear" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Agregar Primera Credencial
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
                <strong>¡Copiado!</strong> Texto copiado al portapapeles.
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