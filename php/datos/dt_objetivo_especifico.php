<?php

class dt_objetivo_especifico extends extension_datos_tabla
{
    function get_listado($id = null)
    {
        $sql = "SELECT
               
                o_e.id_objetivo ,
                o_e.descripcion ,
                o_e.id_pext
                
                FROM objetivo_especifico as o_e
                WHERE o_e.id_pext = ".$id .
                "ORDER BY id_objetivo";
        return toba::db('extension')->consultar($sql);
    }
}

