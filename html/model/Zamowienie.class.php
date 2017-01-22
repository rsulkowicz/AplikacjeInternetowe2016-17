<?php

class Zamowienie
{
    //
    private $idZamowienia;
    private $idKlient;
    private $cena;
    private $dataZamowienia;
    private $dataRealizacji;
    private $status;  //nowe, zaplacone, zrealizowane     
    private $pozycje;
    
    //metody
    public function getCena()
    {
        return $this->cena;
    }
 
    public function setCena($cena)
    {
        $this->cena = $cena;
    }
                
    public function getIdZamowienia()
    {
        return $this->idZamowienia;
    }
        
    public function getIdKlienta()
    {
        return $this->idKlient;
    }
               
    public function getDataZamowienia()
    {
        return $this->dataZamowienia;
    }
        
    public function getDataRealizacji()
    {            
        return $this->dataRealizacji;
    }
        
    public function getStatus()
    {            
        return $this->status;
    }
        
    public function getPozycje()
    {
        return $this->pozycje;
    }
        
    public function setIdZamowienia($idZamowienia)
    {
        $this->idZamowienia = $idZamowienia;
    }
        
    public function setIdKlienta($idKlienta)
    {
        $this->idKlient = $idKlienta;
    }
    
    public function setDataZamowienia($dataZamowienia)
    {
        $this->dataZamowienia = $dataZamowienia;
    }
       
    public function setDataRealizacji($dataRealizacji)
    {
        $this->dataRealizacji = $dataRealizacji;
    }
        
    public function setStatus($status)
    {
        $this->status = $status;
    }
        
    public function setPozycje($pozycje)
    {
        $this->pozycje = $pozycje;
    }
}
?>
