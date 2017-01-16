<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//klasa bazowa dla kontrolerów
include __SITE_PATH . '/application/' . 'controller_base.class.php';
//klasa rejestru
include __SITE_PATH . '/application/' . 'registry.class.php';
//klasa routera
include __SITE_PATH . '/application/' . 'router.class.php';
//klasa szablonu widoku 
include __SITE_PATH . '/application/' . 'template.class.php';
//klasa bazy danych
include __SITE_PATH . '/application/' . 'database.class.php';

//automatyczne ładowanie klas modelu
function __autoload($class_name) {
    $filename = $class_name . '.class.php';
    $file = __SITE_PATH . '/model/' . $filename;
    if (file_exists($file) == false) {
        return false;
    }
    include ($file);
}
//uwtorzenie obiektu rejestru
$registry = new registry;
//singleton
$registry->db = database::getInstance();
//inicjalizacja zmiennej globalnej user
if(!isset($_SESSION['user'])) $_SESSION['user']='';
?>
