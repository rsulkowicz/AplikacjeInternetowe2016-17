<?php
class zamowienieController extends baseController {
    //Wyświelenie listy wszystkich zamówień dla użytkownika Admin
    public function index() {
        $this->ograniczDostepTylkoDlaAdmina();
        $db = $this->registry->db;
        $results = $db::getZamowienieList();
        $zamowienia = array();
        foreach ($results as $row) {
            $zamowienie = new Zamowienie();
            $zamowienie->setIdZamowienia($row['id_zamowienie']);
            $zamowienie->setIdKlienta($row['id_klienta']);
            $pozycje = $db::getPozycjaZamowienia($row['id_zamowienie']);
            $zamowienie->setPozycje($pozycje);
            $cena = 0.0;
            foreach ($pozycje as $pozycja) {
                $cena += $pozycja->getPozycja()->getCena();
            }
            $zamowienie->setCena($cena);
            $zamowienie->setDataZamowienia($row['data_zamowienia']);
            $zamowienie->setDataRealizacji($row['data_realizacji']);
            $zamowienie->setStatus($row['status']);
            $zamowienia[] = $zamowienie;
        }
        $this->registry->template->zamowienia = $zamowienia;
        $this->registry->template->show('zamowienie/zamowienie_index');
    }

    //POBANIE I WYSWIETLENIE ZAMOWIEN ZALOGOWANEGO ZWYKLEGO UZYTKOWNIKA
    public function moje_zamowienia() {
        $this->ograniczDostepTylkoDlaZalogowanegoUzytkownika();
        $db = $this->registry->db;
        $login = $_SESSION['user'];
        $user = $db::getUserByLogin($login);
        $results = $db::getZamowienieUserList($user->getId());
        $zamowienia = array();
        foreach ($results as $row) {
            $zamowienie = new Zamowienie();
            $zamowienie->setIdZamowienia($row['id_zamowienie']);
            $zamowienie->setIdKlienta($row['id_klienta']);
            $pozycje = $db::getPozycjaZamowienia($row['id_zamowienie']);
            $zamowienie->setPozycje($pozycje);
            $cena = 0.0;
            foreach ($pozycje as $pozycja) {
                $cena += $pozycja->getPozycja()->getCena();
            }
            $zamowienie->setCena($cena);
            $zamowienie->setDataZamowienia($row['data_zamowienia']);
            $zamowienie->setDataRealizacji($row['data_realizacji']);
            $zamowienie->setStatus($row['status']);
            $zamowienia[] = $zamowienie;
        }
        $this->registry->template->zamowienia = $zamowienia;
        $this->registry->template->show('zamowienie/zamowienie_indexUser');
    }

    //DODANIE NOWEGO ZAMOWIENIA
    public function add() {
        $this->ograniczDostepTylkoDlaZalogowanegoUzytkownika();
        $error = "";
        $success = "";
        $db = $this->registry->db;
        $pozycje = array();
        if (isset($_SESSION['koszyk'])) {
            foreach ($_SESSION['koszyk'] as $idPozycja => $ilosc) {
                $pozycja = $db::getPozycjaById($idPozycja);
                $pozycje[] = $pozycja;
            }
            $user = $db::getUserByLogin($_SESSION['user']);
            $this->registry->template->pozycje = $pozycje;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($error)) {
                for ($i = 0; $i < count($pozycje); $i++) {
                    $p = $pozycje[$i];
                    $pozycjaZamowienia = new PozycjaZamowienia();
                    $pozycjaZamowienia->setIlosc(1);
                    $pozycjaZamowienia->setPozycja($p);
                    $pozycjaZamowienia->setIdPozycja($p->getIdPozycja());
                    $pozycjeZ[] = $pozycjaZamowienia;
                }

                $zamowienie = new Zamowienie();
                $zamowienie->setPozycje($pozycjeZ);
                $kwota = 0.0;
                foreach ($pozycjeZ as $p) {
                    $kwota += $p->getIlosc();
                }
                $zamowienie->setCena($kwota);
                $zamowienie->setStatus("nowe");
                $user = $db::getUserByLogin($_SESSION['user']);
                $userId = $user->getId();
                $zamowienie->setIdKlienta($userId);
                if ($db::addZamowienie($zamowienie)) {
                    $success .= 'Dodano zamowienie <br />';
                    unset($_SESSION['koszyk']);
                    unset($_SESSION['calkowita_wartosc']);
                    unset($_SESSION['wartosc']);
                } else {
                    $error .= 'Dodanie zamowienia nie powiodło się <br />';
                }
            }
            $this->registry->template->success = $success;
            $this->registry->template->error = $error;
        }
        $this->registry->template->show('zamowienie/zamowienie_add');
    }

    //USUNIECIE ZAMOWIENIA
    public function delete() {
    $this->ograniczDostepTylkoDlaAdmina();
    $db = $this->registry->db;
    $error = "";
    $success = "";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['delete'])) {
            $id = trim($_POST['id']);
            $zamowienie = $db::getZamowienieById($id);
            if ($db::deleteZamowienie($zamowienie)) {
                $success .= 'Usunięto zamówienie <br />';
            } else {
                $error .= 'Usuwanie nie powiodło się <br />';
            }
        } else {
            $location = '/' . APP_ROOT . '/zamowienie';
            header("Location: $location");
        }
        $this->registry->template->error = $error;
        $this->registry->template->success = $success;
        $this->registry->template->show('zamowienie/zamowienie_action_result');
        } else {
            $id = $this->registry->id;
            $zamowienie = $db::getZamowienieById($id);
            $this->registry->template->model = $zamowienie;
            $this->registry->template->show('zamowienie/zamowienie_delete');
        }
    }

    //ZREALIZOWANIE (WYSLANIE) ZAMOWIENIA
    public function realize() {
        $this->ograniczDostepTylkoDlaAdmina();
        $db = $this->registry->db;
        $error = "";
        $success = "";
        $pozycje = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['realize'])) {
                $id = trim($_POST['id']);
                
                $zamowienie = $db::getZamowienieById($id);
                $pozycje = $db::getPozycjaZamowienia($id);
                $userId = $zamowienie->getIdKlienta();
                foreach($pozycje as $pozycja)
                {
                    $idPozycja = $pozycja->getIdPozycja();
                    if(!($db::addZakupione($userId, $idPozycja)))
                    {
                        $error .= 'Realizacja nie powiodła się <br />';
                    }
                }
                $zamowienie->setStatus("Zrealizowane");
                if ($db::realizeZamowienie($zamowienie)) {
                    $success .= 'Wysłano zamówienie <br />';
                } else {
                    $error .= 'Realizacja nie powiodła się <br />';
                }
            } else {
                $location = '/' . APP_ROOT . '/zamowienie';
                header("Location: $location");
            }
            $this->registry->template->error = $error;
            $this->registry->template->success = $success;
            $this->registry->template->show('zamowienie/zamowienie_action_result');
        } else {
            $id = $this->registry->id;
            $zamowienie = $db::getZamowienieById($id);
            $this->registry->template->model = $zamowienie;
            $this->registry->template->show('zamowienie/zamowienie_realize');
        }
    }
}

?>
