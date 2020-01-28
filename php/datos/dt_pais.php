<?php

class dt_pais extends extension_datos_tabla {

    function get_listado() {

        $sql = "SELECT t_p.* FROM dblink('" . $this->dblink_designa() . "','SELECT t_p.id_periodo,t_p.descripcion FROM periodo as t_p') as t_p (id_periodo INTEGER ,descripcion CHARACTER(8)) ORDER BY t_p.descripcion";
        return toba::db('extension')->consultar($sql);
    }

    function get_descripciones() {
        $sql = " SELECT t_p.nombre, t_p.codigo_pais FROM dblink('" . $this->dblink_designa() . "','SELECT nombre,codigo_pais FROM pais') as t_p (nombre CHARACTER VARYING(40), codigo_pais CHARACTER(2))"
                . " WHERE t_p.codigo_pais = 'AR'"
                . " ORDER BY nombre";
        return toba::db('extension')->consultar($sql);
    }

    function get_descripciones_sin_ambos() {
        $sql = "SELECT id_periodo, descripcion FROM periodo WHERE id_periodo<>4"
                . " ORDER BY id_periodo";
        return toba::db('extensions')->consultar($sql);
    }

}

?>