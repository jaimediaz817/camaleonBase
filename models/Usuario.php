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
 * Description of Usuario
 *
 * @author Jaime Diaz <jaimeivan0017@gmail.com>
 */
class Usuario extends Model {
    //put your code here
    protected static $table = "usuario";
    
    
    //protected static $table2 = "table2Join";
    
    
    private $id;
    private $username;
    private $password;
    //[ new properties ]----------------------------------------------------------
    private $email;
    private $fechaCreacion;
    private $estadoRegistro;
    private $horaCreacion;
    //temporal field :: integridad referencial
    private $keyGenerator;
    //-------[ END TEMPORAL FIELD ]----------
    private $nivelAcceso;
    //-------[ FK-idKeyGenerator ]-----------
    private $idKeyGenerator;
    //--------------------------------------------------------------------------
    
    //[ OBJECTS ]---------------------------------------------------------------
    private $keyGeneratorObj;
    
    //-------------------[ RELACIONES UNO A MUCHOS ]----------------------------
    private $has_many = array(
        //NOMBRE DE LA RELACION
        'Amigos' => array(
            'class' => 'Usuario',
            'my_key' => 'id',
            'other_key' => 'id',
            'join_other_as' => 'idAmigo',
            'join_self_as' => 'idUsuario',
            'join_table' => 'amigos_usuario'
        )                
    );
    //--------------------------------------------------------------------------
    
    //----------------[ RELACION BOLATERAL 1-1 USUARIO- TIENDA]-----------------
        private $known_as = array(
        
            'Owner' => array(
                'class' => 'tienda',
                'join_as' => 'id',
                'join_with' => 'owner'
            )        
        );
    //--------------------------------------------------------------------------
    
    //----------------[ RELACION BOLATERAL 1-1 KEYGENERATOR - USUARIO]----------
    private $has_one = array(    
            //nombre de la relacion:
            'perosnalKeyGen' => array(
                'class' => 'KeyGenerator',
                'join_as' => 'idKeyGenerator',
                'join_with' => 'id'
            )                        
    );
    //--------------------------------------------------------------------------
    
    function __construct($id, $username, $password, $email='', $fechaCreacion='', 
            $estadoRegistro=0, $keyGenerator='', $nivelAcceso = 0, $idKeyGenerator = null,
            $horaCreacion='') {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        //-----------------------------------
        $this->fechaCreacion = $fechaCreacion;
        $this->estadoRegistro = $estadoRegistro;
        $this->keyGenerator = $keyGenerator;
        $this->nivelAcceso = $nivelAcceso;
        $this->horaCreacion = $horaCreacion;
        //------[ FK - fields ]--------------
        $this->idKeyGenerator = $idKeyGenerator;
    }

    /**
     * metodo que me permite obtener todas las variables de éste objeto
     * 
     */
    public function getMyVars(){
        return get_object_vars($this);
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

    function setId($id) {
        $this->id = $id;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setPassword($password) {
        $this->password = $password;
    }
    function setEmail($email){
        $this->email = $email;
    }
    function getEmail(){
        return $this->email;
    }
    function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }
    function getEstadoRegistro() {
        return $this->estadoRegistro;
    }

    function getKeyGenerator() {
        return $this->keyGenerator;
    }

    function setEstadoRegistro($estadoRegistro) {
        $this->estadoRegistro = $estadoRegistro;
    }

    function setKeyGenerator($keyGenerator) {
        $this->keyGenerator = $keyGenerator;
    }
    //--------------------------------------------------------------------------
    function getKeyGeneratorObj() {
        return $this->keyGeneratorObj;
    }

    function setKeyGeneratorObj(KeyGenerator $keyGeneratorObj) {
        $this->keyGeneratorObj = $keyGeneratorObj;
    }
    function getNivelAcceso() {
        return $this->nivelAcceso;
    }

    function setNivelAcceso($nivel_acceso) {
        $this->nivelAcceso = $nivel_acceso;
    }
    function getHoraCreacion() {
        return $this->horaCreacion;
    }

    function setHoraCreacion($horaCreacion) {
        $this->horaCreacion = $horaCreacion;
    }
   //------------------[ FK :: FIELDS ]-----------------------------------------
   function getIdKeyGenerator() {
       return $this->idKeyGenerator;
   }

   function setIdKeyGenerator($idKeyGenerator) {
       $this->idKeyGenerator = $idKeyGenerator;
   }
   //---------------------------------------------------------------------------
    function getHas_many() {
        return $this->has_many;
    }
    function setHas_many($has_many) {
        $this->has_many = $has_many;
    } 
    
    function getKnown_as() {
        return $this->known_as;
    }

    function setKnown_as($known_as) {
        $this->known_as = $known_as;
    }    
    function getHas_one() {
        return $this->has_one;
    }

    function setHas_one($has_one) {
        $this->has_one = $has_one;
    }


}

