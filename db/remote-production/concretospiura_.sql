/*
*  CONKRETEMOS SAS
*  Licencia de cabeceras para el proyecto CONKRETEMOS SAS
*  author:  ing Jaime Diaz G.
*  2016  COMPANY
*/




/**
 * Author:  Jaime Diaz <jaimeivan0017@gmail.com>
 * Created: 29/03/2016
 */

-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema cpiura_shema
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `concretospiura_` ;
-- -----------------------------------------------------
-- Schema cpiura_shema
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `concretospiura_` DEFAULT CHARACTER SET utf8 ;
USE `concretospiura_` ;
-- -----------------------------------------------------
-- Table `cpiura_shema`.`usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `concretospiura_`.`usuario` ;
CREATE TABLE IF NOT EXISTS `concretospiura_`.`usuario` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL,
  `password` VARCHAR(128) CHARACTER SET 'utf8' NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci
COMMENT = 'Tabla usuarios';


-- -----------------------------------------------------
-- Table `concretospiura_`.`amigos_usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `concretospiura_`.`amigos_usuario` ;
CREATE TABLE IF NOT EXISTS `concretospiura_`.`amigos_usuario` (
  `idUsuario` INT(11) NOT NULL,
  `idAmigo` INT(11) NOT NULL,
  PRIMARY KEY (`idUsuario`, `idAmigo`),
  INDEX `fk_Amigos_usuario_Usuario1_idx` (`idAmigo` ASC),
  CONSTRAINT `fk_Amigos_usuario_Usuario`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `concretospiura_`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Amigos_usuario_Usuario1`
    FOREIGN KEY (`idAmigo`)
    REFERENCES `concretospiura_`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `concretospiura_`.`tienda`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `concretospiura_`.`tienda` ;
CREATE TABLE IF NOT EXISTS `concretospiura_`.`tienda` (
  `owner` INT(11) NULL DEFAULT NULL,
  `titulo` VARCHAR(45) CHARACTER SET 'ucs2' NOT NULL,
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `owner_UNIQUE` (`owner` ASC),
  CONSTRAINT `fk_Tienda_Usuario1`
    FOREIGN KEY (`owner`)
    REFERENCES `concretospiura_`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = ucs2
COLLATE = ucs2_spanish_ci;


-- -----------------------------------------------------
-- Table `concretospiura_`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `concretospiura_`.`users` ;
CREATE TABLE IF NOT EXISTS `concretospiura_`.`users` (
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
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;