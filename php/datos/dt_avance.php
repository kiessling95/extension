<?php

class dt_avance extends extension_datos_tabla {

    function get_avance($claves = null) {
        $sql = "SELECT fecha, descripcion,link"
                . "FROM avance "
                . "WHERE id_avance= $claves[id_avance] AND id_actividad =' ". $claves[id_actividad]." ' "
                . "ORDER BY fecha";
        return toba::db('extension')->consultar($sql);
    }

    function get_listado($id_actividad = null , $where = null) {
        $sql = "SELECT fecha,descripcion ,link "
                . "FROM avance "
                . "WHERE id_avance = id_actividad ";
        if (!is_null($where)) {
            $sql .= "AND $where";
        }

        $sql .= "ORDER BY fecha";
        return toba::db('extension')->consultar($sql);
    }

}

?>
