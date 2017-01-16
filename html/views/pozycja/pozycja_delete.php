<h1>Usuń pozycję</h1>
<?php

$nazwa = "";
$id = "";
if (!empty($model)) {
    $nazwa = $model->getNazwa();
    $id = $model->getIdPozycja();
}
?>
<h3>Czy na pewno chcesz usunąć pozycję: <b><?=$nazwa?></b>?</h3>
<form method="POST" action="/<?= APP_ROOT ?>/pozycja/delete">
    <input type="hidden" name="id" value="<?=$id?>"/>
    <button class="btn btn-default" type="submit" name="cancel" >Anuluj</button> <br />
    <button class="btn btn-default" type="submit" name="delete" />Usuń</button>  
</form>
