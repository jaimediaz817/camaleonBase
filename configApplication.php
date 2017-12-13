<?php

/**
 * 
 */
//-------[ CONFIGURACION GLOBAL DE APARCHE - ZONA HORARIA ]---------------------
//DEFINE LA ZONA HORARIA EN EL SERVIDOR APACHE
date_default_timezone_set('America/Bogota');

//-------[ CONFIGURACION DE CARGUE DE ARCHIVOS PARAMETRIZADOS ]-----------------
// *** Vars
$pathConfigFileParams = 'config-file-parameters/';
$mailParametersLOCAL = 'email-config/configEmailLocal.txt';
$mailParametersPROD = 'email-config/configEmailProd.txt';
$connectionParametersLOCAL = 'paramSys-config/configPropertiesLocal.txt';
$connectionParametersPROD = 'paramSys-config/configPropertiesProduction.txt';
// ARCHIVO DE PROPIEDADES PARA LLAVES PUBLICAS :: ACCESO
$publicKeysPath = 'security/publicKeys.properties';
//*** Define
define ('PATH_CONFIG_PARAMS', $pathConfigFileParams);
// ********
define('FILE_EMAIL_PARAMETERS_PROD', PATH_CONFIG_PARAMS . $mailParametersPROD);
define('FILE_EMAIL_PARAMETERS_LOCAL', PATH_CONFIG_PARAMS . $mailParametersLOCAL);
define('FILE_CONNECTION_PARAMETERS_LOCAL', PATH_CONFIG_PARAMS . $connectionParametersLOCAL);
define('FILE_CONNECTION_PARAMETERS_PROD', PATH_CONFIG_PARAMS . $connectionParametersPROD);
//seguridad::
define('FILE_PUBLIC_KEYS_PARAMETERS', PATH_CONFIG_PARAMS . $publicKeysPath);
//------------------------------------------------------------------------------


//------ [ RUTAS DE DIRECTORIOS Y CARPETAS DEL PROYECTO ]-----------------------
$pathHelpers = 'helpers/';
$pathBusiness = 'business/';
$utilities = 'utilities/';
$pathFramework = 'framework/';
$pathModels = 'models/';
$pathViews = 'views/';
$pathControllers = 'controllers/';
//vistas
$pathModules = 'views/modules/';
//DAOS :: Manager 
$pathDaosManager = 'manager-dao/implementationDAO/';
$pathInterfacesDaosManager = 'manager-dao/interfacesDAO/';
//DTOS :: VAR
$pathDTOSTransferObjects = 'transfer-DTO/';
//*** Define
define('PATH_HELPERS', $pathHelpers);
define('PATH_BUSINESS', $pathBusiness);
define('PATH_UTILITIES', $utilities);
define('PATH_FRAMEWORK', $pathFramework);
define('PATH_MODELS', $pathModels);
define('PATH_VIEWS', $pathViews);
define('PATH_CONTROLLERS', $pathControllers);
define('PATH_VIEWS_MODULES', $pathModules);
//DAOS
define('PATH_DAOS_MANAGER', $pathDaosManager);
define('PATH_INFERFACES_DAOS_MANAGER', $pathInterfacesDaosManager);
//DTOS
define('PATH_DTOS_TRANSFER_OBJECTS', $pathDTOSTransferObjects);
//------------------------------------------------------------------------------


//------[ CONFIGURACION DE SESSIONS GLOBALS ]-----------------------------------

//------------------------------------------------------------------------------


//------[ CONFIGURACION DE CONEXIONES A BASE DE DATOS ]-------------------------
//*** Vars 
$localhost = 'localHost';
$userName = 'userName';
$password = 'password';
$scheme='databaseName';

//*** Define

//------------------------------------------------------------------------------







