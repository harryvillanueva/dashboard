<?php
class TemaModel {
    private $conn;
    private $table_name = "temas";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crear($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                 (nombre, archivo_path, version, descripcion, categoria) 
                 VALUES (:nombre, :archivo_path, :version, :descripcion, :categoria)";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    public function listar() {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE activo = 1 
                 ORDER BY nombre";
        
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

    public function actualizar($id, $data) {
        $query = "UPDATE " . $this->table_name . " 
                 SET nombre = :nombre, version = :version, descripcion = :descripcion, categoria = :categoria 
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
