<?php
?>
<h1>Lista pozycji zakupionych</h1>
<br />


<div class="table-responsive">
    <table id="zakupione" class="table table-bordered table-hover">

        <tr><th>Tytuł</th><th>Autor</th><th>Rok Wydania</th><th>Kategoria</th><th>Opis</th> 
            </tr>
            <?php
            foreach ($zakupione as $zakupiona) {
                echo '<tr>';
                echo '<td>' . $zakupiona->getPozycja()->getTytuł() . '</td>';
                echo '<td>' . $zakupiona->getPozycja()->getAutor()->getImieNazwisko() . '</td>';
                echo '<td>' . $zakupiona->getPozycja()->getRokWydania() . '</td>';
                echo '<td>' . $zakupiona->getPozycja()->getKategoria()->getNazwa() . '</td>';
                echo '<td>' . $zakupiona->getPozycja()->getOpis() . '</td>';
                echo '</tr>';
            }
            ?>
    </table>
</div>
<br />


