/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  RSułkowicz
 * 
 */

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


/*------------------------------------------------------------------------
--Utworzenie bazy danych Ksiegarnia-------------------------------------
------------------------------------------------------------------------*/
CREATE DATABASE IF NOT EXISTS ksiegarnia DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
use ksiegarnia;

/*-----------------------------------------------------------------------------
--Utworzenie tabel-----------------------------------------------------------
-----------------------------------------------------------------------------

--Uzytkownik*/
CREATE TABLE IF NOT EXISTS `uzytkownik` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `imie` VARCHAR(30) NOT NULL,
  `nazwisko` VARCHAR(30) NOT NULL,
  `adres` VARCHAR(50) NOT NULL,
  `telefon` INT NOT NULL,
  `email` VARCHAR(30) NOT NULL,
  `login` VARCHAR(30) NOT NULL,
  `haslo` VARCHAR(40) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

/*--Role*/
CREATE TABLE IF NOT EXISTS `role` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nazwa` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

/*--Uzytkownik-Role*/
CREATE TABLE IF NOT EXISTS `uzytkownik_role` (
  `id_uzytkownik` INT NOT NULL,
  `id_role` INT NOT NULL,
  INDEX `fk_uzytkownik_role_uzytkownik1_idx` (`id_uzytkownik` ASC),
  INDEX `fk_uzytkownik_role_role1_idx` (`id_role` ASC),
  PRIMARY KEY (`id_uzytkownik`, `id_role`),
  CONSTRAINT `fk_uzytkownik_role_uzytkownik1`
    FOREIGN KEY (`id_uzytkownik`)
    REFERENCES `uzytkownik` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_uzytkownik_role_role1`
    FOREIGN KEY (`id_role`)
    REFERENCES `role` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

/*---Autorzy*/
CREATE TABLE IF NOT EXISTS `autorzy` (
`id_autor` INT NOT NULL AUTO_INCREMENT,
`imie_nazwisko` VARCHAR(60) NOT NULL,
PRIMARY KEY (`id_autor`))
ENGINE = InnoDB;

/*--Kategoria*/
CREATE TABLE IF NOT EXISTS `kategoria` (
  `id_kategoria` INT NOT NULL AUTO_INCREMENT,
  `nazwa` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`id_kategoria`))
ENGINE = InnoDB;

/*--Pozycja*/
CREATE TABLE IF NOT EXISTS `pozycja` (
  `id_pozycja` INT NOT NULL AUTO_INCREMENT,
  `tytuł` VARCHAR(30) NOT NULL,
  `rok_wydania` INT(4) NOT NULL,
  `id_autor` INT NOT NULL,
  `cena` DECIMAL(6,2) NOT NULL,
  `opis` TEXT(100) NULL,
  `id_kategoria` INT NOT NULL,
  PRIMARY KEY (`id_pozycja`),
  INDEX `fk_pozycja_kategoria1_idx` (`id_kategoria` ASC),
  INDEX `fk_pozycja_autorzy1_idx` (`id_autor` ASC),
  CONSTRAINT `fk_pozycja_kategoria1`
    FOREIGN KEY (`id_kategoria`)
    REFERENCES `kategoria` (`id_kategoria`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_pozycja_autorzy`
    FOREIGN KEY (`id_autor`)
    REFERENCES `kategoria` (`id_kategoria`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

/*--Zamowienie*/
CREATE TABLE IF NOT EXISTS `zamowienie` (
  `id_zamowienie` INT NOT NULL AUTO_INCREMENT,
  `data_zamowienia` DATETIME NOT NULL,
  `data_realizacji` DATETIME NULL,
  `status` VARCHAR(30) NULL,
  `id_klienta` INT NOT NULL,
  PRIMARY KEY (`id_zamowienie`),
  INDEX `fk_zamowienie_uzytkownik1_idx` (`id_klienta` ASC),
  CONSTRAINT `fk_zamowienie_uzytkownik1`
    FOREIGN KEY (`id_klienta`)
    REFERENCES `uzytkownik` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

/*--Pozycja-Zamowienie*/
CREATE TABLE IF NOT EXISTS `pozycja_zamowienie` (
  `id_zamowienie` INT NOT NULL,
  `id_pozycja` INT NOT NULL,
  INDEX `fk_pozycja_zamowienie_zamowienie1_idx` (`id_zamowienie` ASC),
  INDEX `fk_pozycja_zamowienie_pozycja1_idx` (`id_pozycja` ASC),
  PRIMARY KEY (`id_zamowienie`, `id_pozycja`),
  CONSTRAINT `fk_pozycja_zamowienie_zamowienie1`
    FOREIGN KEY (`id_zamowienie`)
    REFERENCES `zamowienie` (`id_zamowienie`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_pozycja_zamowienie_pozycja1`
    FOREIGN KEY (`id_pozycja`)
    REFERENCES `pozycja` (`id_pozycja`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

/*--Zakupione*/
CREATE TABLE IF NOT EXISTS `zakupione` (
  `id_uzytkownik` INT NOT NULL,
  `id_pozycja` INT NOT NULL,
  INDEX `fk_zakupione_uzytkownik1_idx` (`id_uzytkownik` ASC),
  INDEX `fk_zakupione_pozycja1_idx` (`id_pozycja` ASC),
  PRIMARY KEY (`id_uzytkownik`, `id_pozycja`),
  CONSTRAINT `fk_zakupione_uzytkownik1`
    FOREIGN KEY (`id_uzytkownik`)
    REFERENCES `uzytkownik` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_zakupione_pozycja1`
    FOREIGN KEY (`id_pozycja`)
    REFERENCES `pozycja` (`id_pozycja`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


/*---------------------------------------------------------------------------
--Utworzenie konta roli admininistratora i użytkownika Admin
--------------------------------------------------------------------------*/
INSERT INTO role(id,nazwa) VALUES (1,'admin');
INSERT INTO uzytkownik(id,login,email,haslo) VALUES (1,'admin','admin@admin.pl',sha1('password'));
INSERT INTO uzytkownik_role(id_uzytkownik,id_role) VALUES (1,1);

/*--Utworzenie nowego użytkownika bazy danych, aby zapobiec korzystaniu z roota*/
CREATE USER 'ksiegarnia'@'localhost' IDENTIFIED BY 'qwerty';
GRANT ALL PRIVILEGES ON ksiegarnia.* TO 'ksiegarnia'@'localhost';
