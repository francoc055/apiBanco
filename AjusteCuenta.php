<?php
include_once('./Models/Ajuste.php');
if(isset($_POST['numeroDeCuenta'], $_POST['motivo'], $_POST['tipoAjuste']))
{
    $ajuste = new Ajuste();
    $ajuste->numeroDeCuenta = $_POST['numeroDeCuenta'];
    $ajuste->motivo = $_POST['motivo'];
    $ajuste->tipoAjuste = $_POST['tipoAjuste'];

    if($_POST['tipoAjuste'] === "deposito")
    {
        return $ajuste->AjusteDeposito();
        
    }
    else if($_POST['tipoAjuste'] === "retiro")
    {
        return $ajuste->AjusteRetiro();
    }


}
?>