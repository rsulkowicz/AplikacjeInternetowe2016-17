<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of registry
 *
 * @author RSulkowicz
 */
class registry {
        //tablica przechowująca zmienne
    private $vars = array();
    //wstawienie zmiennej do rejestru
    public function __set($index, $value) {
        $this->vars[$index] = $value;
    }
    //pobranie warości zmiennej
    public function __get($index) {
        return $this->vars[$index];
    }
}
