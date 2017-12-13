<?php
//------------------------[ VARIABLES GLOBALES ] -------------------------------
$path ="";
//------------------------[ LIBRERIAS ] ----------------------------------------
require_once('configApplication.php');
// put your code here
// URL PARAMETER THAT GETTING FROM GET METHOD:
$urlGetParams = (isset($_GET['url']))? $_GET['url'] : "Index/index";
//print("from: index - router " . $urlGetParams);

//------------- EXISTENCIA DE CONTROLADOR POR GET-------------------------------
$getController = 0;
$getMethod = 0;
$getParams = 0;
//------------------------------------------------------------------------------
$controller = '';
$method = '';
$params = '';
// PARTIR LA URL - EN UN ARRAY SEGUN LOS PARAMETROS
$arreglo = explode("/", $urlGetParams);

if(isset($arreglo[0])){
    $controller = $arreglo[0] ."_controller";
    $getController = 1;
}else{
    $controller = "Index_controller";
}
if(isset($arreglo[1]) && $arreglo[1]!= ''){
        $method = $arreglo[1];
        $getMethod = 1;        
} else {
        // accede a un metodo index para cualquier controlador existente
        $method = 'index';
    
}
if(isset($arreglo[2])){
    if($arreglo[2]!= ''){
        $params = $arreglo[2];
        $getParams = 1;
    }
}

// ECHO EXPERIMENTAL
//echo "<br>from : index - router controlador: ". $controller . " , metodo: ". $method;


//---------[ AUTOLOAD-REGISTER - CARGA LAZZY LOAD ------------------------------
spl_autoload_register(function ($classLoad){
    //FUNCION CALLBACK ::
    if(file_exists(PATH_FRAMEWORK. $classLoad .'.php')){            
        
        require_once PATH_FRAMEWORK . $classLoad .'.php';
   
    } elseif(file_exists( PATH_UTILITIES. $classLoad .'.php')){

        require_once PATH_UTILITIES . $classLoad .'.php';
          
    } elseif(file_exists( PATH_HELPERS. $classLoad .'.php')){
        
        require_once PATH_HELPERS . $classLoad .'.php';
         
    } elseif(file_exists( PATH_MODELS. $classLoad .'.php')){
        
        require_once PATH_MODELS . $classLoad .'.php';
        
    } elseif(file_exists( PATH_BUSINESS. $classLoad .'.php')){
        
        require_once PATH_BUSINESS . $classLoad .'.php';
    } elseif (file_exists( PATH_CONTROLLERS . $classLoad . '.php')) {        
        //CONTROLLERS
        require_once PATH_CONTROLLERS . $classLoad .'.php';
    }
        // MANAGER - DAO
        elseif(file_exists( PATH_DAOS_MANAGER. $classLoad .'.php')){
        //DAOS-MANAGER
        require_once PATH_DAOS_MANAGER . $classLoad .'.php';
    }  elseif(file_exists( PATH_INFERFACES_DAOS_MANAGER. $classLoad .'.php')){
        //DAOS-INTERFACE
        require_once PATH_INFERFACES_DAOS_MANAGER . $classLoad .'.php';
    } elseif(file_exists( PATH_DTOS_TRANSFER_OBJECTS. $classLoad .'.php')){
        //DTOS *****
        require_once PATH_DTOS_TRANSFER_OBJECTS . $classLoad .'.php';
    } 
    else {
        //exit("from:: APP-CONFIG No existe la libreria a cargar ");
    }
});
//------------------------------------------------------------------------------



//LOGICA DE RUTEO PARA CONTROLADORES Y METODOS ---------------------------------
if ($getController == 1){
    //DEFINIENDO LA RUTA DEL CONTROLADOR A EVALUAR
    $path = "controllers/". $controller . ".php";
    
    //EVALUANDO EXISTENCIA DE ARCHIVO
    if (file_exists($path)){
        //intentando instanciar el controlador
        require $path;
        $controllerObj = new $controller();
        
        //EVALUANDO EXISTENCIA DEL METODO ]-------------------------------------
        if ( $getMethod == 1){
            //VALIDACION FISICA [ EXISTENCIA DEL METODO ]-----------------------
            if (method_exists($controllerObj, $method)) {
                //VALIDANDO LOS PARAMETROS
                if ($getParams == 1){
                    $controllerObj->{$method}($params);
                }else {
                    $controllerObj->{$method}();
                }
            } else { //INEXISTENCIA DEL METHOD
                exit("No existe el metodo en el controlador");
            }
        }
    } else { //INEXISTENCIA DEL CONTROLLER
        exit("El controlador no existe fisicamente como artefacto PHP");
    }    
}

?>
