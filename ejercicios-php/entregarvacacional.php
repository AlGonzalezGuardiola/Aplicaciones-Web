<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtrar Información</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body {
	    font-family: "Comic Sans MS", "Comic Sans", cursive;
            margin: 40px;
        }
        form {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
        }
	label{
		font-size:14 px;
		margin-bottom: 5px;
		display: inline-bottom;
	}
        input, select {
            margin-bottom: 10px;
        }
        fieldset {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
        h2 {
            color: #333;
        }
        p {
            margin-bottom: 5px;
        }
        hr {
            border: 0;
            border-top: 1px solid #ccc;
            margin: 10px 0;
        }
    </style>
</head>
<body>

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

    // Ordenar las arrays por orden alfabético con ksort
    ksort($municipis);
    ksort($codigosPostales);
}

// Filtros de búsqueda con GET
$municipioSeleccionado = isset($_GET['municipi']) ? $_GET['municipi'] : null;
$codigoPostalSeleccionado = isset($_GET['codigo_postal']) ? $_GET['codigo_postal'] : null;
$terminoBusqueda = isset($_GET['termino_busqueda']) ? $_GET['termino_busqueda'] : null;
?>

<form method="GET" action="" style="position: relative;">
    <input type="button" class="btn btn-primary" value="Refrescar" onclick="window.location.href=window.location.pathname">
    <input type="submit" class= "btn btn-dark" value="Filtrar">

    <label for="municipi">Municipio:</label>
    <select name="municipi">
        <option class="btn btn-light" value="" <?php echo empty($municipioSeleccionado) ? "selected" : ""; ?>>Todos los municipios</option>

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
    
    <div>
        <label for="termino_busqueda">Buscar por nombre:</label>
        <input type="text" class="btn btn-outline-dark" name="termino_busqueda" value="<?php echo $terminoBusqueda; ?>">
    </div>

    <br>


<fieldset>
    <legend>Códigos Postales:</legend>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <?php
                foreach ($codigosPostales as $codigoPostal => $_) {
                    echo "<td class='radio-label'><label><input type=\"radio\" name=\"codigo_postal\" value=\"$codigoPostal\"";
                    if ($codigoPostalSeleccionado === $codigoPostal) {
                        echo " checked";
                    }
                    echo ">$codigoPostal</label></td>";
                }
                ?>
            </tr>
        </table>
    </div>
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

</body>
</html>
