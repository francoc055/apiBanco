<?php
include_once("./Models/Cuenta.php");
include_once("./rwJson.php");


class ModificarCuenta{

    public static function UpdateCuenta($putData)
    {
        $statusCode = 404;
        $listaCuentas = rwJson::ReadJson(Cuenta::GetPath());
        if($listaCuentas !== null)
        {
            foreach($listaCuentas as $cuenta)
            {
                if($cuenta->tipoDeCuenta === $putData['tipoDeCuenta'] && $cuenta->numeroDeCuenta == $putData['numeroDeCuenta'])
                {
                    $cuenta->nombre = $putData['nombre'];
                    $cuenta->apellido = $putData['apellido'];
                    $cuenta->tipoDocumento = $putData['tipoDocumento'];
                    $cuenta->numeroDocumento = $putData['numeroDocumento'];
                    $cuenta->email = $putData['email'];
                    $cuenta->tipoDeCuenta = $putData['tipoDeCuenta'];
        
                    if(rwJson::SaveJson($listaCuentas, Cuenta::GetPath()))
                    {
                        echo "Cuenta modificada correctamente";
                        $statusCode = 204;
                        break;
                    }
                }
                
            }            
        }
        
        return $statusCode;
    }
}


?>