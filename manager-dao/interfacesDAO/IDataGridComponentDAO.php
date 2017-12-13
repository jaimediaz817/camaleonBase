<?php

/*
 *  CONKRETEMOS SAS
 *  Licencia de cabeceras para el proyecto CONKRETEMOS SAS
 *  author:  ing Jaime Diaz G.
 *  2016  COMPANY
 */

/**
 *
 * @author Jaime Diaz <jaimeivan0017@gmail.com>
 */
interface IDataGridComponentDAO {
    //put your code here
    public static function callSPGenericDataGridComponent($cols, $criterio, $wheres, $getPage, $getRegXpage, $colNameOrder, $orderType);
}
