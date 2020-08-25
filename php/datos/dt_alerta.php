<?php
class dt_alerta extends extension_datos_tabla
{
	function get_alerta($claves=null)
	{
            $sql= "SELECT * "
                    . "FROM alerta "
                    . "WHERE estado_alerta='Pendiente' AND rol='".$claves[rol]."' AND id_pext=".$claves[id_pext];

            return toba::db('extension')->consultar($sql);
           
	}
        
        function get_alerta_rol($claves=null)
	{
            $sql= "SELECT * "
                    . "FROM alerta AS a "
                    . "INNER JOIN pextension AS p ON (a.id_pext = p.id_pext) "
                    . "WHERE p.uni_acad='".$claves[$claves]."' AND a.estado_alerta='Pendiente' AND a.rol='".$claves[rol]."'";

            return toba::db('extension')->consultar($sql);
           
	}
        
        function get_alerta_solicitud($claves=null)
	{
            $sql= "SELECT * "
                    . "FROM alerta "
                    . "WHERE estado_alerta='Pendiente' AND rol='".$claves[rol]."' AND id_pext=".$claves[id_pext]." AND tipo_solicitud='".$claves['id_solicitud']."'";

            return toba::db('extension')->consultar($sql);
           
	}

}
?>

