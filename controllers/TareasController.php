<?php

include_once BASE_DIR  . '../models/Tarea.php';
include_once BASE_DIR  . '../models/Estados.php';

class TareasController {

    /*  controller Tareas */

    public function Index() {
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'GET':
                $id = (empty($_GET['id'])) ? '' : $_GET['id'];
                $tareas = Tarea::all($id);
                $estados = Estados::all();
                include_once BASE_DIR  . '../view/home.php';
            break;
            Default:
                echo 'No se esta usando este Metodo '.$method.' Method';
            break;
        }
    }

    public function Download_Excel() {
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'POST':
                $array =  Tarea::all();
                $head = ['Nombre Tarea', 'Estado Tarea', 'Fecha Creacion'];
                $data[] = $head;
                foreach ($array as $key => $value) {
                    $fila = null;
                    $fila[] = $value->nombre;
                    $fila[] = $value->nombre_estado;
                    $fila[] = $value->fec_creacion;
                    $data[] = $fila;
                }

                $excelFilename = "datos.csv";
                $this->generateExcelFromArray($data, $excelFilename);

            break;
            Default:
                echo 'No se esta usando este Metodo '.$method.' Method';
            break;
        }
    }

    public function Lista_all_Tareas() {
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'POST':
                $id = (empty($_POST['id'])) ? '' : $_POST['id'];
                $data =  Tarea::all($id);
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($data[0]);
            break;
            Default:
                echo 'No se esta usando este Metodo '.$method.' Method';
            break;
        }
    }

    public function Insert() {
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'POST':
                $data = null;
                $data["id"] = (empty($_POST['id'])) ? '' : $_POST['id'];
                $data["nombre"] = (empty($_POST['nombre'])) ? '' : $_POST['nombre'];
                $data["fecha_creacion"] = date("Y-m-d");
                $data["id_estado"] = (empty($_POST['id_estado'])) ? '' : $_POST['id_estado'];
                $tarea = new Tarea();
                $tarea->save($data);
                header("Location: ./");
            break;
            Default:
                echo 'No se esta usando este Metodo '.$method.' Method';
            break;
        }
    }

    public function Eliminar() {
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'POST':
                $id = $_POST['id_delete'];
                Tarea::delete($id);
                header("Location: ./");
            break;
            Default:
                echo 'No se esta usando este Metodo '.$method.' Method';
            break;
        }
    }

    /*  controller Estados */

    public function Lista_all_Estados() {
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'GET':
                return Estados::all();
            break;
            Default:
                echo 'No se esta usando este Metodo '.$method.' Method';
            break;
        }
    }
    
    // Función para generar el archivo Excel a partir del array
    function generateExcelFromArray($data, $filename) {
        // Abrir el archivo en modo de escritura
        $file = fopen('php://output', 'w');

        // Escribir los datos en el archivo CSV
        foreach ($data as $row) {
            fputcsv($file, $row);
        }

        // Cerrar el archivo
        fclose($file);

        // Definir las cabeceras para descargar el archivo
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');

        // Salida al navegador
        readfile('php://output');
    }

}
