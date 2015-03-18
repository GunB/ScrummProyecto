-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema scrumgrAu0VvEumO
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `scrumgrAu0VvEumO` ;

-- -----------------------------------------------------
-- Schema scrumgrAu0VvEumO
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `scrumgrAu0VvEumO` DEFAULT CHARACTER SET utf8 ;
USE `scrumgrAu0VvEumO` ;

-- -----------------------------------------------------
-- Table `scrumgrAu0VvEumO`.`usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scrumgrAu0VvEumO`.`usuario` ;

CREATE TABLE IF NOT EXISTS `scrumgrAu0VvEumO`.`usuario` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` TEXT NULL,
  `correo` TEXT NULL,
  `clave` TEXT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scrumgrAu0VvEumO`.`proyecto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scrumgrAu0VvEumO`.`proyecto` ;

CREATE TABLE IF NOT EXISTS `scrumgrAu0VvEumO`.`proyecto` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` TEXT NOT NULL,
  `ent_interesada` TEXT NULL,
  `duracion` INT NOT NULL DEFAULT 0,
  `duracion_iteracion` TEXT NULL,
  `cantidad_iteraciones` TEXT NULL,
  `descripcion` TEXT NULL,
  `usuario_id` INT UNSIGNED NOT NULL,
  `grafica` TEXT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_proyecto_usuario_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_proyecto_usuario`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `scrumgrAu0VvEumO`.`usuario` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scrumgrAu0VvEumO`.`integrante_equipo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scrumgrAu0VvEumO`.`integrante_equipo` ;

CREATE TABLE IF NOT EXISTS `scrumgrAu0VvEumO`.`integrante_equipo` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` TEXT NULL,
  `apellidos` TEXT NULL,
  `edad` TEXT NULL,
  `correo` TEXT NULL,
  `telefono` TEXT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scrumgrAu0VvEumO`.`tipo_historia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scrumgrAu0VvEumO`.`tipo_historia` ;

CREATE TABLE IF NOT EXISTS `scrumgrAu0VvEumO`.`tipo_historia` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` TEXT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scrumgrAu0VvEumO`.`historia_usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scrumgrAu0VvEumO`.`historia_usuario` ;

CREATE TABLE IF NOT EXISTS `scrumgrAu0VvEumO`.`historia_usuario` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` TEXT NULL,
  `descripcion` TEXT NULL,
  `prioridad` INT NULL,
  `puntos_de_historia` INT NULL,
  `detalles` TEXT NULL,
  `tipo_historia_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_historia_usuario_tipo_historia1_idx` (`tipo_historia_id` ASC),
  CONSTRAINT `fk_historia_usuario_tipo_historia1`
    FOREIGN KEY (`tipo_historia_id`)
    REFERENCES `scrumgrAu0VvEumO`.`tipo_historia` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scrumgrAu0VvEumO`.`tipo_iteracion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scrumgrAu0VvEumO`.`tipo_iteracion` ;

CREATE TABLE IF NOT EXISTS `scrumgrAu0VvEumO`.`tipo_iteracion` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` TEXT NULL,
  `descripcion` TEXT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scrumgrAu0VvEumO`.`iteracion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scrumgrAu0VvEumO`.`iteracion` ;

CREATE TABLE IF NOT EXISTS `scrumgrAu0VvEumO`.`iteracion` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `numero` TEXT NULL,
  `meta` TEXT NULL,
  `fecha_entregable` TEXT NULL,
  `lugar_daily_scrum` TEXT NULL,
  `hora_daily_scrum` TEXT NULL,
  `velocidad` TEXT NULL,
  `tipo_iteracion_id` INT UNSIGNED NOT NULL,
  `proyecto_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_iteracion_tipo_iteracion1_idx` (`tipo_iteracion_id` ASC),
  INDEX `fk_iteracion_proyecto1_idx` (`proyecto_id` ASC),
  CONSTRAINT `fk_iteracion_tipo_iteracion1`
    FOREIGN KEY (`tipo_iteracion_id`)
    REFERENCES `scrumgrAu0VvEumO`.`tipo_iteracion` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_iteracion_proyecto1`
    FOREIGN KEY (`proyecto_id`)
    REFERENCES `scrumgrAu0VvEumO`.`proyecto` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scrumgrAu0VvEumO`.`ci_sessions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scrumgrAu0VvEumO`.`ci_sessions` ;

CREATE TABLE IF NOT EXISTS `scrumgrAu0VvEumO`.`ci_sessions` (
  `session_id` VARCHAR(40) NOT NULL DEFAULT '0',
  `ip_address` VARCHAR(45) NOT NULL DEFAULT '0',
  `user_agent` VARCHAR(120) NOT NULL,
  `last_activity` INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` TEXT NOT NULL,
  PRIMARY KEY (`session_id`),
  INDEX `last_activity_idx` (`last_activity` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `scrumgrAu0VvEumO`.`estado_proyecto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scrumgrAu0VvEumO`.`estado_proyecto` ;

CREATE TABLE IF NOT EXISTS `scrumgrAu0VvEumO`.`estado_proyecto` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` TEXT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scrumgrAu0VvEumO`.`estado_iteracion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scrumgrAu0VvEumO`.`estado_iteracion` ;

CREATE TABLE IF NOT EXISTS `scrumgrAu0VvEumO`.`estado_iteracion` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` TEXT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scrumgrAu0VvEumO`.`iteracion_has_estado_iteracion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scrumgrAu0VvEumO`.`iteracion_has_estado_iteracion` ;

CREATE TABLE IF NOT EXISTS `scrumgrAu0VvEumO`.`iteracion_has_estado_iteracion` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `iteracion_id` INT UNSIGNED NOT NULL,
  `estado_iteracion_id` INT UNSIGNED NOT NULL,
  INDEX `fk_iteracion_has_estado_iteracion_estado_iteracion1_idx` (`estado_iteracion_id` ASC),
  INDEX `fk_iteracion_has_estado_iteracion_iteracion1_idx` (`iteracion_id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_iteracion_has_estado_iteracion_iteracion1`
    FOREIGN KEY (`iteracion_id`)
    REFERENCES `scrumgrAu0VvEumO`.`iteracion` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_iteracion_has_estado_iteracion_estado_iteracion1`
    FOREIGN KEY (`estado_iteracion_id`)
    REFERENCES `scrumgrAu0VvEumO`.`estado_iteracion` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scrumgrAu0VvEumO`.`proyecto_has_estado_proyecto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scrumgrAu0VvEumO`.`proyecto_has_estado_proyecto` ;

CREATE TABLE IF NOT EXISTS `scrumgrAu0VvEumO`.`proyecto_has_estado_proyecto` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `proyecto_id` INT UNSIGNED NOT NULL,
  `estado_proyecto_id` INT UNSIGNED NOT NULL,
  INDEX `fk_proyecto_has_estado_proyecto_estado_proyecto1_idx` (`estado_proyecto_id` ASC),
  INDEX `fk_proyecto_has_estado_proyecto_proyecto1_idx` (`proyecto_id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_proyecto_has_estado_proyecto_proyecto1`
    FOREIGN KEY (`proyecto_id`)
    REFERENCES `scrumgrAu0VvEumO`.`proyecto` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_proyecto_has_estado_proyecto_estado_proyecto1`
    FOREIGN KEY (`estado_proyecto_id`)
    REFERENCES `scrumgrAu0VvEumO`.`estado_proyecto` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scrumgrAu0VvEumO`.`historia_usuario_has_integrante_equipo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scrumgrAu0VvEumO`.`historia_usuario_has_integrante_equipo` ;

CREATE TABLE IF NOT EXISTS `scrumgrAu0VvEumO`.`historia_usuario_has_integrante_equipo` (
  `historia_usuario_id` INT UNSIGNED NOT NULL,
  `integrante_equipo_id` INT UNSIGNED NOT NULL,
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `detalles` TEXT NULL,
  `fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `fk_historia_usuario_has_integrante_equipo_integrante_equipo_idx` (`integrante_equipo_id` ASC),
  INDEX `fk_historia_usuario_has_integrante_equipo_historia_usuario1_idx` (`historia_usuario_id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_historia_usuario_has_integrante_equipo_historia_usuario1`
    FOREIGN KEY (`historia_usuario_id`)
    REFERENCES `scrumgrAu0VvEumO`.`historia_usuario` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_historia_usuario_has_integrante_equipo_integrante_equipo1`
    FOREIGN KEY (`integrante_equipo_id`)
    REFERENCES `scrumgrAu0VvEumO`.`integrante_equipo` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scrumgrAu0VvEumO`.`estado_daily_scrum`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scrumgrAu0VvEumO`.`estado_daily_scrum` ;

CREATE TABLE IF NOT EXISTS `scrumgrAu0VvEumO`.`estado_daily_scrum` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` TEXT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scrumgrAu0VvEumO`.`daily_scrum`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scrumgrAu0VvEumO`.`daily_scrum` ;

CREATE TABLE IF NOT EXISTS `scrumgrAu0VvEumO`.`daily_scrum` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `dia` INT NULL,
  `fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `detalles` TEXT NULL,
  `iteracion_id` INT UNSIGNED NOT NULL,
  `estado_daily_scrum_id` INT UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  INDEX `fk_daily_scrum_iteracion1_idx` (`iteracion_id` ASC),
  INDEX `fk_daily_scrum_estado_daily_scrum1_idx` (`estado_daily_scrum_id` ASC),
  CONSTRAINT `fk_daily_scrum_iteracion1`
    FOREIGN KEY (`iteracion_id`)
    REFERENCES `scrumgrAu0VvEumO`.`iteracion` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_daily_scrum_estado_daily_scrum1`
    FOREIGN KEY (`estado_daily_scrum_id`)
    REFERENCES `scrumgrAu0VvEumO`.`estado_daily_scrum` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scrumgrAu0VvEumO`.`iteracion_has_integrante_equipo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scrumgrAu0VvEumO`.`iteracion_has_integrante_equipo` ;

CREATE TABLE IF NOT EXISTS `scrumgrAu0VvEumO`.`iteracion_has_integrante_equipo` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `iteracion_id` INT UNSIGNED NOT NULL,
  `integrante_equipo_id` INT UNSIGNED NOT NULL,
  `fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `fk_iteracion_has_integrante_equipo_integrante_equipo1_idx` (`integrante_equipo_id` ASC),
  INDEX `fk_iteracion_has_integrante_equipo_iteracion1_idx` (`iteracion_id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_iteracion_has_integrante_equipo_iteracion1`
    FOREIGN KEY (`iteracion_id`)
    REFERENCES `scrumgrAu0VvEumO`.`iteracion` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_iteracion_has_integrante_equipo_integrante_equipo1`
    FOREIGN KEY (`integrante_equipo_id`)
    REFERENCES `scrumgrAu0VvEumO`.`integrante_equipo` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scrumgrAu0VvEumO`.`iteracion_has_historia_usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scrumgrAu0VvEumO`.`iteracion_has_historia_usuario` ;

CREATE TABLE IF NOT EXISTS `scrumgrAu0VvEumO`.`iteracion_has_historia_usuario` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `iteracion_id` INT UNSIGNED NOT NULL,
  `historia_usuario_id` INT UNSIGNED NOT NULL,
  INDEX `fk_iteracion_has_historia_usuario_historia_usuario1_idx` (`historia_usuario_id` ASC),
  INDEX `fk_iteracion_has_historia_usuario_iteracion1_idx` (`iteracion_id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_iteracion_has_historia_usuario_iteracion1`
    FOREIGN KEY (`iteracion_id`)
    REFERENCES `scrumgrAu0VvEumO`.`iteracion` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_iteracion_has_historia_usuario_historia_usuario1`
    FOREIGN KEY (`historia_usuario_id`)
    REFERENCES `scrumgrAu0VvEumO`.`historia_usuario` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scrumgrAu0VvEumO`.`estado_tarea`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scrumgrAu0VvEumO`.`estado_tarea` ;

CREATE TABLE IF NOT EXISTS `scrumgrAu0VvEumO`.`estado_tarea` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` TEXT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scrumgrAu0VvEumO`.`tipo_tarea`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scrumgrAu0VvEumO`.`tipo_tarea` ;

CREATE TABLE IF NOT EXISTS `scrumgrAu0VvEumO`.`tipo_tarea` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` TEXT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scrumgrAu0VvEumO`.`tarea`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scrumgrAu0VvEumO`.`tarea` ;

CREATE TABLE IF NOT EXISTS `scrumgrAu0VvEumO`.`tarea` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` TEXT NULL,
  `detalles` TEXT NULL,
  `descripcion` TEXT NULL,
  `historia_usuario_id` INT UNSIGNED NOT NULL,
  `estado_tarea_id` INT UNSIGNED NOT NULL DEFAULT 1,
  `tipo_tarea_id` INT UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  INDEX `fk_tarea_historia_usuario1_idx` (`historia_usuario_id` ASC),
  INDEX `fk_tarea_estado_tarea1_idx` (`estado_tarea_id` ASC),
  INDEX `fk_tarea_tipo_tarea1_idx` (`tipo_tarea_id` ASC),
  CONSTRAINT `fk_tarea_historia_usuario1`
    FOREIGN KEY (`historia_usuario_id`)
    REFERENCES `scrumgrAu0VvEumO`.`historia_usuario` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_tarea_estado_tarea1`
    FOREIGN KEY (`estado_tarea_id`)
    REFERENCES `scrumgrAu0VvEumO`.`estado_tarea` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_tarea_tipo_tarea1`
    FOREIGN KEY (`tipo_tarea_id`)
    REFERENCES `scrumgrAu0VvEumO`.`tipo_tarea` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scrumgrAu0VvEumO`.`daily_scrum_has_tarea`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scrumgrAu0VvEumO`.`daily_scrum_has_tarea` ;

CREATE TABLE IF NOT EXISTS `scrumgrAu0VvEumO`.`daily_scrum_has_tarea` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `daily_scrum_id` INT UNSIGNED NOT NULL,
  `tarea_id` INT UNSIGNED NOT NULL,
  `estado_tarea_id` INT UNSIGNED NOT NULL DEFAULT 1,
  INDEX `fk_daily_scrum_has_tarea_tarea1_idx` (`tarea_id` ASC),
  INDEX `fk_daily_scrum_has_tarea_daily_scrum1_idx` (`daily_scrum_id` ASC),
  PRIMARY KEY (`id`),
  INDEX `fk_daily_scrum_has_tarea_estado_tarea1_idx` (`estado_tarea_id` ASC),
  CONSTRAINT `fk_daily_scrum_has_tarea_daily_scrum1`
    FOREIGN KEY (`daily_scrum_id`)
    REFERENCES `scrumgrAu0VvEumO`.`daily_scrum` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_daily_scrum_has_tarea_tarea1`
    FOREIGN KEY (`tarea_id`)
    REFERENCES `scrumgrAu0VvEumO`.`tarea` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_daily_scrum_has_tarea_estado_tarea1`
    FOREIGN KEY (`estado_tarea_id`)
    REFERENCES `scrumgrAu0VvEumO`.`estado_tarea` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `scrumgrAu0VvEumO`.`tipo_historia`
-- -----------------------------------------------------
START TRANSACTION;
USE `scrumgrAu0VvEumO`;
INSERT INTO `scrumgrAu0VvEumO`.`tipo_historia` (`id`, `nombre`) VALUES (1, 'normal');
INSERT INTO `scrumgrAu0VvEumO`.`tipo_historia` (`id`, `nombre`) VALUES (2, 'extra');
INSERT INTO `scrumgrAu0VvEumO`.`tipo_historia` (`id`, `nombre`) VALUES (3, 'dividida');
INSERT INTO `scrumgrAu0VvEumO`.`tipo_historia` (`id`, `nombre`) VALUES (4, 'hija');
INSERT INTO `scrumgrAu0VvEumO`.`tipo_historia` (`id`, `nombre`) VALUES (5, 'incompleta');

COMMIT;


-- -----------------------------------------------------
-- Data for table `scrumgrAu0VvEumO`.`tipo_iteracion`
-- -----------------------------------------------------
START TRANSACTION;
USE `scrumgrAu0VvEumO`;
INSERT INTO `scrumgrAu0VvEumO`.`tipo_iteracion` (`id`, `nombre`, `descripcion`) VALUES (1, 'original', NULL);
INSERT INTO `scrumgrAu0VvEumO`.`tipo_iteracion` (`id`, `nombre`, `descripcion`) VALUES (2, 'extra', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `scrumgrAu0VvEumO`.`estado_proyecto`
-- -----------------------------------------------------
START TRANSACTION;
USE `scrumgrAu0VvEumO`;
INSERT INTO `scrumgrAu0VvEumO`.`estado_proyecto` (`id`, `nombre`) VALUES (1, 'creado');
INSERT INTO `scrumgrAu0VvEumO`.`estado_proyecto` (`id`, `nombre`) VALUES (2, 'en progreso');
INSERT INTO `scrumgrAu0VvEumO`.`estado_proyecto` (`id`, `nombre`) VALUES (3, 'finilizado');

COMMIT;


-- -----------------------------------------------------
-- Data for table `scrumgrAu0VvEumO`.`estado_iteracion`
-- -----------------------------------------------------
START TRANSACTION;
USE `scrumgrAu0VvEumO`;
INSERT INTO `scrumgrAu0VvEumO`.`estado_iteracion` (`id`, `nombre`) VALUES (1, 'creada');
INSERT INTO `scrumgrAu0VvEumO`.`estado_iteracion` (`id`, `nombre`) VALUES (2, 'ingresando equipo');
INSERT INTO `scrumgrAu0VvEumO`.`estado_iteracion` (`id`, `nombre`) VALUES (3, 'ingresando historias');
INSERT INTO `scrumgrAu0VvEumO`.`estado_iteracion` (`id`, `nombre`) VALUES (4, 'en progreso');
INSERT INTO `scrumgrAu0VvEumO`.`estado_iteracion` (`id`, `nombre`) VALUES (5, 'finalizada');

COMMIT;


-- -----------------------------------------------------
-- Data for table `scrumgrAu0VvEumO`.`estado_daily_scrum`
-- -----------------------------------------------------
START TRANSACTION;
USE `scrumgrAu0VvEumO`;
INSERT INTO `scrumgrAu0VvEumO`.`estado_daily_scrum` (`id`, `nombre`) VALUES (1, 'en progreso');
INSERT INTO `scrumgrAu0VvEumO`.`estado_daily_scrum` (`id`, `nombre`) VALUES (2, 'finalizada');

COMMIT;


-- -----------------------------------------------------
-- Data for table `scrumgrAu0VvEumO`.`estado_tarea`
-- -----------------------------------------------------
START TRANSACTION;
USE `scrumgrAu0VvEumO`;
INSERT INTO `scrumgrAu0VvEumO`.`estado_tarea` (`id`, `nombre`) VALUES (1, 'creada');
INSERT INTO `scrumgrAu0VvEumO`.`estado_tarea` (`id`, `nombre`) VALUES (2, 'en progreso');
INSERT INTO `scrumgrAu0VvEumO`.`estado_tarea` (`id`, `nombre`) VALUES (3, 'finalizada');

COMMIT;


-- -----------------------------------------------------
-- Data for table `scrumgrAu0VvEumO`.`tipo_tarea`
-- -----------------------------------------------------
START TRANSACTION;
USE `scrumgrAu0VvEumO`;
INSERT INTO `scrumgrAu0VvEumO`.`tipo_tarea` (`id`, `nombre`) VALUES (1, 'normal');
INSERT INTO `scrumgrAu0VvEumO`.`tipo_tarea` (`id`, `nombre`) VALUES (2, 'entregable');

COMMIT;

