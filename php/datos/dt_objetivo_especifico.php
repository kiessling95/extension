<?php

class dt_objetivo_especifico extends extension_datos_tabla
{
    function get_listado($id = null)
    {
        $sql = "SELECT
               
                o_e.id_objetivo ,
                o_e.descripcion ,
                o_e.id_pext ,
                o_e.meta ,
                o_e.ponderacion
                
                FROM objetivo_especifico as o_e INNER JOIN pextension as p_e ON (o_e.id_pext = p_e.id_pext)
                WHERE o_e.id_pext = ".$id .
                "ORDER BY id_objetivo";
        
        return toba::db('extension')->consultar($sql);
    }
    
    function get_datos($id)
    {
                $sql = "SELECT
                
                o_e.id_objetivo ,
                o_e.descripcion ,
                o_e.id_pext ,
                o_e.meta ,
                o_e.ponderacion
                
                FROM objetivo_especifico as o_e INNER JOIN pextension as p_e ON (o_e.id_pext = p_e.id_pext)
                WHERE o_e.id_pext = ".$id;
        return toba::db('extension')->consultar($sql);
    }
}

