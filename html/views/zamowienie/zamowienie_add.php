<h1>Dodaj zamówienie</h1>
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

<form method="POST" action="/<?= APP_ROOT ?>/zamowienie/add">
    <div class="form-group">
        <label>Pozycje</label>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <tr> 
                    <td>
                        Tytuł
                    </td>
                    <td>
                        Cena
                    </td>
                    <td>
                        Kategoria
                    </td>
                </tr>
                <?php
                for ($i = 0; $i < count($pozycje); $i++) {
                    echo '<tr>';
                    echo '<td>' . $pozycje[$i]->getTytuł() . '</td>';
                    echo '<td>' . $pozycje[$i]->getCena() . '</td>';
                    echo '<td>' . $pozycje[$i]->getKategoria()->getNazwa() . '</td>';
                    echo '</tr>';
                }
                ?>
            </table>
        </div>
    </div>
    <!-- -->

    <button type="submit" class="btn btn-default">Zapłać</button>

</form>
