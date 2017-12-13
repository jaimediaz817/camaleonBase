<?php

/*
 *  CONKRETEMOS SAS
 *  Licencia de cabeceras para el proyecto CONKRETEMOS SAS
 *  author:  ing Jaime Diaz G.
 *  2016  COMPANY
 */

/**
 * Description of UserDAO
 *
 * @author Jaime Diaz <jaimeivan0017@gmail.com>
 */
class UserDAO implements IUserDAO{
    //put your code here
    function __construct() {
        
    }

    public static function validarExistenciaEmailFromDATABASE($email = '', $ajax)
    {
        $respuesta = array();
        if (!empty($email)){
            //consultando en la BD
            $userObj = Usuario::getBy("email", $email);                        
            if ($ajax){
                //validacion de existencia :: OPERACION TERNARIA
                $userObj = (empty($userObj) ? false : true);
                $respuesta["success"] = $userObj;
            }else{
                //validacion de existencia
                $userObj = (empty($userObj) ? null: $userObj);                
            }
            //var_dump($userObj);
        }else {
            ResourceBundleV2::writeDebugLOG("006", "NO HAY ARGUMENTOS");
            $respuesta["success"] = false;
        }
        return $respuesta;        
    }

    public static function validarExistenciaUserNameFromDATABASE($userName = '', $ajax) 
    {
        $respuesta = array();
        if (!empty($userName))
        {
            //consultando en la BD
            $userObj = Usuario::getBy("username", $userName);            
            //--------------------------------------------------
            // SI ES VIA AJAX LA PETICION **********************
            if ( $ajax )
            {
                //validacion de existencia :: OPERACION TERNARIA
                $userObj = (empty($userObj) ? false : true);
                $respuesta["success"] = $userObj;
            }
            else 
            {
                //validacion de existencia
                $userObj = (empty($userObj) ? null: $userObj);                
            }
        }
        else
        {
            $respuesta["success"] = false;
        }
        return $respuesta;
    }

    public static function getAllUsersFromDATABASE() {
        $arrayAllUsers = Usuario::getAll();
        return $arrayAllUsers;
    }

    public static function iniciarSessionUsuarioFromDATABASE($userName, $password) 
    {
            $arrayResponse = array();
            //SETEANDO LOS VALORES POR POST
            $usernamePOSTFilter = $userName;
            $passwordPOSTFilter = $password;            
            
            //creando instancia de USUARIO :: POST
            $userObjPOST = new Usuario(null, $usernamePOSTFilter, $passwordPOSTFilter);
            
            //encriptar PASSWORD QUE LLEGA POR POST *****
                        
            //-------------------------------------------
            //creando instancia por reflexion y buscando USUARIO :: PDO
            $userObjDb = Usuario::getBy("username", $usernamePOSTFilter);//filter_input(INPUT_POST, "username")
            

            //PROGRAMACION DEFENSIVA ]
            if (!is_null($userObjDb)){
                //Business logic Lyer ]*****************************************
                $arrayResponse = User_business::iniciarLoginUser($userObjDb , $userObjPOST);
            } else {
                $arrayResponse["error"] = 1;
                $arrayResponse["username"] = false;
                $arrayResponse["password"] = false;
            }
            //respuesta
            return $arrayResponse;
    }

    public static function registrarUsuarioFromDATABASE($arrayDataPOST = array()) 
    {
        $arrayResponse = array();
        /**
         * el filtrado a traves de filter_input_array ( INPUT:: POST ) DENTRO
         * del arreglo metodo post creado por apache hace las peticiones
         */
        $objUser = Usuario::instanciate($arrayDataPOST);
                
        //ENCRIPTAR EL PWS
        $objUser->setPassword(
                User_business::encriptarPasswordUser($arrayDataPOST["password"]));
        
//        print_r($objUser);
        $objCreate = $objUser->create();
        
        //----------------------------------------------------------------------
/*      1) GENERAR UNA LLAVE KEY_GENERATOR DE STRING-MANAGER
 *      2) VALIDAR SI EXISTE LA LLAVE EN LA TABLA KEY_GENNERATOR
        3) EXISTE=?  : GUARDAR EL REGISTRO
 *      3.1) NO EXISTE ? : VOLVER AL PASO 1)
 * 
*/      
        //----------------------------------------------------------------------
        $arrayResponse = $objCreate;

        //***************[ GESTION DE LA SESSION ] *****************************
        //              [ BUSINESS - LOGIC - LYER ]
        /*
         * OJO! NO SE CREA LA SESSION HASTA QUE NO HAYA CAMBIADO EL ESTADO DEL
         * REGISTRO ENVIADO A TRAVES DEL MAIL DE CONFIRMACION
         */
        if ( $arrayResponse["error"] == 0)
        {
            //User_business::crearUserSession($objUser);
        }
        //**********************************************************************        
        //RETURN::
        return $arrayResponse;
    }
}
