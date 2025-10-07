<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Buscar Clientes</h1>
                </div>
                <div class="col-sm-6">
                    <a href="index.php?controller=clientes&action=listar" class="btn btn-default float-right">
                        <i class="fas fa-arrow-left"></i> Volver a la lista
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- Barra de búsqueda -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Búsqueda de Clientes</h3>
                        </div>
                        <div class="card-body">
                            <form action="index.php?controller=clientes&action=buscar" method="GET" class="form-inline">
                                <input type="hidden" name="controller" value="clientes">
                                <input type="hidden" name="action" value="buscar">
                                <div class="input-group" style="width: 100%;">
                                    <input type="text" name="q" class="form-control" 
                                           placeholder="Buscar clientes por nombre, email, empresa o teléfono..." 
                                           value="<?= htmlspecialchars($termino) ?>" required>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Buscar
                                        </button>
                                        <a href="index.php?controller=clientes&action=listar" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Limpiar
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resultados de búsqueda -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Resultados de la búsqueda 
                                <?php if (!empty($termino)): ?>
                                    para: "<strong><?= htmlspecialchars($termino) ?></strong>"
                                <?php endif; ?>
                            </h3>
                            <div class="card-tools">
                                <span class="badge badge-primary">
                                    <?= count($clientes) ?> resultado(s) encontrado(s)
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($clientes)): ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Email</th>
                                                <th>Teléfono</th>
                                                <th>Empresa</th>
                                                <th>Fecha Registro</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($clientes as $cliente): ?>
                                            <tr>
                                                <td><?= $cliente['id'] ?></td>
                                                <td>
                                                    <strong><?= htmlspecialchars($cliente['nombre']) ?></strong>
                                                    <?php if (!empty($cliente['direccion'])): ?>
                                                        <br><small class="text-muted"><?= htmlspecialchars(substr($cliente['direccion'], 0, 50)) ?>...</small>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($cliente['email'])): ?>
                                                        <a href="mailto:<?= $cliente['email'] ?>">
                                                            <?= htmlspecialchars($cliente['email']) ?>
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">No especificado</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($cliente['telefono'])): ?>
                                                        <a href="tel:<?= $cliente['telefono'] ?>">
                                                            <?= htmlspecialchars($cliente['telefono']) ?>
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">No especificado</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?= !empty($cliente['empresa']) ? htmlspecialchars($cliente['empresa']) : '<span class="text-muted">No especificada</span>' ?>
                                                </td>
                                                <td><?= date('d/m/Y', strtotime($cliente['fecha_registro'])) ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="index.php?controller=clientes&action=ver&id=<?= $cliente['id'] ?>" 
                                                           class="btn btn-sm btn-info" title="Ver detalle">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="index.php?controller=clientes&action=editar&id=<?= $cliente['id'] ?>" 
                                                           class="btn btn-sm btn-warning" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="index.php?controller=clientes&action=eliminar&id=<?= $cliente['id'] ?>" 
                                                           class="btn btn-sm btn-danger" 
                                                           onclick="return confirm('¿Estás seguro de eliminar este cliente?')"
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
                                <?php if (!empty($termino)): ?>
                                    <div class="alert alert-warning text-center">
                                        <h4><i class="icon fas fa-exclamation-triangle"></i> No se encontraron resultados</h4>
                                        <p>No se encontraron clientes que coincidan con "<strong><?= htmlspecialchars($termino) ?></strong>"</p>
                                        <div class="mt-3">
                                            <a href="index.php?controller=clientes&action=crear" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Crear Nuevo Cliente
                                            </a>
                                            <a href="index.php?controller=clientes&action=listar" class="btn btn-default">
                                                <i class="fas fa-list"></i> Ver Todos los Clientes
                                            </a>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-info text-center">
                                        <h4><i class="icon fas fa-info"></i> Realiza una búsqueda</h4>
                                        <p>Ingresa un término en el campo de búsqueda para encontrar clientes.</p>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sugerencias de búsqueda -->
            <?php if (empty($clientes) && !empty($termino)): ?>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-lightbulb"></i> Sugerencias de búsqueda
                            </h5>
                        </div>
                        <div class="card-body">
                            <ul class="mb-0">
                                <li>Verifica que los términos de búsqueda estén escritos correctamente</li>
                                <li>Prueba con palabras clave más generales</li>
                                <li>Busca por nombre, email, empresa o teléfono</li>
                                <li>Si el cliente no existe, puedes <a href="index.php?controller=clientes&action=crear">crearlo aquí</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php include 'views/templates/footer.php'; ?>