//-----------------------[ CARGA DE ARTEFACTOS ]--------------------------------
//---------[ AUTOLOAD-REGISTER - CARGA LAZZY LOAD ------------------------------
spl_autoload_register(function ($classLoad){
    //FUNCION CALLBACK ::
    if(file_exists(PATH_FRAMEWORK. $classLoad .'.php')){            
        
        require_once PATH_FRAMEWORK . $classLoad .'.php';
   
    } elseif(file_exists( PATH_UTILITIES. $classLoad .'.php')){
        if( class_exists($classLoad) != true ){
           require_once PATH_UTILITIES . $classLoad .'.php'; 
        }
                  
    } elseif(file_exists( PATH_HELPERS. $classLoad .'.php')){
        
        require_once PATH_HELPERS . $classLoad .'.php';
         
    } elseif(file_exists( PATH_MODELS. $classLoad .'.php')){
        
        require_once PATH_MODELS . $classLoad .'.php';
        
    } elseif(file_exists( PATH_BUSINESS. $classLoad .'.php')){
        
        require_once PATH_BUSINESS . $classLoad .'.php';
        
    } 
    // DAOS-INTERFACE, DAOS-IMPLEMENTATION, DTOS-IMPLEMENTATION
    elseif(file_exists( PATH_DAOS_MANAGER. $classLoad .'.php')){
        
        require_once PATH_DAOS_MANAGER . $classLoad .'.php';
    } elseif(file_exists( PATH_INFERFACES_DAOS_MANAGER. $classLoad .'.php')){
        
        require_once PATH_INFERFACES_DAOS_MANAGER . $classLoad .'.php';
    } elseif(file_exists( PATH_DTOS_TRANSFER_OBJECTS. $classLoad .'.php')){
        
        require_once PATH_DTOS_TRANSFER_OBJECTS . $classLoad .'.php';
    }
    elseif (file_exists( PATH_CONTROLLERS . $classLoad . '.php')) {
        
        if (class_exists(PATH_CONTROLLERS . $classLoad . '.php')){
            require_once PATH_CONTROLLERS . $classLoad .'.php';
        }
//        exit("from:: APP-CONFIG No existe la libreria " .$classLoad . ".php a cargar ");
    }
});
//------------------------------------------------------------------------------
//AUTOLOAD PSR-0 USO DE NAMESPACES - USE
function autoloadNameSpaces($className)
{
    $bandera = false;
    
    $className = ltrim($className, '\\');
//    echo "className: ". $className;
    $fileName  = '';
    $namespace = '';
    ResourceBundleV2::writeDebugLOG("005", "ClassName: ". $className);
    if ($lastNsPos = strrpos($className, '\\')) {
        $bandera = true;
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        ResourceBundleV2::writeDebugLOG("005", "fileName: ". $fileName);
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
//    echo "<br>PSR-0 ::  ". $fileName. " , NAMESPACE: ". $namespace; 
    ResourceBundleV2::writeDebugLOG("005", "fileName:despues del if ". $fileName);
    
    if ($bandera){
        require_once $fileName;
    }
        
}

spl_autoload_register('autoloadNameSpaces');

//------------------[ LOGICA DE CONFIGURACION ]---------------------------------
//***** Lógica para cargar la llave publica de encriptacion - desencriptacion
$propertyName = 'passwords.publicKey';
$publicKeyFromPropertyFile = ResourceBundleV2::leerArchivoProperties(
        FILE_PUBLIC_KEYS_PARAMETERS);

//ResourceBundleV2::writeHELPERSLog("FROM PARAMETERS, PUBLIC KEY: ", "[".$publicKeyFromPropertyFile[$propertyName]."]");
define('PUBLIC_KEY_SECURYTY_ENCY_DESCY_STRING', $publicKeyFromPropertyFile[$propertyName]);
//******************************************************************************


//----------------[ CONFIGURACION DE URL - OBJECT ]-----------------------------
//*** Vars
use utilities\UrlGenerator;

$urlGlobal = InnerUrlGenerator::getInstanceURLGenerator()->obtenerURL();
$singleUrl = InnerUrlGenerator::getInstanceURLGenerator()->getSingleURLRoot();
$ambienteApp = InnerUrlGenerator::getInstanceURLGenerator()->getAmbienteApplication();
$dirNameFolders = InnerUrlGenerator::getInstanceURLGenerator()->get__DIRname();
//*** Define
ResourceBundleV2::writeDebugLOG('003', "URL: " . $ambienteApp);
define('URL_GLOBAL',$urlGlobal);
define('URL_SINGLE_APPLICATION',$singleUrl);
define('DIR_NAME_DIRECTORY', $dirNameFolders);
//------------------------------------------------------------------------------




//-------------[ LOGICA DE SESSION ]--------------------------------------------
//*** COMPORTAMIENTO GENERAL :: SABER SI EXISTE SESION 
if (SessionApp::existVarSessionNowVersion()){
    ResourceBundleV2::writeErrorLOG("830", "from:: CONSTANT EXISTE LA SESSION, METODO NUEVO");
}else{
    ResourceBundleV2::writeErrorLOG("830", "from:: CONSTANT NO EXISTE LA SESSION, METODO NUEVO");
}
//------------------------------------------------------------------------------



//--------------[ LOGICA DE AMBIENTE DE LA APP ]--------------------------------
$parametersConnection = array();

if( $ambienteApp == 'localhost'){
    $parametersConnection = ResourceBundleV2::getPropertiesInArray(FILE_CONNECTION_PARAMETERS_LOCAL);
}else{
    $parametersConnection = ResourceBundleV2::getPropertiesInArray(FILE_CONNECTION_PARAMETERS_PROD);
}

$arrayString = ResourceBundleV2::convertirDeArrayACadena($parametersConnection);

//*** Define
define('LOCAL_HOST_APPLICATION_CONN', (string)($arrayString[0]));
define('USERNAME_APPLICATION_CONN', (string)($arrayString[1]));
define('PASSWORD_APPLICATION_CONN', (string)($arrayString[2]));
define('SCHEME_APPLICATION_CONN', (string)(string)($arrayString[3]));
//*** Define for PDO Connection
//*** Define
define('_DB_TYPE', 'mysql');
define('_DB_HOST', (string)($arrayString[0]));
define('_DB_USER', (string)($arrayString[1]));
define('_DB_PASS', (string)($arrayString[2]));
define('_DB_NAME', (string)(string)($arrayString[3]));
//*** Logs
ResourceBundleV2::writeErrorLOG("830", "from: CONSTANTS, VARIABLES DB: local: ". LOCAL_HOST_APPLICATION_CONN. "  : ");
ResourceBundleV2::writeErrorLOG("830", "from: CONSTANTS, VARIABLES DB: root: ". USERNAME_APPLICATION_CONN. "  : ");
ResourceBundleV2::writeErrorLOG("830", "from: CONSTANTS, VARIABLES DB: pws: ". PASSWORD_APPLICATION_CONN. "  : ");
ResourceBundleV2::writeErrorLOG("830", "from: CONSTANTS, VARIABLES DB: schema: ". SCHEME_APPLICATION_CONN. "  : ");
//------------------------------------------------------------------------------


/**
 * CLASE QUE PERMITE OBTENER INSTANCIAS ]---------------------------------------
 */
class InnerUrlGenerator{
    private static $urlGeneratorObj;

    public static function getInstanceURLGenerator(){
        if (! self::$urlGeneratorObj){        
            self::$urlGeneratorObj = new UrlGenerator();
            ResourceBundleV2::writeDebugLOG('002', "FROM:: CONFIG-APP, se instancio URLGENERATOR ");
        }
    return self::$urlGeneratorObj;
    }
}

ResourceBundleV2::writeDebugLOG('001', "FROM:: CONFIG-APP ");
