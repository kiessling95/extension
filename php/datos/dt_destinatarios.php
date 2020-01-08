<?php

class dt_destinatarios extends extension_datos_tabla {

    function get_descripciones($id_dest = null) {

        if (!is_null($id_dest)) {
            $sql = "SELECT "
                    . "d.id_destinatario, "
                    . "d.descripcion "
                    . "FROM destinatarios as d "
                    . "WHERE d.id_destinatario = $id_dest ";
            $res = toba::db('extension')->consultar($sql);
        } else {
            $res = array();
        }
        return $res;
    }

    function get_listado($id_pext = null) {

        if (!is_null($id_pext)) {
            $sql = "SELECT "
                    . "d.id_destinatario, "
                    . "d.id_pext, "
                    . "d.domicilio, "
                    . "d.telefono, "
                    . "d.email, "
                    . "d.contacto,"
                    . "d.descripcion "
                    . "FROM destinatarios as d "
                    . "WHERE d.id_pext = $id_pext ";
            $res = toba::db('extension')->consultar($sql);
        } else {
            $res = array();
        }
        return $res;
    }

}

?>
