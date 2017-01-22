<h1>Lista kategorii</h1>
<br />
<div class="table-responsive">
 <table class="table table-bordered table-hover">
 <tr>
 <th>Nazwa</th><th>Edytuj</th><th>Usuń</th>
 </tr>
 <?php
 foreach ($results as $row) {
 echo '<tr>';
 echo '<td>' . $row['nazwa'] . '</td>';
 echo '<td><a href="kategoria/edit/' . $row['id_kategoria'] . '">Edytuj</a></td>';
 echo '<td><a href="kategoria/delete/' . $row['id_kategoria'] . '">Usuń</a></td>';
 echo '</tr>';
 }
 ?>
 </table>

</div>
<a href="kategoria/add"><button class="btn btn-default" type="submit">Dodaj</button></a>
