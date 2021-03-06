<?php

/*
 *  CONKRETEMOS SAS
 *  Licencia de cabeceras para el proyecto CONKRETEMOS SAS
 *  author:  ing Jaime Diaz G.
 *  2016  COMPANY
 */

/**
 * Description of KeyGenerator
 *
 * @author Jaime Diaz <jaimeivan0017@gmail.com>
 */
class KeyGenerator extends Model implements IModel{
    
    protected static $table = "key_generator";
    
    private $id;
    private $codeGenerator;
    private $codeState;
    private $dataInit;
    private $dataExpired;
    
    
    //----------------[ RELACION BOLATERAL 1-1 USUARIO- KEYGENERATOR ]----------
    private $known_as = array(

        'perosnalKeyGen' => array(
            'class' => 'Usuario',
            'join_as' => 'id', // id => Usuario
            'join_with' => 'idKeyGenerator' // 
        )
    );    
    /**
     * 
     */
    public function getMyVars() {
        return get_object_vars($this);
    }
    function __construct($id, $codeGenerator, $codeState=0, $dataInit="", $dataExpired="") {
        $this->id = $id;
        $this->codeGenerator = $codeGenerator;
        $this->codeState = $codeState;
        $this->dataInit = $dataInit;
        $this->dataExpired = $dataExpired;
    }
    function getId() {
        return $this->id;
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
//---------------------------[ RELACIONES ]-------------------------------------
    function getKnown_as() {
        return $this->known_as;
    }

    function setKnown_as($known_as) {
        $this->known_as = $known_as;
    }



//put your code here
}
