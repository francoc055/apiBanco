<?php
class ImageHandler{
    public static function CargarImagen($imagen, $destino)
    {
        if (copy($imagen["tmp_name"], $destino)) {
            return true;
        }

        return false;
    }
}
?>