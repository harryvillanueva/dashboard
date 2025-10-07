<?php
class PaginaWebModel {
    private $conn;
    private $table_name = "paginas_web";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crear($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                 (cliente_id, titulo, url, rubro, descripcion, imagen_path, fecha_creacion, fecha_vencimiento_hosting) 
                 VALUES (:cliente_id, :titulo, :url, :rubro, :descripcion, :imagen_path, :fecha_creacion, :fecha_vencimiento_hosting)";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute($data);
    }

    public function listar() {
        $query = "SELECT pw.*, c.nombre as cliente_nombre 
                 FROM " . $this->table_name . " pw 
                 LEFT JOIN clientes c ON pw.cliente_id = c.id 
                 WHERE pw.activo = 1 
                 ORDER BY pw.fecha_creacion DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT pw.*, c.nombre as cliente_nombre, c.email as cliente_email, c.telefono as cliente_telefono
                 FROM " . $this->table_name . " pw 
                 LEFT JOIN clientes c ON pw.cliente_id = c.id 
                 WHERE pw.id = :id AND pw.activo = 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $data) {
        $query = "UPDATE " . $this->table_name . " 
                 SET cliente_id = :cliente_id, titulo = :titulo, url = :url, rubro = :rubro, 
                     descripcion = :descripcion, imagen_path = :imagen_path, 
                     fecha_vencimiento_hosting = :fecha_vencimiento_hosting 
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