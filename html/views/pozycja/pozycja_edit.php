<h1>Edytuj pozycję</h1>
<?php
$nazwa = "";
$autorzy = array();
$rok_wydania = "";
$cena = "";
$opis = "";
$kategorie = array();
$id = "";

if (!empty($model)) {
    $id = $model->getIdPozycja();
    $nazwa = $model->getTytuł();
    $autorPozycji = $model->getAutor();
    $cena = $model->getCena();
    $opis = $model->getOpis();
    $kategoriaPozycji = $model->getKategoria();
}
?>

<form method="POST" action="/<?= APP_ROOT ?>/pozycja/edit">
    <div class="form-group">
        <label>Tytuł </label>
        <input class="form-control" type="text" name="tytuł" value="<?= $nazwa ?>" /> 
        <input type="hidden" name="id" value="<?= $id ?>" />
    </div>
    <div class="form-group">
        <label>Autor </label>
        <select name="autor" class="form-control">
            <?php
            foreach ($autorzyAll as $autor) {
                if ($autor['imie_nazwisko'] == $autorPozycji->getIdAutor()) {
                    echo '<option value="' . $autor['id_autor'] . '" selected>' . $autor['imie_nazwisko'] . '</option>';
                } else {
                    echo '<option value="' . $autor['id_autor'] . '" >' . $autor['imie_nazwisko'] . '</option>';
                }
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Rok wydania </label>
        <input class="form-control" type="text" name="rok_wydania" value="<?= $rok_wydania ?>"/>
    </div>
    <div class="form-group">
        <label>Cena </label>
        <input class="form-control" type="text" name="cena"  value="<?= $cena ?>"/> 
    </div>
    <div class="form-group">
        <label>Kategoria</label>
        <select name="kategoria" class="form-control">
            <?php
            foreach ($kategorieAll as $kategoria) {
                if ($kategoria['id_kategoria'] == $kategoriaPozycji->getIdKategoria()) {
                    echo '<option value="' . $kategoria['id_kategoria'] . '" selected>' . $kategoria['nazwa'] . '</option>';
                } else {
                    echo '<option value="' . $kategoria['id_kategoria'] . '" >' . $kategoria['nazwa'] . '</option>';
                }
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Opis </label>
        <input class="form-control" type="text" name="opis" value="<?= $opis ?>"/> 
    </div>

    <button type="submit"  class="btn btn-default" >Zapisz</button> 
</form>
