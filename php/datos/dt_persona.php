<?php
class dt_persona extends extension_datos_tabla {

    function minimo_docum() {
        $sql = "select min(nro_docum) as num from persona";
        $resul = toba::db('extension')->consultar($sql);
        return $resul[0]['num'];
    }

    function existe($tipo, $nro) {
        $sql = "select * from persona"
                . " where tipo_docum='" . $tipo . "'"
                . " and nro_docum=" . $nro;
        $resul = toba::db('extension')->consultar($sql);
        if (count($resul) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_cuil($sexo, $doc) {
        switch ($sexo) {
            case 'F': $xy = 27;
                break;

            case 'M': $xy = 20;
                break;
        }
        $arreglo = array(
            1 => 5,
            2 => 4,
            3 => 3,
            4 => 2,
            5 => 7,
            6 => 6,
            7 => 5,
            8 => 4,
            9 => 3,
            10 => 2,
        );
        $suma = 0;
        $cadena = $xy . $doc;
        $long = strlen($cadena);
        $i = 1;
        while ($i <= $long) {
            $suma = $suma + (substr($cadena, $i, 1) * $arreglo[$i]);
            $i++;
        }
    }

    function get_descripciones() {
        $sql = "SELECT p.*,trim(apellido)||', '||trim(nombre) as descripcion FROM persona p ORDER BY apellido,nombre";
        return toba::db('extension')->consultar($sql);
    }

    //devuelve un listado de todos los docentes y personas (unifica ambas tablas)
    //si esta en la tabla docente y tambien en la tabla persona aparece solo una vez
    function get_descripciones_p($where = null) {
        if (!is_null($where)) {
            $where = ' WHERE ' . $where;
        } else {
            $where = '';
        }
//	    $sql = " select sub.id_persona,max(descripcion) as descripcion from 
//                    (SELECT trim(p.tipo_docum)||p.nro_docum as id_persona,trim(apellido)||', '||trim(nombre)||'('||case when nro_docum<0 then docum_extran else cast(nro_docum as text) end ||')' as descripcion 
//                        FROM persona p
//                    UNION
//                        SELECT trim(d.tipo_docum)||d.nro_docum as id_persona,(trim(apellido)||', '||trim(nombre)||'('||nro_cuil1||'-'||nro_cuil||'-'||nro_cuil2||')' ) as descripcion 
//                        FROM docente d
//                    )sub
//                    $where
//                    group by sub.id_persona
//                    order by descripcion";
//              $sql="select * from (select case when p.nro_docum>0 then calculo_cuil(p.tipo_sexo,p.nro_docum) else docum_extran end as cuil, apellido,nombre,nro_docum,trim(p.apellido)||', '||trim(p.nombre) as agente
//                    from persona p    
//                    UNION
//                    select nro_cuil1||'-'||nro_cuil||'-'||nro_cuil2 as cuil,apellido,nombre,nro_docum,trim(apellido)||', '||trim(nombre) as agente
//                    from docente d         
//                    )sub
//                    $where"
//                    . "order by agente";
        $sql = "select cuil,max(agente) as agente 
                    from (select case when p.nro_docum>0 then calculo_cuil(p.tipo_sexo,p.nro_docum) else docum_extran end as cuil, apellido,nombre,nro_docum,trim(p.apellido)||', '||trim(p.nombre) as agente
                          from persona p 
                          $where
                          UNION
                          select nro_cuil1||'-'||nro_cuil||'-'||nro_cuil2 as cuil,apellido,nombre,nro_docum,trim(apellido)||', '||trim(nombre) as agente
                          from docente d 
                          $where
                       )sub
                    group by cuil
                    order by agente";
        return toba::db('extension')->consultar($sql);
    }

    //metodo utilizado para mostrar las personas
    //ordenado por apellido y nombre
	function get_listado($filtro=array())
	{
		$where = array();
		if (isset($filtro['apellido'])) {
			$where[] = "apellido ILIKE ".quote("%{$filtro['apellido']}%");
		}
		if (isset($filtro['nombre'])) {
			$where[] = "nombre ILIKE ".quote("%{$filtro['nombre']}%");
		}
		if (isset($filtro['nro_docum'])) {
			$where[] = "nro_docum = ".quote($filtro['nro_docum']);
		}
		$sql = "SELECT
			t_p.apellido,
			t_p.nombre,
			t_p.nro_tabla,
			t_p.tipo_docum,
			t_p.nro_docum,
			t_p.tipo_sexo,
			t_p1.nombre as pais_nacim_nombre,
			t_p2.descripcion_pcia as pcia_nacim_nombre,
			t_p.fec_nacim,
			t_t.codc_nivel as titulog_nombre,
			t_t3.codc_nivel as titulop_nombre,
			t_p.docum_extran,
                        t_p.telefono
		FROM
			persona as t_p	
                        LEFT OUTER JOIN (SELECT t_p1.nombre, t_p1.codigo_pais FROM dblink('".$this->dblink_designa()."','SELECT nombre,codigo_pais FROM pais') as t_p1 (nombre CHARACTER VARYING(40), codigo_pais CHARACTER(2))) as t_p1"
                        . "ON (t_p.pais_nacim = t_p1.codigo_pais)"
                        . "LEFT OUTER JOIN (SELECT t_p2.codigo_pcia,t_p2.descripcion_pcia FROM dblink('".$this->dblink_designa()."', 'SELECT codigo_pcia, descripcion_pcia FROM provincia') as t_p2 (codigo_pcia INTEGER,descripcion_pcia CHARACTER(40))) as t_p2"
                        . "ON (t_p.pcia_nacim = t_p2.codigo_pcia)"
                        . "LEFT OUTER JOIN (SELECT t_t.codc_titul,t_t.codc_nivel FROM dblink('".$this->dblink_designa()."','SELECT codc_titul,codc_nivel  FROM titulo') as t_t (codc_titul CHARACTER(4),codc_nivel CHARACTER(4) ) ) as t_t"
                        . " ON (t_p.titulog = t_t.codc_titul) "
                        . "LEFT OUTER JOIN (SELECT t_t3.codc_titul,t_t3.codc_nivel FROM dblink('".$this->dblink_designa()."','SELECT codc_titul,codc_nivel FROM titulo') as t_p3 (codc_titul CHARACTER(4),codc_nivel CHARACTER(4)) ) as t_p3"
                        . " ON (t_p.titulop = t_t3.codc_titul)"
                        
		."ORDER BY nombre";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('extension')->consultar($sql);
	}



    //solo trae las personas cuyo apellido comienza con a
    function get_listado_comienzan_a() {
        $sql = "SELECT
                                        t_p.apellido,
                                        t_p.nombre,
                                        t_p.nro_tabla,
                                        t_p.tipo_docum,
                                        t_p.nro_docum,
                                        case when t_p.tipo_docum='EXTR' then t_p.docum_extran else cast (t_p.nro_docum as text) end as nro_documento,
                                        t_p.tipo_sexo,
                                        t_p1.nombre as pais_nacim_nombre,
                                        t_p2.descripcion_pcia as pcia_nacim_nombre,
                                        t_p.fec_nacim
                                    
                                    FROM persona as t_p"
                                        ." LEFT OUTER JOIN (SELECT t_p1.nombre, t_p1.codigo_pais FROM dblink('".$this->dblink_designa()."','SELECT nombre,codigo_pais FROM pais') as t_p1 (nombre CHARACTER VARYING(40), codigo_pais CHARACTER(2))) as t_p1"
                                        . " ON (t_p.pais_nacim = t_p1.codigo_pais)"
                                        . "LEFT OUTER JOIN (SELECT t_p2.codigo_pcia,t_p2.descripcion_pcia FROM dblink('".$this->dblink_designa()."', 'SELECT codigo_pcia, descripcion_pcia FROM provincia') as t_p2 (codigo_pcia INTEGER,descripcion_pcia CHARACTER(40))) as t_p2"
                                        . " ON (t_p.pcia_nacim = t_p2.codigo_pcia)"
                                        . "where t_p.apellido like 'A%' "
                                    . "ORDER BY apellido,nombre;";
        return toba::db('extension')->consultar($sql);
    }

    function get_datos($tipo, $nro) {
        $sql = "select trim(apellido)||', '||trim(nombre) as nombre from persona"
                . " where tipo_docum='" . $tipo . "'" . " and nro_docum=" . $nro;
        return toba::db('extension')->consultar($sql);
    }

}
?>