<?php

#require_once 'dt_mocovi_periodo_presupuestario.php';
#require_once 'consultas_mapuche.php';

class dt_integrante_interno_pe extends extension_datos_tabla {

    function get_integrante($id_docente = null, $id_pext = null) {
        $sql = "SELECT t_ii.*, t_dc.id_docente "
                . "FROM integrante_interno_pe as t_ii "
                . "INNER JOIN  ( SELECT t_d.* FROM dblink('" . $this->dblink_designa() . "', 'SELECT t_d.id_designacion,t_d.id_docente FROM designacion as t_d ') as t_d ( id_designacion INTEGER,id_docente INTEGER)) as t_d ON (t_ii.id_designacion = t_d.id_designacion) "
                . "LEFT OUTER JOIN (SELECT t_dc.* FROM dblink('" . $this->dblink_designa() . "',
                    'SELECT t_dc.id_docente,t_dc.nombre, t_dc.apellido, t_dc.tipo_docum,t_dc.nro_docum, t_dc.fec_nacim,t_dc.tipo_sexo,t_dc.pais_nacim 
                    FROM docente as t_dc ') as t_dc 
                    ( id_docente INTEGER,nombre CHARACTER VARYING,apellido CHARACTER VARYING,tipo_docum CHARACTER(4) ,nro_docum INTEGER,fec_nacim DATE,tipo_sexo CHARACTER(1),pais_nacim CHARACTER(2)) ) as t_dc ON (t_d.id_docente = t_dc.id_docente) "
                . "WHERE t_dc.id_docente = $id_docente AND id_pext = $id_pext";
        return toba::db('extension')->consultar($sql);
    }

    function get_listado($id_p = null) {
        $sql = "select "
                . "id_pext,"
                . "trim(dc.apellido)||', '||trim(dc.nombre) as nombre,"
                . "t_i.id_designacion,"
                . "dc.tipo_docum,"
                . "dc.nro_docum,"
                . "dc.fec_nacim,"
                . "dc.tipo_sexo,"
                . "dc.pais_nacim,"
                . "f_e.descripcion as funcion_p,"
                . "carga_horaria,"
                . "t_i.desde,"
                . "t_i.hasta,"
                . "rescd,"
                . "tipo,"
                . "ad_honorem "
                . "from integrante_interno_pe as t_i "
                . "LEFT OUTER JOIN funcion_extension as f_e ON (t_i.funcion_p = f_e.id_extension) "
                . "INNER JOIN  ( SELECT d.* FROM dblink('" . $this->dblink_designa() . "', 'SELECT d.id_designacion,d.id_docente FROM designacion as d ') as d ( id_designacion INTEGER,id_docente INTEGER)) as d ON (t_i.id_designacion = d.id_designacion) "
                . "LEFT OUTER JOIN (SELECT dc.* FROM dblink('" . $this->dblink_designa() . "',
                    'SELECT dc.id_docente,dc.nombre, dc.apellido, dc.tipo_docum,dc.nro_docum, dc.fec_nacim,dc.tipo_sexo,dc.pais_nacim 
                    FROM docente as dc ') as dc 
                    ( id_docente INTEGER,nombre CHARACTER VARYING,apellido CHARACTER VARYING,tipo_docum CHARACTER(4) ,nro_docum INTEGER,fec_nacim DATE,tipo_sexo CHARACTER(1),pais_nacim CHARACTER(2)) ) as dc ON (d.id_docente = dc.id_docente)  "
                . "where id_pext=" . $id_p
                . "order by nombre,desde"
        ;
        return toba::db('extension')->consultar($sql);
    }

    function get_fecha($where = array()) {

        if (!is_null($where)) {
            $where = ' WHERE ' . $where;
        } else {
            $where = '';
        }
        $sql = " SELECT t_i.*, trim(apellido)||', '||trim(nombre) as nombre, dc.tipo_docum, dc.nro_docum, dc.tipo_sexo, dc.fec_nacim"
                . " FROM integrante_interno_pe as t_i  "
                . " LEFT OUTER JOIN pextension as p ON (t_i.id_pext = p.id_pext)"
                . "INNER JOIN  ( SELECT d.* FROM dblink('" . $this->dblink_designa() . "', 'SELECT d.id_designacion,d.id_docente FROM designacion as d ') as d ( id_designacion INTEGER,id_docente INTEGER)) as d ON (t_i.id_designacion = d.id_designacion) "
                . " LEFT OUTER JOIN (SELECT dc.* FROM dblink('" . $this->dblink_designa() . "',
                    'SELECT dc.correo_institucional,dc.id_docente,dc.nombre, dc.apellido, dc.tipo_docum,dc.nro_docum, dc.fec_nacim,dc.tipo_sexo,dc.pais_nacim 
                    FROM docente as dc ') as dc 
                    ( correo_institucional CHARACTER(60),id_docente INTEGER,nombre CHARACTER VARYING,apellido CHARACTER VARYING,tipo_docum CHARACTER(4) ,nro_docum INTEGER,fec_nacim DATE,tipo_sexo CHARACTER(1),pais_nacim CHARACTER(2)) ) as dc ON (d.id_docente = dc.id_docente)  "

