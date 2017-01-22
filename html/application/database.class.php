<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of database
 *
 * @author RSulkowicz
 */
class database 
{
    private static $db;
    
    public static function getInstance() 
    {
        if(!self::$db) 
        {
            self::$db=new PDO('mysql:host=serwer1789548.home.pl;dbname=22870910_0000001;charset=utf8','22870910_0000001','R;4NLnL.146.');
            return new database();
        }
    }
    
    ////////////////////////////////////////
    //uzytkownicy
    ///////////////////////////
    
    //Dodanie uzytkownika
    public static function addUser($user)
    {
        $stmt=self::$db->prepare("INSERT INTO uzytkownik(imie,nazwisko,adres,telefon,email,login,haslo) "
                . "VALUES(:imie,:nazwisko,:adres,:telefon,:email,:login,:haslo)");
        
        $stmt->execute(array(
            ':imie'=>$user->getImie(),
            ':nazwisko'=>$user->getNazwisko(),
            ':adres'=>$user->getAdres(),
            ':telefon'=>$user->getTelefon(),
            ':email'=>$user->getEmail(),
            ':login'=>$user->getLogin(),
            ':haslo'=> sha1($user->getHaslo()))
        );
        
        $affected_rows=$stmt->rowCount();
        if($affected_rows==1)
        {
            return TRUE;
        }
        return FALSE;
    }
    
    //Pobranie użytkownika po ID
    public static function getUserByID($id)
    {
        $stmt=self::$db->prepare('SELECT * FROM uzytkownik WHERE id=?');
        $stmt->execute(array($id));
        if($stmt->rowCount>0)
        {
            $results=$stmt->fetchAll(PDO::FETCH_ASSOC);
            $result=$results[0];
            $user=new Uzytkownik;
            $user->setId($result['id']);
            $user->setImie($result['imie']);
            $user->setNazwisko($result['nazwisko']);
            $user->setAdres($result['adres']);
            $user->setTelefon($result['telefon']);
            $user->setEmail($result['email']);
            $user->setLogin($result['login']);
            $user->setHaslo($result['haslo']);
            $role=self::userRoles($result['login']);
            $user->setRole($role);
            return $user;
        }
    }
    
    //Pobranie użytkownika po loginie i haśle
    public static function getUserByLoginAndPassword($login, $password) 
    {
        $stmt = self::$db->prepare('SELECT * FROM uzytkownik WHERE login=? and haslo=?');
        $stmt->execute(array($login, sha1($password)));
        if ($stmt->rowCount() > 0)
        {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $user = new Uzytkownik();
            $user->setId($result['id']);
            $user->setImie($result['imie']);
            $user->setNazwisko($result['nazwisko']);
            $user->setAdres($result['adres']);
            $user->setTelefon($result['telefon']);
            $user->setEmail($result['email']);
            $user->setLogin($result['login']);
            $user->setHaslo($result['haslo']);
            $role = self::userRoles($result['login']);
            $user->setRole($role);
            return $user;
        }
    }
    
    //pobranie uzytkownika o podanym loginie
    public static function getUserByLogin($login)
    {
        $stmt = self::$db->prepare('SELECT * FROM uzytkownik WHERE login=?');
        $stmt->execute(array($login));
        if ($stmt->rowCount() > 0)
        {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $user = new Uzytkownik();
            $user->setId($result['id']);
            $user->setImie($result['imie']);
            $user->setNazwisko($result['nazwisko']);
            $user->setAdres($result['adres']);
            $user->setTelefon($result['telefon']);
            $user->setEmail($result['email']);
            $user->setLogin($result['login']);
            $user->setHaslo($result['haslo']);
            $role = self::userRoles($result['login']);
            $user->setRole($role);
            return $user;
        }
    }
    
