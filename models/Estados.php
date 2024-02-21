<?php
include_once BASE_DIR  .  '../config/database.php';

class Estados{
    private $id;
    private $nombre_estado;

    public function __construct(){
        $this->id;
        $this->nombre_estado;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre_estado()
    {
        return $this->nombre_estado;
    }

    public static function all(){
        $conexion = Conexion::connectDB();
        $sql = "SELECT * FROM  estados";
        $consulta = $conexion->query($sql);
        $array_estados  = [];
        while ($registro = $consulta->fetchObject()) {
            $array_estados[] = $registro;
        }

        return $array_estados;
    }
}
