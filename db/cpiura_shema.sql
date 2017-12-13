-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema cpiura_shema
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `cpiura_shema` ;

-- -----------------------------------------------------
-- Schema cpiura_shema
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `cpiura_shema` DEFAULT CHARACTER SET utf8 ;
USE `cpiura_shema` ;

-- -----------------------------------------------------
-- Table `cpiura_shema`.`key_generator`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cpiura_shema`.`key_generator` ;

CREATE TABLE IF NOT EXISTS `cpiura_shema`.`key_generator` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `codeGenerator` VARCHAR(128) CHARACTER SET 'utf8' NOT NULL,
  `codeState` INT(1) NULL DEFAULT NULL,
  `dataInit` VARCHAR(45) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `dataExpired` VARCHAR(45) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `cpiura_shema`.`usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cpiura_shema`.`usuario` ;

CREATE TABLE IF NOT EXISTS `cpiura_shema`.`usuario` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL,
  `password` VARCHAR(128) CHARACTER SET 'utf8' NOT NULL,
  `email` VARCHAR(150) CHARACTER SET 'utf8' NOT NULL,
  `fechaCreacion` DATE NULL DEFAULT NULL,
  `estadoRegistro` INT(1) NULL DEFAULT NULL,
  `keyGenerator` VARCHAR(128) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `nivelAcceso` INT(1) NULL DEFAULT NULL,
  `idKeyGenerator` INT(11) NULL DEFAULT NULL,
  `horaCreacion` TIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  INDEX `fk_usuario_key_generator1_idx` (`idKeyGenerator` ASC),
  CONSTRAINT `fk_usuario_key_generator1`
    FOREIGN KEY (`idKeyGenerator`)
    REFERENCES `cpiura_shema`.`key_generator` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci
COMMENT = 'Tabla usuarios';


-- -----------------------------------------------------
-- Table `cpiura_shema`.`amigos_usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cpiura_shema`.`amigos_usuario` ;

CREATE TABLE IF NOT EXISTS `cpiura_shema`.`amigos_usuario` (
  `idUsuario` INT(11) NOT NULL,
  `idAmigo` INT(11) NOT NULL,
  PRIMARY KEY (`idUsuario`, `idAmigo`),
  INDEX `fk_Amigos_usuario_Usuario1_idx` (`idAmigo` ASC),
  CONSTRAINT `fk_Amigos_usuario_Usuario`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `cpiura_shema`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Amigos_usuario_Usuario1`
    FOREIGN KEY (`idAmigo`)
    REFERENCES `cpiura_shema`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `cpiura_shema`.`bitacora_usuarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cpiura_shema`.`bitacora_usuarios` ;

CREATE TABLE IF NOT EXISTS `cpiura_shema`.`bitacora_usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `usuario_mysql` VARCHAR(45) NULL DEFAULT NULL,
  `fecha_movimiento` DATETIME NULL DEFAULT NULL,
  `accion_sistema` VARCHAR(45) NULL DEFAULT NULL,
  `id_usuario` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cpiura_shema`.`tienda`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cpiura_shema`.`tienda` ;

CREATE TABLE IF NOT EXISTS `cpiura_shema`.`tienda` (
  `owner` INT(11) NULL DEFAULT NULL,
  `titulo` VARCHAR(45) CHARACTER SET 'ucs2' NOT NULL,
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `owner_UNIQUE` (`owner` ASC),
  CONSTRAINT `fk_Tienda_Usuario1`
    FOREIGN KEY (`owner`)
    REFERENCES `cpiura_shema`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = ucs2
COLLATE = ucs2_spanish_ci;


-- -----------------------------------------------------
-- Table `cpiura_shema`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cpiura_shema`.`users` ;

CREATE TABLE IF NOT EXISTS `cpiura_shema`.`users` (
  `id_user` INT(11) NOT NULL AUTO_INCREMENT,
  `login_user` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL,
  `password_user` VARCHAR(60) CHARACTER SET 'utf8' NOT NULL,
  `mail_user` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  `nivel_acceso` INT(11) NOT NULL,
  `fecha_creacion` DATE NULL DEFAULT NULL,
  `hora_creacion` TIME NULL DEFAULT NULL,
  `nombre_user` VARCHAR(75) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`id_user`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;

USE `cpiura_shema` ;

-- -----------------------------------------------------
-- procedure simple_loop
-- -----------------------------------------------------

USE `cpiura_shema`;
DROP procedure IF EXISTS `cpiura_shema`.`simple_loop`;

DELIMITER $$
USE `cpiura_shema`$$
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

DELIMITER ;

-- -----------------------------------------------------
-- procedure updateIdKeyGen
-- -----------------------------------------------------

USE `cpiura_shema`;
DROP procedure IF EXISTS `cpiura_shema`.`updateIdKeyGen`;

DELIMITER $$
USE `cpiura_shema`$$
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

DELIMITER ;

-- -----------------------------------------------------
-- procedure updateStateKeyGenerator
-- -----------------------------------------------------

USE `cpiura_shema`;
DROP procedure IF EXISTS `cpiura_shema`.`updateStateKeyGenerator`;

DELIMITER $$
USE `cpiura_shema`$$
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
USE `cpiura_shema`;

DELIMITER $$

USE `cpiura_shema`$$
DROP TRIGGER IF EXISTS `cpiura_shema`.`tgr_Insert_usuariosBitacora` $$
USE `cpiura_shema`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `cpiura_shema`.`tgr_Insert_usuariosBitacora`
AFTER INSERT ON `cpiura_shema`.`usuario`
FOR EACH ROW
insert INTO bitacora_usuarios (usuario_mysql, fecha_movimiento, accion_sistema, id_usuario)
 values (USER(), NOW(), 'INSERT', NEW.id)$$


DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
