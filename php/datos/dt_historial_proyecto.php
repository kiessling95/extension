<?php

class dt_historial_proyecto extends extension_datos_tabla
{
    function get_historial($proyecto)
    {
        $sql = "SELECT
                    denominacion as nombre,
                    id_estado as estado,
                    auditoria_fecha as fecha,
                    auditoria_usuario as responsable
                FROM logs_pextension 
                WHERE id_pext = $proyecto";
        return toba::db('extension')->consultar($sql);
    }
   
}

?>