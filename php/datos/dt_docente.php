<?php

#require_once 'consultas_mapuche.php';
#require_once 'dt_mocovi_periodo_presupuestario.php';

class dt_docente extends extension_datos_tabla {

    function get_nombre($id_desig) {
        $sql = "SELECT n.nombre "
                . "FROM dlink('" . $this->dblink_designa() . "', 'SELECT apellido||', '||nombre as nombre from docente t_do,designacion t_d "
                . "           WHERE t_do.id_docente=t_d.id_docente and t_d.id_designacion=" . $id_desig . ")";
        $res = toba::db('extension')->consultar($sql);
        return $res[0]['nombre'];
    }

    function get_id_docente($id_desig) {
        #print_r($id_desig);
        $sql = "SELECT t_do.apellido||', '||t_do.nombre as nombre,t_do.id_docente FROM dblink('" . $this->dblink_designa() . "','SELECT t_do.apellido,t_do.nombre,t_do.id_docente FROM docente as t_do,designacion as t_d"
                . " WHERE t_do.id_docente=t_d.id_docente and t_d.id_designacion=" . $id_desig . "') as t_do (nombre CHARACTER VARYING, apellido CHARACTER VARYING, id_docente INTEGER)";
        $res = toba::db('extension')->consultar($sql);
        #print_r($res[0]['id_docente']);
        return $res[0];
    }

    function get_listado($where = null) {
        if (!is_null($where)) {
            $where = ' WHERE ' . $where;
        } else {
            $where = '';
        }
        $sql = "SELECT "
                . "t_d.id_docente,"
                . "t_d.legajo,"
                . "t_d.apellido,"
                . "t_d.nombre,"
                . "t_d.legajo,"
                . "t_d.tipo_docum,"
                . "t_d.nro_docum "
                . "FROM "
                . "(SELECT t_d.* "
                . "FROM dblink('" . $this->dblink_designa() . "',"
                . "'SELECT t_d.id_docente,t_d.nombre, t_d.apellido, t_d.tipo_docum,t_d.nro_docum, t_d.legajo "
                . "FROM docente as t_d ') as t_d ( id_docente INTEGER,nombre CHARACTER VARYING,apellido CHARACTER VARYING,tipo_docum CHARACTER(4) ,nro_docum INTEGER, legajo INTEGER) ) as t_d "
                . "$where "
                . "ORDER BY nombre";

        return toba::db('extension')->consultar($sql);
    }


    function get_descripciones() {
        $sql = "SELECT d.id_docente , d.nombre "
                . "FROM dblink('" . $this->dblink_designa() . "', 'SELECT id_docente, (trim(apellido),nombre) as nombre "
                . "                              FROM docente ORDER BY nombre')  "
                . "as d (id_docente INTEGER, nombre CHARACTER VARYING)";
        return toba::db('extension')->consultar($sql);
    }

}

?>