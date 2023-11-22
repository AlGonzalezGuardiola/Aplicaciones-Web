<!DOCTYPE html>
<html>
    <body>
<?php
$url = "https://catalegdades.caib.cat/resource/rjfm-vxun.xml";
if (!$xml = file_get_contents($url)) {
        echo "No se ha podido descargar la url";
}
else {
        $xml = simplexml_load_string($xml);
}
$mis_datos = $xml->row;

//filtros: municipios, codigos postales, filtro libre
//$codigos_postales = array()

$municipi = array();

$municipi = isset($_GET["Municipi"]) ? $_GET["Municipi"] : "";
$codigo_postal = isset($GET["Código Postal"]) ? $_GET["Código Postal"] : "";
$nombre = isset($_GET["Nombre"]) ? $_GET["Nombre"] : "";
$i = 0;

foreach ($xml->row as $dades){
if (isset($dades->municipi)){
$municipi[] = $dades->municipi;
$i++;
}
}

?>
