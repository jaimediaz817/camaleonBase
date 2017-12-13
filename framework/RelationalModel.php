<?php

/*
 *  CONKRETEMOS SAS
 *  Licencia de cabeceras para el proyecto CONKRETEMOS SAS
 *  author:  ing Jaime Diaz G.
 *  2016  COMPANY
 */

/**
 * Description of RelationalModel
 *
 * @author Jaime Diaz <jaimeivan0017@gmail.com>
 */
class RelationalModel extends Model
{
    
    //put your code here
    function __construct() {
        
    }
    
    public static function getString ($var)
    {       
        return "ejemplo". ", tabla2: ". $var;
    }
    
}
