<?php
//primero el precio
$precio = 653.00;
$porcentaje = 0.05;
$descuento = $precio * $porcentaje;
$preciodescontado = $precio - $descuento;
$iva = 0.21;
$resultadoiva = $preciodescontado * $iva;
$resultado = $preciodescontado + $resultadoiva;
echo $resultado;

?>



