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
-- Table `cpiura_shema`.`usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cpiura_shema`.`usuario` ;

CREATE TABLE IF NOT EXISTS `cpiura_shema`.`usuario` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL,
  `password` VARCHAR(128) CHARACTER SET 'utf8' NOT NULL,
  `email` VARCHAR(150) CHARACTER SET 'utf8' NOT NULL,
  `fechaCreacion` VARCHAR(45) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `estadoRegistro` INT(1) NULL DEFAULT NULL,
  `keyGenerator` VARCHAR(128) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 28
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


-- -----------------------------------------------------
-- Table `cpiura_shema`.`key_generator`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cpiura_shema`.`key_generator` ;

CREATE TABLE IF NOT EXISTS `cpiura_shema`.`key_generator` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `codeGenerator` VARCHAR(128) NOT NULL,
  `codeState` INT(1) NULL,
  `dataInit` VARCHAR(45) NULL,
  `dataExpired` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
