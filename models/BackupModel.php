<?php
class BackupModel {
    private $conn;
    private $table_name = "backups";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crear($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                 (pagina_web_id, nombre_archivo, tipo, categoria, ruta_archivo, tamaño, descripcion) 
                 VALUES (:pagina_web_id, :nombre_archivo, :tipo, :categoria, :ruta_archivo, :tamaño, :descripcion)";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    public function listar() {
        $query = "SELECT b.*, pw.titulo as pagina_web_titulo, pw.url as pagina_web_url
                 FROM " . $this->table_name . " b 
                 LEFT JOIN paginas_web pw ON b.pagina_web_id = pw.id 
                 ORDER BY b.fecha_backup DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT b.*, pw.titulo as pagina_web_titulo, pw.url as pagina_web_url
                 FROM " . $this->table_name . " b 
                 LEFT JOIN paginas_web pw ON b.pagina_web_id = pw.id 
                 WHERE b.id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $data) {
        $query = "UPDATE " . $this->table_name . " 
                 SET nombre_archivo = :nombre_archivo, tipo = :tipo, categoria = :categoria, 
                     descripcion = :descripcion, fecha_backup = NOW()
                 WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function eliminar($id) {
        // Primero obtenemos la información del backup para eliminar el archivo físico
        $backup = $this->obtenerPorId($id);
        
        if ($backup && !empty($backup['ruta_archivo']) && file_exists($backup['ruta_archivo'])) {
            unlink($backup['ruta_archivo']);
        }
        
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function obtenerPorPaginaWeb($pagina_web_id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE pagina_web_id = :pagina_web_id 
                 ORDER BY fecha_backup DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":pagina_web_id", $pagina_web_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerEstadisticas() {
        $query = "SELECT 
                    COUNT(*) as total_backups,
                    COUNT(DISTINCT pagina_web_id) as sitios_con_backup,
                    SUM(CASE WHEN tipo = 'wordpress' THEN 1 ELSE 0 END) as backups_wordpress,
                    SUM(CASE WHEN tipo = 'database' THEN 1 ELSE 0 END) as backups_database,
                    SUM(CASE WHEN tipo = 'zip' THEN 1 ELSE 0 END) as backups_zip,
                    MAX(fecha_backup) as ultimo_backup
                 FROM " . $this->table_name;
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerPorTipo($tipo) {
        $query = "SELECT b.*, pw.titulo as pagina_web_titulo
                 FROM " . $this->table_name . " b 
                 LEFT JOIN paginas_web pw ON b.pagina_web_id = pw.id 
                 WHERE b.tipo = :tipo 
                 ORDER BY b.fecha_backup DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":tipo", $tipo);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorCategoria($categoria) {
        $query = "SELECT b.*, pw.titulo as pagina_web_titulo
                 FROM " . $this->table_name . " b 
                 LEFT JOIN paginas_web pw ON b.pagina_web_id = pw.id 
                 WHERE b.categoria = :categoria 
                 ORDER BY b.fecha_backup DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":categoria", $categoria);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>