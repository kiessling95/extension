<?php

class dt_avance extends extension_datos_tabla {

    function get_avance($claves = null) {
        $sql = "SELECT *"
                . "FROM avance "
                . "WHERE id_avance= $claves[id_avance] AND id_obj_esp =' ". $claves[id_obj_esp]." ' "
                . "ORDER BY fecha";
        return toba::db('extension')->consultar($sql);
    }

    function get_listado($id_obj = null , $where = null) {
        $sql = "SELECT id_obj_esp, id_avance,fecha,descripcion ,link,ponderacion,titulo_actividad "
                . "FROM avance "
                . "WHERE id_obj_esp = $id_obj ";
        if (!is_null($where)) {
            $sql .= "AND $where ";
        }

        $sql .= "ORDER BY fecha";
        return toba::db('extension')->consultar($sql);
    }

}

?>
