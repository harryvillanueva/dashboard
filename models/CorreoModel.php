<?php
class CorreoModel {
    private $conn;
    private $table_name = "correos";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crear($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                 (pagina_web_id, email, password_encrypted, quota, fecha_creacion) 
                 VALUES (:pagina_web_id, :email, :password_encrypted, :quota, :fecha_creacion)";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    public function listar() {
        $query = "SELECT c.*, pw.titulo as pagina_web_titulo 
                 FROM " . $this->table_name . " c 
                 LEFT JOIN paginas_web pw ON c.pagina_web_id = pw.id 
                 WHERE c.activo = 1 
                 ORDER BY c.email";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT c.*, pw.titulo as pagina_web_titulo 
                 FROM " . $this->table_name . " c 
                 LEFT JOIN paginas_web pw ON c.pagina_web_id = pw.id 
                 WHERE c.id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $data) {
        $query = "UPDATE " . $this->table_name . " 
                 SET email = :email, quota = :quota 
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
                 ORDER BY email";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":pagina_web_id", $pagina_web_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>