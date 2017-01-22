<?php


class Zakupione {
   // atrybuty klasy
    private $idUzytkownik;
    private $idPozycja;
    private $uzytkownik;
    private $pozycja;
    
    //metody
    
    public function getIdUzytkownik()
    {
        return $this->idUzytkownik;
    }
    
    public function setIdUzytkownik($idUzytkownik)
    {
        $this->idUzytkownik = $idUzytkownik;
    }
    
    public function getIdPozycja()
    {
        return $this->idPozycja;
    }
    
    public function setIdPozycja($idPozycja)
    {
        $this->idPozycja = $idPozycja;
    }
    
    public function getUzytkownik()
    {
        return $this->uzytkownik;
    }
    
    public function setUzytkownik($uzytkownik)
    {
        $this->uzytkownik = $uzytkownik;
    }
    
    public function getPozycja()
    {
        return $this->pozycja;
    }
    
    public function setPozycja($pozycja)
    {
        $this->pozycja = $pozycja;
    }
}
