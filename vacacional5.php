<?php
$url = "https://catalegdades.caib.cat/resource/rjfm-vxun.xml";
if (!$xml = file_get_contents($url)) {
  echo "No se ha podido descargar la URL";
}
 else {
    $xml = simplexml_load_file($url);
}

echo $xml;
