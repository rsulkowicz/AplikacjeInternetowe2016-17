<?php
class koszykController extends baseController {
 //Zawartość koszyka
 public function index() {
 $this->ograniczDostepTylkoDlaZalogowanegoUzytkownika();
 $produkty = array();
 $calk_ilosc = 0;
 $wart = 0;
 if (isset($_SESSION['koszyk']) && isset($_SESSION['calkowita_ilosc']) && isset($_SESSION['wartosc'])) {
 $db = $this->registry->db;
 foreach ($_SESSION['koszyk'] as $idProduktu => $ilosc) {
 $produkt = $db::getProduktById($idProduktu);
 $wart = $_SESSION['wartosc'];
 $calk_ilosc = $_SESSION['calkowita_ilosc'];
 $produkty[] = $produkt;
 }
 }
 $this->registry->template->produkty = $produkty;
 $this->registry->template->calkowita_ilosc = $calk_ilosc;
 $this->registry->template->wartosc = $wart;
 $this->registry->template->show('koszyk/koszyk_index');
 }

 //Odświeżenie zawartości
 private function refreshShoppingCart() {
 $calkowita_ilosc = 0;
 $wartosc = 0;
 if (isset($_SESSION['koszyk']) && isset($_SESSION['calkowita_ilosc']) && isset($_SESSION['wartosc'])) {
 $db = $this->registry->db;
 foreach ($_SESSION['koszyk'] as $idProduktu => $ilosc) {
 $produkt = $db::getProduktById($idProduktu);
 $calkowita_ilosc += $ilosc;
 $wartosc += $ilosc * $produkt->getCena();
 }
 }
 $_SESSION['calkowita_ilosc'] = $calkowita_ilosc;
 $_SESSION['wartosc'] = $wartosc;
 }

 //Dodanie pozycji
 public function add() {
 $this->ograniczDostepTylkoDlaZalogowanegoUzytkownika();
 $idProduktu = $this->registry->id;
 if (!isset($_SESSION['koszyk']) || !isset($_SESSION['calkowita_ilosc']) || !isset($_SESSION['wartosc'])) {
 $_SESSION['koszyk'] = array();
 $_SESSION['calkowita_ilosc'] = 0;
 $_SESSION['wartosc'] = 0;
 }
 if (isset($_SESSION['koszyk'][$idProduktu])) {
 $_SESSION['koszyk'][$idProduktu] ++;
 } else {
 $_SESSION['koszyk'][$idProduktu] = 1;
 }
 $this->refreshShoppingCart();
 $location = '/' . APP_ROOT . '/koszyk';
 header("Location: $location");
 }

 //Edycja zawartości
 public function edit() {
 $this->ograniczDostepTylkoDlaZalogowanegoUzytkownika();
 if (isset($_SESSION['koszyk'])) {
 foreach ($_SESSION['koszyk'] as $idProduktu => $ilosc) {
 if (isset($_POST[$idProduktu])) {
 var_dump($_POST);
 $nowaIlosc = $_POST[$idProduktu];
 if ($nowaIlosc < 0) {
 continue;}
 if ($nowaIlosc == 0) {
 unset($_SESSION['koszyk'][$idProduktu]);
 } else {
 $_SESSION['koszyk'][$idProduktu] = $nowaIlosc;
 }
 }
 }
 $this->refreshShoppingCart();
 }
 $location = '/' . APP_ROOT . '/koszyk';
 header("Location: $location");
 }

 //Usunięcie pozycji
 public function delete() {
 $this->ograniczDostepTylkoDlaZalogowanegoUzytkownika();
 $idProduktu = $this->registry->id;

 if (isset($_SESSION['koszyk'][$idProduktu])) {
 unset($_SESSION['koszyk'][$idProduktu]);
 $this->refreshShoppingCart();
 }
 $location = '/' . APP_ROOT . '/koszyk';
 header("Location: $location");
 }
}
?>