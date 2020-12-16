<?php

class consultas {
    
    static function get_observaciones_existentes($id_pext) {
        $schema_public = toba::db('extension')->get_schema(). '_auditoria';
        $sql = "SELECT id_pext, auditoria_fecha, auditoria_usuario, observacion_ua FROM $schema_public.logs_seguimiento_ua "
                . "WHERE id_pext = $id_pext AND observacion_ua <> ''";
		return toba::db('extension')->consultar($sql);
    }
    
    
}

?>
