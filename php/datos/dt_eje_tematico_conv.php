<?php
class dt_eje_tematico_conv extends extension_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_eje, descripcion FROM eje_tematico_conv ORDER BY descripcion";
		return toba::db('extension')->consultar($sql);
	}

}

?>