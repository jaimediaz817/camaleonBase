<?php

/*
 *  CONKRETEMOS SAS
 *  Licencia de cabeceras para el proyecto CONKRETEMOS SAS
 *  author:  ing Jaime Diaz G.
 *  2016  COMPANY
 */


/**
 * Description of ResourceBundleV2
 *
 * @author Jaime Diaz <jaimeivan0017@gmail.com>
 */

//namespace utilities;
class ResourceBundleV2 {

	private $arrayProp = null;
         public static $arrayConvertidoAStr = null;

	public static function getPropertiesInArray($pathFile){
                  //$path = "src/infrastucture/lyer-data/configProperties.txt";
                  $path= $pathFile;
//                  echo "<br>FROM RESOURCEBUNDLE:: GETPROP..   PATH: " . $path;
		static $arrayProp = array();
		$arrayProp = self::leerArchivo($path);
                  //proceso de conversion a str
                  //self::convertirDeArrayACadena($arrayProp);
                  //self::setArrayResultanteAconvertir($arrayProp);
		return $arrayProp;
	}
         public static function getTestString(){
		return "textStringTesting";
	}
         //---------------------------------------------------------------------
//         private static function setArrayResultanteAconvertir($arrayEntrante){
//             self::$arrayConvertidoAStr = $arrayEntrante;
//         }
//         private static function getArrayResultanteAconvertir(){
//             return self::$arrayConvertidoAStr;
//         }
         public static function convertirDeArrayACadena($arrayConvertidoAStr){
             
            $resultante = implode(",", $arrayConvertidoAStr);
            $arrayResultante = explode(',', $resultante);
            
            return $arrayResultante;
         }
         /**
          * function interna que lee el archivo de propiedades
          * 
          * @param type $rutaFile
          * @return type
          */
	private static function leerArchivo($rutaFile){
		$ruta = $rutaFile;

		$arrayProperties = array();

		$prueba=fopen($ruta, "r")  or die ("Error write");

		while(!feof($prueba)){
			$line=fgets($prueba);
                           //ResourceBundleV1::writeErrorLOG("810", "linea: ". $line);
			//obtenigo la linea
			$saltoLinea=nl2br($line);
                           //quitando el <br /> de cada linea leida
//                           $tmpString = str_replace(array("<br />", "\n"), '', $saltoLinea);
                           $tmpString = str_replace(array("<br />", "\n"), '', $saltoLinea);
//                           ResourceBundleV1::writeErrorLOG("810", "tmp: ". $tmpString);
                           //ResourceBundleV1::writeErrorLOG("810", "salto de linea: ". $saltoLinea);
			//echo($saltoLinea);
			$propValue = explode("=", $tmpString);

                           //eliminando espacios a la derecha
                           $arrayProperties[$propValue[0]] = rtrim($propValue[1]);
//                           echo "<br>var dump: " . var_dump($arrayProperties[$propValue[0]]);
//                           ResourceBundleV1::writeErrorLOG("810", "from:: BUNDLE, PROP: ".$arrayProperties[$propValue[0]]);
			//valores::
//			echo "<br>RESOURCEBUNDLE ::  propiedad en el array :: [ ".  $arrayProperties[$propValue[0]]. " ]";
		}

		fclose($prueba);

		return $arrayProperties;
	}
         //LOG DE ERRORES :
         public static function writeErrorLOG($numero,$texto){ 
            $hoy = getdate();
            
            /*
                [seconds] => 40
                [minutes] => 58
                [hours]   => 21
                [mday]    => 17
                [wday]    => 2
                [mon]     => 6
                [year]    => 2003
                [yday]    => 167
                [weekday] => Tuesday
                [month]   => June
             */
            
//            echo"<br> FROM RESOURCEBUNDLE :: WRITE LOG, hora actual :: " .$hoy["hours"];
            $ddf = fopen('error.log','a'); 
            fwrite($ddf,"[".date("r")."] Error $numero: $texto\r\n"); 
            fclose($ddf); 
         }
        public static function writeDebugLOG($numero,$texto){ 
            $hoy = getdate();
            
            /*
                [seconds] => 40
                [minutes] => 58
                [hours]   => 21
                [mday]    => 17
                [wday]    => 2
                [mon]     => 6
                [year]    => 2003
                [yday]    => 167
                [weekday] => Tuesday
                [month]   => June
             */
            
//            echo"<br> FROM RESOURCEBUNDLE :: WRITE LOG, hora actual :: " .$hoy["hours"];
            $ddf = fopen('debug-info.log','a'); 
            fwrite($ddf,"[".date("r")."] info $numero: $texto\r\n"); 
            fclose($ddf); 
         }      
        public static function writeDATABASELOG($numero,$texto){ 
            $hoy = getdate();
            
            /*
                [seconds] => 40
                [minutes] => 58
                [hours]   => 21
                [mday]    => 17
                [wday]    => 2
                [mon]     => 6
                [year]    => 2003
                [yday]    => 167
                [weekday] => Tuesday
                [month]   => June
             */
            
//            echo"<br> FROM RESOURCEBUNDLE :: WRITE LOG, hora actual :: " .$hoy["hours"];
            $ddf = fopen('debug-DATABASE.log','a'); 
            fwrite($ddf,"[".date("r")."] info $numero: $texto\r\n"); 
            fclose($ddf); 
         }         
}
?>