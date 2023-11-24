<!DOCTYPE html>
<html>
<body>

<?php
$url = "https://catalegdades.caib.cat/resource/rjfm-vxun.xml";
if (!$xml = file_get_contents($url)) {
  echo "No se ha podido descargar la URL";
}
 else {
    $xml = simplexml_load_file($url);
}

$municipis = array();
//$codigos_postales = array();

$dades = $xml->rows;
$i = 0;

foreach ($xml->rows->row as $dades) {
	if (isset($dades->municipi)) {
        $municipis[$i] = $dades->municipi;
	$i++;
    }
//    if (isset($dades->{'código-postal'})) {
//        $codigos_postales[] = (string)$dades->{'código-postal'};
    }

//}

//$selectedCodigoPostal = isset($_GET["Código_Postal"]) ? $_GET["Código_Postal"] : "";


?>
<form method="GET" action="">

	<label for="municipi">Municipio:</label>
	<select name="municipi">
		<option value="" <?php echo $municipis === "" ? "selected" : ""; ?>>Todos los municipios</option>
			 <option value= <?php $municipis[$i];
				for ($i = 0; $i < count($municipis); $i++){
}
?>>
	</select>
</form>

</body>
</html>
