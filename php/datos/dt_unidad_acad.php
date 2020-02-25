<?php

class dt_unidad_acad extends extension_datos_tabla {

    //trae todas las dependencias 
    function get_descripciones() {
        
        $sql = "SELECT ua.sigla,ua.descripcion FROM dblink('".$this->dblink_designa()."','SELECT sigla,descripcion FROM unidad_acad') as ua (sigla CHARACTER(5),descripcion CHARACTER(60) )"
                . "ORDER BY ua.descripcion";
        return toba::db('extension')->consultar($sql);
    }
    
   
    function get_descripcion($sigla) {
        
        $sql = "select descripcion from unidad_acad where sigla='" . $sigla . "'";
        $resul = toba::db('extension')->consultar($sql);
        if (count($resul) > 0) {
            return trim($resul[0]['descripcion']);
        } else {
            return '';
        }
    }

    function get_ua_dependencia() {//trae todas menos la UA asociada al usuario logueado, para las ua dependencia de los proyectos 
        
        $perfil = toba::usuario()->get_perfil_datos();
        if (isset($perfil)) {       //es usuario de la UA
            $sql = "SELECT ua.sigla,ua.descripcion FROM dblink('".$this->dblink_designa()."','SELECT sigla,descripcion FROM unidad_acad') as ua (sigla CHARACTER(5),descripcion CHARACTER(60) )";
            $sql = toba::perfil_de_datos()->filtrar($sql);
            $resul = toba::db('extension')->consultar($sql);
            
            $sql = "select * FROM dblink('".$this->dblink_designa()."','SELECT sigla,descripcion FROM unidad_acad') as ua (sigla CHARACTER(5),descripcion CHARACTER(60) ) WHERE sigla<>'AUZA' and sigla<>'ASMA' and sigla<>'" . $resul[0]['sigla'] . "'";
        } else {
            $sql = "SELECT * FROM dblink('".$this->dblink_designa()."','SELECT sigla,descripcion FROM unidad_acad') as ua (sigla CHARACTER(5),descripcion CHARACTER(60) )";
        }
        return toba::db('extension')->consultar($sql);
    }

    function get_descripciones_ua($id_des = null) {

        if (!is_null($id_des)) {
            $where = " LEFT JOIN unidad_acad t_u ON (t_d.uni_acad=t_u.sigla) WHERE t_d.id_designacion= " . $id_des;
        } else {
            $where = '';
        }
        $sql = "SELECT t_d.uni_acad as sigla FROM designacion t_d $where ORDER BY descripcion";
        return toba::db('extension')->consultar($sql);
    }

    //filtra por dependencia
    function get_ua() {
        
        //primero veo si esta asociado a un perfil de datos departamento y obtengo la ua del departamento
        $sql = "SELECT d.iddepto,d.idunidad_academica FROM dblink('".$this->dblink_designa()."','SELECT iddepto,idunidad_academica FROM departamento') as d (iddepto INTEGER, idunidad_academica CHARACTER(5))";
        
        $sql = toba::perfil_de_datos()->filtrar($sql);

        $perfil = toba::perfil_de_datos('designa')->get_restricciones_dimension('designa','unidad_acad');
  
        #$resul = toba::db('extension')->consultar($sql);

        if (count($perfil) == 1) {//si solo tiene un registro entonces esta asociado a un perfil de datos departamento
            $condicion = " WHERE sigla='" . $perfil[0] . "'";
        } else {
            $condicion = "";
        }
        
        $sql = "SELECT ua.sigla,ua.descripcion FROM (SELECT ua.sigla,ua.descripcion FROM dblink('".$this->dblink_designa()."','SELECT sigla,descripcion FROM unidad_acad ') as ua (sigla CHARACTER(5),descripcion CHARACTER(60) )) as ua $condicion"
                . "ORDER BY ua.descripcion";
        $sql = toba::perfil_de_datos()->filtrar($sql);
        $resul = toba::db('extension')->consultar($sql);
        
        return $resul;
    }

    function get_ua_departamentos() {//es para el filtro de asignacion materias.El director de departamento no filtra por UA
        
        $sql = "SELECT ua.sigla,ua.descripcion FROM dblink('".$this->dblink_designa()."','SELECT sigla,descripcion FROM unidad_acad') as ua (sigla CHARACTER(5),descripcion CHARACTER(60) )";
        $sql = toba::perfil_de_datos()->filtrar($sql);
        $resul = toba::db('extension')->consultar($sql);
        return $resul;
    }

    //credito docente del periodo actual para una UA alguien usa esta funcion?
    //sino la usan sacar?
    function credito($ua) {
        $sql = "select sum(b.credito) as cred "
                . " from mocovi_credito b, mocovi_periodo_presupuestario c"
                . " where  "
                . " b.id_periodo=c.id_periodo"
                . " and b.id_escalafon='D'"
                . " and c.actual "
                . " and b.id_unidad =trim(upper('" . $ua . "'))";

        $resul = toba::db('extension')->consultar($sql);

        if ($resul[0]['cred'] <> null) {
            $tengo = $resul[0]['cred'];
        } else {
            $tengo = 0;
        }
        return $tengo;
    }

    //credito docente x año y UA
    //sino la usan sacar
    function credito_x_anio($ua, $anio) {
        $sql = "select sum(b.credito) as cred "
                . "from  mocovi_credito b, mocovi_periodo_presupuestario c"
                . " where "
                . " b.id_periodo=c.id_periodo"
                . " and b.id_escalafon='D'"
                . " and c.anio=" . $anio
                . " and a.id_unidad =trim(upper('" . $ua . "'))";

        $resul = toba::db('extension')->consultar($sql);

        if ($resul[0]['cred'] <> null) {
            $tengo = $resul[0]['cred'];
        } else {
            $tengo = 0;
        }
        return $tengo;
    }

}

?>