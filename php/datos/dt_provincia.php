<?php
class dt_provincia extends extension_datos_tabla
{
	
	function get_descripciones($pais_nacim)
	{
                $sql = "SELECT p.codigo_pcia, p.descripcion_pcia FROM dblink('".$this->dblink_designa()."','SELECT codigo_pcia, descripcion_pcia , cod_pais  FROM provincia') as p (codigo_pcia INTEGER , descripcion_pcia CHARACTER(40), cod_pais CHARACTER(2)) "
                        . " WHERE p.cod_pais = '".$pais_nacim ."'"
                        . "ORDER BY descripcion_pcia";
                $result =toba::db('extension')->consultar($sql);
                foreach ($result as $key => $value) {
                    $result[$key]['descripcion_pcia'] = $value['descripcion_pcia'];
                }
		return $result;
	}

        

}
?>