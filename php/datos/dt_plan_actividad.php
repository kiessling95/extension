<?php

class dt_plan_actividad extends extension_datos_tabla
{
    //Arreglar cuando el rubro ya esté definido
    function get_listado()
    {
        $sql = "SELECT 
                
                p_a.id_plan ,
                p_a.id_rubro_extension ,
                p_a.id_obj_especifico ,
                p_a.destinatarios ,
                p_a.detalle ,
                p_a.fecha ,
                p_a.localizacion ,
                p_a.meta
                
                FROM plan_actividades as p_a INNER JOIN objetivo_especifico as o_e ON (p_a.id_obj_especifico = o_e.id_objetivo)
               
                ORDER BY id_plan";
        return toba::db('extension')->consultar($sql);
    }
}

