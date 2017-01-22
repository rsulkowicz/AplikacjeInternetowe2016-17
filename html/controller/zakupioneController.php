<?php
class zakupioneController extends baseController {

    //Lista autorów
    public function index() {
        $this->ograniczDostepTylkoDlaZalogowanegoUzytkownika();
        $db = $this->registry->db;
        $user = $db::getUserByLogin($_SESSION['user']);
        $this->registry->template->zakupione = $db::getZakupioneListByUser($user);
        $this->registry->template->show('zakupione/zakupione_index');
    }
    
    //Nowy zakup
    public function add() {
        $this->ograniczDostepTylkoDlaAdmina();
        $error = "";
        $success = "";
        $db = $this->registry->db;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $imie_nazwisko = trim($_POST['imie_nazwisko']);
            if (empty($imie_nazwisko)) {
                $error .= 'Uzupełnij pole imię i nazwisko <br />';
            }
            if (empty($error)) {
                $autor = new Autor();
                $autor->setImieNazwisko($imie_nazwisko);
                if ($db::addAutor($autor)) {
                    $success .= 'Dodano autora <br />';
                } else {
                    $error .= 'Dodanie autora nie powiodło się <br />';
                }
            }
            $this->registry->template->error = $error;
            $this->registry->template->success = $success;
        }
        $this->registry->template->show('autorzy/autor_add');
    }
}
?>