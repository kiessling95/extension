<?php

class ci_docentes extends extension_ci {

    protected $s__datos_filtro;
    protected $s__where;

    //---- Filtro -----------------------------------------------------------------------

    function conf__filtro(toba_ei_filtro $filtro) {
        if (isset($this->s__datos_filtro)) {
            $filtro->set_datos($this->s__datos_filtro);
        }
    }

    function evt__filtro__filtrar($datos) {
        $this->s__datos_filtro = $datos;
        $this->s__where = $this->dep('filtro')->get_sql_where();
    }

    function evt__filtro__cancelar() {
        unset($this->s__datos_filtro);
        unset($this->s__where);
    }

    //---- Cuadro -----------------------------------------------------------------------

    function conf__cuadro(toba_ei_cuadro $cuadro) {
        $cuadro->desactivar_modo_clave_segura();
        if (isset($this->s__datos_filtro)) {
            $cuadro->set_datos($this->dep('datos')->tabla('docente')->get_listado($this->s__where));
        } else {
            $cuadro->set_datos($this->dep('datos')->tabla('docente')->get_listado());
        }
    }

    function evt__cuadro__seleccion($datos) {
        $this->dep('datos')->cargar($datos);
    }

    function resetear() {
        $this->dep('datos')->resetear();
    }

}

?>