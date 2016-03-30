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
 * Description of Index_controller
 *
 * @author Jaime Diaz <jaimeivan0017@gmail.com>
 */
class Index_controller extends Controller {
    //put your code here
    function __construct() {
        parent::__construct();
    }

    public function index( $param = null){
        
        $expParam = "";        
        if (empty($param)){
            $expParam = "vacio";
        } else {
            $expParam = $param;
        }
        
        //-------------- [ INCRUSTANDO VISTAS EN INDEX ]------------------------
        $userController = new User_controller();
        $this->view->userControllerObj = $userController;//->signIn();
        
        //*****************************************************
        //             [ DEBUG MODE ]
        $this->view->debug = false;
        $this->view->render($this, "index", 'Conkretemos SAS.');
    }
    
    /**
     * mecanismo de carga:
http://localhost:8081/conkretemos-SAS-sistemaComercial-BETA/Index/crearUsuario/?username=jdiaz&password=18402120     *
     */
    public function crearUsuario () {
        
        if ( isset($_GET["username"]) && isset($_GET["password"])){
            $username = $_GET["username"];
            $password = $_GET["password"];
            
            $args = ["username"=> $username, "password"=> $password];
            
            $Usuario = new Usuario(null, $username, $password);
            $Usuario->create();
            //metodo de carga por reflexion:
//            $usuarioReflx = Usuario::instanciate($args);
            print_r($Usuario);
            
            echo "<br>FROM: Index_controller:index Todos los usuarios: <br>";
            print_r(Usuario::getAll());
        }
    }
    
    public function buscarUsuario ($username) {
        if (!empty($username)){
            $resultado = Usuario::getBy("username", $username);
            
            if (is_null($resultado)){
                echo "<br> No existe el usuario: ". $username;
            } else {
                print_r("<br>Nombre:  " . $resultado->getUsername());
            }
        }
    }
    
    public function hacerAmigos (){
        if (isset($_GET["user"]) && isset($_GET["friend"])) {
            
            $user = $_GET["user"];
            $friend = $_GET["friend"];
            
            $user = Usuario::getBy("username", $user);
            $friend = Usuario::getBy("username", $friend);
            
            print_r("<br>");
            print_r($user->getUsername());
            print_r("<br>");
            print_r($friend->getUsername());
            
            $user->has_many("Amigos", $friend);
            $user->delete();
        }
    }
    
   public function asignarOwner(){        
        if(isset($_GET["user"]) && isset($_GET["shop"])){
            
            $user = $_GET["user"];
            $shop = $_GET["shop"];

            $user = Usuario::getById($user);
            $shop = Tienda::getById($shop);

            $user->known_as("Owner",$shop);

        }
    }
    
    public function obtenerEmail($email){
        if (!empty($email)){
            $userObj = Usuario::getBy("email", $email);
            
            //validacion de existencia
            $userObj = (empty($userObj) ? false: $userObj);
            var_dump($userObj);
        }
    }
}

