<h1>Dodaj pozycje</h1>
<?php
if (!empty($error)) {
    ?>
    <div class="alert alert-danger" role="alert">
        <?= $error ?>
    </div>
    <?php
} else if (!empty($success)) {
    ?>
    <div class="alert alert-success" role="alert">
        <?= $success ?>
    </div>

    <?php
}
?>

<form method="POST" action="/<?= APP_ROOT ?>/pozycja/add">
    <div class="form-group">
        <label>Tytuł </label>
        <input type="text" name="tytuł"   class="form-control" />
    </div>
    <div class="form-group">
        <label>Autor </label>
        <select name="autor" class="form-control">
            <?php
            foreach ($autorzy as $autor) {
                echo '<option value="' . $autor['id_autor'] . '">' . $autor['imie_nazwisko'] . '</option>';
            }
            ?>
        </select>
        <br />               
    </div>
    <div class="form-group">
        <label>Rok wydania </label>
        <input type="text" name="rok_wydania" class="form-control" />
    </div>
    <div class="form-group">
        <label>Cena </label>
        <input type="text" name="cena" class="form-control"  /> 
    </div>
    <div class="form-group">
        <label>Kategoria</label>
        <select name="kategoria" class="form-control">
            <?php
            foreach ($kategorie as $kategoria) {
                echo '<option value="' . $kategoria['id_kategoria'] . '">' . $kategoria['nazwa'] . '</option>';
            }
            ?>
        </select>
        <br />
    </div>
    <div class="form-group">
        <label>Opis </label>
        <input type="text" name="opis"  class="form-control" /> 
    </div>




    <input type="submit" value="Dodaj" class="btn btn-default"/> <br />
</form>
