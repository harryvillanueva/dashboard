<?php
// models/UsuarioModel.php
class UsuarioModel {
    private $conn;
    private $table_name = "usuarios";

    public $id;
    public $username;
    public $email;
    public $password;
    public $nombre;
    public $rol;
    public $activo;
    public $fecha_creacion;

    public function __construct($db) {
        $this->conn = $db;
    }

    // CREAR USUARIO - SIN ENCRIPTACIÓN
    public function crear() {
        try {
            $query = "INSERT INTO " . $this->table_name . " 
                     SET username = :username, email = :email, password = :password, 
                         nombre = :nombre, rol = :rol, activo = :activo";

            $stmt = $this->conn->prepare($query);

            // Contraseña en texto plano - SIN ENCRIPTACIÓN
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":password", $this->password); // Texto plano
            $stmt->bindParam(":nombre", $this->nombre);
            $stmt->bindParam(":rol", $this->rol);
            $stmt->bindParam(":activo", $this->activo);

            if ($stmt->execute()) {
                return true;
            } else {
                $errorInfo = $stmt->errorInfo();
                error_log("Error en execute: " . print_r($errorInfo, true));
                return false;
            }
        } catch (PDOException $exception) {
            error_log("Exception en crear: " . $exception->getMessage());
            return false;
        }
    }

    // LISTAR TODOS LOS USUARIOS
    public function listar() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY fecha_creacion DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // LEER UN USUARIO POR ID
    public function leerUno() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->username = $row['username'];
            $this->email = $row['email'];
            $this->password = $row['password']; // Texto plano
            $this->nombre = $row['nombre'];
            $this->rol = $row['rol'];
            $this->activo = $row['activo'];
            $this->fecha_creacion = $row['fecha_creacion'];
            return true;
        }
        return false;
    }

    // ACTUALIZAR USUARIO - SIN ENCRIPTACIÓN AUTOMÁTICA
    public function actualizar() {
        try {
            // Construir query dinámicamente dependiendo si hay nueva contraseña
            if (!empty($this->password)) {
                $query = "UPDATE " . $this->table_name . " 
                         SET username = :username, email = :email, nombre = :nombre, 
                             rol = :rol, activo = :activo, password = :password 
                         WHERE id = :id";
            } else {
                $query = "UPDATE " . $this->table_name . " 
                         SET username = :username, email = :email, nombre = :nombre, 
                             rol = :rol, activo = :activo 
                         WHERE id = :id";
            }

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":nombre", $this->nombre);
            $stmt->bindParam(":rol", $this->rol);
            $stmt->bindParam(":activo", $this->activo);
            $stmt->bindParam(":id", $this->id);

            // Si hay nueva contraseña, almacenar en texto plano
            if (!empty($this->password)) {
                $stmt->bindParam(":password", $this->password); // Texto plano
            }

            return $stmt->execute();
        } catch (PDOException $exception) {
            error_log("Error al actualizar usuario: " . $exception->getMessage());
            return false;
        }
    }

    // ELIMINAR USUARIO
    public function eliminar() {
        try {
            $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->id);
            return $stmt->execute();
        } catch (PDOException $exception) {
            error_log("Error al eliminar usuario: " . $exception->getMessage());
            return false;
        }
    }

    // BUSCAR USUARIO POR USERNAME (para login)
    public function buscarPorUsername($username) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = ? AND activo = 1 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $username);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // BUSCAR USUARIO POR EMAIL (mantener por compatibilidad)
    public function buscarPorEmail($email) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = ? AND activo = 1 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // VERIFICAR SI EMAIL EXISTE (excluyendo el usuario actual para edición)
    public function emailExiste($exclude_id = null) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = ?";
        $params = [$this->email];
        
        if ($exclude_id) {
            $query .= " AND id != ?";
            $params[] = $exclude_id;
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->rowCount() > 0;
    }

    // VERIFICAR SI USERNAME EXISTE (excluyendo el usuario actual para edición)
    public function usernameExiste($exclude_id = null) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE username = ?";
        $params = [$this->username];
        
        if ($exclude_id) {
            $query .= " AND id != ?";
            $params[] = $exclude_id;
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->rowCount() > 0;
    }

    // OBTENER ESTADÍSTICAS
    public function obtenerEstadisticas() {
        $query = "SELECT 
                    COUNT(*) as total,
                    SUM(activo = 1) as activos,
                    SUM(activo = 0) as inactivos,
                    SUM(rol = 'admin') as admins,
                    SUM(rol = 'editor') as editores,
                    SUM(rol = 'viewer') as viewers
                  FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ACTUALIZAR SOLO CONTRASEÑA - SIN ENCRIPTACIÓN
    public function actualizarPassword() {
        try {
            $query = "UPDATE " . $this->table_name . " 
                     SET password = :password 
                     WHERE id = :id";

            $stmt = $this->conn->prepare($query);

            // Contraseña en texto plano
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":id", $this->id);

            return $stmt->execute();
        } catch (PDOException $exception) {
            error_log("Error al actualizar password: " . $exception->getMessage());
            return false;
        }
    }

    // VERIFICAR CONTRASEÑA (para login) - COMPARACIÓN EN TEXTO PLANO
    public function verificarPassword($password_input) {
        // Comparación directa en texto plano
        return $password_input === $this->password;
    }
}
?>