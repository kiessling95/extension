<?php

class dt_tipos_ejes_tematicos extends extension_datos_tabla {

    function get_descripciones() {
        $sql = "SELECT id_eje, descripcion FROM tipos_ejes_tematicos ORDER BY descripcion";
        return toba::db('extension')->consultar($sql);
    }

    function get_tipo($id_eje = null) {
        
        if(!is_null($id_eje)){
            $where = 'WHERE id_eje= '.$id_eje;
        } else {
            $where = '';
        }
        //print_r($where);
        $sql = "SELECT id_eje, descripcion FROM tipos_ejes_tematicos"
                . " $where"
                . " ORDER BY descripcion";
        //print_r($sql);
        return toba::db('extension')->consultar($sql);
    }

    function get_listado() {
        $sql = "SELECT
			t_etc.id_eje,
			t_etc.descripcion
		FROM
			tipos_ejes_tematicos as t_etc
		ORDER BY descripcion";
        return toba::db('extension')->consultar($sql);
    }

}

?>