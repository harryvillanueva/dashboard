<?php
class UsuarioWordPressModel {
    private $conn;
    private $table_name = "usuarios_wordpress";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crear($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                 (pagina_web_id, username, email, password_encrypted, rol) 
                 VALUES (:pagina_web_id, :username, :email, :password_encrypted, :rol)";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    public function listar() {
        $query = "SELECT uw.*, pw.titulo as pagina_web_titulo 
                 FROM " . $this->table_name . " uw 
                 LEFT JOIN paginas_web pw ON uw.pagina_web_id = pw.id 
                 WHERE uw.activo = 1 
                 ORDER BY uw.username";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT uw.*, pw.titulo as pagina_web_titulo 
                 FROM " . $this->table_name . " uw 
                 LEFT JOIN paginas_web pw ON uw.pagina_web_id = pw.id 
                 WHERE uw.id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $data) {
        $query = "UPDATE " . $this->table_name . " 
                 SET username = :username, email = :email, rol = :rol 
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

    public function obtenerPorPaginaWeb($pagina_web_id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE pagina_web_id = :pagina_web_id AND activo = 1 
                 ORDER BY username";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":pagina_web_id", $pagina_web_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>