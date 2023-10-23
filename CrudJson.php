<?php
include_once("./ICrudJson.php");
class CrudJson implements ICrudJson{
    

    public static function AddJson($objeto, $archivo){
        $lista = rwJson::ReadJson($archivo);
        if($lista === null)
        {
            $lista = array();
        }

        array_push($lista, $objeto);
        if(rwJson::SaveJson($lista, $archivo))
        {
            return true;
        }

        return false;
    }


    public static function VerificarUltimoId($archivo)
    {
        $id = null;

        $listaId = rwJson::ReadJson($archivo);
        if($listaId === null)
        {
            $listaId = array("ultimoId" => 1);
            rwJson::SaveJson($listaId, $archivo);
            $id = 1;
        }
        else
        {
            // var_dump($listaId->ultimoId);
            $listaId->ultimoId += 1;
            $id = $listaId->ultimoId;
            rwJson::SaveJson($listaId, $archivo);
        }

        return $id;
    }
}

?>