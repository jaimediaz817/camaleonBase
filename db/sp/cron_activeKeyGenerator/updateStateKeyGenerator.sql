CREATE DEFINER=`root`@`localhost` PROCEDURE `updateStateKeyGenerator`()
BEGIN
    
		DECLARE cantidadKeys INTEGER(11);
        DECLARE idKey INTEGER(11);
        DECLARE fechaExpiracion DATE;
        DECLARE estadoKey INTEGER(11) UNSIGNED;	
		DECLARE ciclo_fin INTEGER(1) DEFAULT 0;
        
        DECLARE counter bigint default 0;
        #RETORNO DE LA OPERACION UPDATE POR CADA LLAVE
        DECLARE retorno INTEGER(1) default 0;
		DECLARE paramRetorno INTEGER(1);
        
        
        #SET estadoKey = 0;
        #DECLARE 
        #declarando cursor
        
        DECLARE cursorTestKeys CURSOR FOR 
          SELECT keyg.id, keyg.dataExpired FROM key_generator as keyg
          WHERE keyg.codeState = 1;
        #abrir cursor::
        
        DECLARE CONTINUE HANDLER FOR NOT FOUND SET ciclo_fin=1;
        
        #--------------------------------------------------------------
        #DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET bContinuar = false;

        SET estadoKey = 0;

        #APERTURA DEL CURSOR
        OPEN cursorTestKeys;
        
        
        getAllKeys : LOOP

			  #incrementando contador::
			  SET counter=counter+1;
			  
			  fetch cursorTestKeys INTO idKey, fechaExpiracion;

			  #FECHA DE EXPIRACION MENOR A FECHA ACTUAL
			  IF (fechaExpiracion < DATE(NOW())) THEN
              
				SET estadoKey = 1;
				#acciones para la fecha de activacion vencida
				call updateIdKeyGen(idKey , 0, paramRetorno);
                set retorno = paramRetorno;
                
              ELSEIF (fechaExpiracion > DATE(NOW())) THEN
                SET estadoKey = 0;
                set retorno = 0;
				#acciones para la fecha de activacion vencida
				#call updateIdKeyGen(idKey , 0, );
                #$retorno
                #SET retorno = paramRetorno;
				
                #--------------------------------------------
			  END IF;
			  
			  #saber si es el final del ciclo
			  IF ciclo_fin = 1 THEN
				LEAVE getAllKeys;
			  END IF;
			  
			  SELECT idKey, fechaExpiracion as fecha_vencimiento, estadoKey, counter, DATE(now()), retorno as resultado_update;
			  #SET estadoKey = 0;
        END LOOP getAllKeys;
        
        
        
        #cierre del cursor::
        CLOSE cursorTestKeys;
        #--------------------------------------------------------------
        #SELECCION DE PRUEBA
		#SELECT count(key_generator.id) into cantidadKeys FROM key_generator;
    
		#SELECT cantidadKeys as CANTIDAD_REGISTROS;
    END