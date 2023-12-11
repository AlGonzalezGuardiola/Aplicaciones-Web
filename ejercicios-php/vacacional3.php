<!DOCTYPE html>
<html>
<body>

<?php
$url = "https://catalegdades.caib.cat/resource/rjfm-vxun.xml";
if (!$xml = file_get_contents($url)) {
    echo "No se ha podido descargar la URL";
} else {
    $xml = simplexml_load_string($xml);
}

$mis_datos = $xml->row;

// Filtros: municipios, códigos postales, filtro libre
$municipios = array();
$codigos_postales = array();
$nombre = isset($_GET["Nombre"]) ? $_GET["Nombre"] : "";

foreach ($xml->row as $dades) {
    if (isset($dades->municipi)) {
        $municipios[] = (string)$dades->municipi;
    }
    if (isset($dades->{'código-postal'})) {
        $codigos_postales[] = (string)$dades->{'código-postal'};
    }
}


// Filtrar municipio y código postal
$selectedMunicipio = isset($_GET["Municipi"]) ? $_GET["Municipi"] : "";
$selectedCodigoPostal = isset($_GET["Código_Postal"]) ? $_GET["Código_Postal"] : "";
?>

<form method="GET" action="">
    <label for="Nombre">Nombre:</label>
    <input type="text" name="Nombre" value="<?php echo $nombre; ?>">

    <label for="Municipi">Municipio:</label>
    <select name="Municipi">
        <option value="" <?php echo $selectedMunicipio === "" ? "selected" : ""; ?>>Todos los municipios</option>
        <?php
        foreach ($municipios as $municipio) {
            echo "<option value=\"$municipio\" " . ($selectedMunicipio === $municipio ? "selected" : "") . ">$municipio</option>";
        }
        ?>
    </select>

    <label for="Código_Postal">Código Postal:</label>
    <?php
    foreach ($codigos_postales as $codigo_postal) {
        echo "<input type=\"radio\" name=\"Código_Postal\" value=\"$codigo_postal\" " . ($selectedCodigoPostal === $codigo_postal ? "checked" : "") . ">$codigo_postal ";
    }
    ?>

    <input type="submit" value="Filtrar">
</form>

</body>
</html>
