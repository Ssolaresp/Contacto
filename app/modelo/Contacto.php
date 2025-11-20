<?php
require_once __DIR__ . '/../Conexion/conexion.php';

class Contacto {
    private $conexion;

    public function __construct() {
        $this->conexion = new Conexion();
    }

    public function listar() {
        $sql = "SELECT c.id, c.nombre, c.asunto, c.correo, c.mensaje, 
                       ec.nombre AS estado_contacto, c.fecha_creacion, c.fecha_actualizacion
                FROM contacto c
                INNER JOIN estado_contacto ec ON c.estado_contacto_id = ec.id
                ORDER BY c.id DESC";
        $stmt = $this->conexion->getConexion()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($id) {
        $sql = "SELECT * FROM contacto WHERE id = ?";
        $stmt = $this->conexion->getConexion()->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertar($data) {
        $sql = "INSERT INTO contacto (nombre, asunto, correo, mensaje, estado_contacto_id, fecha_creacion, fecha_actualizacion) 
                VALUES (?, ?, ?, ?, 1, NOW(), NOW())";
        $stmt = $this->conexion->getConexion()->prepare($sql);
        $stmt->execute([
            $data['nombre'],
            $data['asunto'],
            $data['correo'],
            $data['mensaje']
        ]);
    }

    public function actualizar($data) {
        $sql = "UPDATE contacto 
                SET nombre = ?, asunto = ?, correo = ?, mensaje = ?, estado_contacto_id = ?, fecha_actualizacion = NOW()
                WHERE id = ?";
        $stmt = $this->conexion->getConexion()->prepare($sql);
        $stmt->execute([
            $data['nombre'],
            $data['asunto'],
            $data['correo'],
            $data['mensaje'],
            $data['estado_contacto_id'],
            $data['id']
        ]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM contacto WHERE id = ?";
        $stmt = $this->conexion->getConexion()->prepare($sql);
        $stmt->execute([$id]);
    }

    public function obtenerEstadosContacto() {
        $sql = "SELECT id, nombre FROM estado_contacto ORDER BY nombre ASC";
        $stmt = $this->conexion->getConexion()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
