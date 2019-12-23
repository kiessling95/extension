<?php

class dt_destinatarios extends extension_datos_tabla {
    
    function get_listado ($id_pext = null){
        $sql = "SELECT "
                . "d.id_destinatario, "
                . "d.id_pext, "
                . "d.domicilio, "
                . "d.telefono, "
                . "d.email, "
                . "d.contacto "
                . "FROM destinatarios as d "
                . "WHERE d.id_pext = $id_pext ";
        return toba::db('extension')->consultar($sql);
    }
}

?>
