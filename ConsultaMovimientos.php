<?php
include_once("./rwJson.php");
// include_once("./Models/Deposito.php");
include_once("./Models/Movimientos.php");

if(isset($_GET['movimiento']))
{
    switch($_GET['movimiento'])
    {
        case "a":
            if(isset($_GET['fecha']))
            {
                Movimientos::TotalDepositos($_GET['fecha']);
            }
            else
            {
                Movimientos::TotalDepositos();
            }
        break;
        case "b":
            Movimientos::DepositosDeUnUsuario($_GET['email']);
        break;
        case "c":
            if(isset($_GET['fechaA'], $_GET['fechaB']))
            {
                Movimientos::ListarDepositosEntreFechas($_GET['fechaA'], $_GET['fechaB']);
            }
        break;
        case "d":
            if(isset($_GET['tipoDeCuenta']))
            {
                Movimientos::ListarPorTipoDeCuenta($_GET['tipoDeCuenta']);
            }
        break;
        case "e":
            if(isset($_GET['moneda']))
            {
                Movimientos::ListarPorMoneda($_GET['moneda']);
            }
        break;
    }
}



?>