<?php

/*
 *  CONKRETEMOS SAS
 *  Licencia de cabeceras para el proyecto CONKRETEMOS SAS
 *  author:  ing Jaime Diaz G.
 *  2016  COMPANY
 */

/**
 * Description of DataGridComponent
 *
 * @author Jaime Diaz <jaimeivan0017@gmail.com>
 */
class DataGridComponent 
{
    //NOMBRE DEL GRID PRINCIPAL ------------------------------------------------
    private static $_gridNameComponent = '';
    // COLUMNAS DE LA TABLA <THEAD>
    private static $_columns = array();    
    //REGISTROS DE LA TABLA <TBODY> <TR>
    private static $_dataRows = array();    
    //CONTANDO LA CANTIDAD DE REGISTROS
    private static $_countDataRows;        
    //put your code here
    
    //--------------------------------------------------------------------------
    private static $ajaxDataPaginate = array();
    private static $criterio;
    private static $itemPaginas;
    //CURRENT PAGE ]------
    private static $page;
    //--------------------
    private static $registrosXpagina;
    private static $_ajaxContent;
    //FLAG INFO
    private static $_infoTextPaginate;
    private static $flagInfo;
    //COMBO-BOX :: CANTIDAD DE PAGINAS   [COMBO <]
    private static $_currentPageGlobal;
    //OJO ARREGLAR BUG DE CANTIDAD DE PAGINAS POR PAGINADOR
    private static $_changeNumRowsXpage = array(1,2,3,4,5,6,7,8,9,10);
    //--------------------------------------------------------------------------
    //ACTIONS ]
    //array con la configuracion de las acciones
    private static $_arrActionsConfig = array();
    //--------------------------------------------------------------------------
    // CHECKBOX CONF ]
    private static $_arrCheckBoxConfig = array();
    private static $_stateCheck = false;
    //--------------------------------------------------------------------------
    //ORDENAMIENTO ]------------------------------------------------------------
    private static $_nameColumnOrder;
    private static $_nameOrderType;
    
    //**************************************************************************
    function __construct() {
        
    }
    
    public static function addArrayCheckBoxByRow($arrayCheckBoxConf = array())
    {
        //significa que llega una configuracion de check
        self::$_stateCheck = true;
        self::$_arrCheckBoxConfig = $arrayCheckBoxConf;
    }
    
