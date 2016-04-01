<?php

/*
 *  CONKRETEMOS SAS
 *  Licencia de cabeceras para el proyecto CONKRETEMOS SAS
 *  author:  ing Jaime Diaz G.
 *  2016  COMPANY
 */

/**
 * Description of DataTimeManager
 *
 * @author Jaime Diaz <jaimeivan0017@gmail.com>
 */
class DataTimeManager 
{
    private static $singleTime = null;
    
    //put your code here
    function __construct() {
        
    }
    
    private static function getCurrentDate()
    {
        $singleTime = time ();
        return $singleTime;
    }
    
    private static function getCurrentTime ()
    {
        
    }
    public static function getFullDateTime ()
    {
        $fullTime = date("r");
        return $fullTime;
    }
    public static function getFormatDate($delimitador = '-', $orden = 1)
    {
        $date = self::getCurrentDate();
        $returnDate = null;
        if ( $orden == 1)
        {
            if ($delimitador == '-')
            {
                $returnDate = date('Y-m-d', $date);
            } 
            elseif ($delimitador == '/') {
                $returnDate = date('Y/m/d', $date);
            }            
        } elseif ($orden == 0)
        {
             if ($delimitador == '-')
            {
                $returnDate = date('d-m-Y', $date);
            } 
            elseif ($delimitador == '/') {
                $returnDate = date('d/m/Y', $date);
            }              
        }
        return $returnDate;
    }
    
    public static function getFormatTime($delimitador = ':', $orden = 1)
    {
        $date = self::getCurrentDate();
        $returnDate = null;
        if ( $orden == 1)
        {
            if ($delimitador == ':')
            {
                $returnDate = date('H:i:s', $date);
            } 
            elseif ($delimitador == '/') {
                $returnDate = date('H-i-s', $date);
            }            
        } elseif ($orden == 0)
        {
            if ($delimitador == '-')
            {
                $returnDate = date('s:i:H', $date);
            } 
            elseif ($delimitador == '/') {
                $returnDate = date('s-i-H', $date);
            }              
        }
        return $returnDate;        
    }
    
}
