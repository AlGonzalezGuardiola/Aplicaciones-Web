<?php
$url = "https://catalegdades.caib.cat/resource/rjfm-vxun.xml";
if (!$xml = simplexml_load_file($url)) {
    echo "No se ha podido cargar el XML";
} else {
    $municipis = array();

    foreach ($xml->rows->row as $row) {
        if (isset($row->municipi)) {
            $municipio = (string)$row->municipi;
            $municipis[$municipio] = true;
        }
    }
}
?>

<form method="GET" action="">
    <label for="municipi">Municipio:</label>
    <select name="municipi">
        <option value="" <?php echo empty($_GET['municipi']) ? "selected" : ""; ?>>Todos los municipios</option>

        <?php
        foreach ($municipis as $municipio => $_) {
            echo "<option value=\"$municipio\"";
            if (isset($_GET['municipi']) && $_GET['municipi'] === $municipio) {
                echo " selected";
            }
            echo ">$municipio</option>";
        }
        ?>
    </select>
    <input type="submit" value="Filtrar">
</form>
