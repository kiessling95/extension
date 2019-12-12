<?php

class dt_estado_pe extends extension_datos_tabla
{
    function get_descripciones(){
       $sql="select id_estado, descripcion from estado_pe";    
       return toba::db('extension')->consultar($sql);
    }
    function get_descripciones_perfil(){
         $perfil = toba::usuario()->get_perfil_datos();
         if ($perfil != null) {//es de una unidad academica
             $sql="select * from estado_pe where id_estado='I'";//solo retorna Inicial
         }else{
             $sql="select * from estado_pe ";
         }
         return toba::db('extension')->consultar($sql);
    }
    
}
?>
