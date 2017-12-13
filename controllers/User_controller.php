<?php

/*
 * Copyright (C) 2016 Jaime Diaz <jaimeivan0017@gmail.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

/**
 * Description of User_controller
 *
 * @author Jaime Diaz <jaimeivan0017@gmail.com>
 */
class User_controller extends Controller{
    function __construct() {
        parent::__construct();
        ResourceBundleV2::writeDebugLOG("002", "Se instancio User_controller()");
    }

    // METODOS :: ACCIONES
    public function signIn (){
        $this->view->render($this, "signIn");
    }
    
    public function userOptions(){
        $this->view->render($this, "userOptions");
    }
    public function signUp (){
        $this->view->render($this, "signUp");
    }
    /**
     * valida existencia de email
     * @param type $email
     * @param type $ajax
     */
    public function validarExistenciaEmail($email, $ajax = true)
    {    
        $respuesta = array();
        
        //------------[ USERNAME :: DAO ]---------------------------------------
        $respuesta = UserDAO::validarExistenciaEmailFromDATABASE($email, $ajax);
        //header("Content-type: application/json");
        //enviando la respuesta
        echo json_encode($respuesta);
    }
    /**
     * 
     * @param type $userName
     * @param type $ajax
     */
    public function validarExistenciaUsername ($userName, $ajax = true)
    {
        $respuesta = array();
        
        $respuesta = UserDAO::validarExistenciaUserNameFromDATABASE($userName, $ajax);
        //print response ***********
        echo json_encode($respuesta);
    }
    
    /**
     * 
     */
    public function iniciarSessionUsuario()
    {
        $arrayResponse = array();
        if (filter_input(INPUT_POST, "username") != null &&
                filter_input(INPUT_POST, "password") != null)
        {            
            //seteando los parametros filtrados en POST
            $usernamePOSTFilter = filter_input(INPUT_POST, "username");
            $passwordPOSTFilter = filter_input(INPUT_POST, "password");
            
            //LLAMANDO AL DAO INICIAR SESSION
            $arrayResponse = UserDAO::iniciarSessionUsuarioFromDATABASE(
                    $usernamePOSTFilter, $passwordPOSTFilter);
            
            //req 02-37
            $this->view->varTestAccess = 817;
            //end req 02-37
            
            //Business logic Lyer :: Codificando a JSON]************************
            echo json_encode($arrayResponse);            
        }
    }
    
    /**
     *  METODO QUE LLEVA A CABO EL REGISTRO DE UN NUEVO USUARIO
     */
    public function registrarNuevoUsuario()
    {
        //preguntar por las llaves que existen actualmente
        $keys = Usuario::getKeys();
        ResourceBundleV2::writeDATABASELOG("005_DATAPOST", "ARRAY_ ". $keys[4] . ' = '. $_POST["fechaCreacion"]);
                
        //quitar elemento del array::
        unset($keys[0]);
        //asignacion por defecto por campo autoincrementable
        $_POST["id"] = null;
        //----------------------------------------------------------------------
        
        // ASIGNACION DE VARIABLES QUE LLEGAN DE SESSION-CONTROLLER.JS ]********
        $_POST["fechaCreacion"] = DataTimeManager::getFormatDate('-', 1);
        $_POST["horaCreacion"] = DataTimeManager::getFormatTime(':', 1);
        $_POST["estadoRegistro"] = FALSE;
        $_POST["keyGenerator"] = "keyGen";
        $_POST["nivelAcceso"] = 1;
        $_POST["idKeyGenerator"] = 0;
        /***********************************************************************
         *  para evitar que realice una insercion de mas o inyeccion se aplica
         *  un filtro
         */
        $this->validateKeys($keys, filter_input_array(INPUT_POST));
                
        $_POST["idKeyGenerator"] = null;
        //$_POST["idKeyGenerator"] = null;
        
        //---------------[ DAO :: USER ]----------------------------------------
        $objCreate = array();
        $objCreate = UserDAO::registrarUsuarioFromDATABASE($_POST);
        //devolviendo respuesta al server
        echo json_encode($objCreate);   
        //----------------------------------------------------------------------
    }
    /**
     * 
     */
    public function destruirSessionGlobal ()
    {
        User_business::destruirUserSession(false);
        return true;
    }
    
    //******************[  TESTS   ]********************************************
    public function testRequest ($param) {        
        $return = false;
        if (!empty($param)){
            $return = true;
        }        
        echo $return;
    }
    
    public function testRequestPost(){
        $param = $_POST["param"];
        $response = false;
        if (!empty($param)){
            $response = true;
        }
        echo $response;
    }
    //***********************[ TESTEANDO LAS SESSIONS ]*************************
    public function testValidateSession()
    {
        if (!SessionApp::getValueSession("username"))
        {
            echo "no existe var session";
        }else {
            echo "existe variable de session";
        }
    }
    public function testCreateSession()
    {
        $user = new Usuario('01', 'jdiaz', '123', 'jdiaz@jdiaz.co');
        //print_r($user);
        User_business::iniciarSession();
        User_business::crearUserSession($user);
    }
    public function testDestroySession ()
    {
        User_business::destruirUserSession();
        $this->testValidateSession();
    }
    
    
    //----------------[ EXPERIMENTAL :: GET USERS ( ) ]-------------------------
    public function getUsersFromDB ()
    {
        $respuestaArr = array();
        if (isset($_POST["varRequest"]))
        {
            //$respuestaArr["success"] = 'respuesta OK ';
            //$respuestaArr["error"] = false;
            $respuestaArr = UserDAO::getAllUsersFromDATABASE();
        }else
        {
            $respuestaArr["success"] = "respuesta FAIL";
        }
        //enviando los usuarios por ajax
        echo json_encode($respuestaArr);
    }
    
    public function testJoinDataModel ()
    {
        echo("Join Data Model");
        
        //"WHERE us.id = '416' OR us.id = '32';
        //tablas => alias
        $arrWhere = array(
            $colName = array(
                0 => "us.id"//,
                //0 => "us.id
            ),
            $column = array(
                0 => "usid"
                //1 => "us.id"
            ),
            $value = array(
                0 => 32
                //1 => 16
            )            
        );
        //----------------------------------------------------------------------
        
        $objDTO = User_keyInformationDTO::getObjectDTOFromJoinsMethod($arrWhere);
        //echo $objDTO;
        if ($objDTO != null)
        {
            echo "EXISTEN REGISTROS";
            print_r($objDTO);
        }else{
            echo "NO HAY REGISTROS";
        }
    }
    public function testRelationalModel()
    {
        $obj = User_keyInformationDTO::setTable2();
        echo $obj;
    }
}

