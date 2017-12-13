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
interface IUserDAO {
    //put your code here
    public static function getAllUsersFromDATABASE ();
    
    public static function iniciarSessionUsuarioFromDATABASE ( $username, $password );
    
    public static function registrarUsuarioFromDATABASE ( $arrayDataPOST = array() );
    
    public static function validarExistenciaUserNameFromDATABASE ( $username = '', $ajax);
    
    public static function validarExistenciaEmailFromDATABASE ( $email = '', $ajax);
 
}
