<?php
include_once("./rwJson.php");
include_once("./Models/Cuenta.php");
$statusCode = 404;
if(isset($_POST['tipoDeCuenta'], $_POST['numeroDeCuenta']))
{
    $tipo = $_POST['tipoDeCuenta'];
    $numero = $_POST['numeroDeCuenta'];

    $lista = rwJson::ReadJson(Cuenta::GetPath());

    if($lista !== null)
    {
        foreach($lista as $item)
        {
            if($item->tipoDeCuenta == $tipo && $item->numeroDeCuenta == $numero)
            {
                echo "Tipo de moneda: {$item->moneda} <br> Saldo: {$item->saldo}";
                $statusCode = 200;
                break;
            }
            else if($item->tipoDeCuenta != $tipo && $item->numeroDeCuenta == $numero)
            {
                echo "Tipo de cuenta incorrecto";
                $statusCode = 400;
                break;
            }
        }
    }
    if($statusCode === 404)
    {
        echo "No existe la cuenta";
    }
}

return $statusCode;


?>