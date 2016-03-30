<?php

/*
 *  CONKRETEMOS SAS
 *  Licencia de cabeceras para el proyecto CONKRETEMOS SAS
 *  author:  ing Jaime Diaz G.
 *  2016  COMPANY
 */

/**
 * Description of User_business
 *
 * @author Jaime Diaz <jaimeivan0017@gmail.com>
 */
class User_business {
    //put your code here
    public static function iniciarSession ()
    {
        SessionApp::init();
    }
    
    public static function crearUserSession (Usuario $userObj)
    {
        SessionApp::setValueSession("username", $userObj->getUsername());
        SessionApp::setValueSession("idUser", $userObj->getId());
        ResourceBundleV2::writeDebugLOG("007", "se creo la session: " . SessionApp::getValueSession("idUser"));
    }
    public static function destruirUserSession ($fullDestroy = true)
    {
        if ( $fullDestroy )
        {
            SessionApp::destroyAllSession();
        } else {
            SessionApp::unsetVarSession("username");
            SessionApp::unsetVarSession("idUser");
        }
        
    }
    
    public static function iniciarLoginUser (Usuario $userObjDb, Usuario $userObjPOST)
    {
        $responseJson = array();
        
        $responseJson["error"] = 0;
        //VALIDANDO SI ES EL USERNAME
        if ($userObjDb->getUsername() == $userObjPOST->getUsername())
        {
            $responseJson["username"] = true;
            
        } else {
            $responseJson["username"] = false;
        }
        //VALIDANDO SI ES EL PASSWORD
        if ($userObjDb->getPassword() == $userObjPOST->getPassword())
        {
            $responseJson["password"] = true;
        } else {
            $responseJson["password"] = false;
        }
        //cuando el usuario y la contraseña son validos
        if ($responseJson["username"] == true && $responseJson["password"] == true){
            //INICIAR SESSION VAR
            self::iniciarSession();
            //creando la session con los datos completos cargados de la BD
            self::crearUserSession($userObjDb);
        }
        //RETORNANDO EL ARRAY CON LA RESPUESTA                
        return $responseJson;
    }
}
