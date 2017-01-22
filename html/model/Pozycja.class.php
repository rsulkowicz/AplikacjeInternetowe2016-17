<?php

class Pozycja
{
//atrybuty
    private $idPozycja;
    private $tytuł;
    private $rokWydania;
    private $idAutor;
    private $autor;
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
    
    public function getRokWydania()
    {
        return $this->rokWydania;
    }
    
    public function setRokWydania($rokWydania)
    {
        $this->rokWydania = $rokWydania;
    }
    
    public function getIdAutor()
    {
        return $this->idAutor;
    }
    
    public function setIdAutor($idAutor)
    {
        $this->idAutor = $idAutor;
    }
    
    public function getAutor()
    {
        return $this->autor;
    }
    
    public function setAutor($autor)
    {
        $this->autor = $autor;
    }
    
    public function getIdPozycja()
    {
        return $this->idPozycja;
    }
    
    public function getTytuł()
    {
        return $this->tytuł;
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
    
    public function setTytuł($tytuł)
    {
        $this->tytuł = $tytuł;
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
