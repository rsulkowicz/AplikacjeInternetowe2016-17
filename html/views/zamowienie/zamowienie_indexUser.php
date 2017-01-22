<h1>Lista zamówień</h1>
<br />

<div class="table-responsive">
<table class="table table-bordered table-hover">
    <tr>
        <th>
            Pozycje
        </th>
        <th>
            Cena
        </th>
        <th>
            Data zamówienia
        </th>
        <th>
            Data realizacji
        </th>
         <th>
            Status
        </th>

    </tr>
    <?php
    foreach ($zamowienia as $zamowienie) {
        echo '<tr>';
        echo '<td><div class="table-responsive"><table class="table table-bordered">'
        . '<tr><th>Tytuł</th><th>Cena</th></tr>';
        foreach ($zamowienie->getPozycje() as $pozycjaZamowienie) {
            echo '<tr>';
            echo '<td>' . $pozycjaZamowienie->getPozycja()->getTytuł() . '</td>';
            echo '<td>' . $pozycjaZamowienie->getPozycja()->getCena() . '</td>';
            echo '</tr>';
        }
        echo '</table></div></td>';
        echo '<td>' . $zamowienie->getCena() . '</td>';
        echo '<td>' . $zamowienie->getDataZamowienia() . '</td>';
        echo '<td>' . $zamowienie->getDataRealizacji() . '</td>';
         echo '<td>' . $zamowienie->getStatus() . '</td>';
        echo '</tr>';
    }
    ?>
</table>
</div>

