<?php

include_once("./Models/Cuenta.php");
include_once("./rwJson.php");
include_once("./ImageHandler.php");
include_once("./CrudJson.php");
include_once("./ICrudJson.php");

$statusCode = 400;
// $flag = false;
if(isset($_POST['nombre'], $_POST['apellido'], $_POST['tipoDocumento'], $_POST['numeroDocumento'], $_POST['email'], 
$_POST['tipoDeCuenta'], $_POST['moneda']))
{
    
    $cuenta = new Cuenta();
    if(isset($_POST['saldo']) && trim($_POST['saldo']) !== "")
    {
        $cuenta->saldo = $_POST['saldo'];
    }
    else
    {
        $cuenta->saldo = 0;
    }
    $cuenta->AsignarNumeroDeCuenta();
    $cuenta->nombre = $_POST['nombre'];
    $cuenta->apellido = $_POST['apellido'];
    $cuenta->tipoDocumento = $_POST['tipoDocumento'];
    $cuenta->numeroDocumento = $_POST['numeroDocumento'];
    $cuenta->email = $_POST['email'];
    $cuenta->tipoDeCuenta = $_POST['tipoDeCuenta'];
    $cuenta->moneda = $_POST['moneda'];

    
    
    $descripcionImagen = $cuenta->numeroDeCuenta . $cuenta->tipoDeCuenta;
    $imagen = $_FILES["imagen"];
    $imagen["name"] = $descripcionImagen . ".png";
    $destino = "./ImagenesDeCuentas/" . $imagen["name"];

    if(!Cuenta::VerificarCuenta($cuenta->numeroDocumento))
    {
        CrudJson::AddJson($cuenta, Cuenta::GetPath());
        ImageHandler::CargarImagen($imagen, $destino);
        $statusCode = 201;
    }
    

    
}

return $statusCode;

?>