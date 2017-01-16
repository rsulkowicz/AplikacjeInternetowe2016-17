<?php

class PozycjaZamowienia
{
    //atrybuty klasy
    
    private $idZamowienia;
    private $idPozycja;
    private $ilosc;
    private $pozycja;
    private $zamowienie;
    
    
    //metody
    public function getIdZamowienia()
    {
        return $this->idZamowienia;
    }

    public function getIdPozycja()
    {
        return $this->idPozycja;
    }

    public function getIlosc()
    {
        return $this->ilosc;
    }


    public function getPozycja()
    {
        return $this->pozycja;
    }

    public function getZamowienie()
    {
        return $this->zamowienie;
    }

    public function setIdZamowienia($idZamowienia)
    {
        $this->idZamowienia = $idZamowienia;
    }

    public function setIdPozycja($idPozycja)
    {
        $this->idPozycja = $idPozycja;
    }

    public function setIlosc($ilosc)
    {
        $this->ilosc = $ilosc;
    }


    public function setPozycja($pozycja)
    {
        $this->pozycja = $pozycja;
    }

    public function setZamowienie($zamowienie)
    {
        $this->zamowienie = $zamowienie;
    }
}
