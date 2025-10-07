</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
$(document).ready(function() {
    // Inicializar tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Confirmación para eliminar
    $('.btn-danger').on('click', function(e) {
        if (!confirm('¿Estás seguro de que deseas eliminar este elemento?')) {
            e.preventDefault();
        }
    });

    // Toggle theme functionality
    $('#toggleTheme').on('click', function() {
        const currentTheme = $('body').attr('data-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        
        // Cambiar el tema en el body
        $('body').attr('data-theme', newTheme);
        
        // Guardar preferencia en cookie (expira en 30 días)
        const date = new Date();
        date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
        document.cookie = `theme=${newTheme}; expires=${date.toUTCString()}; path=/`;
        
        // Mostrar notificación del cambio
        showThemeNotification(newTheme);
    });

    function showThemeNotification(theme) {
        // Remover notificación anterior si existe
        $('.theme-notification').remove();
        
        const themeName = theme === 'dark' ? 'oscuro' : 'claro';
        const icon = theme === 'dark' ? 'moon' : 'sun';
        
        const notification = $(`
            <div class="theme-notification alert alert-success alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><i class="fas fa-${icon}"></i> Tema cambiado</strong><br>
                Modo ${themeName} activado
            </div>
        `);
        
        $('body').append(notification);
        
        // Auto-eliminar después de 3 segundos
        setTimeout(() => {
            notification.alert('close');
        }, 3000);
    }

    // Detectar preferencia del sistema
    function detectSystemTheme() {
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            return 'dark';
        }
        return 'light';
    }

    // Aplicar tema del sistema si no hay preferencia guardada
    if (!document.cookie.includes('theme=')) {
        const systemTheme = detectSystemTheme();
        if (systemTheme === 'dark') {
            $('body').attr('data-theme', 'dark');
            document.cookie = `theme=dark; path=/`;
        }
    }

    // Escuchar cambios en la preferencia del sistema
    if (window.matchMedia) {
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (!document.cookie.includes('theme=')) {
                const newTheme = e.matches ? 'dark' : 'light';
                $('body').attr('data-theme', newTheme);
                document.cookie = `theme=${newTheme}; path=/`;
            }
        });
    }
});
</script>

</body>
</html>