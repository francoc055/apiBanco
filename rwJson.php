<?php
class rwJson{

    public static function SaveJson($lista, $archivo)
    {
        $json = json_encode($lista, JSON_PRETTY_PRINT);
        if(file_put_contents($archivo, $json) === false)
        {
            return false;
        }
        return true;
    }

    public static function ReadJson($path)
    {
        if(file_exists($path))
        {
            $datos = file_get_contents($path); 
            if(!empty($datos))
            {
                $lista = json_decode($datos);
                return $lista;
            }
        }
        
        return null;
    }
}


?>