<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Nuevo Cliente</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="index.php?controller=clientes&action=listar">Clientes</a></li>
                        <li class="breadcrumb-item active">Nuevo Cliente</li>
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
                            <h3 class="card-title">Información del Cliente</h3>
                        </div>
                        <form action="index.php?controller=clientes&action=crear" method="POST">
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
                                    <label for="nombre">Nombre completo *</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" 
                                           value="<?= $_POST['nombre'] ?? '' ?>" required 
                                           placeholder="Ingrese el nombre completo del cliente">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?= $_POST['email'] ?? '' ?>" 
                                           placeholder="correo@ejemplo.com">
                                </div>

                                <div class="form-group">
                                    <label for="telefono">Teléfono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" 
                                           value="<?= $_POST['telefono'] ?? '' ?>" 
                                           placeholder="+1 234 567 8900">
                                </div>

                                <div class="form-group">
                                    <label for="empresa">Empresa</label>
                                    <input type="text" class="form-control" id="empresa" name="empresa" 
                                           value="<?= $_POST['empresa'] ?? '' ?>" 
                                           placeholder="Nombre de la empresa">
                                </div>

                                <div class="form-group">
                                    <label for="direccion">Dirección</label>
                                    <textarea class="form-control" id="direccion" name="direccion" 
                                              rows="3" placeholder="Dirección completa"><?= $_POST['direccion'] ?? '' ?></textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Guardar Cliente
                                </button>
                                <a href="index.php?controller=clientes&action=listar" class="btn btn-default">
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