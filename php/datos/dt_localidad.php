<?php


class dt_localidad extends extension_datos_tabla 
{
    function get_descripciones($id_prov)
    {
        $sql = " SELECT 
            
                    id ,
                    id_provincia
                    localidad
                    
                FROM localidad  
                
                WHERE id_provincia = ".$id_prov;
        return toba::db('extension')->consultar($sql);
    }
}
