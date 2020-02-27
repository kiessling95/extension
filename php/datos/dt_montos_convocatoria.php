<?php

class dt_montos_convocatoria extends extension_datos_tabla {

    function get_descripciones($id_rubro_extension = null,$id_bases = null) {
        $where = "";
        if (!is_null($id_rubro_extension)) {
            $where = " WHERE id_rubro_extension=$id_rubro_extension AND id_bases = $id_bases ";
        }
        $sql = "SELECT id_rubro_extension,id_bases, monto_max"
                . " FROM montos_convocatoria "
                . " $where";
        return toba::db('extension')->consultar($sql);
        
    }
    function get_listado($id_bases = null){
        $where = "";
        if (!is_null($id_bases)) {
            $where = " WHERE id_bases=$id_bases";
        }
        $sql = "SELECT id_rubro_extension,id_bases, monto_max"
                . " FROM montos_convocatoria "
                . " $where";
        return toba::db('extension')->consultar($sql);
    }

}

?>