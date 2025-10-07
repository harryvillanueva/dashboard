<?php
class CredencialHostingModel {
    private $conn;
    private $table_name = "credenciales_hosting";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crear($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                 (pagina_web_id, url_cpanel, usuario, password_encrypted, fecha_compra, fecha_caducidad, proveedor, plan_hosting) 
                 VALUES (:pagina_web_id, :url_cpanel, :usuario, :password_encrypted, :fecha_compra, :fecha_caducidad, :proveedor, :plan_hosting)";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    public function listar() {
        $query = "SELECT ch.*, pw.titulo as pagina_web_titulo 
                 FROM " . $this->table_name . " ch 
                 LEFT JOIN paginas_web pw ON ch.pagina_web_id = pw.id 
                 ORDER BY ch.fecha_caducidad DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT ch.*, pw.titulo as pagina_web_titulo 
                 FROM " . $this->table_name . " ch 
                 LEFT JOIN paginas_web pw ON ch.pagina_web_id = pw.id 
                 WHERE ch.id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $data) {
        $query = "UPDATE " . $this->table_name . " 
                 SET url_cpanel = :url_cpanel, usuario = :usuario, fecha_compra = :fecha_compra, 
                     fecha_caducidad = :fecha_caducidad, proveedor = :proveedor, plan_hosting = :plan_hosting 
                 WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function eliminar($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function obtenerPorPaginaWeb($pagina_web_id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE pagina_web_id = :pagina_web_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":pagina_web_id", $pagina_web_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>