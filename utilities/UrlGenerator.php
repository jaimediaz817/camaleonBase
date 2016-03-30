<?php

/*
 *  CONKRETEMOS SAS
 *  Licencia de cabeceras para el proyecto CONKRETEMOS SAS
 *  author:  ing Jaime Diaz G.
 *  2016  COMPANY
 */

/**
 * Description of UrlGenerator
 *
 * @author Jaime Diaz <jaimeivan0017@gmail.com>
 */
namespace utilities;
class UrlGenerator {
    //put your code here
        /**
         * CONSTRUCTOR __
         */
	public function __Construct(){
//		echo "me instanciaron";
	}     
	public function obtenerURL() {
	  $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
	  $protocol = $this->strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/") . $s;
	  $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
//           print_r ("<br>DESDE URL GENERATOR: ". $_SERVER['REQUEST_URI']);
	  return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
	}
         public function getAmbienteApplication(){
            $urlCompleta = $this->obtenerURL();
            $datos = parse_url($urlCompleta);
            foreach ($datos as $key=>$value) {
//              echo "URL-GENERATOR ::  ". "$key: $value <br>";
            } 
//            echo "<br>URL-GENERATOR ::::::::::  GET AMBIENTE APP:::::::::::::   [". $datos['host']. "]";
            $hostVar = $datos['host'];
            return $hostVar;
         }
         
         public function getSingleURLRoot(){   
            $urlCompleta = $this->obtenerURL();
            $datos = parse_url($urlCompleta);
            foreach ($datos as $key=>$value) {
//              echo "URL-GENERATOR ::  ". "$key: $value <br>";
            }
//           echo "<br>URL-GENERATOR ::::::::::::::::::::::::::::::::::::   [". $datos['host']. "]";
           $hostVar = $datos['host'];
            $path = explode("/", $datos['path']);
            //validacion para el tipo de ambiente:
            if ($hostVar == 'localhost'){
//                echo "<br><br>URL-GENERATOR :: HOST LOCAL O PRODUCCION ? :[". $hostVar . "]";
                //cambiar la visibilidad del proyecto
                $explodePath = $path[1]. "/";
            }else {
                $explodePath = $path[0];
            }
            $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
//            echo "URL - GENERATOR :: PORT:::::::::::::   " . $_SERVER["SERVER_PORT"];
           return  $datos['scheme']."://". $datos['host'] . $port ."/". $explodePath;         
//            $urlCompleta = $this->obtenerURL();
//            $datos = parse_url($urlCompleta);
//            foreach ($datos as $key=>$value) {
//              echo "$key: $value <br>";
//            }
//            echo "<br> antes del explode: " . $datos['host'];
//            $path = explode("/", $datos['path']);
//            
//	  return  $datos['scheme']."://". $datos['host'] . ":" . $datos['port']. $path[1]. "/";
         }
         public function obtenerURL_DirectorioActual(){
//             echo getcwd();
             $varPath = getcwd();
             return $varPath;
         }
         public function get__DIRname(){
             $dirname = dirname(__DIR__);
             return $dirname;
         }
	public function strleft($s1, $s2) {
	  return substr($s1, 0, strpos($s1, $s2));
	}    
    
}

