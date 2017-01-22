<h1>Lista autorów</h1>
<br />
<div class="table-responsive">
 <table class="table table-bordered table-hover">
 <tr>
 <th>Imię i nazwisko</th><th>Edytuj</th><th>Usuń</th>
 </tr>
 <?php
 foreach ($results as $row) {
 echo '<tr>';
 echo '<td>' . $row['imie_nazwisko'] . '</td>';
 echo '<td><a href="autorzy/edit/' . $row['id_autor'] . '">Edytuj</a></td>';
 echo '<td><a href="autorzy/delete/' . $row['id_autor'] . '">Usuń</a></td>';
 echo '</tr>';
 }
 ?>
 </table>

</div>
<a href="autorzy/add"><button class="btn btn-default" type="submit">Dodaj</button></a>