//                .$where;
        ;
        $sql = sql_concatenar_where($sql, $where)
                . " t_i.hasta = p.fec_hasta";
        return toba::db('extension')->consultar($sql);
    }

    function get_vigentes($filtro = null, $id_pext = null) {

        $vigente = "hasta = 'Vigentes'";

        if (str_word_count($filtro) == 2) {
            $where = " WHERE t_i.hasta >= '" . date('Y-m-d') . "' AND  id_pext = $id_pext ";
        } else {
            $vigente = "hasta = 'No Vigentes'";
            if (str_word_count($filtro) == 3) {
                $where = " WHERE t_i.hasta < '" . date('Y-m-d') . "' AND  id_pext = $id_pext  ";
            } else {
                $where = "WHERE id_pext = $id_pext";
            }
        }

        $sql = "select "
                . "id_pext,"
                . "trim(dc.apellido)||', '||trim(dc.nombre) as nombre,"
                . "t_i.id_designacion,"
                . "dc.tipo_docum,"
                . "dc.nro_docum,"
                . "dc.fec_nacim,"
                . "dc.tipo_sexo,"
                . "dc.pais_nacim,"
                . "f_e.descripcion as funcion_p,"
                . "carga_horaria,"
                . "t_i.desde,"
                . "t_i.hasta,"
                . "rescd,"
                . "tipo,"
                . "ad_honorem "
                . "from integrante_interno_pe as t_i "
                . "LEFT OUTER JOIN funcion_extension as f_e ON (t_i.funcion_p = f_e.id_extension) "
                . "INNER JOIN  ( SELECT d.* FROM dblink('" . $this->dblink_designa() . "', 'SELECT d.id_designacion,d.id_docente FROM designacion as d ') as d ( id_designacion INTEGER,id_docente INTEGER)) as d ON (t_i.id_designacion = d.id_designacion) "
                . "LEFT OUTER JOIN (SELECT dc.* FROM dblink('" . $this->dblink_designa() . "',
                    'SELECT dc.id_docente,dc.nombre, dc.apellido, dc.tipo_docum,dc.nro_docum, dc.fec_nacim,dc.tipo_sexo,dc.pais_nacim 
                    FROM docente as dc ') as dc 
                    ( id_docente INTEGER,nombre CHARACTER VARYING,apellido CHARACTER VARYING,tipo_docum CHARACTER(4) ,nro_docum INTEGER,fec_nacim DATE,tipo_sexo CHARACTER(1),pais_nacim CHARACTER(2)) ) as dc ON (d.id_docente = dc.id_docente)  "
                . $where
                . "order by nombre,desde";
        return toba::db('extension')->consultar($sql);
    }

    function get_director($id_p = null) {
        $sql = "select "
                . "id_pext,"
                . "trim(dc.apellido)||', '||trim(dc.nombre) as nombre,"
                . "t_i.id_designacion,"
                . "dc.tipo_docum,"
                . "dc.nro_docum,"
                . "dc.fec_nacim,"
                . "dc.tipo_sexo,"
                . "dc.pais_nacim,"
                . "f_e.descripcion as funcion_p,"
                . "carga_horaria,"
                . "t_i.desde,"
                . "t_i.hasta,"
                . "rescd,"
                . "tipo,"
                . "t_i.ua,"
                . "ad_honorem,"
                . "dc.correo_institucional "
                . "from integrante_interno_pe as t_i "
                . "LEFT OUTER JOIN funcion_extension as f_e ON (t_i.funcion_p = f_e.id_extension) "
                . "INNER JOIN  ( SELECT d.* FROM dblink('" . $this->dblink_designa() . "', 'SELECT d.id_designacion,d.id_docente FROM designacion as d ') as d ( id_designacion INTEGER,id_docente INTEGER)) as d ON (t_i.id_designacion = d.id_designacion) "
                . "LEFT OUTER JOIN (SELECT dc.* FROM dblink('" . $this->dblink_designa() . "',
                    'SELECT dc.correo_institucional,dc.id_docente,dc.nombre, dc.apellido, dc.tipo_docum,dc.nro_docum, dc.fec_nacim,dc.tipo_sexo,dc.pais_nacim 
                    FROM docente as dc ') as dc 
                    ( correo_institucional CHARACTER(60),id_docente INTEGER,nombre CHARACTER VARYING,apellido CHARACTER VARYING,tipo_docum CHARACTER(4) ,nro_docum INTEGER,fec_nacim DATE,tipo_sexo CHARACTER(1),pais_nacim CHARACTER(2)) ) as dc ON (d.id_docente = dc.id_docente)  "
                . "where id_pext=" . $id_p . " AND funcion_p='D' "
                . "order by nombre,desde"
        ;
        return toba::db('extension')->consultar($sql);
    }

    function get_co_director($id_p = null) {
        $sql = "select "
                . "id_pext,"
                . "trim(dc.apellido)||', '||trim(dc.nombre) as nombre,"
                . "t_i.id_designacion,"
                . "dc.tipo_docum,"
                . "dc.nro_docum,"
                . "dc.fec_nacim,"
                . "dc.tipo_sexo,"
                . "dc.pais_nacim,"
                . "f_e.descripcion as funcion_p,"
                . "carga_horaria,"
                . "t_i.desde,"
                . "t_i.hasta,"
                . "rescd,"
                . "tipo,"
                . "t_i.ua,"
                . "ad_honorem, "
                . "dc.correo_institucional "
                . "from integrante_interno_pe as t_i "
                . "LEFT OUTER JOIN funcion_extension as f_e ON (t_i.funcion_p = f_e.id_extension) "
                . "INNER JOIN  ( SELECT d.* FROM dblink('" . $this->dblink_designa() . "', 'SELECT d.id_designacion,d.id_docente FROM designacion as d ') as d ( id_designacion INTEGER,id_docente INTEGER)) as d ON (t_i.id_designacion = d.id_designacion) "
                . "LEFT OUTER JOIN (SELECT dc.* FROM dblink('" . $this->dblink_designa() . "',
                    'SELECT dc.correo_institucional,dc.id_docente,dc.nombre, dc.apellido, dc.tipo_docum,dc.nro_docum, dc.fec_nacim,dc.tipo_sexo,dc.pais_nacim 
                    FROM docente as dc ') as dc 
                    ( correo_institucional CHARACTER(60),id_docente INTEGER,nombre CHARACTER VARYING,apellido CHARACTER VARYING,tipo_docum CHARACTER(4) ,nro_docum INTEGER,fec_nacim DATE,tipo_sexo CHARACTER(1),pais_nacim CHARACTER(2)) ) as dc ON (d.id_docente = dc.id_docente)  "
                . "where id_pext=" . $id_p . " AND funcion_p='CD-Co' "
                . "order by nombre,desde"
        ;
        return toba::db('extension')->consultar($sql);
    }

    //recibe el id_docente
    function sus_proyectos_ext($id_doc) {

        $sql = "select t_s.id_designacion||'-'||t_s.cat_estat||t_s.dedic||t_s.carac||'-'||t_i.ua||'('||to_char(t_s.desde,'dd/mm/YYYY')||'-'||case when t_s.hasta is null then '' else to_char(t_s.hasta,'dd/mm/YYYY') end  ||')' as desig,t_s.id_designacion,t_p.denominacion,t_p.codigo,t_p.nro_resol,t_p.fecha_resol,t_i.funcion_p,t_i.carga_horaria,t_i.ua,t_i.desde,t_i.hasta,t_i.rescd,t_i.ad_honorem,t_s.cat_mapuche,t_s.carac  "
                . " from integrante_interno_pe t_i "
                . "LEFT OUTER JOIN pextension t_p ON (t_i.id_pext=t_p.id_pext)"
                . " LEFT OUTER JOIN designacion t_s ON (t_i.id_designacion=t_s.id_designacion) "
                . " where  "
                . " t_s.id_docente=" . $id_doc
                . " order by id_designacion,desde";
        return toba::db('extension')->consultar($sql);
    }

    function get_participantes($filtro = array()) {
        $where = " WHERE ";
        if (isset($filtro['uni_acad']['valor'])) {
            if (trim($filtro['uni_acad']['valor']) == 'ASMA') {//el usuario de ASMA puede ver los proyectos de FACA
                $where .= "  (uni_acad = " . quote($filtro['uni_acad']['valor']) . " or uni_acad = 'FACA')";
            } else {
                $where .= "  uni_acad = " . quote($filtro['uni_acad']['valor']);
            }
        }

        if (isset($filtro['anio']['valor'])) {
            $pdia = dt_mocovi_periodo_presupuestario::primer_dia_periodo_anio($filtro['anio']['valor']);
            $udia = dt_mocovi_periodo_presupuestario::ultimo_dia_periodo_anio($filtro['anio']['valor']);
            $where .= " and fec_desde <='" . $udia . "' and (fec_hasta>='" . $pdia . "' or fec_hasta is null)";
        }
        if (isset($filtro['funcion_p']['valor'])) {
            $where .= " and funcion_p=" . quote($filtro['funcion_p']['valor']);
        }
        //||d.uni_acad as designacion
        //el nombre de las columnas nunca igual al nombre de alguna tabla!!!
        //
        $sql = "select * from ("
                . " select trim(t_do.apellido)||', '||trim(t_do.nombre) as agente,t_do.legajo,t_i.uni_acad,t_i.codigo,t_i.denominacion,t_i.fec_desde,t_i.fec_hasta, i.desde ,i.hasta,i.funcion_p,f.descripcion as funcion,i.carga_horaria,i.rescd,d.cat_estat||d.dedic||'-'||d.carac||'('|| extract(year from d.desde)||'-'||case when (extract (year from case when d.hasta is null then '1800-01-11' else d.hasta end) )=1800 then '' else cast (extract (year from d.hasta) as text) end||')'||d.uni_acad as desig"
                . " from integrante_interno_pe i, docente t_do ,pextension t_i,designacion d, funcion_extension f "
                . " WHERE i.id_designacion=d.id_designacion "
                . " and d.id_docente=t_do.id_docente
                    and t_i.id_pext =i.id_pext
                    and i.funcion_p=f.id_extension
                    order by denominacion,apellido,nombre
                    ) b 
                $where";
        //$sql="select * from integrante_interno_pe";
        return toba::db('extension')->consultar($sql);
    }

    function tiene_cv($datos = array()) {
        $sql = "select case when cv is not null then 1 else 0 end as tiene from integrante_interno_pe where id_pext =" .$datos['id_pext']." AND desde='" .$datos['desde']."'  AND id_designacion=" .$datos['id_designacion'];
        $res = toba::db('extension')->consultar($sql);
        return $res[0]['tiene'];
    }

}

?>