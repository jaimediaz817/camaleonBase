<?php

/*
 *  CONKRETEMOS SAS
 *  Licencia de cabeceras para el proyecto CONKRETEMOS SAS
 *  author:  ing Jaime Diaz G.
 *  2016  COMPANY
 */

/**
 * Description of StringManager
 *
 * @author Jaime Diaz <jaimeivan0017@gmail.com>
 */
class StringSecurityManager {
    //put your code here
    function __construct() {
        
    }
    /**
     * ============================================================
     * <br>Busca cualquier texto en una cadena de palabras / caracteres
     * @param type $busqueda caracteres a buscar
     * @param type $cadena cadena completa con la cadena
     * @return boolean
     */
    public static function buscarPalabraEnCadenaString( $busqueda, $cadena)
    {
        $posicion_coincidencia = strpos($cadena, $busqueda);
        //condicional
        if ( $posicion_coincidencia ){
            return true;
        } else {
            return false;
        }
    }
    
    public static function encriptarCadenaTexto ($cadenaEntrante)
    {   // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
        $key = PUBLIC_KEY_SECURYTY_ENCY_DESCY_STRING;  
        $encrypted = base64_encode(
                mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $cadenaEntrante, 
                        MCRYPT_MODE_CBC, md5(md5($key))));
        return $encrypted; //Devuelve el string encriptado        
    }
    
    public static function desencriptarCadenaTexto ($cadenaEntrante)
    {
        // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
        $key = PUBLIC_KEY_SECURYTY_ENCY_DESCY_STRING;  
        $decrypted = rtrim(mcrypt_decrypt(
                MCRYPT_RIJNDAEL_256, md5($key), base64_decode($cadenaEntrante), 
                MCRYPT_MODE_CBC, md5(md5($key))), "\0");
        return $decrypted;  //Devuelve el string desencriptado        
    }    
}