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
        
        function get_alerta_solicitud($claves=null)
	{
            $sql= "SELECT * "
                    . "FROM alerta "
                    . "WHERE estado_alerta='Pendiente' AND rol='".$claves[rol]."' AND id_pext=".$claves[id_pext]." AND id_solicitud='".$claves['id_solicitud']."'";

            return toba::db('extension')->consultar($sql);
           
	}

}
?>

