<?php
class dt_pextension extends extension_datos_tabla
{
	function get_listado($where = null)
	{
		$sql = "SELECT
			t_p.id_pext,
			t_p.codigo,
			t_p.denominacion,
			t_p.nro_resol,
			t_p.fecha_resol,
			t_ua.descripcion as uni_acad_nombre,
			t_p.fec_desde,
			t_p.fec_hasta,
			t_p.nro_ord_cs,
			t_p.res_rect,
			t_p.expediente,
			t_p.duracion,
			t_p.palabras_clave,
			t_p.objetivo,
			t_p.estado,
			t_p.financiacion,
			t_p.monto,
			t_p.fecha_rendicion,
			t_p.rendicion_monto,
			t_p.fecha_prorroga1,
			t_p.fecha_prorroga2,
			t_p.observacion,
			t_p.estado_informe_a,
			t_p.estado_informe_f
		FROM
			pextension as t_p	LEFT OUTER JOIN unidad_acad as t_ua ON (t_p.uni_acad = t_ua.sigla)";
		if (!is_null($where)) {
			$sql .="
			WHERE 
				$where";
		}
		$sql .="
		ORDER BY codigo";
		
		return toba::db('extension')->consultar($sql);
	}


}
?>