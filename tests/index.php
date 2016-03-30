<?php

/*
*  CONKRETEMOS SAS
*  Licencia de cabeceras para el proyecto CONKRETEMOS SAS
*  author:  ing Jaime Diaz G.
*  2016  COMPANY
*/
    try {
             $conn = new PDO('mysql:host=concretospiura.com.mysql;dbname=concretospiura_','concretospiura_','gidetdatabase817');
             echo "Conexión realizada con éxito !!!";
             
             $consulta = "SELECT * FROM usuario";
             $res = $conn->query($consulta);
             
             if (!$res){
                 print ("error");
             }else{
                 foreach ($res as $value){
                     print ("<p> $value[username] </p>\n");
                 }
             }
    }
    catch (PDOException $ex) {
             echo $ex->getMessage();
             exit;
    }	





