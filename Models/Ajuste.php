<?php
include_once('Transacciones.php');
include_once('./rwJson.php');



class Ajuste{
    public $numeroDeCuenta;
    public $idTransaccion;
    public $tipoAjuste;
    public $motivo;


    public function BuscarMayor($lista)
    {
        $mayor = -1;
        foreach($lista as $item)
        {
            if($item->cuenta->numeroDeCuenta == $this->numeroDeCuenta)
            {
                if($item->id > $mayor)
                {
                    $mayor = $item->id;
                }
            }
        }

        return $mayor;
    }


    public static function GetPath()
    {
        return "C:/xampp/htdocs/PrimerParcial/ajustes.json";
    }

    public static function ExisteAjuste($id, $tipoAjuste)
    {
        $lista = rwJson::ReadJson(self::GetPath());
        if($lista !== null)
        {
            foreach($lista as $ajuste)
            {
                if($ajuste->idTransaccion === $id && $ajuste->tipoAjuste === $tipoAjuste)
                {
                    return true;
                }
            }
        }

        return false;
    }
    

    public function AjusteDeposito()
    {
        $statusCode = 404;
        $lista = rwJson::ReadJson(Transacciones::GetPathDeposito());
        $listaCuenta = rwJson::ReadJson(Cuenta::GetPath());

        if($lista !== null && $listaCuenta !== null)
        {
            $indice = $this->BuscarMayor($lista);
            if($indice !== -1)
            {
                $this->idTransaccion = $indice;

                foreach($listaCuenta as $cuenta)
                {
                    if($this->numeroDeCuenta == $cuenta->numeroDeCuenta)
                    {
                        if(!self::ExisteAjuste($this->idTransaccion, $this->tipoAjuste))
                        {
                            $cuenta->saldo -= $lista[count($lista) - 1]->importe;
                            $listaAjuste = rwJson::ReadJson(self::GetPath());
                            if($listaAjuste === null)
                            {
                                $listaAjuste = array();
                            }
    
                            array_push($listaAjuste, $this);
    
                            if(rwJson::SaveJson($listaCuenta, Cuenta::GetPath()) && rwJson::SaveJson($listaAjuste, self::GetPath()))
                            {
                                echo "ajuste finalizado correctamente";
                                $statusCode = 200;
                                break;
                            }
                        }
                    }
                }
            }
    
           
        }
        
        return $statusCode;

        
    }


    public function AjusteRetiro()
    {
        $statusCode = 404;
        $lista = rwJson::ReadJson(Transacciones::GetPathRetiro());
        $listaCuenta = rwJson::ReadJson(Cuenta::GetPath());

        if($lista !== null && $listaCuenta !== null)
        {
            $indice = $this->BuscarMayor($lista);
            if($indice !== -1)
            {
                $this->idTransaccion = $indice;
    
                foreach($listaCuenta as $cuenta)
                {
                    if($this->numeroDeCuenta == $cuenta->numeroDeCuenta)
                    {
                        if(!self::ExisteAjuste($this->idTransaccion, $this->tipoAjuste))
                        {
                            $cuenta->saldo += $lista[count($lista) - 1]->importe;
                            $listaAjuste = rwJson::ReadJson(self::GetPath());
                            if($listaAjuste === null)
                            {
                                $listaAjuste = array();
                            }

                            array_push($listaAjuste, $this);

                            if(rwJson::SaveJson($listaCuenta, Cuenta::GetPath()) && rwJson::SaveJson($listaAjuste, self::GetPath()))
                            {
                                echo "ajuste finalizado correctamente";
                                $statusCode = 200;
                                break;
                            }
                        }
                    }
                    
                }
            }
            
        }


        return $statusCode;
        
    }
}
?>