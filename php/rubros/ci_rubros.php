<?php

class ci_rubros extends extension_ci {

    protected $s__mostrar;
    protected $s__datos_filtro;
    protected $s__where;
    protected $s__datos;

    //----Filtros ----------------------------------------------------------------------

    function conf__filtro_rubro(toba_ei_filtro $filtro) {
        if (isset($this->s__datos_filtro)) {
            $filtro->set_datos($this->s__datos_filtro);
        }
    }

    function evt__filtro_rubro__filtrar($datos) {
        $this->s__datos_filtro = $datos;
        $this->s__where = $this->dep('filtro_rubro')->get_sql_where();
    }

    function evt__filtro_rubro__cancelar() {
        unset($this->s__datos_filtro);
        unset($this->s__where);
    }

    //---- Cuadro -----------------------------------------------------------------------

    function conf__cuadro(toba_ei_cuadro $cuadro) {
        $cuadro->desactivar_modo_clave_segura();
        if (isset($this->s__where)) {
            $cuadro->set_datos($this->dep('datos')->tabla('rubro_presup_extension')->get_listado_filtro($this->s__where));
        }
    }

    function evt__cuadro__seleccion($datos) {
        //$this->s__mostrar = 1;
        $this->dep('datos')->cargar($datos);
    }

    function evt__cuadro__editar($datos) {
        $this->dep('datos')->cargar($datos);
        $this->s__mostrar = 1;
        $this->dep('cuadro')->colapsar();
        $this->dep('filtro_rubro')->colapsar();
    }

    function evt__form_cargo__modif($datos) {
        $this->s__datos = $datos;
    }

    function conf__formulario(toba_ei_formulario $form) {

        if ($this->s__mostrar == 1) {// si presiono el boton alta entonces muestra el formulario para dar de alta un nuevo registro
            $this->dep('formulario')->descolapsar();
            $form->ef('id_rubro_extension')->set_obligatorio('true');
            $form->ef('tipo')->set_obligatorio('true');
        } else {
            $this->dep('formulario')->colapsar();
        }
        
        if ($this->dep('datos')->esta_cargada()) {
            $form->set_datos($this->dep('datos')->tabla('rubro_presup_extension')->get());
        }
    }

    function evt__formulario__alta($datos) {
        print_r($datos);
        $this->dep('datos')->tabla('rubro_presup_extension')->set($datos);
        $this->dep('datos')->tabla('rubro_presup_extension')->sincronizar();
        $this->s__mostrar = 0;
        $this->dep('datos')->resetear();
    }

    function evt__formulario__baja($datos) {
        $this->dep('datos')->eliminar_todo();
        toba::notificacion()->agregar('El rubro se ha eliminado  correctamente.', 'info');
        $this->s__mostrar = 0;
        $this->resetear();
    }

    function evt__formulario__modificacion($datos) {
        $this->dep('datos')->tabla('rubro_presup_extension')->set($datos);
        $this->dep('datos')->tabla('rubro_presup_extension')->sincronizar();
    }

    function evt__formulario__cancelar() {
        $this->s__mostrar = 0;
        $this->dep('datos')->tabla('rubro_presup_extension')->resetear();
    }

    function resetear() {
        $this->dep('datos')->resetear();
    }

    //-----------------------------------------------------------------------------------
    //---- JAVASCRIPT -------------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    function extender_objeto_js() {
        echo "
		//---- Eventos ---------------------------------------------
		
		{$this->objeto_js}.evt__agregar = function()
		{
		}
		";
    }

    //-----------------------------------------------------------------------------------
    //---- Eventos ----------------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    function evt__agregar() {
        $this->s__mostrar = 1;
        unset($this->s__datos_filtro);
        unset($this->s__where);
    }

    function evt__volver() {
        $this->s__mostrar = 0;
        $this->resetear();
        $this->dep('cuadro')->descolapsar();
        $this->dep('filtro_rubro')->descolapsar();
    }

}

?>
