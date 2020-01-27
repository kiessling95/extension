<?php
class dt_provincia extends extension_datos_tabla
{
	
	function get_descripciones($pais_nacim)
	{
                $sql = "SELECT p.codigo_pcia, p.descripcion_pcia FROM dblink('".$this->dblink_designa()."','SELECT codigo_pcia, descripcion_pcia , cod_pais  FROM provincia') as p (codigo_pcia INTEGER , descripcion_pcia CHARACTER(40), cod_pais CHARACTER(2)) "
                        . " WHERE p.cod_pais = '".$pais_nacim ."'"
                        . "ORDER BY descripcion_pcia";

		return toba::db('extension')->consultar($sql);
	}

        

}
?>