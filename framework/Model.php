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
 * Description of Model
 * @author pabhoz 
 * @author Jaime Diaz <jaimeivan0017@gmail.com>
 */
class Model {
    
    private static $db;
    protected static $table;
    
    //------------------[ EXPERIMENTAL - DTO ]----------------------------------
    protected static $tablesQuery = array();    
    protected static $columnAlias = array();
    protected static $onJoinsColumn = array();
    protected static $whereColumnAlias;    
    //--------------------------------------------------------------------------
    
    protected static $table2;
    private static $resultText;

    protected static function getConnection(){
     
        /*
         * PERFECCIONAR SINGLETON::
         * if (!(self::$db instaceof PDOManager))
         * {
         *   self::$db = new PDOManager();
         * }
         * return self::$db;
         */
                
     if(!isset(self::$db)){
        self::$db = new PDOManager(_DB_TYPE,_DB_HOST,_DB_NAME,_DB_USER,_DB_PASS);
        ResourceBundleV2::writeDATABASELOG("001_PDO", "from: MODEL: se instancio PDOManager en var static db");
     }
    }
    
    public function getRelationship($t){
        self::getConnection();
        return self::$db->getRelationship($t);
    }

    public static function setTable($table){
        self::$table = $table;
    }
            
    public static function getAll(){
        self::getConnection();
        $sql = "SELECT * FROM ".static::$table.";";
        return $results = self::$db->select($sql);
    }
    
    public static function call_sp_Generic( $column = array(), $criterios = '',
            $whereConcat = array(), $page, $regXpage, $colNameOrder, $orderType)
    {
        $_table = static::$table;
        $_criterios = $criterios;
        $_cols = '';
        $_wheresConcat = '';
        $come = ',';
        $counter = 0;
        $limit = count($column);
        
        //REQUERIMIENTO DE ORDENAMIENTO::
        $columnNameOrder = $colNameOrder;
        $orderType = $orderType;
        //------------------------------
        
        //COLUMNAS ::
        if (count($column)>0)
        {            
            foreach ($column as $columnDb)
            {
                $col = $columnDb;                
                if ($counter == ($limit-1))
                {
                    $_cols .= $col;
                }else
                {
                    $_cols .= $col. $come;
                }               
                $col = '';
                $counter ++;
            }
        } else {
            $_cols = '*';                        
        }
        //----------------------------------------------------------------------
        //NOMBRE DE LOS WHERE CONCATENADOS O COLUMNA CRITERIAL
        $limit = count($whereConcat);
        //reiniciando contador
        $counter = 0;
        //$limit = count();
        
        if ($limit > 0)
        {
            foreach ($whereConcat as $valueCol)
            {
                $whereUnit = $valueCol;
                if ($counter == ($limit-1))
                {
                    $_wheresConcat .= $whereUnit;
                }else
                {
                    $_wheresConcat .= $whereUnit . $come;
                }
                $whereUnit = '';
                $counter++;
            }
        }
        self::getConnection();             
        //FLUJO NORMAL DE EVENTOS
        // nuevo requerimiento        $columnNameOrder = $colNameOrder;
        //$orderType = $orderType;
        $results = self::$db->call_sp_select(
          $_table, $_cols, $_criterios, $_wheresConcat, $page, $regXpage, $columnNameOrder, $orderType);
        //$results = self::$db->call_sp_select($_table, $_cols, $_criterios, $_wheresConcat, $page, $regXpage);
        //$test = self::c
        return $results;
    }
    
