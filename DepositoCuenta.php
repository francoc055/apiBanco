<?php
include_once("./Models/Transacciones.php");




$statusCode = 400;
if(isset($_POST['tipoDeCuenta'], $_POST['numeroDeCuenta'], $_POST['moneda'], $_POST['importe']))
{
    $transaccion = new Transacciones();
    return $transaccion->Deposito($_POST['tipoDeCuenta'], $_POST['numeroDeCuenta'], $_POST['moneda'], $_POST['importe']);
}


?>