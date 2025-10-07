<?php
// views/templates/sidebar.php
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index.php" class="brand-link">
        <i class="fas fa-code brand-icon"></i>
        <span class="brand-text font-weight-light">Agencia Web</span>
    </a>

    <div class="sidebar">
        <!-- Botón de toggle theme en el sidebar -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-center">
            <button class="btn-toggle-theme" id="toggleTheme" title="Cambiar tema">
                <i class="fas fa-moon theme-icon moon"></i>
                <i class="fas fa-sun theme-icon sun"></i>
            </button>
        </div>

        <!-- Información del usuario logueado -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <div class="user-avatar-small">
                    <?php 
                    $inicial = isset($_SESSION['usuario_nombre']) ? strtoupper(substr($_SESSION['usuario_nombre'], 0, 1)) : 'U';
                    echo $inicial;
                    ?>
                </div>
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    <?php echo $_SESSION['usuario_nombre'] ?? 'Usuario'; ?>
                </a>
                <small class="text-muted">
                    <?php echo ucfirst($_SESSION['usuario_rol'] ?? 'user'); ?>
                </small>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a href="index.php" class="nav-link <?php echo (!isset($_GET['controller']) || $_GET['controller'] == 'dashboard') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="index.php?controller=paginas-web" class="nav-link <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'paginas-web') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-globe"></i>
                        <p>Gestión de Páginas Web</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="index.php?controller=clientes" class="nav-link <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'clientes') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Gestión de Clientes</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="index.php?controller=credenciales-hosting" class="nav-link <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'credenciales-hosting') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-server"></i>
                        <p>Usuarios cPanel</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="index.php?controller=plugins" class="nav-link <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'plugins') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-plug"></i>
                        <p>Gestión de Plugins</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="index.php?controller=temas" class="nav-link <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'temas') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-paint-brush"></i>
                        <p>Gestión de Temas</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="index.php?controller=fragmentos-codigo" class="nav-link <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'fragmentos-codigo') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-code"></i>
                        <p>Gestión de Códigos</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="index.php?controller=usuarios-wordpress" class="nav-link <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'usuarios-wordpress') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>Usuarios WordPress</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="index.php?controller=correos" class="nav-link <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'correos') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>Gestión de Correos</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="index.php?controller=backups" class="nav-link <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'backups') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-database"></i>
                        <p>Gestión de Backups</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="index.php?controller=usuarios&action=listar" class="nav-link <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'usuario') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>Usuarios Sistema</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="index.php?controller=portafolio" class="nav-link <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'portafolio') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-folder"></i>
                        <p>Ver Portfolio</p>
                    </a>
                </li>

                <!-- Separador -->
                <li class="nav-header mt-3">CUENTA</li>

                <li class="nav-item">
                    <a href="index.php?controller=usuarios&action=perfil" class="nav-link <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'usuarios' && isset($_GET['action']) && $_GET['action'] == 'perfil') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-user-edit"></i>
                        <p>Mi Perfil</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="index.php?controller=auth&action=logout" class="nav-link text-danger" onclick="return confirm('¿Estás seguro de que deseas cerrar sesión?')">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Cerrar Sesión</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<style>
/* Estilos para el sidebar */
.main-sidebar {
    background-color: #343a40 !important;
    min-height: 100vh;
}

.brand-link {
    border-bottom: 1px solid #4b545c;
}

.brand-icon {
    font-size: 1.5rem;
}

.brand-text {
    font-weight: 300;
}

.sidebar {
    height: calc(100vh - 4rem);
}

.nav-sidebar > .nav-item > .nav-link {
    color: #c2c7d0;
    margin: 0.1rem 0.5rem;
    border-radius: 0.25rem;
}

.nav-sidebar > .nav-item > .nav-link:hover {
    background-color: #4b545c;
    color: #fff;
}

.nav-sidebar > .nav-item > .nav-link.active {
    background-color: #007bff;
    color: #fff;
}

.nav-sidebar .nav-icon {
    margin-right: 0.5rem;
    width: 1.2rem;
    text-align: center;
}

/* Estilos para el botón de tema */
.btn-toggle-theme {
    background: none;
    border: 2px solid #6c757d;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    color: #6c757d;
    cursor: pointer;
    position: relative;
    transition: all 0.3s ease;
}

.btn-toggle-theme:hover {
    border-color: #007bff;
    color: #007bff;
    transform: scale(1.1);
}

.theme-icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    transition: opacity 0.3s ease;
}

.theme-icon.sun {
    opacity: 0;
}

.theme-icon.moon {
    opacity: 1;
}

/* Avatar del usuario */
.user-avatar-small {
    width: 40px;
    height: 40px;
    background: linear-gradient(45deg, #28a745, #20c997);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 1.2rem;
}

.user-panel .info {
    margin-left: 10px;
}

.user-panel .info a {
    color: #fff;
    text-decoration: none;
}

.user-panel .info small {
    font-size: 0.8rem;
}

/* Separador */
.nav-header {
    padding: 0.5rem 1rem;
    font-size: 0.8rem;
    color: #6c757d;
    text-transform: uppercase;
    font-weight: bold;
}

/* Enlace de cerrar sesión */
.nav-link.text-danger {
    color: #dc3545 !important;
}

.nav-link.text-danger:hover {
    background-color: #dc3545 !important;
    color: white !important;
}

/* Para modo claro */
body.light-theme .btn-toggle-theme .theme-icon.sun {
    opacity: 1;
}

body.light-theme .btn-toggle-theme .theme-icon.moon {
    opacity: 0;
}

/* Responsive */
@media (max-width: 767.98px) {
    .main-sidebar {
        position: fixed;
        z-index: 1030;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    
    .main-sidebar.show {
        transform: translateX(0);
    }
}
</style>

<script>
// Toggle theme functionality
document.addEventListener('DOMContentLoaded', function() {
    const toggleThemeBtn = document.getElementById('toggleTheme');
    const body = document.body;
    
    // Check for saved theme preference or default to dark
    const currentTheme = localStorage.getItem('theme') || 'dark';
    
    // Apply the saved theme
    if (currentTheme === 'light') {
        body.classList.add('light-theme');
    }
    
    toggleThemeBtn.addEventListener('click', function() {
        body.classList.toggle('light-theme');
        
        // Save theme preference
        const theme = body.classList.contains('light-theme') ? 'light' : 'dark';
        localStorage.setItem('theme', theme);
    });

    // Confirmación para cerrar sesión
    const logoutLinks = document.querySelectorAll('a[href*="logout"]');
    logoutLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (!confirm('¿Estás seguro de que deseas cerrar sesión?')) {
                e.preventDefault();
            }
        });
    });
});
</script>