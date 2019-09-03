<?php
class dt_bases_convocatoria extends extension_datos_tabla
{
	function get_listado($where=null)
	{
		$sql = "SELECT
			t_bc.id_bases,
			t_bc.convocatoria,
			t_bc.objetivo,
			t_bc.eje_tematico,
			t_bc.destinatarios,
			t_bc.integrantes,
			t_bc.monto,
			t_bc.duracion,
			t_bc.fecha,
			t_bc.evaluacion,
			t_bc.adjudicacion,
			t_bc.consulta,
			t_bc.bases_titulo,
			t_bc.ordenanza,
			t_bc.tipo_convocatoria
		FROM
			bases_convocatoria as t_bc";
		if (!is_null($where)) {
			$sql.="
			WHERE
				$where";
		}
		$sql .="
		ORDER BY convocatoria";
		
		return toba::db('extension')->consultar($sql);
	}

}
?>