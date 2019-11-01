<?php

class dt_pais extends extension_datos_tabla {

    function get_listado() {
        $sql = "SELECT
            t_p.id_periodo,
            t_p.descripcion
        FROM
            periodo as t_p
        ORDER BY descripcion";
        return toba::db('extension')->consultar($sql);
    }

    function get_descripciones() {
       
        $sql = "SELECT codigo_pais, nombre FROM pais ORDER BY nombre";
        return toba::db('extension')->consultar($sql);
    }

    function get_descripciones_sin_ambos() {
        $sql = "SELECT id_periodo, descripcion FROM periodo WHERE id_periodo<>4"
                . " ORDER BY id_periodo";
        return toba::db('extensions')->consultar($sql);
    }

}

?>