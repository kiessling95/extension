<?php
class dt_funcion_extension extends extension_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_extension, descripcion FROM funcion_extension ORDER BY descripcion";
		return toba::db('extension')->consultar($sql);
	}

}
?>