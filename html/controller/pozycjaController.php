<?php

class pozycjaController extends baseController {

 public function index() {
    //$this->ograniczDostepTylkoDlaAdmina();
    $db = $this->registry->db;
    $results = $db::getPozycjaList();
    $pozycje = array();
    $user = $db::GetUserByLogin($_SESSION['user']);
    if(!$_SESSION['user']=="")
    {
        $user = $db::GetUserByLogin($_SESSION['user']);
        $userId = $user->getId();
        foreach ($results as $row) {
            if($db::getZakupione($userId, $row['id_pozycja'])){
                $pozycja = new Pozycja();
                $pozycja->setIdPozycja($row['id_pozycja']);
                $pozycja->setTytuł($row['tytuł']);
                $pozycja->setRokWydania($row['rok_wydania']);
                $pozycja->setIdAutor($row['id_autor']);
                $autor = $db::getAutorById($row['id_autor']);
                $pozycja->setAutor($autor);
                $pozycja->setCena($row['cena']);
                $pozycja->setOpis($row['opis']);
                $pozycja->setIdKategoria($row['id_kategoria']);
                $kategoria = $db::getKategoriaById($row['id_kategoria']);
                $pozycja->setKategoria($kategoria);
                $pozycje[] = $pozycja;
            }
        }
    }
    else
    {
        foreach ($results as $row) {
            $pozycja = new Pozycja();
            $pozycja->setIdPozycja($row['id_pozycja']);
            $pozycja->setTytuł($row['tytuł']);
            $pozycja->setRokWydania($row['rok_wydania']);
            $pozycja->setIdAutor($row['id_autor']);
            $autor = $db::getAutorById($row['id_autor']);
            $pozycja->setAutor($autor);
            $pozycja->setCena($row['cena']);
            $pozycja->setOpis($row['opis']);
            $pozycja->setIdKategoria($row['id_kategoria']);
            $kategoria = $db::getKategoriaById($row['id_kategoria']);
            $pozycja->setKategoria($kategoria);
            $pozycje[] = $pozycja;
        }
    }
    $kategorie = array();
    $results = $db::getKategoriaList();
    foreach ($results as $row) {
        $kategoria = new Kategoria();
        $kategoria->setIdKategoria($row['id_kategoria']);
        $kategoria->setNazwa($row['nazwa']);
        $kategorie[] = $kategoria;
    }
    $autorzy = array();
    $results = $db::getAutorList();
    foreach ($results as $row) {
        $autor = new Autor();
        $autor->setIdAutor($row['id_autor']);
        $autor->setImieNazwisko($row['imie_nazwisko']);
        $autorzy[] = $autor;
    }
    $this->registry->template->pozycje = $pozycje;
    $this->registry->template->kategorie = $kategorie;
    $this->registry->template->autorzy = $autorzy;
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
    $autorzyList = $db::getAutorList();
    $this->registry->template->autorzy = $autorzyList;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tytuł = trim($_POST['tytuł']);
        if (empty($tytuł)) {
            $error .= 'Uzupełnij pole tytuł <br />';
        }
        $rokWydania = trim($_POST['rok_wydania']);
        if (empty($rokWydania)) {
            $error .= 'Uzupełnij pole rok wydania <br />';
        }
        $idAutor = $_POST['autor'];
        if (empty($idAutor)) {
            $error .= 'Wybierz pole autor <br />';
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
            $pozycja->setTytuł($tytuł);
            $pozycja->setRokWydania($rokWydania);
            $pozycja->setIdAutor($idAutor);
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
    $autorList = $db::getAutorList();
    $this->registry->template->autorzyAll = $autorList;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = trim($_POST['id']);
        if (empty($id)) {
            $error .= 'Błąd <br />';
        }
        $tytuł = trim($_POST['tytuł']);
        if (empty($tytuł)) {
            $error .= 'Uzupełnij pole tytuł <br />';
        }
        $rokWydania = trim($_POST['rok_wydania']);
        if (empty($rokWydania)) {
            $error .= 'Uzupełnij pole rok wydania <br />';
        }
        $idAutor = trim($_POST['id_autor']);
        if (empty($idAutor)) {
            $error .= 'Wybierz pole autor <br />';
        }
        $cena = trim($_POST['cena']);
        if (empty($cena)) {
            $error .= 'Uzupełnij pole cena <br />';
        }
        $idKategoria = $_POST['id_kategoria'];
        if (empty($idKategoria)) {
            $error .= 'Wybierz pole kategoria <br />';
        }
        $opis = trim($_POST['opis']);
        if (empty($error)) {
            $pozycja = new Pozycja();
            $pozycja->setIdPozycja($id);
            $pozycja->setTytuł($tytuł);
            $pozycja->setRokWydania($rokWydania);
            $pozycja->setIdAutor($idAutor);
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
