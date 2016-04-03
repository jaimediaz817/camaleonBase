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
        
        if (!empty($email)){
            //consultando en la BD
            $userObj = Usuario::getBy("email", $email);                        
            if ($ajax){
                //validacion de existencia :: OPERACION TERNARIA
                $userObj = (empty($userObj) ? false : true);
                $respuesta["success"] = $userObj;
            }else{
                //validacion de existencia
                $userObj = (empty($userObj) ? null: $userObj);                
            }
            //var_dump($userObj);
        }else {
            ResourceBundleV2::writeDebugLOG("006", "NO HAY ARGUMENTOS");
            $respuesta["success"] = false;
        }
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
        if (!empty($userName))
        {
            //consultando en la BD
            $userObj = Usuario::getBy("username", $userName);
            // SI ES VIA AJAX LA PETICION **********************
            if ( $ajax)
            {
                //validacion de existencia :: OPERACION TERNARIA
                $userObj = (empty($userObj) ? false : true);
                $respuesta["success"] = $userObj;
            }
            else 
            {
                //validacion de existencia
                $userObj = (empty($userObj) ? null: $userObj);                
            }
        }
        else
        {
            $respuesta["success"] = false;
        }
        //print response ***********
        echo json_encode($respuesta);
    }
    public function iniciarSessionUsuario()
    {
        if (filter_input(INPUT_POST, "username") != null &&
                filter_input(INPUT_POST, "password") != null)
        {
            //seteando los parametros filtrados en POST
            $usernamePOSTFilter = filter_input(INPUT_POST, "username");
            $passwordPOSTFilter = filter_input(INPUT_POST, "password");
            //creando instancia de USUARIO :: POST
            $userObjPOST = new Usuario(null, $usernamePOSTFilter, $passwordPOSTFilter);
            //creando instancia por reflexion y buscando USUARIO :: PDO
            $userObjDb = Usuario::getBy("username", filter_input(INPUT_POST, "username"));
            //PROGRAMACION DEFENSIVA ]
            if (!is_null($userObjDb)){
                //Business logic Lyer ]*****************************************
                $arrayResponse = User_business::iniciarLoginUser($userObjDb , $userObjPOST);
            } else {
                $arrayResponse["error"] = 1;
                $arrayResponse["username"] = false;
                $arrayResponse["password"] = false;
            }
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
        
        
        $_POST["id"] = null;
        //----------------------------------------------------------------------
        
        // ASIGNACION DE VARIABLES QUE LLEGAN DE SESSION-CONTROLLER.JS ]********
        $_POST["fechaCreacion"] = 'changeDataVoid_LOL :)';
        $_POST["estadoRegistro"] = FALSE;
        $_POST["keyGenerator"] = "keyGen";
        /**
         *  para evitar que realice una insercion de mas o inyeccion se aplica
         *  un filtro
         */
        $this->validateKeys($keys, filter_input_array(INPUT_POST));
        /**
         * el filtrado a traves de filter_input_array ( INPUT:: POST ) DENTRO
         * del arreglo metodo post creado por apache hace las peticiones
         */
        $objUser = Usuario::instanciate($_POST);
//        print_r($objUser);
        $objCreate = $objUser->create();
//        print_r($objCreate);
        echo json_encode($objCreate);
        //***************[ GESTION DE LA SESSION ] *****************************
        //              [ BUSINESS - LOGIC - LYER ]
        /*
         * OJO! NO SE CREA LA SESSION HASTA QUE NO HAYA CAMBIADO EL ESTADO DEL
         * REGISTRO ENVIADO A TRAVES DEL MAIL DE CONFIRMACION
         */
        if ( $objCreate["error"] == 0)
        {
            //User_business::crearUserSession($objUser);
        }
        //**********************************************************************
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
}