    //pobranie użytkownika o podanym mailu
    public static function getUserByEmail($email)
    {
        $stmt = self::$db->prepare('SELECT * FROM uzytkownik WHERE email=?');
        $stmt->execute(array($email));
        if ($stmt->rowCount() > 0)
        {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $user = new Uzytkownik();
            $user->setId($result['id']);
            $user->setImie($result['imie']);
            $user->setNazwisko($result['nazwisko']);
            $user->setAdres($result['adres']);
            $user->setTelefon($result['telefon']);
            $user->setEmail($result['email']);
            $user->setLogin($result['login']);
            $user->setHaslo($result['haslo']);
            $role = self::userRoles($result['login']);
            $user->setRole($role);
            return $user;
        }
    }
    
    
    ///////////////////////////////////////////////////////////////////////////
    //Role/////
    ////////////////////////////////////////////////////////////////////
    
    //sprawdzenie, czy użytkownik posiada określoną rolę
    public static function isUserInRole($login, $role)
    {
        $userRoles = self::userRoles($login);
        return in_array($role, $userRoles);
    }
    
    //pobranie wszystkich roli użytkownika
    public static function userRoles($login)
    {
        $stmt = self::$db->prepare("SELECT r.nazwa FROM uzytkownik u 	
		INNER JOIN uzytkownik_role ur on(u.id = ur.id_uzytkownik)
		INNER JOIN role r on(ur.id_role = r.id)
		WHERE	u.login = ?");
        $stmt->execute(array($login));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $roles = array();
        for ($i = 0; $i < count($result); $i++)
        {
            $roles[] = $result[$i]['nazwa'];
        }
        return $roles;
    }
    
    //////////////////////////////////////////////////////////////////////
    //Kategorie//////////////////
    ///////////////////////////////////////////////////////////////////////
    
    //Pobranie kategorii na podstawie id
    public static function getKategoriaById($id)
    {
        $stmt = self::$db->prepare('SELECT * FROM kategoria WHERE id_kategoria=?');
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $kategoria = new Kategoria();
            $kategoria->setIdKategoria($result['id_kategoria']);
            $kategoria->setNazwa($result['nazwa']);
            return $kategoria;
        }
    }
    
    //Dodanie kategorii
    public static function addKategoria($kategoria)
    {
        $stmt = self::$db->prepare("INSERT INTO kategoria(nazwa) "
                . "VALUES(:nazwa)");
        $stmt->execute(array(':nazwa' => $kategoria->getNazwa()));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }
    
    //Pobranie listy kategorii
    public static function getKategoriaList()
    {
        $stmt = self::$db->query('SELECT * FROM kategoria');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //Usuniecie kategorii
    public static function deleteKategoria($kategoria)
    {
        $stmt = self::$db->prepare('DELETE FROM kategoria WHERE id_kategoria=?');
        $stmt->execute(array($kategoria->getIdKategoria()));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }
    
    //Edycja kategorii
    public static function updateKategoria($kategoria)
    {
        $stmt = self::$db->prepare('UPDATE kategoria set nazwa=? WHERE id_kategoria=?');
        $stmt->execute(array($kategoria->getNazwa(), $kategoria->getIdKategoria()));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1)
        {
            return TRUE;
        }
        return FALSE;
    }
    
    
    /////////////////////////////////////////////////////////////////////////
    //Produkty//////////////////////////////
    /////////////////////////////////////////////////////////////////////////
    
