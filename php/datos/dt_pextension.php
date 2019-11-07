<?php

class dt_pextension extends extension_datos_tabla {

    function get_datos($filtro = array() ) {
        $where = array();
        if (isset($filtro['uni_acad'])) {
            $where[] = "t_p.uni_acad = " . quote($filtro['uni_acad']);
            $where[] = "t_p.id_pext = " . quote($filtro['id_pext']);
        }
        $sql = "SELECT
			t_p.id_pext,
                        t_p.codigo,
                        t_p.denominacion,
                        t_p.nro_resol,
                        t_p.fecha_resol,
                        t_ua.descripcion as uni_acad_nombre,
                        t_p.fec_desde,
                        t_p.fec_hasta,
                        t_p.nro_ord_cs,
                        t_p.res_rect,
                        t_p.expediente,
                        t_p.duracion,
                        t_p.palabras_clave,
                        t_p.objetivo,
                        t_p.estado,
                        t_p.financiacion,
                        t_p.monto,
                        t_p.fecha_rendicion,
                        t_p.rendicion_monto,
                        t_p.fecha_prorroga1,
                        t_p.fecha_prorroga2,
                        t_p.observacion,
                        t_p.estado_informe_a,
                        t_p.estado_informe_f,
                        t_p.uni_acad,
                        d.apellido || ' '|| d.nombre as director,
                        t_p.eje_tematico,
                        t_p.descripcion_situacion,
                        t_p.caracterizacion_poblacion,
                        t_p.localizacion_geo,
                        t_p.antecedente_participacion,
                        t_p.importancia_necesidad,
                        b_c.id_bases,
                        t_c.id_conv,
                        t_p.responsable_carga
                    FROM
                        pextension as t_p INNER JOIN (SELECT t_ua.* FROM dblink('".$this->dblink_designa()."','SELECT sigla,descripcion FROM unidad_acad ') as t_ua (sigla CHARACTER(5), descripcion CHARACTER(60)  )) as t_ua ON (t_p.uni_acad = t_ua.sigla)
                        LEFT OUTER JOIN integrante_interno_pe as i ON (t_p.id_pext = i.id_pext AND i.funcion_p='D')
                        LEFT OUTER JOIN (SELECT d.* FROM  dblink('".$this->dblink_designa()."', 
                                    'SELECT d.id_designacion, dc.id_docente , dc.apellido, dc.nombre 
                                     FROM designacion as d LEFT OUTER JOIN docente as dc 
                                            ON(dc.id_docente = d.id_docente)') as d 
                                            ( id_designacion INTEGER ,id_docente INTEGER ,apellido CHARACTER VARYING, nombre CHARACTER VARYING)) as d ON (i.id_designacion=d.id_designacion)
                        LEFT OUTER JOIN bases_convocatoria as b_c ON (b_c.id_bases = t_p.id_bases)
                        LEFT OUTER JOIN tipo_convocatoria as t_c ON (t_c.id_conv = b_c.tipo_convocatoria)
                        
                    ORDER BY codigo";
        if (count($where) > 0) {
            $sql = sql_concatenar_where($sql, $where);
        }
        return toba::db('extension')->consultar($sql);
    }

    function get_listado($where = null) {
        $this->s__perfil = toba::manejador_sesiones()->get_perfiles_funcionales();

        
        if (!is_null($where)) {
            $where = ' WHERE ' . $where;
        } else {
            $where = '';
        }
        $usr = toba::manejador_sesiones()->get_id_usuario_instancia();
        
        $p = array_search('formulador', $this->s__perfil);
        if($p !== false){ 
            $where = $where . "AND responsable_carga= '".$usr. "' ";
        }
        
        
        $sql = "SELECT
                        t_p.id_pext,
                        t_p.codigo,
                        t_c.descripcion,
                        dc.apellido || ' '|| dc.nombre as director,
                        t_p.denominacion,
                        t_p.nro_resol,
                        t_p.fecha_resol,
                        t_p.uni_acad,
                        t_p.fec_desde,
                        t_p.fec_hasta                 
                    FROM
                        pextension as t_p INNER JOIN
                        (SELECT t_ua.* FROM dblink('".$this->dblink_designa()."','SELECT sigla FROM unidad_acad ') as t_ua (sigla CHARACTER(5) )) as t_ua ON (t_p.uni_acad = t_ua.sigla)
                        LEFT OUTER JOIN integrante_interno_pe as i ON (t_p.id_pext = i.id_pext AND i.funcion_p='D')
                        LEFT OUTER JOIN ( SELECT d.* FROM dblink('".$this->dblink_designa()."', 'SELECT d.id_designacion,d.id_docente FROM designacion as d ') as d ( id_designacion INTEGER,id_docente INTEGER)) as d ON (i.id_designacion = d.id_designacion)
                        LEFT OUTER JOIN ( SELECT dc.* FROM dblink('".$this->dblink_designa()."', 'SELECT dc.id_docente,dc.nombre, dc.apellido FROM docente as dc ') as dc ( id_docente INTEGER,apellido CHARACTER VARYING, nombre CHARACTER VARYING)) as dc ON (d.id_docente = dc.id_docente)
                        LEFT OUTER JOIN bases_convocatoria as b_c ON (b_c.id_bases = t_p.id_bases)
                        LEFT OUTER JOIN tipo_convocatoria as t_c ON (t_c.id_conv = b_c.tipo_convocatoria)"
                    .$where
                    ." ORDER BY codigo";
        $sql = toba::perfil_de_datos()->filtrar($sql);

        // buscar usuario y rol
        //si rol formulador agrego al filtro que solo muestre los proyectos que el formulo 
        
        return toba::db('extension')->consultar($sql);
    }


}

?>