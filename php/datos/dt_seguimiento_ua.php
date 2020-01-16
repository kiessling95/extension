<?php

class dt_seguimiento_ua extends extension_datos_tabla {

    function get_listado($id_pext = null)
    {
        
        $sql = "SELECT
            
                    s_u.id_seguimiento,
                    s_u.id_pext,
                    s_u.observacion_ua,
                    s_u.nro_resol,
                    s_u.fecha_resol,
                    s_u.observacion_ua,
                    s_u.estado,
                    s_u.tipo_docum,
                    s_u.nro_docum,
                    s_u.desde
                    
                FROM seguimiento_ua as s_u INNER JOIN pextension as p_e ON (s_u.id_pext = p_e.id_pext)
                LEFT OUTER JOIN integrante_externo_pe as t_e ON (s_u.nro_docum = t_e.nro_docum AND s_u.tipo_docum = t_e.tipo_docum
                 AND s_u.desde = t_e.desde AND s_u.id_pext = t_e.id_pext)
                WHERE s_u.id_pext = ".$id_pext;
        
        return toba::db('extension')->consultar($sql);
    }
}
?>