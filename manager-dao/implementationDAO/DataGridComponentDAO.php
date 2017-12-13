<?php

/*
 *  CONKRETEMOS SAS
 *  Licencia de cabeceras para el proyecto CONKRETEMOS SAS
 *  author:  ing Jaime Diaz G.
 *  2016  COMPANY
 */

/**
 * Description of DataGridComponentDAO
 *
 * @author Jaime Diaz <jaimeivan0017@gmail.com>
 */
class DataGridComponentDAO implements IDataGridComponentDAO{
    
    function __construct() {
        
    }
    
    /**
     * INTERACTUA CON EL SP definido como FACADE en MODEL.php
     * 
     * @param type $cols
     * @param type $criterio
     * @param type $wheres
     * @param type $getPage
     * @param type $getRegXpage
     * @param type $colNameOrder
     * @param type $orderType
     * @return type
     */
    public static function callSPGenericDataGridComponent($cols, $criterio, $wheres, $getPage, $getRegXpage, $colNameOrder, $orderType) {
        //CONSULTA SP
        $resultados = Usuario::call_sp_Generic(
                $cols, $criterio, $wheres, $getPage, $getRegXpage,$colNameOrder,$orderType);        
        return $resultados;
    }

//put your code here
}
