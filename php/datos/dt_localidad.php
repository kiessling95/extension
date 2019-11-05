<?php


class dt_localidad extends extension_datos_tabla 
{
    function get_descripciones()
    {
        $sql = " SELECT 
            
                    id ,
                    localidad
                FROM localidad  ORDER BY id";
        return toba::db('extension')->consultar($sql);
    }
}
