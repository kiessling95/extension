<?php

class dt_presupuesto_extension extends extension_datos_tabla {

    function get_listado($id_p = null) {

        $sql = "select "
                . "p_e.id_pext,"
                . "p_e.id_presupuesto,"
                . "p_e.id_rubro_extension,"
                . "r.tipo as rubro,"
                . "p_e.concepto,"
                . "p_e.cantidad,"
                . "p_e.monto "
                . "from presupuesto_extension as p_e "
                . "INNER JOIN rubro_presup_extension as r ON ( p_e.id_rubro_extension = r.id_rubro_extension )  "
                . "where id_pext=" . $id_p
                . "order by concepto,monto";
        return toba::db('extension')->consultar($sql);
    }

    function get_datos($id) {

        $sql = "select "
                . "p_e.id_pext,"
                . "p_e.id_presupuesto,"
                . "p_e.id_rubro_extension,"
                . "p_e.concepto,"
                . "p_e.cantidad,"
                . "p_e.monto "
                . "from presupuesto_extension as p_e "
                . "INNER JOIN rubro_presup_extension as r ON ( p_e.id_rubro_extension = r.id_rubro_extension )"
                . "LEFT OUTER JOIN pextension as p ON ( p_e.id_pext = p.id_pext )  "
                . " where p_e.id_presupuesto =" . $id['id_presupuesto'];
        return toba::db('extension')->consultar($sql);
    }
    
    function get_listado_rubro($id_rubro_extension = null){
        $sql = "select "
                . "p_e.id_pext,"
                . "p_e.id_presupuesto,"
                . "p_e.id_rubro_extension,"
                . "r.tipo as rubro,"
                . "p_e.concepto,"
                . "p_e.cantidad,"
                . "p_e.monto "
                . "from presupuesto_extension as p_e "
                . "INNER JOIN rubro_presup_extension as r ON ( p_e.id_rubro_extension = r.id_rubro_extension )  "
                . "where p_e.id_rubro_extension=" . $id_rubro_extension
                . "order by concepto,monto";
        return toba::db('extension')->consultar($sql);
    }

}
?>

