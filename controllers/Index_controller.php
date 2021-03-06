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
        
        $this->view->varTestAccess = 0;
        
        ResourceBundleV2::writeHELPERSLog('001', 'hora :'. DataTimeManager::getFormatDate('-', 1) .
                " hora: " . DataTimeManager::getFormatTime(':', 1). ' full time: '. 
                DataTimeManager::getFullDateTime());
        $txt = GeneratorManager::getCharsetKey(8);
        ResourceBundleV2::writeHELPERSLog("006", "GeneratorManager: " .
                $txt);
        //echo phpinfo();
        $encriptado = StringSecurityManager::encriptarCadenaTexto('12345');
        $original = StringSecurityManager::desencriptarCadenaTexto($encriptado);
        ResourceBundleV2::writeHELPERSLog("encriptado: ", $encriptado);
        ResourceBundleV2::writeHELPERSLog("Desencriptado: ", $original);
        
        
        $arrayAss = array(
          "id" => "01",
          "codeGenerator" => "xyz",
          "codeState" => "1",
          "dataInit" => "date",
          "dataExpired" => "date" 
        );
        
        $objEx = KeyGenerator::instanciate($arrayAss);
        
        ResourceBundleV2::writeDATABASELOG("006_newEntity", "Probando entidad". $objEx->getId());
        //*****************************************************
        //             [ DEBUG MODE ]
        $this->view->debug = true;
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
            
            $Usuario = new Usuario(null, $username, $password, 'email'.GeneratorManager::getCharsetKey(2));
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
                //print_r("<br>Key foraneo :  " . $resultado->getIdKeyGenerator());
                print_r($resultado);
            }
        }
    }
    
    public function buscarUsuarioPorId ($id)
    {
        if (!empty($id))
        {
            $resultado = Usuario::getById($id);
            
            if (!is_null($resultado))
            {
                print_r($resultado);
            }
        }
    }
    
    public function buscarTiendaPorId ($id)
    {
        if (!empty($id))
        {
            $resultado = Tienda::getById($id);
            
            if (!is_null($resultado))
            {
                print_r($resultado);
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
            
            $friend->has_many("Amigos", $user);
            //$user->delete();
            $user->create();
            $friend->create();
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
    
    public function asignarKeyGeneratorAUser ()
    {
        $bandera1 = false; $bandera2 = false;
        if(isset($_GET["user"]) && isset($_GET["key"])){
            $user = $_GET["user"];
            $key = $_GET["key"];
            
            $userObj = Usuario::getById($user);
            $keyObj = KeyGenerator::getById($key); 
            
            if (is_null($userObj)){
                echo "no existe usuario obj";
            } else {
                print_r($userObj);
                echo "<br>";
                echo "----------------------------------------";
                echo "<br>";
                $bandera1 = true;
            }
            if (is_null($keyObj)){
                echo "no existe KeyGenerator obj";
            }else {
                print_r($keyObj);
                $bandera2 = true;
            }
            
            if ($bandera1 && $bandera2){
                echo "----------------------------------------";
                echo "<br> existen ambos objetos ";
                /*
                 * asignar un keyGenerator al user
                 */
                $keyObj->known_as("perosnalKeyGen", $userObj);
            }
            
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
    
    public function testMailComponent ($codeActivation)
    {
        //echo $codeActivation;
        
        $resultado = Usuario::getBy("keyGenerator", $codeActivation);
        
        echo $resultado->getKeyGenerator() ." , name ". $resultado->getUsername();
        echo $resultado->getEstadoRegistro();
        $resultado->setEstadoRegistro(4);
        
        if ($resultado->getEstadoRegistro() == 4){
            echo "LOL";
        }
        echo $resultado->getEstadoRegistro();
        $resultado->update();
        //print_r($resultado);
    }
    
    public function crearCodeGenerator ()
    {
        $arrayAss = array(
          "id" => null,
          "codeGenerator" => "xyz",
          "codeState" => 1,
          "dataInit" => "date",
          "dataExpired" => "date" 
        );
        
        $objEx = KeyGenerator::instanciate($arrayAss);     
        
        $res = $objEx->create();
        
        print_r($res);
    }
    public function obtenerUsuarios ()
    {
        $users = Array();
        
        $users = Usuario::getAll();
        print_r($users);
        foreach ($users as $key)
        {
           // ResourceBundleV2::writeDATABASELOG("008_getAll ", "element: ". $key . " , value : ". $val);
            echo "element ".$key["id"];
        }
    }
}

