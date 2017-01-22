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

        <tr><th>Tytuł</th><th>Autor</th><th>Rok Wydania</th><th>Cena</th><th>Kategoria</th><th>Opis</th><th>Dodaj do koszyka</th> 
                <?php
                if ($isAdmin) {
                    ?>
                    <th>Edytuj</th><th>Usuń</th>
                    <?php
                }
                ?>
            </tr>
            <?php
            foreach ($pozycje as $zakupiona) {
                echo '<tr>';
                echo '<td>' . $zakupiona->getTytuł() . '</td>';
                echo '<td>' . $zakupiona->getAutor()->getImieNazwisko() . '</td>';
                echo '<td>' . $zakupiona->getRokWydania() . '</td>';
                echo '<td>' . $zakupiona->getCena() . '</td>';
                echo '<td>' . $zakupiona->getKategoria()->getNazwa() . '</td>';
                echo '<td>' . $zakupiona->getOpis() . '</td>';
                echo '<td><a href="koszyk/add/' . $zakupiona->getIdPozycja() . '">Dodaj do koszyka</a></td>';
                if ($isAdmin) {
                    echo '<td><a href="pozycja/edit/' . $zakupiona->getIdPozycja() . '">Edytuj</a></td>';
                    echo '<td><a href="pozycja/delete/' . $zakupiona->getIdPozycja() . '">Usuń</a></td>';
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
