<?php
class dt_funcion_extension extends extension_datos_tabla
{
	function get_funcion_docente()
	{
		$sql = "SELECT id_extension, descripcion "
                        . "FROM funcion_extension "
                        . "WHERE id_extension='AS' OR id_extension='D' OR id_extension='CD-Co' "
                        . "ORDER BY descripcion";
		return toba::db('extension')->consultar($sql);
	}
        function get_funcion_otros()
	{
		$sql = "SELECT t_f.id_extension, t_f.descripcion "
                        . "FROM funcion_extension as t_f "
                        . "LEFT OUTER JOIN integrante_externo_pe as t_e ON (t_e.funcion_p = t_f.id_extension) "
                        . "WHERE t_f.id_extension='I' OR t_f.id_extension='AS' "
                        . "OR t_f.id_extension='ND' OR (t_f.id_extension='B' AND t_e.funcion_p='B')"
                        . "OR t_f.id_extension='C' OR t_f.id_extension='EST' "
                        . "OR t_f.id_extension='G' OR t_f.id_extension='CE' "
                        . "ORDER BY t_f.descripcion";
		return toba::db('extension')->consultar($sql);
	}
        
}
?>