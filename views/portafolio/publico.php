<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portafolio - Nuestros Proyectos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .portfolio-item {
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }
        .portfolio-item:hover {
            transform: translateY(-5px);
        }
        .portfolio-card {
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            height: 100%;
        }
        .portfolio-image {
            height: 200px;
            object-fit: cover;
        }
        .badge-rubro {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>
<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="index.php?controller=portafolio" class="navbar-brand">
                    <i class="fas fa-code"></i>
                    <span class="brand-text font-weight-bold">Nuestra Agencia</span>
                </a>
                
                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <!-- Content -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-12 text-center">
                            <h1 class="m-0">Nuestro Portafolio</h1>
                            <p class="lead">Descubre algunos de nuestros proyectos más recientes</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container">
                    <div class="row">
                        <?php if (!empty($paginas)): ?>
                            <?php foreach ($paginas as $pagina): ?>
                            <div class="col-lg-4 col-md-6 portfolio-item">
                                <div class="card portfolio-card">
                                    <?php if ($pagina['imagen_path']): ?>
                                        <img src="<?= $pagina['imagen_path'] ?>" class="card-img-top portfolio-image" alt="<?= htmlspecialchars($pagina['titulo']) ?>">
                                    <?php else: ?>
                                        <div class="card-img-top portfolio-image bg-secondary d-flex align-items-center justify-content-center">
                                            <i class="fas fa-image fa-3x text-white"></i>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <span class="badge badge-primary badge-rubro"><?= htmlspecialchars($pagina['rubro'] ?? 'Web') ?></span>
                                    
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($pagina['titulo']) ?></h5>
                                        <?php if (!empty($pagina['descripcion'])): ?>
                                            <p class="card-text"><?= htmlspecialchars(substr($pagina['descripcion'], 0, 100)) ?>...</p>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($pagina['url'])): ?>
                                            <a href="<?= $pagina['url'] ?>" target="_blank" class="btn btn-primary btn-block">
                                                <i class="fas fa-external-link-alt"></i> Visitar Sitio
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-secondary btn-block" disabled>
                                                <i class="fas fa-eye"></i> Próximamente
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 text-center">
                                <div class="alert alert-info">
                                    <h4><i class="icon fas fa-info"></i> Portafolio en construcción</h4>
                                    <p>Estamos trabajando en nuevos proyectos. ¡Vuelve pronto!</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="container">
                <div class="float-right d-none d-sm-inline">
                    Desarrollado con <i class="fas fa-heart text-danger"></i>
                </div>
                <strong>Copyright &copy; <?= date('Y') ?> Nuestra Agencia.</strong> Todos los derechos reservados.
            </div>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>