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
                        Nazwa
                    </td>
                    <td>
                        Cena
                    </td>
                    <td>
                        Kategoria
                    </td>
                </tr>
                <?php
                for ($i = 0; $i < count($produkty); $i++) {
                    echo '<tr>';
                    echo '<td>' . $ilosci[$i] . '</td>';
                    echo '<td>' . $produkty[$i]->getNazwa() . '</td>';
                    echo '<td>' . $produkty[$i]->getCena() . '</td>';
                    echo '<td>' . $produkty[$i]->getKategoria()->getNazwa() . '</td>';
                    echo '</tr>';
                }
                ?>
            </table>
        </div>
    </div>
    <!-- -->

    <button type="submit" class="btn btn-default">Zapłać</button>

</form>