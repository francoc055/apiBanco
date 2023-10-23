<?php
include_once("./rwJson.php");

class Cuenta{
    public $numeroDeCuenta; //emulado - 6 digitos
    public $nombre;
    public $apellido;
    public $tipoDocumento;
    public $numeroDocumento;
    public $email;
    public $tipoDeCuenta; //CA o CC
    public $moneda; //$ o U$S
    public $saldo; //0 por defecto

    
    public static function GetPath()
    {
        return "C:/xampp/htdocs/PrimerParcial/banco.json";
    }


    public static function VerificarCuenta($dni)
    {
        $lista = rwJson::ReadJson(self::GetPath());

        if($lista !== null)
        {
            foreach($lista as $item)
            {
                if(($dni === $item->numeroDocumento))
                {
                    echo "Ya existe la cuenta";
                    return true;
                }
            } 
        }

        return false;
    }

    public static function VerificarNumeroDeCuenta($numeroDeCuenta)
    {
        $lista = rwJson::ReadJson(self::GetPath());

        if($lista !== null)
        {
            foreach($lista as $item)
            {
                if(($numeroDeCuenta === $item->numeroDeCuenta))
                {   
                    return true;
                }
            }
        }
        return false;
    }

    public function AsignarNumeroDeCuenta()
    {
        $numero = rand(100000, 999999);
       
        while(self::VerificarNumeroDeCuenta($numero))
        {
            $numero = rand(100000, 999999);
        }

        $this->numeroDeCuenta = $numero;
        
    }
}

?>