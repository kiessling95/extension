<?php

class dt_tipo_convocatoria extends extension_datos_tabla {

    function get_descripciones($id_bases = null) {
        //$sql = "SELECT id_conv, descripcion FROM tipo_convocatoria ORDER BY descripcion";
        //return toba::db('extension')->consultar($sql);

        if (!is_null($id_bases)) {
            $sql = "SELECT id_conv,descripcion FROM tipo_convocatoria as t_c "
                    . "INNER JOIN bases_convocatoria as b_c ON (b_c.tipo_convocatoria = t_c.id_conv) "
                    . "Where id_bases= " . $id_bases;
            $res = toba::db('extension')->consultar($sql);
        } else {
            $res = array();
        }

        return $res;
    }
    
    function get_tipos_convocatorias() {
        $sql = "SELECT id_conv, descripcion FROM tipo_convocatoria ORDER BY descripcion";
        return toba::db('extension')->consultar($sql);

    }


}

?>