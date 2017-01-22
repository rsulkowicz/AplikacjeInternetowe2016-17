<h1>Dodaj autora</h1>
<?php
if (!empty($error)) {
 ?>
 <div class="alert alert-danger" role="alert">
 <?= $error ?>
 </div>
 <?php }
else if (!empty($success)) { ?>
 <div class="alert alert-success" role="alert">
 <?= $success ?>
 </div>
 <?php } ?>
<form method="POST" action="/<?= APP_ROOT ?>/autorzy/add">
 <div class="form-group">
 <label>Imię i nazwisko </label>
 <input type="text" name="imie_nazwisko" class="form-control"/>
 </div>
 <button class="btn btn-default" type="submit">Dodaj</button>
</form>
