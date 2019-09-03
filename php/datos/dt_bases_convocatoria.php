<?php
class dt_bases_convocatoria extends extension_datos_tabla
{
	function get_listado($filtro=array())
	{
		$where = array();
		if (isset($filtro['id_bases'])) {
			$where[] = "id_bases = ".quote($filtro['id_bases']);
		}
		if (isset($filtro['tipo_convocatoria'])) {
			$where[] = "tipo_convocatoria ILIKE ".quote("%{$filtro['tipo_convocatoria']}%");
		}
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
			bases_convocatoria as t_bc
		ORDER BY convocatoria";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('extension')->consultar($sql);
	}

}
?>