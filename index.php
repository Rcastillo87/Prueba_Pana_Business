<?php

define('BASE_DIR', __DIR__);
define('BASE_URL', '');

include_once BASE_DIR  . '/config/Routing.php';
include_once BASE_DIR  . '/controllers/TareasController.php';
$router = new Routing();

/*$router->add('/',function(){
        echo "Hola q mas"; 
});*/
$router->add('/','TareasController@Index');
$router->add('/lista_tareas','TareasController@Lista_all_Tareas');
$router->add('/input_tarea','TareasController@Insert');
$router->add('/delete','TareasController@Eliminar');
$router->add('/donwload','TareasController@Download_Excel');

$router->run();