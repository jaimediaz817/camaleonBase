<?php

/*
 *  CONKRETEMOS SAS
 *  Licencia de cabeceras para el proyecto CONKRETEMOS SAS
 *  author:  ing Jaime Diaz G.
 *  2016  COMPANY
 */

/**
 * Description of DataComponents_controller
 * @author Jaime Diaz <jaimeivan0017@gmail.com>
 */
class DataComponents_controller extends Controller
{
    //put your code here
    function __construct() {
        parent::__construct();
        ResourceBundleV2::writeDebugLOG("002", "Se instancio DataComponets_controller()");
    }
    
    //DATAGRID COMPONENT ]------------------------------------------------------
    public function renderDataGridComponent ()
    {
        //REGOGIENDO DATOS POR POST::
        $getCriterio = isset($_REQUEST['_criterio'])?$_REQUEST['_criterio']:'';
        
        $getPagina = isset($_REQUEST['_pagina'])?$_REQUEST['_pagina']:'';
        $getPagina = (int)$getPagina;
        $getRegistrosXpagina =  isset($_REQUEST['_regxpagina'])?$_REQUEST['_regxpagina']:'';       
        $getRegistrosXpagina = (int)$getRegistrosXpagina; 

        $getColumnNameOrder = isset($_REQUEST['_columnNameOrder'])?$_REQUEST['_columnNameOrder']:'';
        $getOrderType = isset($_REQUEST['_orderType'])?$_REQUEST['_orderType']:'';
        //*****
        

        
        //COLUMNAS A CONSULTAR EN EL SP ]---------------------------------------
        $cols = array(
            0 => "id",
            1 => "email",
            2 => "username",
            3 => "fechaCreacion",
            4 => "horaCreacion",
            5 => "nivelAcceso"
        );
        $wheres = array(
            0 => "username",
            1 => "email"
        );
        //criterio de BUSQEUDA
        $criterio = $getCriterio;
        //----------------------------------------------------------------------
        //CONSULTA SP
//        $resultados = Usuario::call_sp_Generic(
//                $cols, $criterio, $wheres, $getPagina, $getRegistrosXpagina,$getColumnNameOrder,$getOrderType);
        
        $resultadosDAO = 
             DataGridComponentDAO::callSPGenericDataGridComponent(
                     $cols, $criterio, $wheres, $getPagina, $getRegistrosXpagina, 
                     $getColumnNameOrder, $getOrderType);
        
        
        //[datagridcomponent ]--------------------------------------------------
        //CONFIGURACION DEL ARRAY ]---------------------------------------------
        $ajaxRequestPagerConf = array(
            "flagInfo" => true,
            //DATOS BASICOS:: criterio
            "criterio" => $getCriterio,  
            //ORDENAMIENTO
            "orderColumn" => $getColumnNameOrder,
            "orderByType" => $getOrderType, //or desc
            
            //sub array con los detalles de la nueva peticion
            "paginate" => array(
                "ajaxRequest" => "objDataGridComponent.getRenderDataGridComponent",
                "page" => $getPagina,
                "regXpage" => $getRegistrosXpagina,
                "itemPages" => 5 //<=== cantidad de botones
            )
        );
        //-----[ CONFIGURACION DE LAS ACCIONES ]--------------------------------
        $actionsByEveryDataRowEDIT = array(
            "titulo" => "Editar",
            "icono" => "glyphicon glyphicon-pencil",
            // ARRAY peticiones *****
            "ajax_request" => array(
                "function" => "objDataGridComponent.editObject",
                // ARRAY parametros *****
                "params" => array(
                   "username" ,"email","id", "nivelAcceso"
                )
            )
        );
        //----------------------------------------------------------------------
        
        //-----------[ CONFIGURACION DEL CHECK-BOX ]----------------------------
        $arrCheckBoxByEveryRow = array(
            "values" => array("username", "email"),
            "ajax_request" => array(
                "function" => "objDataGridComponent.checkObjectElement",
                "params" => array("username","email")
            ),
            "fnCallBack" => function ($countRow, $row, $posibleRenderCheck)
            {
                $renderCheck = '';
                //cuerpo del callBack
                if ($row['nivelAcceso'] == 1)
                {
                    $renderCheck = '<input type="checkbox" id="chk'.$countRow. '" name="chk_gridUs[]" values="test" disabled />';
                }
                else
                {                    
                    $renderCheck = $posibleRenderCheck;
                }
                
                return $renderCheck;
            }
        );
        //----------------------------------------------------------------------        
        DataGridComponent::addColumn(array(
            "title" => "ID",
            "dataCol" => "id"
        ));        
        DataGridComponent::addColumn(array(
            "title" => "USERNAME",
            "dataCol" => "username"
        ));        
        DataGridComponent::addColumn(array(
            "title" => "EMAIL",
            "dataCol" => "email"
        ));               
        DataGridComponent::addColumn(array(
            "title" => "FECHA CREACION",
            "dataCol" => "fechaCreacion"
        ));             
        DataGridComponent::addColumn(array(
            "title" => "HORA CREACION",
            "dataCol" => "horaCreacion"
        ));                  
        DataGridComponent::addColumn(array(
            "title" => "NIVEL DE ACCESO",
            "dataCol" => "nivelAcceso"
        ));     
        //*****************[  ADD CONFIGURATIONS ]------------------------------        
        //ADD DATA
        
//        DataGridComponent::addDataRows($resultados, 'gridUs');
        DataGridComponent::addDataRows($resultadosDAO, 'gridUs');
        //--------------------------------------
        //ACCION EDITAR
        DataGridComponent::addActionComponentByRow($actionsByEveryDataRowEDIT);
        //ACCION ACTUALIZAR
        
        //ACCION ELIMINAR
        
        //ACCION CHECKBOX        
        DataGridComponent::addArrayCheckBoxByRow($arrCheckBoxByEveryRow);
        //---------------------------------------
        //ADICIONAR ARRAY PAGINATOR
        DataGridComponent::setArrayDataPaginator($ajaxRequestPagerConf);
               
//        $count = DataGridComponent::getCountDataRows();        
//        $usersDataRows = DataGridComponent::getDataRows();
        
        $tmpTableRender = DataGridComponent::renderTable();
        //ResourceBundleV2::writeHELPERSLog("_dataGrid 001", $tmpTableRender);
        
        echo  $tmpTableRender;
    }
}