    //Pobranie pozycji na podstawie ID
    public static function getPozycjaById($id)
    {
        $stmt = self::$db->prepare('SELECT * FROM pozycja p WHERE id_pozycja=?');
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $pozycja = new Pozycja();
            $pozycja->setIdPozycja($result['id_pozycja']);
            $pozycja->setTytuł($result['tytuł']);
            $pozycja->setRokWydania($result['rok_wydania']);
            $pozycja->setIdAutor($result['id_autor']);
            $pozycja->setAutor(self::getAutorById($result['id_autor']));
            $pozycja->setIdKategoria($result['id_kategoria']);
            $pozycja->setKategoria(self::getKategoriaById($result['id_kategoria']));
            $pozycja->setCena($result['cena']);
            $pozycja->setOpis($result['opis']);
            return $pozycja;
        }
    }
    
    //Dodanie pozycji
    public static function addPozycja($pozycja)
    {
        $stmt = self::$db->prepare('INSERT INTO pozycja(tytuł, rok_wydania, id_autor, cena, opis, id_kategoria) '
                . 'VALUES(:tytuł, :rok_wydania, :id_autor, :cena, :opis, :id_kategoria)');
        $stmt->execute(array(':tytuł' => $pozycja->getTytuł(),
            ':rok_wydania' => $pozycja->getRokWydania(),
            ':id_autor' => $pozycja->getIdAutor(),
            ':cena' => $pozycja->getCena(),
            ':opis' => $pozycja->getOpis(),
            ':id_kategoria' => $pozycja->getIdKategoria()
        )
        );

        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1)
        {
            return TRUE;
        }
        return FALSE;
    }
    
    /*
    public static function addPozycja($pozycja)
    {
        $tytuł = $pozycja->getTytuł();
        $rok_wydania = $pozycja->getRokWydania();
        $id_autor = $pozycja->getIdAutor();
        $cena = $pozycja->getCena();
        $opis = $pozycja->getOpis();
        $id_kategoria = $pozycja->getIdKategoria();
        $stmt = self::$db->prepare("INSERT INTO pozycja(tytuł, rok_wydania, id_autor, cena, opis, id_kategoria) "
                . "VALUES(?, ?, ?, ?, ?, ?)");
        
        $stmt->execute(array(
            'Dziady',
            1394,
            1,
            30.30,
            'coś tam coś tam',
            3
        )
        );
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1)
        {
            return TRUE;
        }
        return FALSE;
    }
    */
    //Pobranie listy pozycji książkowych
    public static function getPozycjaList()
    {
        $stmt = self::$db->query('SELECT * FROM pozycja');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //Pobranie listy pozycji wg kategorii
    public static function getPozycjaListByCategory($idKategoria)
    {
        $stmt = self::$db->prepare('SELECT * FROM pozycja WHERE id_kategoria=?');
         $stmt->execute(array($idKategoria));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //Pobranie listy wg autora
    public static function getPozycjaListByAutor($idAutor)
    {
        $stmt = self::$db->prepare('SELECT * FROM pozycja WHERE id_autor=?');
        $stmt->execute(array($idAutor));
        return $stmt-fetchAll(PDO::FETCH_ASSOC);
    }
    
    //Usuwanie pozycji
    public static function deletePozycja($pozycja) 
    {
        $stmt = self::$db->prepare('DELETE FROM pozycja WHERE id_pozycja=?');
        $stmt->execute(array($pozycja->getIdPozycja()));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1)
        {
            return TRUE;
        }
        return FALSE;
    }
    
    //Edycja pozycji
    public static function updatePozycja($pozycja)
    {
        try
        {
            self::$db->beginTransaction();
            $stmt = self::$db->prepare('UPDATE pozycja set tytuł=:tytuł,'
                    . 'cena=:cena, '
                    . 'rok_wydania=:rok_wydania'
                    . 'id_autor=:id_autor'
                    . 'id_kategoria=:id_kategoria,'
                    . 'opis=:opis WHERE id_produkt=:id');
            $stmt->execute(array(
                ':id' => $pozycja->getIdPozycja(),
                ':tytuł' => $pozycja->getTytuł(),
                ':rok_wydania' => $pozycja->getRokWydania(),
                ':id_autor' => $pozycja->getIdAutor(),
                ':id_kategorii' => $pozycja->getIdKategoria(),
                ':opis' => $pozycja->getOpis(),
                ':cena' => $pozycja->getCena()));
            $affected_rows = $stmt->rowCount();
            if ($affected_rows == 1)
            {
                self::$db->commit();
                return TRUE;
            }
        } 
        catch (Exception $ex)
        {
            echo $ex;
            self::$db->rollBack();
            return FALSE;
        }
    }
    
    ////////////////////////////////////////////////////////////////////////
    //Autorzy//////////////////////
    /////////////////////////////////////////////////////////////////////
    
    //Pobierz autora po ID
    public static function getAutorById($id)
    {
        $stmt = self::$db->prepare('SELECT * FROM autorzy WHERE id_autor=?');
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
           $autor = new Autor();
           $autor->setIdAutor($result['id_autor']);
           $autor->setImieNazwisko($result['imie_nazwisko']);
           return $autor;
        }
    }
    
    //Dodaj autora
    public static function addAutor($autor)
    {
        $stmt = self::$db->prepare("INSERT INTO autorzy(imie_nazwisko) "
                . "VALUES(:imie_nazwisko)");
        $stmt->execute(array(':imie_nazwisko' => $autor->getImieNazwisko()));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }
    
    //Lista autorów
    public static function getAutorList()
    {
        $stmt = self::$db->query('SELECT * FROM autorzy');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //Usuniecie autora
    public static function deleteAutor($autor)
    {
        $stmt = self::$db->prepare('DELETE FROM autorzy WHERE id_autor=?');
        $stmt->execute(array($autor->getIdAutor()));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }
    
    //Edycja autorów
    public static function updateAutor($autor)
    {
        $stmt = self::$db->prepare('UPDATE autorzy set imie_nazwisko=? WHERE id_autor=?');
        $stmt->execute(array($autor->getImieNazwisko(), $autor->getIdAutor()));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1)
        {
            return TRUE;
        }
        return FALSE;
    }
    
    
    ///////////////////////////////////////////////////////////////////////
    //Zamowienia////////////////////
    ///////////////////////////////////////////////////////////////////////
    
    //Pobierz zamowienie po ID
    public static function getZamowienieById($id) 
    {
        $stmt = self::$db->prepare('SELECT * FROM zamowienie WHERE id_zamowienie=?');
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $zamowienie = new Zamowienie();
            $zamowienie->setIdZamowienia($result['id_zamowienie']);
            $pozycjaZamowienie = self::getPozycjaZamowienia($id);
            $zamowienie->setPozycje($pozycjaZamowienie);
            $kwota = 0.0;
            foreach ($pozycjaZamowienie as $p)
            {
                $kwota += $p->getPozycja()->getCena() * $p->getIlosc();
            }
            $zamowienie->setCena($kwota);
            $zamowienie->setDataRealizacji($result['data_realizacji']);
            $zamowienie->setDataZamowienia($result['data_zamowienia']);
            $zamowienie->setIdKlienta($result['id_klienta']);
            $zamowienie->setStatus($result['status']);
            return $zamowienie;
        }
    }
    
    //Dodaj zamowienie
    public static function addZamowienie($zamowienie) 
    {
        $stmt = self::$db->prepare("INSERT INTO zamowienie(id_klienta ,status, data_zamowienia) "
                . "VALUES(:id_klienta, :status, now())");
        $stmt->execute(array(
            ':id_klienta' => $zamowienie->getIdKlienta(),
            ':status' => $zamowienie->getStatus()
        ));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) 
        {
            $idZamowienia = self::$db->lastInsertId();
            if (!empty($idZamowienia)) 
            {
                foreach ($zamowienie->getPozycje() as $pozycje)
                {
                    $stmt = self::$db->prepare("INSERT INTO pozycja_zamowienie(id_zamowienie, id_pozycja) "
                            . "VALUES(:id_zamowienie, :id_pozycja)");
                    $stmt->execute(array(
                        ':id_pozycja' => $pozycje->getIdPozycja(),
                        ':id_zamowienie' => $idZamowienia,
                    )); 
                }
                return TRUE;
            }
            
        }
        return FALSE;
    }
    
    //Pobierz liste zamowien
    public static function getZamowienieList()
    {
        $stmt = self::$db->query('SELECT * FROM zamowienie');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //Pobierz liste zamowien po IDuzytkownika
    public static function getZamowienieUserList($idUser)
    {
        $stmt = self::$db->prepare('SELECT * FROM zamowienie WHERE id_klienta=?');
        $stmt->execute(array($idUser));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    ///////////////////////////////////////////////////////////////
    //Szczegoly zamowienia///
    ////////////////////////////////////////////////////////////////
    
    //Pobierz szczegoly zamowienia po id zamowienia
    public static function getPozycjaZamowienia($idZamowienie)
    {
        $stmt = self::$db->prepare('SELECT * FROM pozycja_zamowienie WHERE id_zamowienie=?');
        $stmt->execute(array($idZamowienie));
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pozycje = array();
        foreach ($results as $row) 
        {
            $idPozycja = $row['id_pozycja'];
            $pozycja = self::getPozycjaById($idPozycja);
            $pozycjaZamowienia = new PozycjaZamowienia();
            $pozycjaZamowienia->setIdPozycja($idPozycja);
            $pozycjaZamowienia->setIdZamowienia($idZamowienie);
            $pozycjaZamowienia->setPozycja($pozycja);
            $pozycje[] = $pozycjaZamowienia;
        }
        return $pozycje;
    }
    
    //Usuwanie zamowienia
    public static function deleteZamowienie($zamowienie)
    {
        $stmt = self::$db->prepare('DELETE FROM zamowienie WHERE id_zamowienie=?');
        $stmt->execute(array($zamowienie->getIdZamowienia()));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) 
        {
            return TRUE;
        }
        return FALSE;
    }
    
    //Opłacenie zamówienia
    public static function payZamowienie($zamowienie)
    {
        $stmt = self::$db->prepare('UPDATE zamowienie SET status=? , data_zamowienia=now() WHERE id_zamowienie=?');
        $stmt->execute(array($zamowienie->getStatus(), $zamowienie->getIdZamowienia()));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1)
        {
            return TRUE;
        }
        return FALSE;
    }
    
    //Realizacja zamowienia
    public static function realizeZamowienie($zamowienie)
    {
        $stmt = self::$db->prepare('UPDATE zamowienie SET data_realizacji=now() , status=? WHERE id_zamowienie=?');
        $stmt->execute(array($zamowienie->getStatus(), $zamowienie->getIdZamowienia()));

        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1)
        {
            return TRUE;
        }
        return FALSE;
    }
    
    ///////////////////////////////////////////////////
    /////Zakupione/////
    ////////////////////////////////////////////////
    
    
    //Dodanie zakupione
    public static function addZakupione($userId, $pozycjaId){
        $stmt = self::$db->prepare('INSERT INTO zakupione VALUES (?, ?)');
        $stmt->execute(array($userId, $pozycjaId));
        
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1)
        {
            return TRUE;
        }
        return FALSE;
        
    }
    
    //Lista zakupionych wg id użytkownika
    public static function getZakupioneListByUser($user)
    {
        $stmt = self::$db->prepare('SELECT * FROM zakupione WHERE id_uzytkownik=?');
        $stmt->execute(array($user->getId()));
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $zakupione = array();
        foreach ($results as $row) 
        {
            $idPozycja = $row['id_pozycja'];
            $pozycja = self::getPozycjaById($idPozycja);
            $zakupiona = new Zakupione();
            $zakupiona->setIdPozycja($idPozycja);
            $zakupiona->setIdUzytkownik($user->getId());
            $zakupiona->setPozycja($pozycja);
            $zakupione[] = $zakupiona;
        }
        return $zakupione;
    }
   
    //ilość występujących zakupionych dla danego użytkownika
    public static function getZakupione($userId, $pozycjaId)
    {
        
        $stmt = self::$db->prepare('SELECT * FROM zakupione WHERE (id_uzytkownik=?) AND (id_pozycja=?)');
        $stmt->execute(array($userId, $pozycjaId));
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 0)
        {
            return TRUE;
        }
        return FALSE;
    }
}