    /** ************************************************************************
     * 
     * @param type $countRow
     * @param type $row
     * @return string
     */
    public static function renderCheckBoxComponentByRow($countRow, $row)
    {
        $valores = '';
        $valuesRow = self::$_arrCheckBoxConfig['values'];
        $tdCheck = '';
        $renderCheckbox = '';
        
        $arrAjaxParams = isset(self::$_arrCheckBoxConfig['ajax_request'])?self::$_arrCheckBoxConfig['ajax_request']:'';
        $functionAjax = isset($arrAjaxParams['function'])?$arrAjaxParams['function']:'';
        $parametros = isset($arrAjaxParams['params'])?$arrAjaxParams['params']:'';
        //REFERENCIANDO EL ITEM CALLBACK:
        $paramCallBack = isset(self::$_arrCheckBoxConfig['fnCallBack'])?self::$_arrCheckBoxConfig['fnCallBack']:'';
        //----------------------------------------------------------------------
        
        
        if (!empty($paramCallBack))
        {
            //VERIFICANDO SI ES UNA FUNCION CALLBACK
            if (is_callable($paramCallBack))
            {
                //EJECUTAR EL PROCEDIMIENTO NORMAL ]----------------------------
                if ($parametros != '')
                 {
                     if (is_array($valuesRow))
                     {
                         foreach ($valuesRow as $rowValue)
                         {
                             //valor + separador
                             $valores .=  "'".$row[$rowValue]."',";
                         }

                     }else
                     {
                         $valores .= "'".$row[$valuesRow]."',";
                     }            
                 }
                 //---------[ ARMANDO LA AJAX FUNCTION ]------------------------
                 //eliminar el ultimo separador::
                 $valores = substr_replace($valores, "", -1);        
                 $onClickCheck = $functionAjax . '('.$valores.')';

                 //reset value
                 $valores = '';
                 //----------------------------------------
                 if (is_array($valuesRow))
                 {
                     foreach ($valuesRow as $rowValue)
                     {
                         //valor + separador
                         $valores .= $row[$rowValue]. '*';
                     }
                     $valores = substr_replace($valores, "", -1);
                 }else
                 {
                     $valores .= $row[$valuesRow];
                 }            
                 //----------------------------------------

                 $renderCheckbox = '<input type="checkbox" id="chk'.self::$_gridNameComponent. $countRow.'" name="chk_'.self::$_gridNameComponent.'[]" values="'.$valores.'" onclick="'
                         . '
                    if ($(this).prop(\'checked\')){
                       //alert(\'checkeado\');
                       $(this).parents(\'tr\').addClass(\'success\');
                    
                    }else{
                       //alert(\'NOcheckeado\'); 
                       $(this).parents(\'tr\').removeClass(\'success\');
                    }                         
                        
                    '
                    .$onClickCheck.


                    '" />';
                 $posibleRenderCheck = $renderCheckbox;
                 
                 $renderCheckbox = '';
                 // FINAL DEL PROCEDIMIENTO ]------------------------------------
                //definir estructura callback
                $callback = call_user_func_array($paramCallBack, array($countRow, $row, $posibleRenderCheck));
                $renderCheckbox .= $callback;
                        
            }else{
                $renderCheckbox .= 'ERROR: [fnCallBack] incorrecto, defina closure para [fnCallBack]';
            }
        }  
        else             
        {
            //void
        }
        
            $tdCheck = '<td>' 
                     . $renderCheckbox
                     . '</td>';        
               
        return $tdCheck;
    }
    /**
     *  ACCIONES POR CADA FILA ]------------------------------------------------
     * @param type $arrayConfig
     */
    public static function addActionComponentByRow($arrayConfig = array())
    {
        self::$_arrActionsConfig[] = $arrayConfig;
    }
    
    public static function createActionsButtons ($row)
    {
        $subArrAJAX = array();
        $subArrPARAMS = array();
        $tituloAction = '';
        $iconAction = '';
        // FUNCTION + PARAMETROS AJAX:
        $onClickFunction = '';
        $btnActionComplete = '';
        $urlApp = URL_SINGLE_APPLICATION;
        //recorriendo el ARRAY completo
        
        /**
         *                 "params" => array(
                                "username" ,"email","id", ... "nparameter"
                             )
         */
        
        //-------------[ EXPERIMENTO ]------------
        $arrJSelements = '';
        
        
        foreach (self::$_arrActionsConfig as $arrConfElement)
        {
            //EXTRAYENDO ELEMENTOS Y SUB ARRAYS
            $tituloAction = isset($arrConfElement['titulo'])?$arrConfElement['titulo']:'title';
            $iconAction = isset($arrConfElement['icono'])?$arrConfElement['icono']:'';
            //SUB ARRAYS
            $subArrAJAX = isset($arrConfElement['ajax_request'])?$arrConfElement['ajax_request']:'';
            //elementos del sub ARRAY
            $functionAjax = isset($subArrAJAX['function'])?$subArrAJAX['function']:'';
            $subArrPARAMS = isset($subArrAJAX['params'])?$subArrAJAX['params']:'';
            
            //PARAMS TIPO [SQL]
            $paramsBind = '';
            
            //programacion defensiva
            if ($subArrPARAMS!= ''){                
                //si es un ARRAY o cadena simple::
                if (is_array($subArrPARAMS))
                {                    
                    //RECORRIENDO PARAMS en caso de que sea ARRAY
                    foreach ($subArrPARAMS as $param)
                    {
                        $paramsBind .= "'".$row[$param]."',";
                        //-------[ EXPERIMENTO ]----------
                        $arrJSelements .= $param . ':' ."'".$row[$param]."',";
                    }
                }else
                {
                    $paramsBind .= "'".$row[$subArrPARAMS]."',";
                }
            }
            
            //EXPERIMENTO ]
            //$arrJSelements = json_encode($arrJSelements);
            //************
            //
            //URL GENERAL DE LA APP::
            $urlApp = "'". $urlApp ."',";
            //recortando la ultima coma en cualquier caso (array, NO array)
            $paramsBind = substr_replace($paramsBind, "", -1);
            $arrJSelements = substr_replace($arrJSelements, "", -1);
            
            //$onClickFunction = $functionAjax . '('. $urlApp . $paramsBind .')';
           $onClickFunction = $functionAjax . '('. $urlApp . '{' .$arrJSelements. '}' .')'; 
            
        }// final recorrido simple, array global
        
        //AGREGANDO EL BOTON::
        $btnActionComplete = '<button class="btn btn-default" '
                . 'title="'.$tituloAction.'" onclick="'.$onClickFunction.'">'
                . '<i class="'.$iconAction.'"></i></button>';
        
        return $btnActionComplete;
    }
    //**************************************************************************
    /**
     * Renderiza EL COMBO para mostrar las opciones con su evento ajax 
     * @return string <HTML> SELECT
     */
    public static function changeLengthSelectComponent()
    {
        //url global de la aplicacion:: 
        $urlGlobal = URL_SINGLE_APPLICATION;
        $onChangeEvent = self::$ajaxDataPaginate['ajaxRequest'] . '(\''. $urlGlobal .'\',\''.self::$criterio.'\',\''. self::$_currentPageGlobal .'\',this.value,\'' . self::$_nameColumnOrder . '\',\'' . self::$_nameOrderType . '\')';
        $combo =  '<span>registros por página: </span><select class="selectpicker" id="id-comboLengthPaginate" name="comboLength" onchange="'.$onChangeEvent.'">';
        $selected = '';
        
        //--------------[ GENERACION DINAMICA DE ELEMENTOS ]--------------------
                
        //----------------------------------------------------------------------
                
        foreach(self::$_changeNumRowsXpage as $elementNumber)
        {
            $selected = '';
            
            if (self::$registrosXpagina == $elementNumber)
            {
                $selected = 'selected="selected"';
            }
            
            //if 
            $combo .= '<option value="'.$elementNumber.'" '.$selected.'>'.$elementNumber.'</option>';                        
        }
        $combo .= '</select>';
        return $combo;
    }
    /** ------------------------------------------------------------------------
     * 
     * RENDERIZA LA TABLA :: <HTML>
     * @return string
     */
    public static function createDataRowsTABLE()
    {
        //VARIABLES GLOBALES DEL METODO
        $countRow = 0;
        $tbody = '<tbody>';
        
        if (count(self::$_dataRows))
        {                                    //    | ID | USER  | PASS  |
            foreach(self::$_dataRows as $row)// <= | 01 | JDIAZ | 12345 |
                                             //    | 02 | IDIAZ | 12345 |
            {
                // incrementando el contador de filas
                $countRow ++;                
                $tbody .= '<tr>'; // <=| POR CADA ROW EN LA TABLA HTML
                
                if (self::$_stateCheck)
                {
                    $tbody .= self::renderCheckBoxComponentByRow($countRow, $row);
                }                
                
                //CREANDO LAS COLUMNAS EN EL TBODY
                foreach(self::$_columns as $col)  // [ ID ], [ USER ], [ PASS ]
                {
                    //VERIFICAR SI EXISTE EL INDICE
                    $campo = isset($col["dataCol"]) ? $col["dataCol"]:'';
                    
                    if (empty($campo))
                    {
                        $f = 'campo indefinido';
                    }else
                    {
                        $f = $row[$campo];
                    }
                    
                    if (!is_null($f) || $f!=''){
                        //RENDER COL:
                        $tbody .= '<td>'. $f .'</td>';
                    }else{
                        //RENDER COL:
                        $tbody .= '<td class="warning">'. 'sin datos' .'</td>';                        
                    }
                }
                //-----[ CREANDO LAS ACCIONES ]------
                if (self::$_arrActionsConfig){
                    $tbody .= '<td>'.self::createActionsButtons($row).'</td>';
                }
                //-----[ FIN ACCIONES ]--------------
                $tbody .= '</tr>';
            }
        }  
        else 
        {
            //--------[ ACTINS BEGIN ]---------------
            $colSpan = count(self::$_columns);
            if (self::$_arrActionsConfig){
                $colSpan ++;
            }
            //---------[ FINAL - ACTIONS ]-----------
            $tbody .= '<tr>';
            $tbody .=  '<td colspan="'. $colSpan .'"> No se encontraron registros</td>';
            $tbody .= '</tr>';
        }
        $tbody .= '</tbody>';
        return $tbody;
    }
    
    /** ************************************************************************
     * RENDERIZA EL HEADER DE LA TABLA :: <THEAD>
     * @return string
     */
    public static function createTableHeader ()
    {
        $thead =  '<thead>';
        $thead .=   '<tr class="info">';
        
        // CHECKBOX ADITION ]---------------------------------------------------
        if (self::$_stateCheck)
        {
            $thead .= '<th style="width:1%">'
                     . '<input type="checkbox" id="chk_'.self::$_gridNameComponent.'_id" name="chk_'.self::$_gridNameComponent.'_all" onclick="'
                     . '
                        //alert(\'click\'); 
                        var chk = $(this);
                        $(\'table#' . self::$_gridNameComponent . '\').find(\'tbody\').find(\'tr\').each(function(){
                            if(chk.is(\':checked\')){
                            
                                if (!$(this).find(\':checkbox\').prop(\'disabled\')){
                                   $(this).find(\':checkbox\').prop(\'checked\',true);
                                   
                                   $(this).find(\':checkbox\').parents(\'tr\').addClass(\'success\');
                                }
                                
                            }else{
                                $(this).find(\':checkbox\').prop(\'checked\',false);
                                $(this).find(\':checkbox\').parents(\'tr\').removeClass(\'success\');
                            }
                            
                            if(!chk.is(\':checked\')){
                                console.log(\'no chequeados\');
                               //$(this).find(\':checkbox\').attr(\'disabled\',true);
                            }else
                            {
                                console.log(\'chequeados\');
                            }
                        });'
                    
                     .'">'
                     .'</th>';
        }
        //----------------------------------------------------------------------
        
        foreach (self::$_columns as  $nameColumn)
        {
            $title = isset($nameColumn['title']) ? $nameColumn['title'] :
                'Title';
            $colName = isset($nameColumn['dataCol']) ? $nameColumn['dataCol'] :
                'col';
            
            $thead .= '<th data-column="'.$colName.'">'. $title .'<span style="cursor:pointer;" class="icon-move-up pull-right" title="Ordenar por: '. $colName .'"></span></th>';
        }
        //SI EXISTEN CONFIGURADAS ACCIONES::
        if (self::$_arrActionsConfig){
            $thead .= '<th>Acciones</th>';
        }
        //---------[ FINAL CHANGE ACTIONS ]-
        $thead .=   '</tr>';
        $thead .= '</thead>';
        return $thead;
    }
    
    public static function setArrayDataPaginator($arrayPaginator = array())
    {
        //EXTRACCION DE LA DATA ::
        self::$criterio = isset($arrayPaginator['criterio'])?$arrayPaginator['criterio']:'';
       
        //FLAG INFO 
        self::$flagInfo = isset($arrayPaginator['flagInfo'])?$arrayPaginator['flagInfo']:false;
        
        //recopilacion de los datos del SUB ARRAY
        //CONTIENE PAGINATOR?
        self::$ajaxDataPaginate = isset($arrayPaginator['paginate'])?$arrayPaginator['paginate']:false;
        //NUMERO POR DEFECTO DE BOTONES PARA PAGINAR
        self::$itemPaginas = isset(self::$ajaxDataPaginate['itemPages'])?self::$ajaxDataPaginate['itemPages']:5;
        //PAGINA
        self::$page =  isset(self::$ajaxDataPaginate['page'])?self::$ajaxDataPaginate['page']:'';
        //REGISTROS POR PAGINA
        self::$registrosXpagina = isset(self::$ajaxDataPaginate['regXpage'])?self::$ajaxDataPaginate['regXpage']:'';
        
        //METODO DE ORDENAMIENTO - COLUMNA::
        self::$_nameColumnOrder = isset($arrayPaginator['orderColumn'])?$arrayPaginator['orderColumn']:'';
        self::$_nameOrderType = isset($arrayPaginator['orderByType'])?$arrayPaginator['orderByType']:'';
    }
    
    public static function addColumn ($objDataArray)
    {
        self::$_columns[] = $objDataArray;
    }
    
    /** ************************************************************************
     * 
     * @param type $objDataRows
     */
    public static function addDataRows ($objDataRows, $gridName)
    {
        self::$_dataRows = $objDataRows;
        self::$_gridNameComponent = $gridName;
        //self::$_countDataRows = count(self::$_dataRows);
        self::$_countDataRows = self::$_dataRows[0]['partialTotal'];
        self::$_countDataRows = (int)self::$_countDataRows;
    }
    
    public static function getCountDataRows()
    {
        return self::$_countDataRows;
    }
    public static function getDataRows ()
    {
        return self::$_dataRows;
    }
    
    
    
    
    
    public static function createPaginatorComponent()
    {
        //url global de la aplicacion:: 
        $urlGlobal = URL_SINGLE_APPLICATION;
        //--------------------------------------------
        $totalRows = self::$_countDataRows;
        $currentPage = self::$ajaxDataPaginate['page'];
        //ALMACENANDO LA PAGINA ACTUAL PARA EL COMBO::
        self::$_currentPageGlobal = $currentPage;
        
        $length = self::$ajaxDataPaginate['regXpage'];
        
        $numPaginas = ceil($totalRows / $length);
        $itemPage = ceil(self::$itemPaginas / 2);
        
        $pagInicio = ($currentPage - $itemPage);
        $pagInicio = ($pagInicio <= 0)?1:$pagInicio;
        $pagFinal = ($pagInicio + (self::$itemPaginas - 1)); 
        
        //------------ INFO PAGINATE --------------------
        $trInicio = (($currentPage * $length) - $length) + 1;
        $trFinal = ($currentPage * $length);
        $cantidadRegs = ($trFinal - ($trFinal - $length));
        //operacion ternaria anidada
        $trCantidadParcialRegs = ($cantidadRegs < $length)?
                ($cantidadRegs === $totalRows)?
                $cantidadRegs:($trFinal - ($length - $cantidadRegs)) 
                : $trFinal;
        
        self::$_infoTextPaginate = $trInicio . ' al ' . $trFinal . ' de ' . '<span id="id-span-pagTotal" class="label label-primary">' .$totalRows . '</span>';
        //INFO PAGINATE END ]----------------------------
        
        $ul =  '<ul class="pagination pull-left">';
        //BOTONES PRIMEROS
        if ($currentPage > 1)
        {
            $disableFirst = '';           
            $clickFirst = self::$ajaxDataPaginate['ajaxRequest'] . '(\''. $urlGlobal .'\',\''.self::$criterio.'\',1,\'' . self::$ajaxDataPaginate['regXpage'] .'\',\'' . self::$_nameColumnOrder . '\',\'' . self::$_nameOrderType . '\')';
            $clickPrev  = self::$ajaxDataPaginate['ajaxRequest'] . '(\''. $urlGlobal .'\',\''.self::$criterio.'\',\''. ($currentPage - 1) .'\',\'' . self::$ajaxDataPaginate['regXpage'] .'\',\'' . self::$_nameColumnOrder . '\',\'' . self::$_nameOrderType . '\')';
        }
        else
        {
            $disableFirst = 'disabled'; 
            $clickFirst = '';
            $clickPrev  = '';
        }
        $ul .= '<li class="'. $disableFirst .'"><a href="javascript:;" onclick="'. $clickFirst .'"><span class="glyphicon glyphicon-fast-backward"></span></a></li>';//glyphicon glyphicon-fast-backward
        $ul .= '<li class="'. $disableFirst .'"><a href="javascript:;" onclick="'. $clickPrev .'"><span class="glyphicon glyphicon-backward"></span></a></li>';//glyphicon glyphicon-backward
        //FINAL BOTONES PRIMEROS
        
        //BOTONES MEDIOS
        //conf:: *******
        $activeButton = '';
        $click = '';
        
        for($i = $pagInicio; $i <= $pagFinal; $i++)
        {
            if ($i <= $numPaginas)
            {
                if ($i == $currentPage)
                {
                    $activeButton = 'active';
                    $click = '';
                                        
                }
                else
                {
                    $activeButton = '';
                    $click = self::$ajaxDataPaginate['ajaxRequest'] . '(\''. $urlGlobal .'\',\''.self::$criterio.'\',\''. $i .'\',\'' . self::$ajaxDataPaginate['regXpage'] .'\',\'' . self::$_nameColumnOrder . '\',\'' . self::$_nameOrderType . '\')';
                    //$click = self::$ajaxDataPaginate['ajaxRequest'] . '(\''. $urlGlobal .'\',\''.self::$criterio.'\',\''. ($currentPage + 1) .'\',\'' . $length .'\')';
                    
                }
                //RENDER URL ::
                $ul .= '<li class="'.$activeButton.'"><a href="javascript:;" onclick="'.$click.'">'.$i.'<span class="sr-only"></span></a></li>'; //dentro del span text=(página actual)
            } 
            else
            {
                //ROMPER PROCESO POR CICLO
                break;
            }
        }
        //FINAL BOTONES MEDIOS
        $disableLast = '';
        $clickNext = '';
        $clickLast = '';
        
        if ( $numPaginas > 1 && $currentPage != $numPaginas)
        {
            $disableLast = '';
            $clickNext = self::$ajaxDataPaginate['ajaxRequest'] . '(\''. $urlGlobal .'\',\''.self::$criterio.'\',\''. ($currentPage + 1) .'\',\'' . self::$ajaxDataPaginate['regXpage'] .'\',\'' . self::$_nameColumnOrder . '\',\'' . self::$_nameOrderType . '\')';
            $clickLast = self::$ajaxDataPaginate['ajaxRequest'] . '(\''. $urlGlobal .'\',\''.self::$criterio.'\',\''. $numPaginas .'\',\'' .        self::$ajaxDataPaginate['regXpage'] .'\',\'' . self::$_nameColumnOrder . '\',\'' . self::$_nameOrderType . '\')';
        
        }else
        {
            $disableLast = 'disabled';
            $clickNext = '';
            $clickLast = '';
        }
 
        $ul .= '<li class="'. $disableLast .'"><a href="javascript:;" onclick="'. $clickNext .'"><span class="glyphicon glyphicon-forward"></span></a></li>';//glyphicon glyphicon-fordward
        $ul .= '<li class="'. $disableLast .'"><a href="javascript:;" onclick="'. $clickLast .'"><span class="glyphicon glyphicon-fast-forward"></span></a></li>';//glyphicon glyphicon-fast-fordward     
        //BOTONES ULTIMOS :: BEGIN
        
        //BOTONES FINALES :: END
        $ul .= '</ul>';
        
        return $ul;
    }
    
    //**************************************************************************
    /**
     * OUTPUT
     * @return string
     */
    public static function renderTable ()
    {
        $table = '<div class="container_pagin"><label style="font-weight: normal;">Ingrese el nombre a buscar:</label>';
        $table .= '</div>';        
        
        //$table .= '<table id="'.self::$_gridNameComponent.'" class="table table-striped table-bordered table-hover table-condensed">';
        $table .= '<table id="'.self::$_gridNameComponent.'" class="table table-bordered table-hover table-condensed">';
            //RENDERIZANDO EL <THEAD>
            $table .= self::createTableHeader();        
            //RENDERIZAR EL <TBODY>
            $table .= self::createDataRowsTABLE();        
        $table .= '</table>';
                
        //VALIDACION :: ES UN ARRAY ] :: ?
        if (count(self::$ajaxDataPaginate) && is_array(self::$ajaxDataPaginate))
        {
            $htmlPaginate = self::createPaginatorComponent();
            

            
            $table .= '<div class="container_pagin">';
            
            $table .= '<div class="pagin_inline pull-right pagin_info">';
            
            if (self::$flagInfo == true){

                $table .= self::$_infoTextPaginate;
                //MOSTRAR UN SELECT CON EL TAMAÑO A MOSTRAR
                $table .= self::changeLengthSelectComponent();
            }                

            $table .= '</div>';
            
            $table .= '<div class="pagin_inline pull-left">';
            $table .= $htmlPaginate;
            $table .= '</div>';

            $table .= '<div class="clearfix">';
            $table .= '</div>';
            
            $table .= '</div>';
        }

        return $table; 
    }
    
}
