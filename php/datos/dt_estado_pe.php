<?php

class dt_estado_pe extends extension_datos_tabla {

    function get_descripciones() {
        $sql = "select id_estado, descripcion from estado_pe";
        return toba::db('extension')->consultar($sql);
    }

    function get_id($descripcion = null) {
        $sql = "SELECT id_estado FROM estado_pe WHERE descripcion='$descripcion'";
        return toba::db('extension')->consultar($sql);
    }

    function get_descripciones_perfil() {
        $perfil = toba::usuario()->get_perfil_datos();
        if ($perfil != null) {
            $sql = "select * from estado_pe where id_estado='FORM'";
        } else {
            $sql = "select * from estado_pe ";
        }
        return toba::db('extension')->consultar($sql);
    }

    function evaluacion_ua() {
        $estado = toba::tabla('pextension')->get()['id_estado'];
        if ($estado == 'FORM' || $estado == 'MODF' || $estado == 'EUA ' || $estado == 'PAPR') {
            $sql = " SELECT id_estado, descripcion "
                    . "FROM estado_pe "
                    . "WHERE "
                    . "id_estado ='MODF' "
                    . "OR id_estado ='ECEN' "
                    . "OR id_estado ='EUA'";
        } else {
            $sql = " SELECT id_estado, descripcion "
                    . "FROM estado_pe "
                    . "WHERE "
                    . " id_estado = 'ECEN'"
                    . " OR id_estado = 'APRB'"
                    . " OR id_estado = 'DES' "
                    . " OR id_estado = 'BAJA'"
                    . " OR id_estado = 'FIN'"
                    . " OR id_estado = 'PRG'";
        }
        return toba::db('extension')->consultar($sql);
    }

    function evaluacion_central() {
        $sql = " SELECT id_estado, descripcion FROM estado_pe "
                . " WHERE "
                . " id_estado = 'ECEN'"
                . " OR id_estado = 'APRB'"
                . " OR id_estado = 'DES' "
                . "OR id_estado ='EUA'";

        return toba::db('extension')->consultar($sql);
    }

    function solicitud() {
        $sql = " SELECT id_estado, descripcion FROM estado_pe "
                . " WHERE id_estado = 'APRB'"
                . " OR id_estado = 'BAJA'"
                . " OR id_estado = 'FIN'"
                . " OR id_estado = 'PRG'";
        return toba::db('extension')->consultar($sql);
    }

}

?>