    public static function selectJoinRelational ($arrWheres = array())
    {   
        //global vars method::
        $whereStatements = $arrWheres;
        //SELECT
        $select = "SELECT * FROM ";
        //from::
        $from = "";
        $acum = "";
        $cont = count(static::$tablesQuery);
        $contFor = 0;
        foreach (static::$tablesQuery as $alias => $tableName)
        {
            $line = "";  
            //echo "<br> ". $contFor ." < ". $cont-1 . " ?";
            if ($contFor < ($cont - 1))
            {
                if ($contFor == 0){
                    $line = $tableName." as ".$alias . " right join (";                    
                }else{
                   $line = $tableName." as ".$alias . ") ". " right join ("; 
                }                
                $acum = $acum . $line;                
            }else{
                $line = $tableName." as ".$alias. ")";
                $acum = $acum . $line ;
            }                      
           $contFor++;
        }
        $from = $acum;
        $select.= $from;
        
        //ON::
        $on = " ON ";
        $lineOn = "";
        foreach (static::$onJoinsColumn as $key => $value)        
        {
            $tmpOpenPar = "(";
            $tmpClosePar = ")";            
            $lineOn = $tmpOpenPar . $value . $tmpClosePar;            
        }        
        //WHERES:: [ OJO! METER EL ARRAY CON LOS WHERES ]-----------------------
        //$whereStatements
        $cantidadWheres = count($whereStatements[0]);
        $cont = 0;
        $strWHERE = ' WHERE ';
        $strOR = ' OR ';
        $tmpStr = "";
                        
        for($i = 0; $i < $cantidadWheres; $i++ )
        {
            if ($i == ($cantidadWheres - 1))
            {
                $tmpStr.= $whereStatements[0][$i] . " = :" . 
                        $whereStatements[1][$i];
            }else
            {
                $tmpStr.= $whereStatements[0][$i] . " = :" . 
                        $whereStatements[1][$i] . $strOR;
            }
        }        
        
        $strWheresNw = $strWHERE . $tmpStr;
        
        self::getConnection();
        $sql = $select . $on . $lineOn . $strWheresNw . ";";
                //"WHERE us.id = '416' OR us.id = '32';";
        $results = self::$db->selectWithJoins($sql, $whereStatements);
        
        return $results;
        //echo "<br> SQL: ". $sql;
    }
        
    public static function getObjectDTOFromJoinsMethod ($arrayWhere = array())
    {
        $usersDTOarr = array();
        $paramsReference = self::selectJoinRelational($arrayWhere);
        
        if ($paramsReference != null){
            //flujo normal de eventos esperados
            $countRowsDTO = count($paramsReference);
            if ($countRowsDTO > 1)
            {
                $cont = 0;
                for($i = 0; $i < $countRowsDTO; $i++)
                {
                    $dtoTmp = $paramsReference[$i];                
                    //$dataArr = array_shift($dtoTmp);        
                    $resultDTOchild = self::instanciate($dtoTmp);                   

                    $usersDTOarr[$i] = $resultDTOchild;
                    $cont++;
                } //final del ciclo            
                return $usersDTOarr;

            }else{
                $dataArr = array_shift($paramsReference);        
                $resultDTO = self::instanciate($dataArr);        
                return $resultDTO;            
            }            
        } 
        else {
            return null;
        }                               
    }
/*
 *     public static function getById($id){
            $paramsReference = self::where("id",$id);
            $data = array_shift($paramsReference);        
            $result = self::instanciate($data);
            return $result;
    }
 */
    public static function where($field, $value){
        self::getConnection();
        $sql = "SELECT * FROM ".static::$table." WHERE ".$field." = :".$field;
        $arrayToSend = array(":".$field=>$value); //($field=>$value);
        $results = self::$db->select($sql, $arrayToSend); // array(":".$field=>$value)
        return $results;
    }

    public static function whereR($attr,$field, $value, $tableR){
            self::getConnection();
            $sql = "SELECT ".$attr." FROM ".$tableR." WHERE ".$field." = :".$field;
            $results = self::$db->select($sql, array(":".$field=>$value) );

            return $results;
    }

    public static function whereN($attr,$field, $tableR){
            self::getConnection();
            $sql = "SELECT ".$attr." FROM ".$tableR." WHERE ".$field. " IS NULL";
            $results = self::$db->select($sql );

            return $results;
    }

