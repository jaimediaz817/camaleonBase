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
class StringManager {
    //put your code here
    function __construct() {
        
    }

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
    
}
