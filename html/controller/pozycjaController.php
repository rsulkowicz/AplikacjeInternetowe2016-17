<?php

class pozycjaController extends baseController {

 public function index() {
 //$this->ograniczDostepTylkoDlaAdmina();
 $db = $this->registry->db;
 $results = $db::getPozycjaList();
 $pozycje = array();
 foreach ($results as $row) {
 $pozycja = new Pozycja();
 $pozycja->setIdPozycja($row['id_pozycja']);
 $pozycja->setNazwa($row['nazwa']);
 $pozycja->setCena($row['cena']);
 $pozycja->setOpis($row['opis']);
 $pozycja->setIdKategoria($row['id_kategoria']);
 $kategoria = $db::getKategoriaById($row['id_kategoria']);
 $pozycja->setKategoria($kategoria);
 $pozycje[] = $pozycja;
 }
 $kategorie = array();
 $results = $db::getKategoriaList();
 foreach ($results as $row) {
 $kategoria = new Kategoria();
 $kategoria->setIdKategoria($row['id_kategoria']);
 $kategoria->setNazwa($row['nazwa']);
 $kategorie[] = $kategoria;
 }
 $this->registry->template->pozycje = $pozycje;
 $this->registry->template->kategorie = $kategorie;
 $this->registry->template->show('pozycja/pozycja_index');
 }


//Dodanie pozycji
 public function add() {
 $this->ograniczDostepTylkoDlaAdmina();
 $error = "";
 $success = "";
 $db = $this->registry->db;
 $kategorieList = $db::getKategoriaList();
 $this->registry->template->kategorie = $kategorieList;
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 $nazwa = trim($_POST['nazwa']);
 if (empty($nazwa)) {
 $error .= 'Uzupełnij pole nazwa <br />';
 }
 $cena = trim($_POST['cena']);
 if (empty($cena)) {
 $error .= 'Uzupełnij pole cena <br />';
 }
 $idKategoria = $_POST['kategoria'];
 if (empty($idKategoria)) {
 $error .= 'Wybierz pole kategoria <br />';
 }
 $opis = trim($_POST['opis']);
 if (empty($error)) {
 $pozycja = new Pozycja();
 $pozycja->setNazwa($nazwa);
 $pozycja->setCena($cena);
 $pozycja->setIdKategoria($idKategoria);
 $pozycja->setOpis($opis);
 if ($db::addPozycja($pozycja)) {
 $success .= 'Dodano pozycje <br />';
 } else {
 $error .= 'Dodanie pozycji nie powiodło się <br />';
 }
 }

 $this->registry->template->error = $error;
 $this->registry->template->success = $success;
 }

 $this->registry->template->show('pozycja/pozycja_add');
 }

 public function edit() {
 $this->ograniczDostepTylkoDlaAdmina();
 $error = "";
 $success = "";
 $db = $this->registry->db;
 $kategorieList = $db::getKategoriaList();
 $this->registry->template->kategorieAll = $kategorieList;
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 $id = trim($_POST['id']);
 if (empty($id)) {
 $error .= 'Błąd <br />';
 }
 $nazwa = trim($_POST['nazwa']);
 if (empty($nazwa)) {
 $error .= 'Uzupełnij pole nazwa <br />';
 }
 $cena = trim($_POST['cena']);
 if (empty($cena)) {
 $error .= 'Uzupełnij pole cena <br />';
 }
 $idKategorii = $_POST['kategoria'];
 if (empty($idKategoria)) {
 $error .= 'Wybierz pole kategoria <br />';
 }
 $opis = trim($_POST['opis']);
 if (empty($error)) {
 $pozycja = new Pozycja();
 $pozycja->setIdPozycja($id);
 $pozycja->setNazwa($nazwa);
 $pozycja->setCena($cena);
 $pozycja->setIdKategoria($idKategoria);
 $pozycja->setOpis($opis);
 if ($db::updatePozycja($pozycja)) {
 $success .= 'Edycja zakończona pomyślnie <br />';
 } else {
 $error .= 'Edycja nie powiodła się <br />';
 }
 }
 $this->registry->template->error = $error;
 $this->registry->template->success = $success;
 $this->registry->template->show('pozycja/pozycja_action_result');
 } else {
 $id = $this->registry->id;
 $pozycja = $db::getPozycjaById($id);
 $this->registry->template->model = $pozycja;
 $this->registry->template->show('pozycja/pozycja_edit');
 }
 }

 public function delete() {
 $this->ograniczDostepTylkoDlaAdmina();
 $db = $this->registry->db;
 $error = "";
 $success = "";
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 if (isset($_POST['delete'])) {
 $id = trim($_POST['id']);
 $pozycja = $db::getPozycjaById($id);
 if ($db::deletePozycja($pozycja)) {
 $success .= 'Usunięto pozycje <br />';
 } else {
 $error .= 'Usuwanie nie powiodło się <br />';
 }
 } else {
 $location = '/' . APP_ROOT . '/pozycja';
 header("Location: $location");
 }
 $this->registry->template->error = $error;
 $this->registry->template->success = $success;
 $this->registry->template->show('pozycja/pozycja_action_result');
 } else {
 $id = $this->registry->id;
 $pozycja = $db::getPozycjaById($id);
 $this->registry->template->model = $pozycja;
 $this->registry->template->show('pozycja/pozycja_delete');
 }
 }

}

?>
