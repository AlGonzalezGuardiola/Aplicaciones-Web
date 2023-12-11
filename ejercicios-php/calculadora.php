<?php
$numero1 = $_GET['n1'];
$numero2 = $_GET['n2'];
$operacion = $_GET['op'];

$result = null;

if (!is_numeric($numero1) || !is_numeric($numero2)) {
    $result  =  "Error: Uno o ambos valores no son numéricos.";
} 
else {

switch ($operacion) {
    case 'suma':
        $result = $numero1 + $numero2;
        break;
    case 'resta':
        $result = $numero1 - $numero2;
        break;
    case 'multiplicacion':
        $result = $numero1 * $numero2;
        break;
    case 'division':
        $result = $numero1 / $numero2;
        break;

}
$result = "Resultado: $result";
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Calculadora</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        table {
            border: 1px solid #ccc;
            border-collapse: collapse;
        }
        table td {
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td></td>
            <td><?php echo $result; ?></td>
        </tr>
    </table>
</body>
</html>
