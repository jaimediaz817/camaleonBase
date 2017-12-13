-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-07-2016 a las 21:03:38
-- Versión del servidor: 5.6.26
-- Versión de PHP: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cpiura_shema`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `EXAMPLEUSER`()
begin
 declare xxx INT(1);
 select * from usuario;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EXAMPLEUSER2`()
begin
 declare xxx INT(1);
 select * from usuario;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `simple_loop`( )
BEGIN
  DECLARE counter BIGINT DEFAULT 0;
  
  my_loop: LOOP
    SET counter=counter+1;

    IF counter=10 THEN
      LEAVE my_loop;
    END IF;

    SELECT counter;

  END LOOP my_loop;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `splitStr`(
in cadena TEXT,
in separador VARCHAR(20)
)
BEGIN

    DECLARE itemArray TEXT;
    DECLARE i INT;
    DECLARE tmp INT;
 
    SET i = 1; # se le puede dar cualquier valor menos 0.
 
    
    #CREANDO TABLAS TEMPORALES
	DROP TEMPORARY TABLE IF EXISTS tmpSplitElements;
	
	CREATE TEMPORARY TABLE tmpSplitElements ( 
    id INT(11) , element VARCHAR(30)
	);   
    
    # INTRO BUCLE
    WHILE i > 0 DO
 
        SET i = INSTR(cadena,separador); 
        # seteo i a la posicion donde esta el caracter para separar
        # realiza lo mismo que indexOf en javascript
 
        SET itemArray = SUBSTRING(cadena,1,i-1); 
        # esta variable guardara el valor actual del supuesto array
        # se logra cortando desde la posicion 1 que para MySQL es la primera letra (en javascript es 0)
        # hasta la posicion donde se encuentra la cadena a separar -1 ya que sino incluiria el 1er caracter
        # del caracter o cadena de caracteres que hacen de separador
        
        IF i > 0 THEN
        
            SET cadena = SUBSTRING(cadena,i+CHAR_LENGTH(separador),CHAR_LENGTH(cadena));
                
        # corto / preparo la cadena total para la proxima vez que se entre al bucle para eso corto desde la posicion
        # donde esta el caracter separador hasta el tamaño total de la cadena
        # como el separador puede ser de n caracteres en el 2do parametro paso i que es la posicion del separador
        # sumado al tamaño de su cadena 
 
        ELSE
        
        # si el if entra aca es porque i ya vale 0 y no entrara nuevamente al bucle lo cual significa que la 
        # cadena original ya no tiene separadores por ende lo que queda de ella es igual a la ultima posicion
        # del supuesto array
 
            SET itemArray = cadena;
         
        END IF;
        
        # he creado una tabla test que tiene como estructura:
        # id int, i int, texto1 text, texto2 text para subir de muestra como cambia el indice (i)
        # y como sube el elemento iterado y por ultimo la cadena original para ver como va mutando
 
        #INSERT INTO test (i,texto1,texto2) VALUES (i,itemArray,cadena);
		#select i as counter, itemArray as palabra, cadena as cadena;
        
        
		insert into tmpSplitElements (id,element) VALUES (i,itemArray);
		
        #select count(id) from tmpSplitElements into tmp;        
        #select concat(tmp, concat(tmp, '<=')) as unionTmp;
        
    END WHILE;
    
	
    #select * from tmpSplitElements;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_dataGrid`(
#PARAMETROS DE ENTRADA
IN _tableName VARCHAR(50),
IN _cols VARCHAR(200),
IN _criterio VARCHAR(200),
IN _concatWhere VARCHAR(200),

