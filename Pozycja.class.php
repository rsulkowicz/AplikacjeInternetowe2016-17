<?php

class Pozycja
{
//atrybuty
    private $idPozycja;
    private $nazwa;
    private $idKategoria;
    private $cena;
    private $opis;
    private $kategoria;
    
    //metody
    public function getKategoria() 
    {
        return $this->kategoria;
    }
    
    public function setKategoria($kategoria)
    {
        $this->kategoria = $kategoria;
        
    }
    
    public function getIdPozycja()
    {
        return $this->idPozycja;
    }
    
    public function getNazwa()
    {
        return $this->nazwa;
    }
    
    public function getIdKategoria()
    {
        return $this->idKategoria;
    }
    
    public function getCena()
    {
        return $this->cena;
    }
    
    public function getOpis()
    {
        return $this->opis;
    }
    
    public function setIdPozycja($idPozycja)
    {
        $this->idPozycja = $idPozycja;
    }
    
    public function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;
    }
    
    public function setIdKategoria($idKategoria)
    {
        $this->idKategoria = $idKategoria;
    }
    
    public function setCena($cena)
    {
        $this->cena = $cena;
    }
    
    public function setOpis($opis)
    {
        $this->opis = $opis;
    }
    
}
?>