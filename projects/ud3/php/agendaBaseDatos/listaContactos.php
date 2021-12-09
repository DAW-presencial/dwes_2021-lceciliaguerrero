<section>
    <?php
    $cuanto = 0;
    $output = "";
    $tablaIni = "<table>";
    $tablaHead = "<thead><tr><th>Id</th><th>Nombre</th><th>Correo Electrónico</th><th>Numero de Teléfono</th></tr></thead>";
    $tablaBodyIni = "<tbody>";
    $medio = "";
    foreach ($lista as $row) {
        $medio .= "<tr>" . "<th>" . $row['id'] . "</th>" . "<th>" . $row['name'] . "</th>" . "<th>" . $row['email'] . "</th>" . "<th>" . $row['telephone_number'] . "</th>" . "</tr>";
        $cuanto++;
    }
    $tablaBodyFin = "</tbody>";
    $tablaFoot = "<tfoot><tr><th colspan='3'>Total</th><th>$cuanto</th></tr></tfoot>";
    $tablaFin = "</table>";
    $output .= $tablaIni . $tablaHead . $tablaBodyIni . $medio . $tablaBodyFin . $tablaFoot . $tablaFin;
    echo $output;
    ?>
</section>