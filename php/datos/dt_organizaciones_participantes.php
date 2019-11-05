<?php

class dt_organizaciones_participantes extends extension_datos_tabla 
{
    function get_listado_filtro($id,$filtro = array()) {
    
        //print_r($filtro);        exit();
        $where = array();
		if (isset($filtro)) {
			//$where[] = "tipo ILIKE ".quote("%{$filtro['tipo']}%");
                        $where[]= $filtro;
		}
	//print_r($where);	
        $sql = "SELECT
                    o_p.id_organizacion ,
                    o_p.id_tipo_organizacion ,
                    o_p.id_pext ,
                    o_p.nombre ,
                    o_p.id_localidad ,
                    o_p.telefono ,
                    o_p.email ,
                    o_p.referencia_vinculacion_inst
                    
                FROM
                   organizaciones_participantes as o_p INNER JOIN pextension as p_e ON (o_p.id_pext = p_e.id_pext)
                   LEFT OUTER JOIN localidad as loc ON (o_p.id_localidad = loc.id)
                   LEFT OUTER JOIN tipo_organizacion as t_o ON (o_p.id_tipo_organizacion = t_o.id_tipo_organizacion)"
                   
                ;
        if (count($where)>0) 
        {
            $sql = sql_concatenar_where($sql, $where)
            . "AND o_p.id_pext=" . $id ;
            //print_r($sql);
	}
       
        
        return toba::db('extension')->consultar($sql);
    }
    
    function get_listado($id = null)
    {
        $sql = "SELECT
                    o_p.id_organizacion ,
                    o_p.id_tipo_organizacion ,
                    o_p.id_pext ,
                    o_p.nombre ,
                    o_p.id_localidad ,
                    o_p.telefono ,
                    o_p.email ,
                    o_p.referencia_vinculacion_inst
                    
                FROM
                   organizaciones_participantes as o_p INNER JOIN pextension as p_e ON (o_p.id_pext = p_e.id_pext)
                   LEFT OUTER JOIN localidad as loc ON (o_p.id_localidad = loc.id)
                   LEFT OUTER JOIN tipo_organizacion as t_o ON (o_p.id_tipo_organizacion = t_o.id_tipo_organizacion) 
                   
                WHERE o_p.id_pext = ".$id
                ;
        
        return toba::db('extension')->consultar($sql);
    }
    
   
    
}