    public function create(){
        self::getConnection();

        $values = $this->getMyVars($this);
        
        //_------------------ OJO! SOLO PROPIEDADES TIPO OBJ NO SE OPERAN-------
        $unsetKeyVal = "";
        foreach ($values as $key => $valueField)
        {
           $res = StringSecurityManager::buscarPalabraEnCadenaString("Obj", $key);
           if ( $res ){
               $unsetKeyVal = $key;
           }
           //ResourceBundleV2::writeDATABASELOG("007_getMyVars : ",$key . " : ". $value. " objeto? ". $res); 
        }
        if ($unsetKeyVal != ""){
            unset($values[$unsetKeyVal]);
        }   
        
        
        $has_many = self::checkRelationship("has_many",$values);
        self::checkRelationship("has_one",$values);
        self::checkRelationship("known_as",$values);
        
        $result = self::$db->insert(static::$table,$values);
        
        if($result === true){
            $response = array('error'=>0,'getID'=> self::$db->lastInsertId(),'msg'=>  get_class($this).' Created');
            $this->setId( $response["getID"] ) ;
        }else{
            $response = array('error'=>1,'msg'=> 'Error '.$result);
        }
        if($has_many){ 
            $rStatus = self::saveRelationships($has_many); 
            if($rStatus["error"]){
                
            }
        }
        
        return $response;
    }

    public function update($field = "id",$value = null){
        self::getConnection();
            
        $values = $this->getMyVars($this);
        
        
        
        
        $unsetKeyVal = "";
        foreach ($values as $key => $val)
        {
           $res = StringSecurityManager::buscarPalabraEnCadenaString("Obj", $key);
           if ( $res ){
               $unsetKeyVal = $key;
           }
           //ResourceBundleV2::writeDATABASELOG("007_getMyVars : ",$key . " : ". $value. " objeto? ". $res); 
        }
        if ($unsetKeyVal != ""){
            unset($values[$unsetKeyVal]);
        }          
        
        
        
        
        
        $has_many = self::checkRelationship("has_many",$values);
        self::checkRelationship("has_one",$values);
        self::checkRelationship("known_as",$values);
        
        $value = ($value == null) ? $values["id"] : $value;
        
        $result = self::$db->update(static::$table,$values,$field." = ".$value);

        if($result){
            $response = array('error'=>0,'msg'=>  get_class($this).' Updated');
        }else{
            $response = array('error'=>1,'msg'=> 'Error '.$result);
        }
        if($has_many){
            $rStatus = self::saveRelationships($has_many); 
            if($rStatus["error"]){
                //Logger::alert("Error saving relationships",$rStatus["trace"],"save");
            }
        }
        //Logger::debug("result",$result,"save");
        return $response;
    }

    public function saveRelationships($relationships){
            $log = array("error"=>0,"trace"=>array());
            foreach ($relationships as $name => $rules) {
                if(isset($rules['relationships'])){
                    foreach ($rules['relationships'] as $key => $relacion) {
                        $table = $rules["join_table"];
                        $result = self::$db->insert($table,$relacion);
                        //TODO Check result
                    }
                }
            }
            return $log;
    }

    public function has_many($rName,$obj){
         $has_many = $this->getHas_many();
            if($has_many[$rName] != null){
                $rule = $has_many[$rName];
                $rule['my_key'] = ucfirst($rule['my_key']);
                $rule['other_key'] = ucfirst($rule['other_key']);
                if(get_class($obj) == $rule["class"]){
                    if( $this->{"get".$rule['my_key']}() 
                    != null && $obj->{"get".$rule['other_key']}() != null ){
                        $rule['relationships'][]= array(
                          $rule['join_self_as']=>$this->{"get".$rule['my_key']}(),
                          $rule['join_other_as']=>$obj->{"get".$rule['other_key']}()
                        );
                        $has_many[$rName] = $rule;
                        $this->setHas_many($has_many);
                    }else{
                        print("Se requieren llaves primarias para la relación");
                    }
                }else{
                    print("No se cumple con el tipo de objeto");
                }
            }else{
                print("No existe este tipo de relación");
            }      
        }

    public function has_one($rName,$obj){
        $relacion = $this->getHas_one();
        if( isset($relacion[$rName]) ){

            $rule = $relacion[$rName];
            if(get_class($obj) == $rule["class"]){
               $this->{"set".ucfirst($rule["join_as"])}($obj->{"get".ucfirst($rule["join_with"])}());
            }else{
                print("No se cumple con el tipo de objeto");
            }

        }else{
            print("No existe este tipo de relación");
        }  
    }
    
