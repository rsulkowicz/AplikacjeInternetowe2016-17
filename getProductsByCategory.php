<?php
include '../application/database.class.php';
include '../model/Pozycja.class.php';
include '../model/Kategoria.class.php';
$db = Database::getInstance();
$idKategorii = $_GET['kategoria'];
if ($idKategorii == "Wszystkie") {
 $results = $db::getPozycjaList();
} else {
 $results = $db::getPozycjaListByCategory($idKategorii);
}
$response = "<tr><th>Nazwa</th><th>Cena</th><th>Kategoria</th><th>Opis</th><th>Dodaj do koszyka</th></tr>";
foreach ($results as $row) {
 $kategoria = $db::getKategoriaById($row['id_kategorii']);
 $response .= '<tr>';
 $response .= '<td>' . $row['nazwa'] . "</td>";
 $response .= '<td>' . $row['cena'] . "</td>";
 $response .= '<td>' . $kategoria->getNazwa() . "</td>";
 $response .= '<td>' . $row['opis'] . "</td>";
 $response .= "<td>" . '<a href="koszyk/add/' . $row['id_pozycja'] . '">Dodaj do koszyka</a></td>';
 $response .= "</tr>";
}
echo $response;