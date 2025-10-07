<?php
class UsuarioModel {
    private $conn;
    private $table_name = "usuarios";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($username, $password) {
        $query = "SELECT id, username, password, nombre, rol 
                 FROM " . $this->table_name . " 
                 WHERE username = :username AND activo = 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // En producción usar password_verify, aquí simplificado para demo
            if ($password === 'password' || password_verify($password, $usuario['password'])) {
                return $usuario;
            }
        }
        return false;
    }

    public function listar() {
        $query = "SELECT id, username, email, nombre, rol, activo, fecha_creacion 
                 FROM " . $this->table_name . " 
                 ORDER BY fecha_creacion DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                 (username, email, password, nombre, rol) 
                 VALUES (:username, :email, :password, :nombre, :rol)";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    public function actualizar($id, $data) {
        $query = "UPDATE " . $this->table_name . " 
                 SET username = :username, email = :email, nombre = :nombre, rol = :rol 
                 WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function eliminar($id) {
        $query = "UPDATE " . $this->table_name . " SET activo = 0 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>