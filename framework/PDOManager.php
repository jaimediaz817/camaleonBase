<?php
/**
 * 
 */
class PDOManager extends PDO
{	
        /**
         * Método constructor
         * 
         * @param type $DB_TYPE
         * @param type $DB_HOST
         * @param type $DB_NAME
         * @param type $DB_USER
         * @param type $DB_PASS
         */
	public function __construct($DB_TYPE, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS)
	{
	       parent::__construct($DB_TYPE.':host='.$DB_HOST.';dbname='.$DB_NAME, $DB_USER, $DB_PASS);
                $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	       ResourceBundleV2::writeDebugLOG("003", "se conecto!");
		//parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTIONS);
	}
	
	/**
	 * select
	 * @param string $sql An SQL string
	 * @param array $array Paramters to bind
	 * @param constant $fetchMode A PDO Fetch mode
	 * @return mixed
	 */
	public function select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
	{        ResourceBundleV2::writeDATABASELOG("001_PDO", "PDO_MANAGER : select, array: ");
		$sth = $this->prepare($sql);
		foreach ($array as $key => $value) {
                           $val = $value;
			//$sth->bindValue(":$key", $val);
                           $sth->bindValue($key, $val);
		}
		try{
                    $sth->execute();
                    return $sth->fetchAll($fetchMode);
                  }catch (PDOException $e){
                    ResourceBundleV2::writeErrorLOG("001", $e->getMessage());                    
                  }
	}
	
         public function selectWithJoins ($sql, $arrayWHERES = array(), $fetchModel = PDO::FETCH_ASSOC)
         {
             $statement = $this->prepare($sql);
             $cantidadWheres = count($arrayWHERES[0]);
             //programacion defensiva
             if ($cantidadWheres >= 1)
             {
                 for($i = 0; $i < $cantidadWheres; $i++ )
                 {
                     $property = $arrayWHERES[1][$i];
                     $value = $arrayWHERES[2][$i];
                     $dataType = gettype($value);
                     /*
                      * integer
                        double
                        NULL
                        object
                        string
                      */
                     switch ($dataType)
                     {
                         case "integer":
                             $statement->bindValue(':'.$property, $value, PDO::PARAM_INT);
                         break;
                         
                         case "double":
                             $statement->bindValue(":". "$property", $value, PDO::PARAM_INT);
                         break;
                         
                         case "string":
                             $statement->bindValue(":". "$property", $value, PDO::PARAM_STR);
                         break;                         
                     }
                     //evaluar tipo de dato                                          
                 }
//                 foreach ($arrayWHERES as $whereColumn => $value)
//                 {
//                     $valColumn = $value;
//                     $statement->bindValue(":{$whereColumn}", $valColumn);
//                 }
             }
                          
             
             //*****************************************************************
             
             //WHERE ARRAY  :: FOREACH
              //BINDVALUE
             //-----------------------
             try
             {
                 //array(':us.id' => 32)
                $statement->execute();
                return $statement->fetchAll($fetchModel);                 
             } catch (PDOException $ex) {
                ResourceBundleV2::writeErrorLOG("001", $ex->getMessage()); 
             }
         }
         
         
         public function call_testing($tableName, $columns ,$criterios = '', $wheresConcat = '', $page = 1, $regXpage = 5)
         {
             $sql = "CALL sp_dataGrid('" . $tableName . "', '". $columns ."', '". $criterios ."', '" . $wheresConcat . "', '" . 1 . "', '". 5 ."');";
             return "";
         }
         
         
         //*********************************************************************
         
         /**
          * llama a sp 
          * 
          * @param type $tableName  tabla
          * @param type $columns  columnas
          * @param type $criterios  criterio
          * @param type $wheresConcat  wheres concat
          * @param type $page  pagina inicio
          * @param type $regXpage registros por pagina
          * @param type $fetchModel
          * @return type
          */
         public function call_sp_select($tableName, $columns ,$criterios = '', 
            $wheresConcat = '', $page, $regXpage, $colNameOrder, $orderType, $fetchModel = PDO::FETCH_ASSOC)
         {                  
             try
             {                 
                 //CALL sp_dataGrid('usuario', 'id, username, email', '@', 'username,email');
                //$statement = $this->prepare($sql);
                $sql = "CALL sp_dataGrid('" . $tableName . "', '". $columns ."', '". $criterios ."', '" . $wheresConcat . "', '" . $page . "', '". $regXpage ."', '" . $colNameOrder ."', '" . $orderType . "');";
                $data = $this->query($sql);
                $resultData = $data->fetchAll($fetchModel);
                
                $data = null;
                 //array(':us.id' => 32)
                return $resultData;               
             } catch (PDOException $ex) {
                ResourceBundleV2::writeErrorLOG("001", $ex->getMessage()); 
             }
               //return array("success"=> "false");
         }
         
         
         
         
         
         
         
         
         
         
         
         
	/**
	 * insert
	 * @param string $table A name of table to insert into
	 * @param string $data An associative array
	 */
	public function insert($table, $data)
	{
		ksort($data);
		ResourceBundleV2::writeDATABASELOG("007_values", "insert 817");
		$fieldNames = implode('`, `', array_keys($data));
		
                  ResourceBundleV2::writeDATABASELOG("007_fieldNames: ", $fieldNames);
                  
                  $fieldValues = ':' . implode(', :', array_keys($data));
		ResourceBundleV2::writeDATABASELOG("007_fieldValues: ", $fieldValues);
                  
		$sth = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");
		//ResourceBundleV2::writeDATABASELOG("007_values", "INSER INTO: ". $sth);
		foreach ($data as $key => $value) {
                       // ResourceBundleV2::writeDATABASELOG("007_values", "values : ". $value);
			$sth->bindValue(":$key", $value);
		}
		//print_r($sth);
                try { 
                    $r = $sth->execute();
                } catch (PDOException $e) { 
                    $r = $e->getMessage(); 
                }
		return $r;
	}
	
	/**
	 * update
	 * @param string $table A name of table to insert into
	 * @param string $data An associative array
	 * @param string $where the WHERE query part
	 */
	public function update($table, $data, $where)
	{

                ksort($data);
		
		$fieldDetails = NULL;
		foreach($data as $key=> $value) {
			$fieldDetails .= "$key=:$key,";
		}

		$fieldDetails = rtrim($fieldDetails, ',');
                
		$sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");
                
		
                foreach ($data as $key => $value) {
			$sth->bindValue(":$key", $value);
		}
                //print_r($sth);
		try { 
                    $r = $sth->execute();
                } catch (PDOException $e) { 
                    $r = $e->getMessage(); 
                }
                
		return $r;
	}
	
	/**
	 * delete
	 * 
	 * @param string $table
	 * @param string $where
	 * @param integer $limit
	 * @return integer Affected Rows
	 */
	public function delete($table, $where, $limit = 1)
	{
		return $this->exec("DELETE FROM $table WHERE $where LIMIT $limit");
	}
	
}