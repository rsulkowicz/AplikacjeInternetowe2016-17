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
            self::$db=new PDO('mysql:host=localhost;dbname=ksiegarnia;charset=utf8','ksiegarnia','qwerty');
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
        $stmt = self::$db->prepare("SELECT r.name FROM uzytkownik u 	
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
            $kategoria->setIdKategorii($result['id_kategoria']);
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
        $stmt->execute(array($kategoria->getIdKategorii()));
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
        $stmt->execute(array($kategoria->getNazwa(), $kategoria->getIdKategorii()));
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
            $produkt = new Pozycja();
            $produkt->setIdPozycja($result['id_pozycja']);
            $produkt->setNazwa($result['nazwa']);
            $produkt->setIdKategorii($result['id_kategoria']);
            $produkt->setKategoria(self::getKategoriaById($result['id_kategoria']));
            $produkt->setCena($result['cena']);
            $produkt->setOpis($result['opis']);
            return $produkt;
        }
    }
    
    //Dodanie pozycji
    public static function addPozycja($pozycja)
    {
        $stmt = self::$db->prepare("INSERT INTO pozycja(nazwa,cena,id_kategoria,opis) "
                . "VALUES(:nazwa , :cena, :id_kategoria, :opis)");
        $stmt->execute(array(
            ':nazwa' => $pozycja->getNazwa(),
            ':id_kategorii' => $pozycja->getIdKategorii(),
            ':cena' => $pozycja->getCena(),
            ':opis' => $pozycja->getOpis()
        ));

        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1)
        {
            return TRUE;
        }
        return FALSE;
    }
    
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
            $stmt = self::$db->prepare('UPDATE pozycja set nazwa=:nazwa, cena=:cena, '
                    . 'id_kategoria=:id_kategoria,'
                    . 'opis=:opis WHERE id_produkt=:id');
            $stmt->execute(array(
                ':id' => $pozycja->getIdPozycja(),
                ':nazwa' => $pozycja->getNazwa(),
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
            $zamowienie->setIdZamowienie($result['id_zamowienie']);
            $pozycjaZamowienie = self::getPozycjaZamowienie($id);
            $zamowienie->setPozycja($pozycjaZamowienie);
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
            $zamowienie->setUwagi($result['uwagi_dodatkowe']);
            return $zamowienie;
        }
    }
    
    //Dodaj zamowienie
    public static function addZamowienie($zamowienie) 
    {
        $stmt = self::$db->prepare("INSERT INTO zamowienie(id_klienta,uwagi_dodatkowe,status,data_zamowienia) "
                . "VALUES(:id_klienta, :uwagi_dodatkowe, :status, now())");
        $stmt->execute(array(
            ':id_klienta' => $zamowienie->getIdKlienta(),
            ':uwagi_dodatkowe' => $zamowienie->getUwagi(),
            ':status' => $zamowienie->getStatus()
        ));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) 
        {
            $idZamowienia = self::$db->lastInsertId();
            if (!empty($idZamowienia)) 
            {
                foreach ($zamowienie->getPozycja() as $pozycja)
                {
                    $stmt = self::$db->prepare("INSERT INTO produkt_zamowienie(id_zamowienia, id_produktu) "
                            . "VALUES(:id_zamowienie, :id_produktu)");
                    $stmt->execute(array(
                        ':id_produktu' => $pozycja->getIDPozycja(),
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
    public static function getProduktyZamowienia($idZamowienie)
    {
        $stmt = self::$db->prepare('SELECT * FROM pozycja_zamowienie WHERE id_zamowienie=?');
        $stmt->execute(array($idZamowienie));
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pozycje = array();
        foreach ($results as $row) 
        {
            $idPozycja = $row['id_produktu'];
            $pozycja = self::getProduktById($idPozycja);
            $pozycjaZamowienia = new ProduktZamowienia();
            $pozycjaZamowienia->setIdPozycja($idPozycja);
            $pozycjaZamowienia->setIdZamowienia($idZamowienie);
            $pozycjaZamowienia->setIlosc($row['ilosc']);
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
}
