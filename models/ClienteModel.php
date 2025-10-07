<?php
class ClienteModel {
    private $conn;
    private $table_name = "clientes";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear nuevo cliente
    public function crear($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                 (nombre, email, telefono, empresa, direccion) 
                 VALUES (:nombre, :email, :telefono, :empresa, :direccion)";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    // Listar todos los clientes activos
    public function listar() {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE activo = 1 
                 ORDER BY fecha_registro DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener cliente por ID
    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE id = :id AND activo = 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar cliente
    public function actualizar($id, $data) {
        $query = "UPDATE " . $this->table_name . " 
                 SET nombre = :nombre, email = :email, telefono = :telefono, 
                     empresa = :empresa, direccion = :direccion 
                 WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $data['id'] = $id;
        
        return $stmt->execute($data);
    }

    // Eliminar cliente (borrado lógico)
    public function eliminar($id) {
        $query = "UPDATE " . $this->table_name . " 
                 SET activo = 0 
                 WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        
        return $stmt->execute();
    }

    // Buscar clientes
    public function buscar($termino) {
    $query = "SELECT * FROM " . $this->table_name . " 
             WHERE (nombre LIKE :termino OR email LIKE :termino OR empresa LIKE :termino OR telefono LIKE :termino) 
             AND activo = 1 
             ORDER BY nombre";
    
    $stmt = $this->conn->prepare($query);
    $termino = "%$termino%";
    $stmt->bindParam(":termino", $termino);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // Obtener estadísticas de clientes
    public function obtenerEstadisticas() {
        $query = "SELECT 
                    COUNT(*) as total_clientes,
                    COUNT(DISTINCT empresa) as total_empresas,
                    MAX(fecha_registro) as ultimo_registro
                 FROM " . $this->table_name . " 
                 WHERE activo = 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Verificar si email ya existe
    public function emailExiste($email, $excluir_id = null) {
        $query = "SELECT id FROM " . $this->table_name . " 
                 WHERE email = :email AND activo = 1";
        
        if ($excluir_id) {
            $query .= " AND id != :excluir_id";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        
        if ($excluir_id) {
            $stmt->bindParam(":excluir_id", $excluir_id);
        }
        
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
?>