<?php
class dt_funcion_extension extends extension_datos_tabla
{
	function get_funcion_docente()
	{
		$sql = "SELECT id_extension, descripcion "
                        . "FROM funcion_extension "
                        . "WHERE id_extension='AS' OR id_extension='D' OR id_extension='CD-Co' OR id_extension='I' "
                        . "ORDER BY descripcion";
		return toba::db('extension')->consultar($sql);
	}
        function get_funcion_otros()
	{
		$sql = "SELECT id_extension, descripcion "
                        . "FROM funcion_extension "
                        . "WHERE id_extension='I' OR id_extension='AS' "
                        . "OR id_extension='CD-Co' OR id_extension='CE' "
                        . "ORDER BY descripcion";
		return toba::db('extension')->consultar($sql);
	}
        
        function get_claustro()
	{
		$sql = "SELECT id_extension, descripcion "
                        . "FROM funcion_extension "
                        . "WHERE id_extension='G' OR id_extension='EST' OR id_extension='ND' OR id_extension='I' OR id_extension='EXT'"
                        . "ORDER BY descripcion";
		return toba::db('extension')->consultar($sql);
	}

        
}
?>