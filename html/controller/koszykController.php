<?php
class koszykController extends baseController {
    //Zawartość koszyka
    public function index() {
        $this->ograniczDostepTylkoDlaZalogowanegoUzytkownika();
        $pozycje = array();
        $calk_ilosc = 0;
        $wart = 0;
        if (isset($_SESSION['koszyk']) && isset($_SESSION['calkowita_ilosc']) && isset($_SESSION['wartosc'])) {
            $db = $this->registry->db;
            foreach ($_SESSION['koszyk'] as $idPozycja => $ilosc) {
                $pozycja = $db::getPozycjaById($idPozycja);
                $wart = $_SESSION['wartosc'];
                $calk_ilosc = $_SESSION['calkowita_ilosc'];
                $pozycje[] = $pozycja;
            }
        }
        $this->registry->template->pozycje = $pozycje;
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
            foreach ($_SESSION['koszyk'] as $idPozycja => $ilosc) {
                $pozycja = $db::getPozycjaById($idPozycja);
                $calkowita_ilosc ++;
                $wartosc += $pozycja->getCena();
            }
        }
        $_SESSION['calkowita_ilosc'] = $calkowita_ilosc;
        $_SESSION['wartosc'] = $wartosc;
    }

    //Dodanie pozycji
    public function add() {
        $this->ograniczDostepTylkoDlaZalogowanegoUzytkownika();
        $idPozycja = $this->registry->id;
        if (!isset($_SESSION['koszyk']) || !isset($_SESSION['calkowita_ilosc']) || !isset($_SESSION['wartosc'])) {
            $_SESSION['koszyk'] = array();
            $_SESSION['calkowita_ilosc'] = 0;
            $_SESSION['wartosc'] = 0;
        }
        if (isset($_SESSION['koszyk'][$idPozycja])) {
            $_SESSION['koszyk'][$idPozycja] ++;
        } else {
            $_SESSION['koszyk'][$idPozycja] = 1;
        }
        $this->refreshShoppingCart();
        $location = '/' . APP_ROOT . '/koszyk';
        header("Location: $location");
    }

    //Edycja zawartości
    public function edit() {
        $this->ograniczDostepTylkoDlaZalogowanegoUzytkownika();
        if (isset($_SESSION['koszyk'])) {
            foreach ($_SESSION['koszyk'] as $idPozycja => $ilosc) {
                if (isset($_POST[$idPozycja])) {
                    var_dump($_POST);
                    $nowaIlosc = $_POST[$idPozycja];
                    if ($nowaIlosc < 0) {
                        continue;}
                    if ($nowaIlosc == 0) {
                        unset($_SESSION['koszyk'][$idPozycja]);
                    } else {
                        $_SESSION['koszyk'][$idPozycja] = $nowaIlosc;
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
 $idPozycja = $this->registry->id;

 if (isset($_SESSION['koszyk'][$idPozycja])) {
 unset($_SESSION['koszyk'][$idPozycja]);
 $this->refreshShoppingCart();
 }
 $location = '/' . APP_ROOT . '/koszyk';
 header("Location: $location");
 }
}
?>
