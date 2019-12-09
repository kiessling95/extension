<?php

#require_once 'dt_mocovi_periodo_presupuestario.php';
#require_once 'consultas_mapuche.php';

class dt_designacion extends extension_datos_tabla {

    function get_uni_acad($id_desig) {
        $sql = "select uni_acad from designacion where id_designacion=" . $id_desig;
        $resul = toba::db('extension')->consultar($sql);
        return $resul[0]['uni_acad'];
    }

    function get_designaciones($where = null) {

        if (!is_null($where)) {
            $where = ' WHERE ' . $where;
        } else {
            $where = '';
        }

        $sql = "select a.id_designacion,case when a.id_docente is null then 'RESERVA: '||c.descripcion else trim(b.apellido)||', '||trim(b.nombre) end as agente,b.legajo,a.nro_540,a.uni_acad,a.cat_estat||a.dedic as cat_estat,a.cat_mapuche,a.carac,a.desde,a.hasta "
                . " from designacion a"
                . " LEFT OUTER JOIN docente b ON (a.id_docente=b.id_docente)"
                . "  LEFT OUTER JOIN reserva c ON (a.id_reserva=c.id_reserva)"
                . " $where"
                . " order by agente";
        return toba::db('extension')->consultar($sql);
    }

    function get_ua($id_des) {

        $sql= "SELECT t_d.uni_acad FROM "
                . "( SELECT t_d.* FROM dblink ('".$this->dblink_designa()."', '
                    SELECT t_d.id_designacion, t_d.uni_acad 
                    FROM designacion as t_d 
                    WHERE id_designacion=" . $id_des." ') as t_d ( id_designacion INTEGER, uni_acad CHARACTER(5))) as t_d"; 
        $res = toba::db('extension')->consultar($sql);

        return $res[0]['uni_acad'];
    }

    function get_docente($id_d) {
        $sql = "select * from designacion where id_designacion=" . $id_d;
        $res = toba::db('extension')->consultar($sql);
        return $res[0]['id_docente'];
    }



    function get_categorias_doc($id_doc = null) {
        //excluyo las designaciones que estan anuladas
        if (!is_null($id_doc)) {
            $where = ' WHERE id_docente= ' . $id_doc;
            $sql = $sql = "SELECT t_d.id_designacion,(t_d.id_designacion||'-'||t_d.cat_estat||t_d.dedic||'-'||t_d.carac||'('||extract(year from t_d.desde)||'-'||case when (extract (year from case when t_d.hasta is null then '1800-01-11' else t_d.hasta end) )=1800 then '' else cast (extract (year from t_d.hasta) as text) end||')'||t_d.uni_acad )as categoria  
                            FROM 
                            ( SELECT t_d.* FROM dblink ('".$this->dblink_designa()."', '
                                                        SELECT t_d.id_designacion,
                                                                t_d.cat_estat,
                                                                t_d.dedic,
                                                                t_d.carac,
                                                                t_d.desde,
                                                                t_d.hasta,
                                                                t_d.uni_acad
                                                                FROM designacion as t_d, unidad_acad t_u"  
                                                                .$where. " AND NOT (t_d.hasta is not null AND t_d.hasta<=t_d.desde) AND (extract(year from hasta)+1)>= extract(year from current_date) AND t_d.uni_acad=t_u.sigla
                                                                ORDER BY t_d.uni_acad,t_d.desde ') as t_d ( id_designacion INTEGER ,cat_estat CHARACTER VARYING, dedic INTEGER, carac CHARACTER(1), desde DATE, hasta DATE, uni_acad CHARACTER(5))) as t_d";
                                                        //print_r($sql); exit();
            $res = toba::db('extension')->consultar($sql);
        } else {
            $res = array();
        }
        return $res;
    }

}

?>