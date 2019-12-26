<?php

class dt_eje_tematico_conv extends extension_datos_tabla {

    function get_descripciones($id_bases = null) {
        //retorna los ejes tematicos asociados a la convocatoria 
        if (!is_null($id_bases)) {
            $sql = "SELECT t_e.id_eje, descripcion FROM eje_tematico_conv as t_e "
                    . "INNER JOIN bases_convocatoria as b_c ON (b_c.id_bases = t_e.id_bases) "
                    . "Where b_c.id_bases= " . $id_bases;
            
            $res = toba::db('extension')->consultar($sql);
        } else {
            $res = array();
        }
        //print_r($res);        exit();
        return $res;
    }

    function get_listado($id_bases = null) {
        $sql = "SELECT
			t_etc.id_eje,
                        t_etc.id_bases,
			t_etc.descripcion
		FROM
			eje_tematico_conv as t_etc
                WHERE   t_etc.id_bases = $id_bases
		ORDER BY descripcion";
        return toba::db('extension')->consultar($sql);
    }
    
    
    function existe_eje($id_base = null, $id_eje = null){
        $sql = "SELECT
			t_etc.id_eje,
                        t_etc.id_bases,
			t_etc.descripcion
		FROM
			eje_tematico_conv as t_etc
                WHERE   t_etc.id_bases = $id_bases AND t_etc.id_eje = $id_eje
		ORDER BY descripcion";
        print_r($sql);        exit();
        return toba::db('extension')->consultar($sql);
    }


}

?>