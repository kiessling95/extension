<?php
class dt_provincia extends extension_datos_tabla
{
	
	function get_descripciones()
	{
		$sql = "SELECT codigo_pcia, descripcion_pcia FROM provincia ORDER BY descripcion_pcia";
		return toba::db('extension')->consultar($sql);
	}







}
?>