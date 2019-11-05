<?php

class dt_plan_actividad extends extension_datos_tabla
{
    //Arreglar cuando el rubro ya esté definido
    function get_listado()
    {
        $sql = "SELECT 
                
                id_plan ,
                id_rubro_extension ,
                destinatarios ,
                detalle ,
                fecha ,
                localizacion ,
                meta
                
                FROM plan_actividades 
                ORDER BY id_plan";
        return toba::db('extension')->consultar($sql);
    }
}

