<?php
include_once("C:/xampp/htdocs/PrimerParcial/Models/Transacciones.php");
include_once("C:/xampp/htdocs/PrimerParcial/rwJson.php");
class Movimientos{

    //A
    public static function CalcularDepositos($fecha, $lista)
    {
        $ccPesos = 0;
        $ccDolares = 0;
        $caPesos = 0;
        $caDolares = 0;
        foreach($lista as $deposito)
        {
            if($deposito->fecha == $fecha)
            {
                if($deposito->cuenta->tipoDeCuenta === "cc")
                {
                    if($deposito->cuenta->moneda === "$")
                    {
                        $ccPesos += $deposito->importe;
                    }
                    else
                    {
                        $ccDolares += $deposito->importe;
                    }
                }
                else if($deposito->cuenta->tipoDeCuenta === "ca")
                {
                    if($deposito->cuenta->moneda === 'U$S')
                    {
                        $caPesos += $deposito->importe;
                    }
                    else
                    {
                        $caDolares += $deposito->importe;
                    }
                }
            }
        }
    
        echo "cc y pesos: {$ccPesos} <br>";
        echo "cc y dolares: {$ccDolares} <br>";
        echo "ca y pesos: {$caPesos} <br>";
        echo "ca y dolares: {$caDolares} <br>";
    }

    public static function TotalDepositos($fecha  = null)
    {
        if($fecha === null)
        {
            $fecha = date('y-m-d');
            $fecha = date('y-m-d', strtotime('-1 day', strtotime($fecha)));
        }


        $listaDepositos = rwJson::ReadJson(Transacciones::GetPathDeposito());
        if($listaDepositos !== null)
        {
            self::CalcularDepositos($fecha, $listaDepositos);
        }
    }

    //B
    public static function DepositosDeUnUsuario($email)
    {
        $flag = false;
        $listaDepositos = rwJson::ReadJson(Transacciones::GetPathDeposito());
        if($listaDepositos !== null)
        {
            foreach($listaDepositos as $deposito)
            {
                if($deposito->cuenta->email === $email)
                {
                    $flag = true;
                    Transacciones::MostrarTransaccion($deposito);
                    echo "<br>-------------------------------<br/>";
                }
            }
        }
        
        if(!$flag)
        {
            echo "No existe el usuario";
        }

        return $flag;           
    }

    
    //c
    public static function ListarDepositosEntreFechas($fechaA, $fechaB)
    {
        $listaDepositos = rwJson::ReadJson(Transacciones::GetPathDeposito());
        $listaEntreFechas = array();
        if($listaDepositos !== null)
        {
            foreach($listaDepositos as $deposito)
            {
                if($deposito->fecha >= $fechaA && $deposito->fecha <= $fechaB)
                {
                    array_push($listaEntreFechas, $deposito);
                }
            }
        }

        if($listaEntreFechas !== null)
        {
            usort($listaEntreFechas, function($a, $b)
            {
                return strcmp($a->cuenta->nombre, $b->cuenta->nombre);
            });

            foreach($listaEntreFechas as $depo)
            {
                Transacciones::MostrarTransaccion($deposito);
            }
        }

        
        
    }

    //D
    public static function ListarPorTipoDeCuenta($tipoDeCuenta)
    {
        $listaDepositos = rwJson::ReadJson(Transacciones::GetPathDeposito());
        $listaTipoDeCuenta = array();
        if($listaDepositos !== null)
        {
            foreach($listaDepositos as $deposito)
            {
                if($deposito->cuenta->tipoDeCuenta === $tipoDeCuenta)
                {
                    array_push($listaTipoDeCuenta, $deposito);
                }
            }
        }

        if($listaTipoDeCuenta !== null)
        {
            foreach($listaTipoDeCuenta as $depo)
            {
                Transacciones::MostrarTransaccion($deposito);
            }
        }

    }

    //E
    public static function ListarPorMoneda($moneda)
    {
        $listaDepositos = rwJson::ReadJson(Transacciones::GetPathDeposito());
        $listaTipoDeMoneda = array();
        if($listaDepositos !== null)
        {
            foreach($listaDepositos as $deposito)
            {
                if($deposito->cuenta->moneda === $moneda)
                {
                    array_push($listaTipoDeMoneda, $deposito);
                }
            }
        }

        if($listaTipoDeMoneda !== null)
        {
            foreach($listaTipoDeMoneda as $depo)
            {
                Transacciones::MostrarTransaccion($depo);
            }
        }
    }
    
    
}

?>