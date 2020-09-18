<?php

class dt_avance extends extension_datos_tabla {

    function get_avance($claves = null) {
        $sql = "SELECT *"
                . "FROM avance "
                . "WHERE id_avance= $claves[id_avance] AND id_obj_esp =' ". $claves[id_obj_esp]." ' "
                . "ORDER BY fecha";
        return toba::db('extension')->consultar($sql);
    }

    function get_listado_cuadro($id_pext = null , $where = null) {
        $sql = "SELECT "
                . "id_obj_esp, "
                . "id_avance, "
                . "fecha, "
                . "t_a.descripcion, "
                . "link, "
                . "t_a.ponderacion, "
                . "titulo_actividad,"
                . "t_o.ponderacion as ponderacionO "
                . "FROM avance as t_a INNER JOIN objetivo_especifico as t_o ON (t_a.id_obj_esp = t_o.id_objetivo) "
                . "WHERE t_o.id_pext = $id_pext ";
        if (!is_null($where)) {
            $sql .= "AND $where ";
        }

        $sql .= "ORDER BY fecha";
        return toba::db('extension')->consultar($sql);
    }
    
    function get_listado($id_obj = null) {
        $sql = "SELECT id_obj_esp, id_avance,fecha,descripcion ,link,ponderacion,titulo_actividad "
                . "FROM avance "
                . "WHERE id_obj_esp = $id_obj "
                . "ORDER BY fecha";
        return toba::db('extension')->consultar($sql);
    }

}

?>