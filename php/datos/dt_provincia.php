<?php
class dt_provincia extends extension_datos_tabla
{
	
	function get_descripciones()
	{
		//$sql = "SELECT codigo_pcia, descripcion_pcia FROM provincia ORDER BY descripcion_pcia";
                $sql = "SELECT p.codigo_pcia, p.descripcion_pcia FROM dblink('".$this->dblink_designa()."','SELECT codigo_pcia, descripcion_pcia FROM provincia') as p (codigo_pcia INTEGER , descripcion_pcia CHARACTER(40))"
                        . "ORDER BY descripcion_pcia";
		return toba::db('extension')->consultar($sql);
	}

        

}
?>