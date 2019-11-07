<?php
class dt_departamento extends toba_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT iddepto, descripcion FROM departamento ORDER BY descripcion";
		return toba::db('extension')->consultar($sql);
	}
        //trae todos los departamentos menos los que se cargaron como SIN DEPARTAMENTO
        function get_descrip()
	{
		$sql = "SELECT iddepto, d.descripcion||' de: '||u.sigla as descripcion FROM departamento d"
                        . " LEFT OUTER JOIN unidad_acad u ON (d.idunidad_academica=u.sigla)"
                        . " WHERE not (d.descripcion like 'SIN%')"
                        . " ORDER BY descripcion";
		return toba::db('extension')->consultar($sql);
	}
        function get_descripcion($id_depto){//retorna la descripcion de un departamento
            $sql="select descripcion from departamento where iddepto=".$id_depto;
            $res = toba::db('extension')->consultar($sql);
            return $res[0]['descripcion'];
        }
        function get_departamentos($id_ua=null)
	{//si recibe parametro entonces filtra por la ua que recibe
            //print_r($id_ua);

            if(isset($id_ua)){
              $where=" and idunidad_academica='".$id_ua."'";  
             }
             
             $sql = "SELECT DISTINCT t_d.iddepto, t_d.descripcion, t_d.idunidad_academica ||'('||t_d.sigla||')' as descripcion "
                     . "FROM dblink('user= postgres password= postgres dbname= designa',"
                     . "'SELECT t_d.iddepto,t_d.descripcion,t_u.sigla, t_d.idunidad_academica "
                     . "FROM departamento as t_d, unidad_acad as t_u') as t_d (iddepto INTEGER, descripcion CHARACTER VARYING, sigla CHARACTER(5), idunidad_academica CHARACTER(5)) "
                     . "WHERE t_d.sigla=t_d.idunidad_academica and idunidad_academica='ASMA'";
             
             
//            $sql = "SELECT distinct t_d.iddepto, t_d.descripcion ||'('||t_u.sigla||')' as descripcion "
//                        . " FROM departamento t_d,"
//                        . " unidad_acad t_u "
//                        . " WHERE t_u.sigla=t_d.idunidad_academica"
//                        . "  $where"
//                        . " order by descripcion";
            
                //obtengo el perfil de datos del usuario logueado
            $con="SELECT ua.sigla,ua.descripcion FROM dblink('".$this->dblink_designa()."','SELECT sigla,descripcion FROM unidad_acad ') as ua (sigla CHARACTER(5),descripcion CHARACTER(60) )";
            
            $con = toba::perfil_de_datos()->filtrar($con);
            
            $resul=toba::db('extension')->consultar($con);
         
            $unidades=array('FAIF','FATU','FACE','FAEA','ASMA','FAHU','FATA','FAAS','CUZA','FADE','FACA','FALE','FAME','AUZA','FAIN','ESCM','CRUB');
            if( in_array (trim($resul[0]['sigla']),$unidades)){
              if((trim($resul[0]['sigla'])<>'FAHU') && (trim($resul[0]['sigla'])<>'AUZA') && (trim($resul[0]['sigla'])<>'ESCM')&& (trim($resul[0]['sigla'])<>'CRUB') && (trim($resul[0]['sigla'])<>'FACA') && (trim($resul[0]['sigla'])<>'ASMA') && (trim($resul[0]['sigla'])<>'CUZA')&& (trim($resul[0]['sigla'])<>'FAAS')){
                    $sql = toba::perfil_de_datos()->filtrar($sql);//aplico el perfil para que solo aparezcan los departamentos de su facultad
                }  
            }else{//perfil de datos de departamento
                $sql = toba::perfil_de_datos()->filtrar($sql);
            }                 
            
	    $resul = toba::db('extension')->consultar($sql);
            return $resul;
        }
	function get_listado($filtro=array())
	{
            
		$where = array();
		if (isset($filtro['iddepto'])) {
			$where[] = "iddepto = ".quote($filtro['iddepto']);
		}
//                $sql = "SELECT "
//                . "t_d.iddepto,"
//                . "t_d.idunidad_academica_nombre,"
//                . "t_d.descripcion"
//                
//                . "FROM "
//                . "(SELECT t_d.* "
//                . "FROM dblink('".$this->dblink_designa()."',"
//                . "'SELECT t_d.iddepto,t_d.descripcion,t_d.idunidad_academica "
//                . "FROM departamento departamento as t_d,
//			unidad_acad as t_ua
//		WHERE
//				t_d.idunidad_academica = t_ua.sigla
//		ORDER BY descripcion ') as t_d ( iddepto INTEGER,descripcion CHARACTER VARYING,idunidad_academica CHARACTER(5)) ) as t_d "

                
                
                
		$sql = "SELECT
			t_d.iddepto,
			t_ua.descripcion as idunidad_academica_nombre,
			t_d.descripcion
		FROM
			departamento as t_d,
			unidad_acad as t_ua
		WHERE
				t_d.idunidad_academica = t_ua.sigla
		ORDER BY descripcion";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('extension')->consultar($sql);
	}

        function get_listado_filtro($where=null)
        {
            if(!is_null($where)){
                    $where=' WHERE '.$where;
                }else{
                    $where='';
                }
            $sql="select sub.*, trim(doc.apellido)||', '||trim(doc.nombre) as director from "
                    . " (select d.*,max(di.desde) as desde from departamento d "
                    . " LEFT OUTER JOIN director_dpto di ON (d.iddepto=di.iddepto)"
                    . $where
                    ." group by d.iddepto,d.idunidad_academica,d.descripcion)sub "
                    . " LEFT OUTER JOIN director_dpto dr ON (dr.iddepto=sub.iddepto and sub.desde=dr.desde )"
                    . " LEFT OUTER JOIN docente doc ON (doc.id_docente=dr.id_docente)"
                    . "order by sub.descripcion"; 
            
            return toba::db('extension')->consultar($sql);
        }
        //retorna true si el departamento que ingresa como parametro tiene areas y false en caso contrario
        function tiene_areas($id_dpto){
            $sql = "select * from area where iddepto=".$id_dpto;  
            $res = toba::db('extension')->consultar($sql);
            if(count($res)>0){
                return true;
            }else{
                return false;
            }
        }
        function get_listado_completo($where=null){
            if(!is_null($where)){
                $where=' WHERE '.$where;
                }else{
                    $where='';
                }
                
            $sql="select distinct a.descripcion as departamento,b.descripcion as area,c.descripcion as orientacion"
                    . " from (select * from departamento".$where.")a "
                    ." LEFT OUTER JOIN area b ON (a.iddepto=b.iddepto)"
                    . "LEFT OUTER JOIN orientacion c ON (b.idarea=c.idarea)"
                    . " order by a.descripcion,b.descripcion,c.descripcion";
            
            $sql2=" CREATE LOCAL TEMP TABLE auxi(
                        departamento character(100),
                        area character(100),
                        orientacion character(100)
                    );";
            toba::db('extension')->consultar($sql2);
            $res=toba::db('extension')->consultar($sql);
           
            $i=1;
            $dep=$res[0]['departamento'];
            $area=$res[0]['area'];
            $orien=$res[0]['orientacion'];
            $sql3=" insert into auxi values ('".$dep."','".$area."','".$orien."')";
            toba::db('extension')->consultar($sql3);
            
            while ($i<count($res)) {
                if($res[$i]['departamento']==$dep){
                    $depi="";
                }else{
                    $dep=$res[$i]['departamento'];
                    $depi=$res[$i]['departamento'];
                }
                if($res[$i]['area']==$area){
                    $areai="";
                }else{
                    $area=$res[$i]['area'];
                    $areai=$res[$i]['area'];
                }
//                if($res[$i]['orientacion']==$orien){
//                    $orieni="";
//                }else{//LA ORIENTACION SIEMPRE CAMBIA RESPECTO A LA ANTERIOR
                    $orien=$res[$i]['orientacion'];
                    $orieni=$res[$i]['orientacion'];
               // }
                
                $sql3=" insert into auxi values ('".$depi."','".$areai."','".$orieni."')";
                toba::db('extension')->consultar($sql3);
                $i=$i+1;
            }
            $sql4="select * from auxi";
            $res=toba::db('extension')->consultar($sql4);
            
            return $res;
            
        }

}
?>