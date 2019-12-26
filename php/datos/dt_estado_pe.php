<?php

class dt_estado_pe extends extension_datos_tabla
{
    function get_descripciones(){
       $sql="select id_estado, descripcion from estado_pe";    
       return toba::db('extension')->consultar($sql);
    }
    
    function get_id($descripcion = null){
        $sql = "SELECT id_estado FROM estado_pe WHERE descripcion='$descripcion'";
        return toba::db('extension')->consultar($sql);
    }


    function get_descripciones_perfil(){
         $perfil = toba::usuario()->get_perfil_datos();
         if ($perfil != null) {
             $sql="select * from estado_pe where id_estado='FORM'";
         }else{
             $sql="select * from estado_pe ";
         }
         return toba::db('extension')->consultar($sql);
    }
    
}
?>
