<?php

class dt_historial_proyecto extends extension_datos_tabla
{
    function get_historial($proyecto)
    {
        $esquema_auditoria = toba::db()->get_schema().'_auditoria';
        $sql = "SELECT
                    aud_pe.denominacion as nombre,
                    est.descripcion as estado,
                    aud_pe.auditoria_fecha as fecha,
                    aud_pe.auditoria_usuario as responsable
                FROM $esquema_auditoria.logs_pextension as aud_pe
                    INNER JOIN estado_pe as est ON (est.id_estado = aud_pe.id_estado)
                WHERE aud_pe.id_pext = $proyecto";
        return toba::db()->consultar($sql);
    }
   
}

?>