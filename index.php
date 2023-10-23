<?php
include_once("./Models/ModificarCuenta.php");

$statusCode = 400;
if($_SERVER['REQUEST_METHOD'] == 'GET')
{
    include_once("./ConsultaMovimientos.php");
}
else if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    switch($_GET['action'])
    {
        case "alta":
            $statusCode = include_once("./CuentaAlta.php");
            echo json_encode(["status code" => $statusCode]);
        break;
        case "consultar":
            $statusCode = include_once("./ConsultarCuenta.php");
            echo json_encode(["status code" => $statusCode]);
        break;
        case "deposito":
            $statusCode = include_once("./DepositoCuenta.php");
            echo json_encode(["status code" => $statusCode]);
        break;
        case "retiro":
            $statusCode = include_once("./RetiroCuenta.php");
            echo json_encode(["status code" => $statusCode]);
        break;
        case "ajuste":
            $statusCode = include_once("./AjusteCuenta.php");
            echo json_encode(["status code" => $statusCode]);
        break;
    }
}
else if($_SERVER['REQUEST_METHOD'] === 'PUT')
{
    parse_str(file_get_contents("php://input"), $putData);


    if(isset($putData['numeroDeCuenta'], $putData['nombre'], $putData['apellido'], $putData['tipoDocumento'], $putData['numeroDocumento'], $putData['email'], 
    $putData['tipoDeCuenta'], $putData['moneda']))
    {
        $statusCode = ModificarCuenta::UpdateCuenta($putData);
    }
    echo json_encode(["status code" => $statusCode]);
}   
?>