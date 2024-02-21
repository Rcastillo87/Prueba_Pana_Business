<?php
include_once BASE_DIR  .  '../config/database.php';

class Tarea{
    private $id;
    private $nombre;
    private $fecha_creacion;
    private $id_estado;

    public function __construct(){
        $this->id;
        $this->nombre;
        $this->fecha_creacion;
        $this->id_estado;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getFechaCreacion()
    {
        return $this->fecha_creacion;
    }

    public function getId_estado()
    {
        return $this->id_estado;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setEstado($id_estado)
    {
        $this->id_estado = $id_estado;
    }

    public function save( $data ){
        $conexion = Conexion::connectDB();
        if ($data["id"] == null) {
            $sql = "INSERT INTO tareas (nombre, fec_creacion, id_estado) 
            VALUES ('" . $data["nombre"] . "', '" . $data["fecha_creacion"] . "'," . $data["id_estado"] . ")";
            return  $conexion->exec($sql);
        } else {
            $sql = "UPDATE tareas SET nombre = '" . $data["nombre"] . "', id_estado = " . $data["id_estado"] . " WHERE id = " . $data["id"];
            return  $conexion->exec($sql);
        }
    }
    public static function all($id=null){
        $conexion = Conexion::connectDB();
        $select = $id?"where t.id = $id" : null;
        $sql = "SELECT t.*, e.nombre_estado FROM tareas t inner join estados e on e.id = t.id_estado $select";
        $consulta = $conexion->query($sql);
        $array_tareas  = [];
        while ($registro = $consulta->fetchObject()) {
            $array_tareas[] = $registro;
        }
        return $array_tareas;
    }

    public static function delete($id){
        $conexion = Conexion::connectDB();
        $sql = "DELETE FROM tareas WHERE id=?";
        $stmt= $conexion->prepare($sql);
        $stmt->execute([$id]);
    }
}
