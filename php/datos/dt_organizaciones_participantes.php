<?php

class dt_organizaciones_participantes extends extension_datos_tabla {

    function get_listado_filtro($id, $filtro = array()) {

        $where = array();
        if (isset($filtro)) {
            $where[] = $filtro;
        }
        $sql = "SELECT
                    o_p.id_organizacion ,
                    o_p.id_tipo_organizacion ,
                    o_p.id_pext ,
                    o_p.nombre ,
                    o_p.id_localidad ,
                    o_p.telefono ,
                    o_p.email ,
                    o_p.referencia_vinculacion_inst,
                    o_p.id_pais,
                    o_p.id_provincia,
                    o_p.domicilio,
                    o_p.aval
                    
                FROM
                   organizaciones_participantes as o_p INNER JOIN pextension as p_e ON (o_p.id_pext = p_e.id_pext)"
                . "LEFT OUTER JOIN (SELECT l.id,l.localidad FROM dblink('" . $this->dblink_designa() . "','SELECT id,localidad  FROM localidad') as l (id INTEGER, localidad CHARACTER VARYING(255) )) as l"
                . " ON (o_p.id_localidad = l.id AND o_p.localidad = l.localidad)
                   LEFT OUTER JOIN tipo_organizacion as t_o ON (o_p.id_tipo_organizacion = t_o.id_tipo_organizacion)
                    where o_p.localidad = l.localidad"

        ;
        if (count($where) > 0) {
            $sql = sql_concatenar_where($sql, $where)
                    . "AND o_p.id_pext=" . $id;
        }
        return toba::db('extension')->consultar($sql);
    }

    function get_listado($id = null) {
        $sql = "SELECT
                    o_p.id_organizacion ,
                    o_p.id_tipo_organizacion ,
                    o_p.id_pext ,
                    o_p.nombre ,
                    trim(localidad) as localidad  ,
                    o_p.telefono ,
                    o_p.email ,
                    o_p.referencia_vinculacion_inst,
                    trim(codigo_pais) as pais ,
                    trim(descripcion_pcia) as provincia ,
                    o_p.domicilio,
                    o_p.aval
                    
                FROM "
                . " organizaciones_participantes as o_p INNER JOIN pextension as p_e ON (o_p.id_pext = p_e.id_pext)"
                . " LEFT OUTER JOIN (SELECT l.id,l.localidad FROM dblink('" . $this->dblink_designa() . "','SELECT id, localidad  FROM localidad') as l (id INTEGER , localidad CHARACTER VARYING(255))) as l"
                . " ON (o_p.id_localidad = l.id)"
                . " LEFT OUTER JOIN tipo_organizacion as t_o ON (o_p.id_tipo_organizacion = t_o.id_tipo_organizacion)
                    LEFT OUTER JOIN (SELECT p.codigo_pais,p.nombre FROM dblink('" . $this->dblink_designa() . "','SELECT codigo_pais, nombre  FROM pais') as p (codigo_pais CHARACTER(2) , nombre CHARACTER VARYING(40))) as p"
                . " ON (o_p.id_pais = p.codigo_pais)
                    LEFT OUTER JOIN (SELECT pcia.codigo_pcia,pcia.descripcion_pcia FROM dblink('" . $this->dblink_designa() . "','SELECT codigo_pcia, descripcion_pcia  FROM provincia') as pcia (codigo_pcia INTEGER , descripcion_pcia CHARACTER (40))) as pcia"
                . " ON (o_p.id_provincia = pcia.codigo_pcia)
                   
                WHERE o_p.id_pext = " . $id;

        return toba::db('extension')->consultar($sql);
    }

    function get_organizacion($id_organizacion = null) {
        $sql = "SELECT
                    o_p.*
                FROM "
                . " organizaciones_participantes as o_p "
                . " WHERE o_p.id_organizacion = " . $id_organizacion;
        return toba::db('extension')->consultar($sql);
    }
    
    function tiene_aval($id_organizacion = null){
        $sql="select case when aval is not null then 1 else 0 end as tiene from organizaciones_participantes where id_organizacion=$id_organizacion";
        $res=toba::db('extension')->consultar($sql); 
        return $res[0]['tiene'];
    }

}
