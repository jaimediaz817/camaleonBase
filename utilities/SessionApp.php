<?php

/*
 *  CONKRETEMOS SAS
 *  Licencia de cabeceras para el proyecto CONKRETEMOS SAS
 *  author:  ing Jaime Diaz G.
 *  2016  COMPANY
 */


/**
 * Description of SessionApp
 *
 * @author Jaime Diaz <jaimeivan0017@gmail.com>
 */
class SessionApp {
    //put your code here
    /*
     * sobreescribiendo cualquier session iniciado anteriormente
     */
    
    public static function init()
    {
       // algo de singleton
       if (session_id() == '')
       {
           @session_start(); 
       }
       /*
        * programacion defensiva OJO
        */
    }
    
    /*
     * cierra o destruye cualquier variable nativa que apunte a las sesiones
     */
    public static function destroySession()
    {
        @session_destroy();
    }
    //--------------------------------------------------------------------------
    /**
     * Destruye absolutamente todo lo relacionado con las session vars,
     * incluyendo archivos de cookies
     */
    public static function destroyAllSession()
    {
        @session_destroy();
        //destruyendo variables creadas aparte
        //session_unset();        
        unset($_SESSION);
        //borrando rastros de cookies
        $parametros_cookies = session_get_cookie_params();
        setcookie(session_name(),0,1,$parametros_cookies["path"]);        
    }
    /**
     * version mejorado, inicializa la session por completo con un varName
     * por defecto
     * 
     * @param type $varNameSession
     */
    public static function initStartFullSessionVar($nameProperty, $varNameSession)
    {
        $this->init();
        $this->setValueSession($nameProperty, $varNameSession);
    }
    //--------------------------------------------------------------------------
    public static function setValueSession($variableName, $valorSession)
    {
        $_SESSION[$variableName] = $valorSession;
    }
    public static function getValueSession($variableName)
    {
        if (isset($_SESSION[$variableName])){
           return $_SESSION[$variableName]; 
        } else {
            return false;
        }       
    }
    /*
     * [ VALIDADO = OK ]
     * Eliminar algun valor de la session
     */
    public static function unsetVarSession($varName)
    {
        //si existe la variable en session eliminela
        if (isset($_SESSION[$varName])){
          self::destroySession();
          unset($_SESSION[$varName]);   
        }
    }
    /**
     * [ VALIDADO :: OK ]
     * VALIDA LA EXISTENCIA DE UN NOMBRE DE VARIABLE DE SESSION
     * 
     * @param type $varName
     * @return boolean
     */
    public static function existVarNameSession($varName)
    {
        if (isset($_SESSION[$varName])){
            return true;
        }else{
            return false;
        }
    }
    /*
     * si existen definidas variables de session en la session actual
     */
    public static function existVarSession ()
    {
        if (sizeof($_SESSION) > 0){
            return true;
        }else {
            return false;
        }
    }
    
    public static function existVarSessionNowVersion ()
    {
        if (session_status() == PHP_SESSION_NONE) {
//            session_start();
            return true;
        }    
        else{
            return false;
        }        
    }
}

