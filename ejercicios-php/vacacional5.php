<?php
$url = "https://catalegdades.caib.cat/resource/rjfm-vxun.xml";
if (!$xml = file_get_contents($url)) {
  echo "No se ha podido descargar la URL";
}
 else {
    $xml = simplexml_load_file($url);
}

echo $xml;


$municipis = array();

$dades = $xml->rows;
$i = 0;

foreach ($xml->rows->row as $dades) {
	if (isset($dades->municipi)) {
        $municipis[$i] = $dades->municipi;
	$i++;
    }
  }
  ?>


<form method="GET" action="">

	<label for="municipi">Municipio:</label>
	<select name="municipi">
		<option value="" <?php echo $municipis === "" ? "selected" : ""; ?>>Todos los municipios</option>
			 <option value= <?php $municipis[$i];
				for ($i = 0; $i < count($municipis); $i++){
}
?>>