<?php

/*
 *  CONKRETEMOS SAS
 *  Licencia de cabeceras para el proyecto CONKRETEMOS SAS
 *  author:  ing Jaime Diaz G.
 *  2016  COMPANY
 */

/**
 * Description of User_keyInformationDTO
 *
 * @author Jaime Diaz <jaimeivan0017@gmail.com>
 */
class User_keyInformationDTO extends Model implements IModel
{
    // ARRAYS DATA CONF ]-------------------------------------------------------
    protected static $table = "User_keyInformationDTO";
    protected static $table2 = "table2testing";
    protected static $tablesQuery = array(
            "us" => "usuario",
            "k" => "key_generator"
    );    
    protected static $columnAlias = array(
            "us1" => "id",
            "us2" => "username",
            "us3" => "password",
            "us4" => "email",
            "us5" => "fechaCreacion",
            "us6" => "estadoRegistro",
            "us7" => "horaCreacion",
            "us8" => "idKeyGenerator", // [FK-KEY_GENERATOR]
            //KEY_GENERATOR :: TABLE
            "key1" => "id",            // [PK-KEY_GENERATOR]
            "key2" => "codeGenerator",
            "key3" => "codeState",
            "key4" => "dataInit",
            "key5" => "dataExpired"         
    );
    
    protected static $onJoinsColumn = array(
        "on1" => "us.idKeyGenerator = k.id"
    );
    
    protected static $whereColumnAlias = array();
    //--------------------------------------------------------------------------

    //USER :: TABLE *****
    private $id;
    private $username;
    private $password;
    //[ new properties ]-------
    private $email;
    private $fechaCreacion;
    private $estadoRegistro;
    
    private $keyGenerator;
    private $nivelAcceso;
    
    private $idKeyGenerator;
    
    private $horaCreacion;
    

    
    //KEY_GENERATOR :: TABLE *****
    private $codeGenerator;
    private $codeState;
    private $dataInit;
    private $dataExpired;
    //--------------------------------------------------------------------------
    
    //METODO IMPLEMENTADO DE LA INTERFACE IModel
    public function getMyVars() {
       return get_object_vars($this);  
    }
    //--------------------------------------------------------------------------
    function __construct0()
    {
        
    }
    
    function __construct($id=0, $username='', $password='', $email='', $fechaCreacion='', 
            $estadoRegistro=0, $keyGenerator='', $nivelAcceso=0,  $idKeyGenerator=0, $horaCreacion='', $codeGenerator='', 
            $codeState=0, $dataInit='', $dataExpired='') {
        
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->fechaCreacion = $fechaCreacion;
        $this->estadoRegistro = $estadoRegistro;
        
        $this->keyGenerator = $keyGenerator;
        $this->nivelAcceso = $nivelAcceso;
        
        $this->idKeyGenerator = $idKeyGenerator;
        
        $this->horaCreacion = $horaCreacion;
        $this->codeGenerator = $codeGenerator;
        $this->codeState = $codeState;
        $this->dataInit = $dataInit;
        $this->dataExpired = $dataExpired;
    }


    function getId() {
        return $this->id;
    }

    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function getEmail() {
        return $this->email;
    }

    function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    function getEstadoRegistro() {
        return $this->estadoRegistro;
    }

    function getHoraCreacion() {
        return $this->horaCreacion;
    }

    function getCodeGenerator() {
        return $this->codeGenerator;
    }

    function getCodeState() {
        return $this->codeState;
    }

    function getDataInit() {
        return $this->dataInit;
    }

    function getDataExpired() {
        return $this->dataExpired;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }

    function setEstadoRegistro($estadoRegistro) {
        $this->estadoRegistro = $estadoRegistro;
    }

    function setHoraCreacion($horaCreacion) {
        $this->horaCreacion = $horaCreacion;
    }

    function setCodeGenerator($codeGenerator) {
        $this->codeGenerator = $codeGenerator;
    }

    function setCodeState($codeState) {
        $this->codeState = $codeState;
    }

    function setDataInit($dataInit) {
        $this->dataInit = $dataInit;
    }

    function setDataExpired($dataExpired) {
        $this->dataExpired = $dataExpired;
    }

    function getIdKeyGenerator() {
        return $this->idKeyGenerator;
    }

    function setIdKeyGenerator($idKeyGenerator) {
        $this->idKeyGenerator = $idKeyGenerator;
    }
    function getKeyGenerator() {
        return $this->keyGenerator;
    }

    function getNivelAcceso() {
        return $this->nivelAcceso;
    }

    function setKeyGenerator($keyGenerator) {
        $this->keyGenerator = $keyGenerator;
    }

    function setNivelAcceso($nivelAcceso) {
        $this->nivelAcceso = $nivelAcceso;
    }


//put your code here
}
