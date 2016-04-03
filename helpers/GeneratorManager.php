<?php
/*
 *  CONKRETEMOS SAS
 *  Licencia de cabeceras para el proyecto CONKRETEMOS SAS
 *  author:  ing Jaime Diaz G.
 *  2016  COMPANY
 */

/**
 * Description of GeneratorManager
 *
 * @author Jaime Diaz <jaimeivan0017@gmail.com>
 */
class GeneratorManager 
{
    private static $rangeLetters = 
        "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_$%&.-";
    
    /**
     *  FUNCTION CONSTRUCTURA
     */
    function __construct() {
        
    }
    
    /**
     * Genera caracteres aleatorios cuya cantidad es tomado del parametro 
     * de entrada $charsetLength
     * 
     * @param type $charsetLength
     * @return type
     */
    public static function getCharsetKey ( $charsetLength )
    {
        $charsetReturn = "";
        $limit = $charsetLength;
        $counter = 0;
        $letters = self::$rangeLetters;
        
        while ( $counter < $limit )
        {
            $charTmp = substr($letters, mt_rand(0, strlen($letters) - 1), 1);
            //concatenacion
            $charsetReturn .= $charTmp;
            $counter ++;
        }
        return $charsetReturn;
    }
}
