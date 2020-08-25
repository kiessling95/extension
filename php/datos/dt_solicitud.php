<?php

class dt_solicitud extends extension_datos_tabla {

    function get_solicitud($claves = null) {
        $sql = "SELECT  * "
                . "FROM solicitud "
                . "WHERE id_pext= $claves[id_pext] AND fecha_solicitud =' ". $claves[fecha_solicitud]." ' AND tipo_solicitud = '".$claves[tipo_solicitud]."' "
                . "ORDER BY tipo_solicitud";
        return toba::db('extension')->consultar($sql);
    }
    
    function get_solicitud_vigente($claves = null) {
        
        // Falta control de fechas
        $sql = "SELECT  * "
                . "FROM solicitud "
                . "WHERE estado_solicitud='$claves[estado_solicitud]' "
                . "AND id_pext= $claves[id_pext] "
                . "AND cambio_integrante ='". $claves[cambio_integrante]."' "
                . "AND tipo_solicitud = '".$claves[tipo_solicitud]."' ";
        
        return toba::db('extension')->consultar($sql);
    }

    function get_listado($id_pext = null , $where = null) {
        $sql = "SELECT tipo_solicitud,fecha_solicitud ,estado_solicitud "
                . "FROM solicitud "
                . "WHERE id_pext = $id_pext ";
        if (!is_null($where)) {
            $sql .= "AND $where ";
        }

        $sql .= "ORDER BY tipo_solicitud";
        
        return toba::db('extension')->consultar($sql);
    }

}

?>
