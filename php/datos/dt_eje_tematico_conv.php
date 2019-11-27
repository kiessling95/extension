<?php

class dt_eje_tematico_conv extends extension_datos_tabla {

    function get_descripciones() {
        $sql = "SELECT id_eje,id_bases, descripcion FROM eje_tematico_conv ORDER BY descripcion";
        return toba::db('extension')->consultar($sql);
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