<?php

class dt_seguimiento_central extends extension_datos_tabla {

    function get_listado($id = null)
    {
        $sql = "SELECT 
                
                   s_c.id_seguimiento,
                   s_c.id_pext,
                   s_c.codigo,
                   s_c.nro_ord_cs,
                   s_c.res_rect,
                   s_c.resolucion_pago,
                   s_c.fecha_inf_avance,
                   s_c.fecha_evaluacion_avance,
                   s_c.dictamen,
                   s_c.fecha_inf_final,
                   s_c.fecha_evaluacion_final,
                   s_c.informe_avance,
                   s_c.informe_final,
                   s_c.observacion_avance,
                   s_c.observacion_final,
                   s_c.num_acta_avance,
                   s_c.num_acta_final,
                   s_c.rendicion,
                   s_c.estado_rendicion,
                   s_c.num_acta,
                   s_c.fecha_rendicion,
                   s_c.rendicion_monto,
                   s_c.estado_informe_a,
                   s_c.estado_informe_f,
                   s_c.res_desig,
                   s_c.nro_expediente_pago,
                   s_c.informe_becario,
                   s_c.fecha_informe_becario,
                   s_c.nro_acta_informe_becario,
                   s_c.estado_becario,
                   s_c.fecha_ordenanza,
                   s_c.dictamen_aprob
                   
                FROM seguimiento_central as s_c INNER JOIN pextension as p_e ON (s_c.id_pext = p_e.id_pext)
                
                WHERE s_c.id_pext = ".$id;
        return toba::db('extension')->consultar($sql);
    }
   
}
?>