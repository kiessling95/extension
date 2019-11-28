<?php

class dt_eje_tematico_conv extends extension_datos_tabla {

    function get_descripciones($id_bases = null) {
        //$sql = "SELECT id_eje,id_bases, descripcion FROM eje_tematico_conv ORDER BY descripcion";
        //return toba::db('extension')->consultar($sql);
        
        if (!is_null($id_bases)) {
            $sql = "SELECT t_e.id_eje,t_e.id_bases, descripcion FROM eje_tematico_conv as t_e "
                    . "INNER JOIN bases_convocatoria as b_c ON (b_c.id_bases = t_e.id_bases) "
                    . "Where b_c.id_bases= " . $id_bases;
            //print_r($sql);
            $res = toba::db('extension')->consultar($sql);
        } else {
            $res = array();
        }

        return $res;
    }

    function get_listado() {
        $sql = "SELECT
			t_etc.id_eje,
                        t_etc.id_bases,
			t_etc.descripcion
		FROM
			eje_tematico_conv as t_etc
		ORDER BY descripcion";
        return toba::db('extension')->consultar($sql);
    }
    


}

?>