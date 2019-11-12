<?php


class dt_localidad extends extension_datos_tabla 
{
    function get_descripciones()
    {
        $sql="SELECT l.id , l.localidad "
                . "FROM dblink('".$this->dblink_designa()."',"
                . "'SELECT id,localidad FROM localidad') as l (id INTEGER , localidad CHARACTER VARYING(255)) ORDER BY id";
        return toba::db('extension')->consultar($sql);
    }
}