#PARAMETROS NUEVOS::
IN _pagina INT,
IN _reg_x_pagina INT,
#REQUERIMIENTO ORDENACION REQ-02-37
IN _columnNameOrder VARCHAR(35),
IN _orderType VARCHAR(10)
)
BEGIN
	#VARIABLES MIEMBRO
    DECLARE contador INT(5);
	DECLARE search VARCHAR(200) default '';
    DECLARE elementLoop VARCHAR (100);
    #NUMERO DE REGISTROS ALMACENADOS EN LA TABLA TEMPORAL
    DECLARE nrowsTmpTable INT(11);
    #CONTROLA LA CONCATENACION O CADENA WHERE concat
    
    DECLARE ciclo_fin INTEGER(1) DEFAULT 0;
    DECLARE strWHEREconcat VARCHAR (50);
    DECLARE strWHEREconcatEnd VARCHAR (1);
    DECLARE strColumsWhere VARCHAR (50);
    DECLARE strFinalWhere VARCHAR (100);
	#CU-02-37
    DECLARE colOrder VARCHAR(65);
    DECLARE strOrderBy VARCHAR (65);
    DECLARE strOrderType VARCHAR(4);
    #END [ CU-02-37 ]
	#NUEVO DATO
    DECLARE pagina_actual INT;
	#declaracion del cursor para recorrer tabla temporal	  
    DECLARE cursorWheres CURSOR FOR 
          SELECT element FROM tmpSplitElements;

    #DECLARACION DEL PUNTERO PARA EL LOOP
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET ciclo_fin=1;
    #CONTADOR PARA EL LOOP
    
    #-----------------[ PAGINADOR ]-------------------------------------
    SET pagina_actual = (_pagina - 1) * _reg_x_pagina;
    #-------------------------------------------------------------------
    
    
	SET contador = 0;
	SET strWHEREconcat = ' CONCAT (';
	SET strWHEREconcatEnd = ') ';
	SET strColumsWhere = '';
	SET elementLoop = '';        
	SET strFinalWhere = '';
    
	#si los campos que forman el criterio de busqueda estan diferentes de vacio
	IF (_concatWhere != '')THEN
		#ENVIAR LA CADENA LINEAL A LA FUNCTION::
        #CALL splitStr('jaime,ivan,diaz,gaona', ',');
        CALL splitStr(_concatWhere, ',');

        # OBTENIENDO LA CANTIDAD DE REGISTROS
        select count(id) from tmpSplitElements into nrowsTmpTable; 
        
		  

        
        IF (nrowsTmpTable > 1) THEN
          
		  #select nrowsTmpTable as totalLoops;
		  #APERTURA DEL CURSOR
          OPEN cursorWheres;
          
          #INICIO DEL CICLO ]------------ LOOP --------------------------
          getAlltmpTable : LOOP			 
              #select contador as valorContador;
		      #ASIGNANDO EL ELEMENTO
              fetch cursorWheres INTO elementLoop;
             
              IF (contador = (nrowsTmpTable-1))THEN
              
				SET strColumsWhere = CONCAT(strColumsWhere, elementLoop);
                #select "ultimo elemento";
              ELSEIF (contador < (nrowsTmpTable-1)) THEN
				#select "primer elemento" as recorrido1;
				#SET strColumsWhere = CONCAT(strColumsWhere, CONCAT(elementLoop, ',"  ",'));
                 SET strColumsWhere = CONCAT(strColumsWhere, elementLoop);
                 SET strColumsWhere = CONCAT(strColumsWhere,', "  ",');
                 
              END IF;
                            
			  #saber si es el final del ciclo
			  IF ciclo_fin = 1 THEN
				LEAVE getAlltmpTable;
			  END IF;
              #INCREMENTANDO CONTADOR
			  SET contador = (contador+1);
                            
          END LOOP getAlltmpTable;
          # END LOOP ]--------------------------------------------------------
          #CERRANDO CURSOR
          CLOSE cursorWheres;
          
          #BORRAR TABLA TEMPORAL
          drop table tmpSplitElements;
		  #--------------------------------------------------------------
          #PRIMERA CONCATENACION  "CONCAT("
          SET strFinalWhere = strWHEREconcat;          
          #SEGUNDA CONCATENACION "CONCAT(" + " [ID, "  ", USERNAME] "
          SET strFinalWhere = CONCAT(strFinalWhere, strColumsWhere);          
          #TERCERA CONCATENACION "CONCAT(" + " [ID, "  ", USERNAME] " + "[)]"
          SET strFinalWhere = CONCAT(strFinalWhere, strWHEREconcatEnd);          
          #select strFinalWhere as whereTotal;
          
        ELSE
		  #asignando criterio SIMPLE:  WHERE [ID] LIKE "%' _criterio_ '%"
                    
          SET strFinalWhere = _concatWhere;
          #select strFinalWhere as whereUnitario;
          
        END IF;
        
    END IF;

    #select _criterio as criterioPrevioWhere;
	# concatenando todo el WHERE
	IF (_criterio != '') THEN
        #CONCAT (username,"  ",email)
		SET search = CONCAT('WHERE ', strFinalWhere ,' LIKE "%', _criterio, '%"');        
    END IF;
    
    SET strOrderType = '';
    SET colOrder = _columnNameOrder;
    #CASO DE USO  CU02-37  CREAR CADENAS DE ORDENAMIENTO POR COLUMNAS 
    IF (colOrder != '') THEN
		# SI EXISTE TIPO DE ORDENAMIENTO
		IF (_orderType != '') THEN
			SET strOrderType = _orderType;
		ELSE
			SET strOrderType = 'ASC';
        END IF;
    
		SET strOrderBy = CONCAT('ORDER BY ', colOrder, ' ', strOrderType, ' ');
	ELSE
		#DEJAR VACIO POR DEFECTO LA CADENA
		SET strOrderType = '';
    END IF;
	#FINAL [ CU-02-37 ]----------------------------------------------

	#PAGINATOR :::::::::::::::::::::::::::::::::::::::::::::
	SET @sentencia = CONCAT('
		SELECT
			  COUNT(*) INTO @countx
	    FROM  ',_tableName,'
        ',search,';
    ');
    #SELECT @sentencia as sentencia;
    #PREPARANDO LA CONSULTA
    PREPARE consulta FROM @sentencia;
    EXECUTE consulta;    
    #liberando variables::
    DEALLOCATE PREPARE consulta;
    SET @sentencia = NULL;	
    # ::::::::::::::::::::::::::::::::::::::::::::::::::::::



	SET @sentencia = CONCAT('
		SELECT
			  ',_cols,', @countx as partialTotal
	    FROM  ',_tableName,'
        ',search, strOrderBy,'
        
        LIMIT ',pagina_actual,',',_reg_x_pagina,';
    ');
    #SELECT @sentencia as sentencia;
    #PREPARANDO LA CONSULTA
    PREPARE consulta FROM @sentencia;
    EXECUTE consulta;    
    #liberando variables::
    DEALLOCATE PREPARE consulta;
    SET @sentencia = NULL;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateIdKeyGen`(
#PARAMETROS DE ENTRADA
IN idKeyGenerator INTEGER(11),
IN newState INTEGER(1),
OUT returnRes INTEGER(1)
)
BEGIN

	UPDATE key_generator set codeState = newState
    WHERE id = idKeyGenerator;
	SET returnRes = 1;

END$$

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
    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `amigos_usuario`
--

CREATE TABLE IF NOT EXISTS `amigos_usuario` (
  `idUsuario` int(11) NOT NULL,
  `idAmigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora_usuarios`
--

CREATE TABLE IF NOT EXISTS `bitacora_usuarios` (
  `id` int(11) NOT NULL,
  `usuario_mysql` varchar(45) DEFAULT NULL,
  `fecha_movimiento` datetime DEFAULT NULL,
  `accion_sistema` varchar(45) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `bitacora_usuarios`
--

INSERT INTO `bitacora_usuarios` (`id`, `usuario_mysql`, `fecha_movimiento`, `accion_sistema`, `id_usuario`) VALUES
(3, 'root@localhost', '2016-04-16 14:25:45', 'INSERT', 3),
(4, 'root@localhost', '2016-04-17 18:32:33', 'INSERT', 4),
(5, 'root@localhost', '2016-04-17 18:32:57', 'INSERT', 5),
(6, 'root@localhost', '2016-04-17 18:33:19', 'INSERT', 6),
(7, 'root@localhost', '2016-04-19 17:35:14', 'INSERT', 7),
(8, 'root@localhost', '2016-04-19 23:19:07', 'INSERT', 8),
(9, 'root@localhost', '2016-04-20 21:40:32', 'INSERT', 9),
(10, 'root@localhost', '2016-04-21 12:15:21', 'INSERT', 10),
(15, 'root@localhost', '2016-04-21 12:17:04', 'INSERT', 19),
(16, 'root@localhost', '2016-04-21 12:17:50', 'INSERT', 20),
(17, 'root@localhost', '2016-04-21 12:17:51', 'INSERT', 21),
(18, 'root@localhost', '2016-04-21 12:17:51', 'INSERT', 22),
(19, 'root@localhost', '2016-04-21 12:17:51', 'INSERT', 23),
(20, 'root@localhost', '2016-04-27 18:33:54', 'INSERT', 24),
(21, 'root@localhost', '2016-04-28 19:06:24', 'INSERT', 26),
(22, 'root@localhost', '2016-04-28 19:10:30', 'INSERT', 27),
(23, 'root@localhost', '2016-04-28 19:22:59', 'INSERT', 28),
(24, 'root@localhost', '2016-05-03 12:04:17', 'INSERT', 29);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `key_generator`
--

CREATE TABLE IF NOT EXISTS `key_generator` (
  `id` int(11) NOT NULL,
  `codeGenerator` varchar(128) CHARACTER SET utf8 NOT NULL,
  `codeState` int(1) DEFAULT NULL,
  `dataInit` date DEFAULT NULL,
  `dataExpired` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tienda`
--

CREATE TABLE IF NOT EXISTS `tienda` (
  `owner` int(11) DEFAULT NULL,
  `titulo` varchar(45) CHARACTER SET ucs2 NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=ucs2 COLLATE=ucs2_spanish_ci;

--
-- Volcado de datos para la tabla `tienda`
--

INSERT INTO `tienda` (`owner`, `titulo`, `id`) VALUES
(3, 'une comunicaciones', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL,
  `login_user` varchar(45) CHARACTER SET utf8 NOT NULL,
  `password_user` varchar(60) CHARACTER SET utf8 NOT NULL,
  `mail_user` varchar(100) CHARACTER SET utf8 NOT NULL,
  `nivel_acceso` int(11) NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `hora_creacion` time DEFAULT NULL,
  `nombre_user` varchar(75) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL,
  `username` varchar(45) CHARACTER SET utf8 NOT NULL,
  `password` varchar(128) CHARACTER SET utf8 NOT NULL,
  `email` varchar(150) CHARACTER SET utf8 NOT NULL,
  `fechaCreacion` date DEFAULT NULL,
  `estadoRegistro` int(1) DEFAULT NULL,
  `keyGenerator` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `nivelAcceso` int(1) DEFAULT NULL,
  `idKeyGenerator` int(11) DEFAULT NULL,
  `horaCreacion` time DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla usuarios';

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `username`, `password`, `email`, `fechaCreacion`, `estadoRegistro`, `keyGenerator`, `nivelAcceso`, `idKeyGenerator`, `horaCreacion`) VALUES
(3, 'jdiaz01', 'UECdutoEjXpaaev0rQk7ZwaIUwyOmKuFqC2ja733C2A=', 'jdiaz@jdiaz.com', '2016-04-16', 1, 'keyGen', 2, NULL, '14:25:45'),
(4, 'jdiaz02', 'UECdutoEjXpaaev0rQk7ZwaIUwyOmKuFqC2ja733C2A=', 'jdiaz02@jdiaz', '2016-04-17', 0, 'keyGen', 1, NULL, '18:32:33'),
(5, 'jdiaz03', 'NBEyetuz3MZT2Hb+uzMJ0KKp3S6XBHmZvm0Mwpqn+iU=', 'jdiaz03@jdiaz', '2016-04-17', 0, 'keyGen', 2, NULL, '18:32:57'),
(6, 'jdiaz04', 'UECdutoEjXpaaev0rQk7ZwaIUwyOmKuFqC2ja733C2A=', 'jdiaz5@jdiaz', '2016-04-17', 0, 'keyGen', 1, NULL, '18:33:19'),
(7, 'jdiaz05', 'UECdutoEjXpaaev0rQk7ZwaIUwyOmKuFqC2ja733C2A=', 'jdiaz05@jdiaz', '2016-04-19', 0, 'keyGen', 1, NULL, '17:35:14'),
(8, 'jdiaz06', '8EsROEZMn6Fx588d/Ml+ZRHt5XD0n79A0duhwgAfIHA=', 'jdiaz06@jdiaz.com', '2016-04-19', 0, 'keyGen', 1, NULL, '23:19:06'),
(9, 'jdiaz07', 'NBEyetuz3MZT2Hb+uzMJ0KKp3S6XBHmZvm0Mwpqn+iU=', 'jdiaz09@jdiaz.com', '2016-04-20', 0, 'keyGen', 1, NULL, '21:40:32'),
(10, 'jdiaz08', '123', 'jdiaz08@', NULL, NULL, NULL, 1, NULL, NULL),
(19, 'jdiaz09', '123', 'jdiaz09@', NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'jdiaz10', '23', 'jdiaz10@', NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'jdiaz11', '123', 'jdiaz11@', NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'jdiaz12', '123', 'jdiaz12@', NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'jdiaz13', '123', 'jdiaz13@', NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'jdiaz14', 'UECdutoEjXpaaev0rQk7ZwaIUwyOmKuFqC2ja733C2A=', 'jdiaz14@jdiaz', '2016-04-27', 0, 'keyGen', 1, NULL, '18:33:54'),
(26, 'jdiaz015', 'NBEyetuz3MZT2Hb+uzMJ0KKp3S6XBHmZvm0Mwpqn+iU=', 'jdiaz015@', '2016-04-28', 0, 'keyGen', 1, NULL, '19:06:23'),
(27, 'jdiaz016', 'NBEyetuz3MZT2Hb+uzMJ0KKp3S6XBHmZvm0Mwpqn+iU=', 'jdiaz016@', '2016-04-28', 0, 'keyGen', 1, NULL, '19:10:30'),
(28, 'jdiaz017', 'NBEyetuz3MZT2Hb+uzMJ0KKp3S6XBHmZvm0Mwpqn+iU=', 'jdiaz017@', '2016-04-28', 0, 'keyGen', 1, NULL, '19:22:59'),
(29, 'jdiaz16', 'UECdutoEjXpaaev0rQk7ZwaIUwyOmKuFqC2ja733C2A=', 'jdiaz16@', '2016-05-03', 0, 'keyGen', 1, NULL, '12:04:17');

--
-- Disparadores `usuario`
--
DELIMITER $$
CREATE TRIGGER `tgr_Insert_usuariosBitacora` AFTER INSERT ON `usuario`
 FOR EACH ROW insert INTO bitacora_usuarios (usuario_mysql, fecha_movimiento, accion_sistema, id_usuario)
 values (USER(), NOW(), 'INSERT', NEW.id)
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `amigos_usuario`
--
ALTER TABLE `amigos_usuario`
  ADD PRIMARY KEY (`idUsuario`,`idAmigo`),
  ADD KEY `fk_Amigos_usuario_Usuario1_idx` (`idAmigo`);

--
-- Indices de la tabla `bitacora_usuarios`
--
ALTER TABLE `bitacora_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `key_generator`
--
ALTER TABLE `key_generator`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indices de la tabla `tienda`
--
ALTER TABLE `tienda`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `owner_UNIQUE` (`owner`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD KEY `fk_usuario_key_generator1_idx` (`idKeyGenerator`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bitacora_usuarios`
--
ALTER TABLE `bitacora_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT de la tabla `key_generator`
--
ALTER TABLE `key_generator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tienda`
--
ALTER TABLE `tienda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `amigos_usuario`
--
ALTER TABLE `amigos_usuario`
  ADD CONSTRAINT `fk_Amigos_usuario_Usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Amigos_usuario_Usuario1` FOREIGN KEY (`idAmigo`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tienda`
--
ALTER TABLE `tienda`
  ADD CONSTRAINT `fk_Tienda_Usuario1` FOREIGN KEY (`owner`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_key_generator1` FOREIGN KEY (`idKeyGenerator`) REFERENCES `key_generator` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
