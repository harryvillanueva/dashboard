<?php
class FragmentoCodigoModel {
    private $conn;
    private $table_name = "fragmentos_codigo";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crear($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                 (titulo, codigo, lenguaje, categoria, descripcion, tags, usuario_id) 
                 VALUES (:titulo, :codigo, :lenguaje, :categoria, :descripcion, :tags, :usuario_id)";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    public function listar() {
        $query = "SELECT fc.*, u.nombre as usuario_nombre 
                 FROM " . $this->table_name . " fc 
                 LEFT JOIN usuarios u ON fc.usuario_id = u.id 
                 ORDER BY fc.fecha_creacion DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT fc.*, u.nombre as usuario_nombre 
                 FROM " . $this->table_name . " fc 
                 LEFT JOIN usuarios u ON fc.usuario_id = u.id 
                 WHERE fc.id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $data) {
        $query = "UPDATE " . $this->table_name . " 
                 SET titulo = :titulo, codigo = :codigo, lenguaje = :lenguaje, 
                     categoria = :categoria, descripcion = :descripcion, tags = :tags,
                     fecha_modificacion = NOW()
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

    public function buscar($termino) {
        $query = "SELECT fc.*, u.nombre as usuario_nombre 
                 FROM " . $this->table_name . " fc 
                 LEFT JOIN usuarios u ON fc.usuario_id = u.id 
                 WHERE titulo LIKE :termino OR descripcion LIKE :termino OR tags LIKE :termino OR lenguaje LIKE :termino
                 ORDER BY fecha_creacion DESC";
        
        $stmt = $this->conn->prepare($query);
        $termino = "%$termino%";
        $stmt->bindParam(":termino", $termino);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorCategoria($categoria) {
        $query = "SELECT fc.*, u.nombre as usuario_nombre 
                 FROM " . $this->table_name . " fc 
                 LEFT JOIN usuarios u ON fc.usuario_id = u.id 
                 WHERE categoria = :categoria 
                 ORDER BY titulo";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":categoria", $categoria);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorLenguaje($lenguaje) {
        $query = "SELECT fc.*, u.nombre as usuario_nombre 
                 FROM " . $this->table_name . " fc 
                 LEFT JOIN usuarios u ON fc.usuario_id = u.id 
                 WHERE lenguaje = :lenguaje 
                 ORDER BY titulo";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":lenguaje", $lenguaje);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerEstadisticas() {
        $query = "SELECT 
                    COUNT(*) as total_fragmentos,
                    COUNT(DISTINCT lenguaje) as total_lenguajes,
                    COUNT(DISTINCT categoria) as total_categorias,
                    MAX(fecha_creacion) as ultimo_fragmento
                 FROM " . $this->table_name;
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function incrementarCopias($id) {
        $query = "UPDATE " . $this->table_name . " 
                 SET copias = COALESCE(copias, 0) + 1 
                 WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>