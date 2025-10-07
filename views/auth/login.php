<?php
// views/auth/login.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Agencia Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
        }
        .login-header {
            background: linear-gradient(135deg, #007bff, #6610f2);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 30px;
            text-align: center;
        }
        .login-body {
            padding: 30px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }
        .btn-login {
            background: linear-gradient(135deg, #007bff, #6610f2);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,123,255,.4);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <i class="fas fa-code fa-3x mb-3"></i>
            <h2>Agencia Web</h2>
            <p class="mb-0">Sistema de Gestión</p>
        </div>
        
        <div class="login-body">
            <?php if (isset($error) && !empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="POST" id="loginForm">
                <div class="mb-3">
                    <label for="username" class="form-label">
                        <i class="fas fa-user me-2"></i>Usuario
                    </label>
                    <input type="text" class="form-control" id="username" name="username" 
                           value="<?php echo $_POST['username'] ?? ''; ?>" 
                           required placeholder="Nombre de usuario">
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock me-2"></i>Contraseña
                    </label>
                    <input type="password" class="form-control" id="password" name="password" 
                           required placeholder="Tu contraseña">
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-login text-white">
                        <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                    </button>
                </div>
            </form>

            <!-- Información de prueba -->
            <div class="mt-4 p-3 bg-light rounded">
                <h6 class="text-center mb-3">
                    <i class="fas fa-info-circle me-2"></i>Usuarios de Prueba
                </h6>
                <?php
                // Mostrar usuarios disponibles para testing
                require_once 'config/database.php';
                $database = new Database();
                $db = $database->getConnection();
                
                $query = "SELECT username, email, password FROM usuarios WHERE activo = 1 LIMIT 3";
                $stmt = $db->prepare($query);
                $stmt->execute();
                $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                if ($usuarios): ?>
                    <div class="row">
                        <?php foreach ($usuarios as $usuario): ?>
                        <div class="col-12 mb-2">
                            <small class="text-muted">
                                <strong>Usuario:</strong> <?php echo $usuario['username']; ?> | 
                                <strong>Contraseña:</strong> <span class="text-success"><?php echo $usuario['password']; ?></span>
                            </small>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-center text-muted mb-0">No hay usuarios registrados</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            
            if (!username || !password) {
                e.preventDefault();
                alert('Por favor, completa todos los campos');
                return false;
            }
        });

        // Auto-focus en el campo de usuario
        document.getElementById('username').focus();
    </script>
</body>
</html>