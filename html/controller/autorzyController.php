<?php
class autorzyController extends baseController {

    //Lista autorów
    public function index() {
        $this->ograniczDostepTylkoDlaAdmina();
        $db = $this->registry->db;
        $this->registry->template->results = $db::getAutorList();
        $this->registry->template->show('autorzy/autor_index');
    }
 
    //Nowy autor
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
 
    //Edycja
    public function edit() {
        $this->ograniczDostepTylkoDlaAdmina();
        $error = "";
        $success = "";
        $db = $this->registry->db;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $imie_nazwisko = trim($_POST['nazwa']);
            if (empty($imie_nazwisko)) {
                $error .= 'Uzupełnij pole imię i nazwisko <br />';
            }
            if (empty($error)) {
                $autor = new Autor();
                $id = trim($_POST['id_autor']);
                $autor->setIdAutor($id);
                $autor->setImieNazwisko($imie_nazwisko);
                if ($db::updateAutor($autor)) {
                    $success .= 'Edycja zakończona pomyślnie <br />';
                } else {
                    $error .= 'Edycja nie powiodła się <br />';
                }
            }
            $this->registry->template->success = $success;
            $this->registry->template->error = $error;
        } else {
            $id = $this->registry->id;

            $autor = $db::getAutorById($id);
            $this->registry->template->model = $autor;
        }
        $this->registry->template->show('autorzy/autor_edit');
    }
 
    //Usuwanie autora
    public function delete() {
        $this->ograniczDostepTylkoDlaAdmina();
        $db = $this->registry->db;
        $error = "";
        $success = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['delete'])) {
                $autor = new Autor();
                $id = trim($_POST['id']);
                $autor->setIdAutor($id);
                if ($db::deleteAutor($autor)) {
                    $success .= 'Usunięto autora <br />';
                } else {
                    $error .= 'Usuwanie nie powiodło się. Autor może być aktualnie używany przez pozycje. <br />';
                }
            } else {
                $location = '/' . APP_ROOT . '/autorzy';
                header("Location: $location");
            }
            $this->registry->template->success = $success;
            $this->registry->template->error = $error;
            $this->registry->template->show('autorzy/autor_action_result');
        } else {
            $id = $this->registry->id;
            $autor = $db::getAutorById($id);
            $this->registry->template->model = $autor;
            $this->registry->template->show('autorzy/autor_delete');
        }
    }
}
?>