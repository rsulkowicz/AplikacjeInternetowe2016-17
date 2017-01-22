<h1>Edytuj autora</h1>
<?php
if (!empty($error)) { ?>
 <div class="alert alert-danger" role="alert">
 <?= $error ?>
 </div>
 <?php } else if (!empty($success)) { ?>
 <div class="alert alert-success" role="alert">
 <?= $success ?>
 </div>
 <?php }
$nazwa = "";
$id = "";
if (!empty($model)) {
 $nazwa = $model->getImieNazwisko();
 $id = $model->getIdAutor(); } ?>
<form method="POST" action="/<?= APP_ROOT ?>/autorzy/edit">
 <div class="form-group">
 <label>Imię i nazwisko </label>
 <input class="form-control" type="text" name="Imię i nazwisko" value="<?= $nazwa ?>" />
 </div>
 <input type="hidden" name="id" value="<?= $id ?>" />
 <button class="btn btn-default" type="submit">Zapisz</button><br />
</form>
