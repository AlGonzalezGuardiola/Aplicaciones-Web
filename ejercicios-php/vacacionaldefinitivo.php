<?php
$url = "https://catalegdades.caib.cat/resource/rjfm-vxun.xml";
if (!$xml = simplexml_load_file($url)) {
    echo "No se ha podido cargar el XML";
} else {
    $municipis = array();
    $codigosPostales = array();

    foreach ($xml->rows->row as $row) {
        if (isset($row->municipi)) {
            $municipio = (string)$row->municipi;
            $municipis[$municipio] = true;

            // Obtener el código postal de la dirección
            $direccion = (string)$row->adre_a_de_l_establiment;
            preg_match('/\b\d{5}\b/', $direccion, $matches);
            if (!empty($matches)) {
                $codigoPostal = $matches[0];
                $codigosPostales[$codigoPostal] = true;
            }
        }
    }

    // Ordenar los arrays asociativos por las claves en orden alfabético
    ksort($municipis);
    ksort($codigosPostales);
}

// Procesar la selección del municipio, código postal y término de búsqueda
$municipioSeleccionado = isset($_GET['municipi']) ? $_GET['municipi'] : null;
$codigoPostalSeleccionado = isset($_GET['codigo_postal']) ? $_GET['codigo_postal'] : null;
$terminoBusqueda = isset($_GET['termino_busqueda']) ? $_GET['termino_busqueda'] : null;

?>

<form method="GET" action="" style="position: relative;">

    <input type="button" value="Refrescar" onclick="window.location.href=window.location.pathname">
    <input type="submit" value="Filtrar">

    <label for="municipi">Municipio:</label>
    <select name="municipi">
        <option value="" <?php echo empty($municipioSeleccionado) ? "selected" : ""; ?>>Todos los municipios</option>

        <?php
        foreach ($municipis as $municipio => $_) {
            echo "<option value=\"$municipio\"";
            if ($municipioSeleccionado === $municipio) {
                echo " selected";
            }
            echo ">$municipio</option>";
        }
        ?>
    </select>
    <div style>
        <label for="termino_busqueda">Buscar por nombre:</label>
        <input type="text" name="termino_busqueda" value="<?php echo $terminoBusqueda; ?>">
    </div>

    <br>

    <fieldset>
        <legend>Códigos Postales:</legend>
        <?php
        foreach ($codigosPostales as $codigoPostal => $_) {
            echo "<label>";
            echo "<input type=\"radio\" name=\"codigo_postal\" value=\"$codigoPostal\"";
            if ($codigoPostalSeleccionado === $codigoPostal) {
                echo " checked";
            }
            echo ">$codigoPostal";
            echo "</label><br>";
        }
        ?>
    </fieldset>
</form>

<?php
// Mostrar información para el municipio, código postal y término de búsqueda seleccionados
if ($municipioSeleccionado || $codigoPostalSeleccionado || $terminoBusqueda) {
    echo "<h2>Información para ";
    if ($municipioSeleccionado) {
        echo "$municipioSeleccionado";
    }
    if ($codigoPostalSeleccionado) {
        echo " - Código Postal: $codigoPostalSeleccionado";
    }
    if ($terminoBusqueda) {
        echo " - Término de búsqueda: $terminoBusqueda";
    }
    echo "</h2>";

    foreach ($xml->rows->row as $row) {
        $municipio = (string)$row->municipi;
        $direccion = (string)$row->adre_a_de_l_establiment;
        preg_match('/\b\d{5}\b/', $direccion, $matches);
        $codigoPostal = !empty($matches) ? $matches[0] : null;
        $nombre = (string)$row->denominaci_comercial;

        // Verificar si el municipio, el código postal y el término de búsqueda coinciden con los seleccionados
        if (
            (!$municipioSeleccionado || $municipio === $municipioSeleccionado) &&
            (!$codigoPostalSeleccionado || $codigoPostal === $codigoPostalSeleccionado) &&
            (!$terminoBusqueda || stripos($nombre, $terminoBusqueda) !== false)
        ) {
            echo "<p>Signatura: ", (string)$row->signatura, "</p>";
            echo "<p>Denominación Comercial: ", $nombre, "</p>";
            echo "<p>Dirección: ", $direccion, "</p>";
            echo "<p>Número de Vehículos: ", (string)$row->nombre_de_vehicles, "</p>";
            echo "<p>Explotador: ", (string)$row->nom_explotador_s, "</p>";
            echo "<p>NIF/CIF del Explotador: ", (string)$row->nif_cif_explotador_s, "</p>";
            echo "<hr>";
        }
    }
}
?>
