<?php
class Kategoria {
 //atrybuty klasy
 private $idKategoria;
 private $nazwa;
 
 //metody klasy
 //pobierz ID
 public function getIdKategoria() {
 return $this->idKategoria;
 }
 //pobierz nazwę
 public function getNazwa() {
 return $this->nazwa;
 }
 //ustaw ID
 public function setIdKategoria($idKategoria) {
 $this->idKategoria = $idKategoria;
 }
 //ustaw nazwę
 public function setNazwa($nazwa) {
 $this->nazwa = $nazwa;
 }
}
?>