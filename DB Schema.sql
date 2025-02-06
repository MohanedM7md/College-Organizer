SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema cufedb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema cufedb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `cufedb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `cufedb` ;

-- -----------------------------------------------------
-- Table `cufedb`.`teachers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cufedb`.`teachers` (
  `InsID` INT NOT NULL AUTO_INCREMENT,
  `Fname` VARCHAR(30) NULL DEFAULT NULL,
  `LName` VARCHAR(30) NULL DEFAULT NULL,
  `Postion` VARCHAR(10) NULL DEFAULT NULL,
  PRIMARY KEY (`InsID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `cufedb`.`contact`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cufedb`.`contact` (
  `InsID` INT NOT NULL,
  `PhoneNom` CHAR(12) NOT NULL,
  `Email` VARCHAR(300) NOT NULL,
  PRIMARY KEY (`InsID`, `PhoneNom`, `Email`),
  CONSTRAINT `contact_ibfk_1`
    FOREIGN KEY (`InsID`)
    REFERENCES `cufedb`.`teachers` (`InsID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `cufedb`.`courses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cufedb`.`courses` (
  `CourseCode` CHAR(7) NOT NULL,
  `CourseName` VARCHAR(60) NULL DEFAULT NULL,
  `CourseGroup` VARCHAR(2048) NULL DEFAULT NULL,
  `Syllabus` BLOB NULL DEFAULT NULL,
  `Matrails` VARCHAR(2048) NULL DEFAULT NULL,
  `AvgFinal` CHAR(1) NULL DEFAULT NULL,
  `avgMD` DECIMAL(2,0) NULL DEFAULT NULL,
  `avgQuizs` DECIMAL(2,2) NULL DEFAULT NULL,
  PRIMARY KEY (`CourseCode`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `cufedb`.`departments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cufedb`.`departments` (
  `Dcode` CHAR(3) NOT NULL,
  `DepName` VARCHAR(60) NULL DEFAULT NULL,
  `CourseMap` BLOB NULL DEFAULT NULL,
  PRIMARY KEY (`Dcode`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `cufedb`.`depcourse`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cufedb`.`depcourse` (
  `Dcode` CHAR(3) NOT NULL,
  `CourseCode` CHAR(7) NOT NULL,
  PRIMARY KEY (`Dcode`, `CourseCode`),
  INDEX `CourseCode` (`CourseCode` ASC) VISIBLE,
  CONSTRAINT `depcourse_ibfk_1`
    FOREIGN KEY (`Dcode`)
    REFERENCES `cufedb`.`departments` (`Dcode`),
  CONSTRAINT `depcourse_ibfk_2`
    FOREIGN KEY (`CourseCode`)
    REFERENCES `cufedb`.`courses` (`CourseCode`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `cufedb`.`stduser`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cufedb`.`stduser` (
  `ID` INT NOT NULL,
  `Fname` VARCHAR(30) NULL DEFAULT NULL,
  `LName` VARCHAR(30) NULL DEFAULT NULL,
  `Email` VARCHAR(300) NULL DEFAULT NULL,
  `Userpassword` VARCHAR(200) NULL DEFAULT NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `cufedb`.`techcourse`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cufedb`.`techcourse` (
  `CourseCode` CHAR(7) NOT NULL,
  `InsID` INT NOT NULL,
  PRIMARY KEY (`CourseCode`, `InsID`),
  INDEX `InsID` (`InsID` ASC) VISIBLE,
  CONSTRAINT `techcourse_ibfk_1`
    FOREIGN KEY (`InsID`)
    REFERENCES `cufedb`.`teachers` (`InsID`),
  CONSTRAINT `techcourse_ibfk_2`
    FOREIGN KEY (`CourseCode`)
    REFERENCES `cufedb`.`courses` (`CourseCode`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `cufedb`.`userdep`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cufedb`.`userdep` (
  `Dcode` CHAR(3) NOT NULL,
  `UserID` INT NULL DEFAULT NULL,
  PRIMARY KEY (`Dcode`),
  INDEX `UserID` (`UserID` ASC) VISIBLE,
  CONSTRAINT `userdep_ibfk_1`
    FOREIGN KEY (`Dcode`)
    REFERENCES `cufedb`.`departments` (`Dcode`),
  CONSTRAINT `userdep_ibfk_2`
    FOREIGN KEY (`UserID`)
    REFERENCES `cufedb`.`stduser` (`ID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
