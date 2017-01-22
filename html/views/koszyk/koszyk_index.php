<h1>Koszyk</h1>
<form method="POST" action="/<?= APP_ROOT ?>/koszyk/edit">
<div class="table-responsive">
 <table class="table table-bordered table-hover">
 <tr><th>Tytuł</th><th>Cena</th><th>Usuń</th> </tr>
 <?php
 for ($i = 0; $i < count($pozycje); $i++) {
 echo '<tr>';
 echo '<td>' . $pozycje[$i]->getTytuł() . '</td>';
 echo '<td>' . $pozycje[$i]->getCena() . '</td>';
 echo '<td><a href="koszyk/delete/' . $pozycje[$i]->getIdPozycja() . '">Usuń</a></td>';
 echo '</tr>';
 }
 ?>
 </table>
</div>
<button class="btn btn-default" >Zapisz zmiany</button> <br />
<a href="/<?= APP_ROOT ?>/produkt">Kontynuuj zakupy</a> <br />
<a href="zamowienie/add">Do kasy</a>
</form>
