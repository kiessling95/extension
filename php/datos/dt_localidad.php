<?php


class dt_localidad extends extension_datos_tabla 
{
    function get_descripciones($id_provincia)
    {
        $sql="SELECT l.id , l.localidad "
                . "FROM dblink('".$this->dblink_designa()."',"
                . "'SELECT id,localidad,id_provincia FROM localidad') as l (id INTEGER , localidad CHARACTER VARYING(255),id_provincia INTEGER) "
                . " WHERE id_provincia = '". $id_provincia."' "
                . " ORDER BY id";
        return toba::db('extension')->consultar($sql);
    }
}