    public function known_as($rName,$obj,$update = true){
        $relacion = $this->getKnown_as();
        if( isset($relacion[$rName]) ){

            $rule = $relacion[$rName];
            if(get_class($obj) == $rule["class"]){
               
               print_r( "set".ucfirst($rule["join_with"]) );
               $obj->{"set".ucfirst($rule["join_with"])}($this->{"get".ucfirst($rule["join_as"])}());
               $obj->update();
               
            }else{
                print("No se cumple con el tipo de objeto");
            }

        }else{
            print("No existe este tipo de relación");
        }  
    }
    
    public function set($attr,$value){
        $this->{$attr} = $value;
    }

    public function checkRelationship($rType,&$data){
            if( isset($data[$rType]) ){
                $relationship = $data[$rType];
                unset($data[$rType]);
                return $relationship;
            }else{
                return false;
            }
        }
        
    public function delete(){
            self::getConnection();
            $result = self::$db->delete(static::$table,"id = ".$this->getId());
            
            if($result){
                    $result = array('error'=>0,'message'=>'Objeto Eliminado');
            }else{
                    $result = array('error'=>1,'message'=> self::$db->getError());
            }
            return $result;
    }
    
    public static function getById($id){
            $paramsReference = self::where("id",$id);
            $data = array_shift($paramsReference);        
            $result = self::instanciate($data);
            return $result;
    }
        
    public static function getBy($field,$data){            
            /*
             * definicion de variables por referencia para evitar el bug
             * en servidor de produccion, bug:
             * Only variables should be passed by reference
             */
            $paramsReference = self::where($field,$data);
            $data = array_shift($paramsReference);              
            $result = self::instanciate($data);
            return $result;
    }
    
    public function getAttrTable($table){
            self::getConnection();
            $attr = self::$db->getAttr($table);
            return $attr;
    }
    
    public function toArray(){
        $arr = [];
        foreach ($this->getMyVars() as $key => $value) {
            if($key != "has_one" && $key != "has_many"){
                $arr[$key] = $this->{"get".$key}();
            }
        }
        return $arr;
    }
    
    public static function instanciate($args){

        if (count($args) > 1) 
        { 
            $refMethod = new ReflectionMethod(get_called_class(),  '__construct'); 
            $params = $refMethod->getParameters(); 
            $re_args = array();
            foreach($params as $key => $param) 
            { 
                if ($param->isPassedByReference()) 
                { 
                    $re_args[$param->getName()] = &$args[$param->getName()]; 
                } 
                else 
                { 
                    $re_args[$param->getName()] = $args[$param->getName()]; 
                }
            } 

            $refClass = new ReflectionClass(get_called_class()); 
            return $refClass->newInstanceArgs((array) $re_args); 
        } 
    }
    
    public static function getKeys(){
        $refMethod = new ReflectionMethod(get_called_class(),  '__construct'); 
        $params = $refMethod->getParameters();
        $keys = [];
        foreach($params as $key => $param) 
            { 
              $keys[$key] = $param->getName();
            }
        return $keys;
    }
    
    
    
    //-----------[ EXPERIMENTAL ]-----------------------------------------------
    public static function setTable2 ()
    {
        //ResourceBundleV2::writeHELPERSLog("001 FROM MODEL:: table2: ", static::$table2);
        $objTmp = RelationalModel::getString(static::$table2);
        return $objTmp;
    }
    public static function getTable2 ()
    {
        return self::$table;
    }
    public static function getCountArraysExperimental()
    {
        $cantidadTablas = count(static::$tablesQuery);
        $tabla1 = static::$tablesQuery["us"];
        echo "tablas count: ". $cantidadTablas;
        
        $camposCont = count (static::$columnAlias);
        echo "cantidad columnas: ". $camposCont;
        echo "usuario id: ". static::$columnAlias["us1"];
        
        echo "<br> RECORRIENDO TABLAS, ARMANDO EL FROM:: ";
        
        self::selectJoinRelational();
        return $camposCont;
    }
}
