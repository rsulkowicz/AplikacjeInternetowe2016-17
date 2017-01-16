<?php
?>
<h1>Lista pozycji</h1>
<br />

<?php
  global $isAdmin;
if (!$isAdmin) {
    ?>
    <!-- WYBÓR KATEGORII -->
    <div class="form-group">
        <label>Wybierz kategorię</label>
        <select id="kategoria" name="kategoria" class="form-control">
            <option value="Wszystkie">Wszystkie</option>
            <?php
            foreach ($kategorie as $kategoria) {
                echo '<option value="' . $kategoria->getIdKategoria() . '">' . $kategoria->getNazwa() . '</option>';
            }
            ?>
        </select>
        <br />
    </div>
    <?php
}
?>


<div class="table-responsive">
    <table id="pozycje" class="table table-bordered table-hover">

            <tr><th>Nazwa</th><th>Cena</th><th>Kategoria</th><th>Opis</th><th>Dodaj do koszyka</th> 
                <?php
                if ($isAdmin) {
                    ?>
                    <th>Edytuj</th><th>Usuń</th>
                    <?php
                }
                ?>
            </tr>
            <?php
            foreach ($pozycje as $pozycja) {
                echo '<tr>';
                echo '<td>' . $pozycja->getNazwa() . '</td>';
                echo '<td>' . $pozycja->getCena() . '</td>';
                echo '<td>' . $pozycja->getKategoria()->getNazwa() . '</td>';
                echo '<td>' . $pozycja->getOpis() . '</td>';
                echo '<td><a href="koszyk/add/' . $pozycja->getIdPozycja() . '">Dodaj do koszyka</a></td>';
                if ($isAdmin) {
                    echo '<td><a href="produkt/edit/' . $pozycja->getIdPozycja() . '">Edytuj</a></td>';
                    echo '<td><a href="produkt/delete/' . $pozycja->getIdPozycja() . '">Usuń</a></td>';
                }
                echo '</tr>';
            }
            ?>
    </table>
</div>
<br />
<?php
if ($isAdmin) {
    ?>
    <a href="pozycja/add">Dodaj</a>
    <?php
}
?>

  
 <!--SKRYPT JQUERY - ŻĄDANIE AJAX -->
<script>
    $("#kategoria").change(function () {
        var kat = $("#kategoria option:selected").val();
        $.ajax({
            url: 'html/async/getProductsByCategory.php',
            type: 'GET',
            data: {kategoria: kat},
            dataType : "html",
            contentType: 'application/html; charset=utf-8',
            success: function (response) {
                
                $("#pozycje").html(response);
            },
            error: function () {
                alert("error");
            }
        });
    })
</script>
