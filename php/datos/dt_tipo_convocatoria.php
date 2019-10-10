<?php
class dt_tipo_convocatoria extends extension_datos_tabla {

	function get_descripciones()
	{
		$sql = "SELECT id_conv, descripcion FROM tipo_convocatoria ORDER BY descripcion";
		return toba::db('extension')->consultar($sql);
	}
}
?>