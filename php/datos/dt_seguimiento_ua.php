<?php

class dt_seguimiento_ua extends extension_datos_tabla {

    function get_listado($id)
    {
        $sql = "SELECT
            
                    s_u.id_seguimiento,
                    s_u.id_pext,
                    s_u.observacion,
                    s_u.nro_resol,
                    s_u.fecha_resol
                    
                FROM seguimiento_ua as s_u INNER JOIN pextension as p_e ON (s_u.id_pext = p_e.id_pext)
                WHERE s_u.id_pext = ".$id;
        
        return toba::db('extension')->consultar($sql);
    }
}
?>