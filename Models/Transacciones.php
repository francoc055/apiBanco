<?php
// include_once("./../rwJson.php");
include_once("./CrudJson.php");
include_once("./ImageHandler.php");
// include_once("./Cuenta.php");

class Transacciones{
    public $id;
    public $fecha;
    public $importe;
    public stdClass $cuenta;


    // public function __construct($fecha, $importe, stdClass $cuenta) {
    //     $this->fecha = $fecha;
    //     $this->importe = $importe;
    //     $this->cuenta = $cuenta;
    // }

    public static function GetPathDeposito()
    {
        return "C:/xampp/htdocs/PrimerParcial/deposito.json";
    }

    public function Deposito($tipoDeCuenta, $numeroDeCuenta, $moneda, $importe)
    {
        $statusCode = 400;
        $archivo = "C:/xampp/htdocs/PrimerParcial/ultimoId.json";
        $lista = rwJson::ReadJson(Cuenta::GetPath());
        if($lista !== null)
        {
            foreach($lista as $item)
            {
                if($item->tipoDeCuenta === $tipoDeCuenta && $item->numeroDeCuenta == $numeroDeCuenta && 
                $item->moneda === $moneda)
                {
                    $item->saldo += $importe;
                    $this->importe = $importe;
                    $this->fecha = date("y-m-d");
                    $this->id = CrudJson::VerificarUltimoId($archivo);
                    $this->cuenta = $item;
                    $descripcionImagen = $this->cuenta->numeroDeCuenta . $this->cuenta->tipoDeCuenta . $this->id;
                    $imagen = $_FILES["imagen"];
                    $imagen["name"] = $descripcionImagen . ".png";
                    $destino = "./ImagenesDeDepositos/" . $imagen["name"];
                    if(CrudJson::AddJson($this, self::GetPathDeposito()) && rwJson::SaveJson($lista, Cuenta::GetPath()))
                    {
                        ImageHandler::CargarImagen($imagen, $destino);
                        $statusCode = 201;
                        break;
                    }
                }
            }
            if($statusCode === 400)
            {
                echo "Error. no se pudo encontrar la cuenta";
                $statusCode = 404;       
            }
        }


        return $statusCode;
    }


    public static function MostrarTransaccion($transaccion)
    {
        echo "Fecha: {$transaccion->fecha} <br>
        Importe: {$transaccion->importe} <br>
        Nombre: {$transaccion->cuenta->nombre} <br>
        Apellido: {$transaccion->cuenta->apellido} <br>
        Tipo de documento: {$transaccion->cuenta->tipoDocumento} <br>
        Numero de documento: {$transaccion->cuenta->numeroDocumento} <br>
        Email: {$transaccion->cuenta->email} <br>
        Tipo de cuenta: {$transaccion->cuenta->tipoDeCuenta} <br>
        Moneda: {$transaccion->cuenta->moneda} <br>
        Saldo: {$transaccion->cuenta->saldo} <br>";
        echo "<br>------------------------------------<br/>";
    }


    public static function GetPathRetiro()
    {
        return "C:/xampp/htdocs/PrimerParcial/retiro.json";
    }

    public function Retiro($tipoDeCuenta, $numeroDeCuenta, $moneda, $importe)
    {
        $flag = false;
        $statusCode = 404;
        $archivo = "C:/xampp/htdocs/PrimerParcial/ultimoIdRetiro.json";
        $lista = rwJson::ReadJson(Cuenta::GetPath());
        if($lista !== null)
        {
            foreach($lista as $item)
            {
                if($item->tipoDeCuenta === $tipoDeCuenta && $item->numeroDeCuenta == $numeroDeCuenta && 
                $item->moneda === $moneda)
                {
                    if(($item->saldo - $importe) >= $importe)
                    {
                        $item->saldo -= $importe;
                        $this->importe = $importe;
                        $this->fecha = date("y-m-d");
                        $this->id = CrudJson::VerificarUltimoId($archivo);
                        $this->cuenta = $item;
                        if(CrudJson::AddJson($this, self::GetPathRetiro()) && rwJson::SaveJson($lista, Cuenta::GetPath()))
                        {
                            $statusCode = 201;
                            $flag = true;
                            break;
                        }
                    }
                    else
                    {
                        echo "El importe supera al saldo de la cuenta";
                        // $flag = true;
                        break;
                    }
                }
            }
            if(!$flag)
            {
                echo "Error. no se pudo encontrar la cuenta";     
            }
        }


        return $statusCode;
    }
}

?>