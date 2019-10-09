<?php

class dt_presupuesto_extension extends extension_datos_tabla 
{
    function get_listado($id_p = null) {
        
        $sql = "select "
                . "id_pext,"
		. "id_presupuesto,"
                . "r.id_rubro_extension,"
                . "tipo,"
                . "concepto,"
                . "cantidad,"
                . "monto "
                . "from presupuesto_extension as p_e "
                . "INNER JOIN rubro_presup_extension as r ON ( p_e.id_rubro_extension = r.id_rubro_extension )  "
                
                . "where id_pext=" . $id_p
                //. "order by tipo,concepto"
        ;
        //print_r($sql);        exit();
        return toba::db('extension')->consultar($sql);
    }

    
}
?>

