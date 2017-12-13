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
        //req 02-37
        SessionApp::setValueSession("nivelAccesoUsr", $userObj->getNivelAcceso());
        //end req 02-37
        ResourceBundleV2::writeDebugLOG("007", "se creo la session: " . SessionApp::getValueSession("idUser"). "nivel acceso: ". SessionApp::getValueSession("nivelAccesoUsr"));
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
    public static function encriptarPasswordUser ($passwordIn)
    {
        $passwordOut = "";        
        $passwordOut = StringSecurityManager::encriptarCadenaTexto($passwordIn);
        return $passwordOut;
    }
    public static function desencriptarPasswordUser ($passwordEnc)
    {
        $passwordOut = "";
        $passwordOut = StringSecurityManager::desencriptarCadenaTexto($passwordEnc);
        return $passwordOut;
    }
    /**
     * 
     * @param Usuario $userObjDb
     * @param Usuario $userObjPOST
     * @return boolean
     */
    public static function iniciarLoginUser (Usuario $userObjDb, Usuario $userObjPOST)
    {
        $passwordEncy = "";        
        $responseJson = array();
        //LOGICA DE ESTADO-REGISTRO
        $estadoReg = 0;        
        $responseJson["error"] = 0;
        //VALIDANDO SI ES EL USERNAME
        if ($userObjDb->getUsername() == $userObjPOST->getUsername())
        {
            $responseJson["username"] = true;
            
        } else {
            $responseJson["username"] = false;
        }
        //VALIDANDO SI ES EL PASSWORD
        //desencriptando el PWS de la BD
        $passwordEncy = self::desencriptarPasswordUser($userObjDb->getPassword());
        if ($passwordEncy == $userObjPOST->getPassword())
        {
            $responseJson["password"] = true;
        } else {
            $responseJson["password"] = false;
        }
        //cuando el usuario y la contraseña son validos ]***********************
        if ($responseJson["username"] == true && $responseJson["password"] == true){
            
            //VALIDAR SI EL USUARIO ESTA ACTIVO PARA INICIAR LA SESION    
            $estadoReg = $userObjDb->getEstadoRegistro();
            
            if ($estadoReg == 1){
                //INICIAR SESSION VAR
                self::iniciarSession();
                //creando la session con los datos completos cargados de la BD
                self::crearUserSession($userObjDb);
                $responseJson["estadoRegistro"] = true;
            } else {
                $responseJson["estadoRegistro"] = false;
            }
        }
        //RETORNANDO EL ARRAY CON LA RESPUESTA                
        return $responseJson;
    }
}
