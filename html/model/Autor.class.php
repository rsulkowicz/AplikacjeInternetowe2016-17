<?php

class Autor {
    //atrybuty klasy
    private $idAutor;
    private $imieNazwisko;
    
    //metody
    public function getIdAutor()
    {
        return $this->idAutor;
    }
    
    public function setIdAutor($idAutor)
    {
        $this->idAutor = $idAutor;
    }
    
    public function getImieNazwisko()
    {
        return $this->imieNazwisko;
    }
    
    public function setImieNazwisko($imieNazwisko)
    {
        $this->imieNazwisko = $imieNazwisko;
    }
}
?>