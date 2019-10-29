<?php

class dt_tipo_organizacion_participante extends extension_datos_tabla 
{
    function get_listado()
    {
        $sql = "SELECT 
                    id_tipo_organizacion, 
                    descripcion 
                    
                FROM tipo_organizacion
                
                ORDER BY descripcion";
        
        return toba::db('extension')->consultar($sql);
                
    }
    
    function get_tipo_org()
    {
        $sql = "SELECT id_tipo_organizacion, descripcion
            FROM tipo_organizacion
            ORDER BY descripcion";
		return toba::db('extension')->consultar($sql);
               
    }
}
