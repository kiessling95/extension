<?php

class ci_eje_tematicos extends extension_ci {

    protected $s__mostrar;

    //---- Cuadro -----------------------------------------------------------------------

    function conf__cuadro(toba_ei_cuadro $cuadro) {
        $cuadro->desactivar_modo_clave_segura();
        $cuadro->set_datos($this->dep('datos')->tabla('tipos_ejes_tematicos')->get_listado());
    }

    function evt__cuadro__seleccion($datos) {
        $this->dep('datos')->cargar($datos);
    }

    function evt__cuadro__editar($datos) {
        $this->dep('datos')->cargar($datos);
        $this->s__mostrar = 1;
    }

    //---- Formulario -------------------------------------------------------------------

    function conf__formulario(toba_ei_formulario $form) {

        if ($this->s__mostrar == 1) {
            $this->dep('formulario')->descolapsar();
            if ($this->dep('datos')->esta_cargada()) {
                $form->set_datos($this->dep('datos')->tabla('tipos_ejes_tematicos')->get());
            }
        }else{
            $this->dep('formulario')->colapsar();
        }
    }
    
    function evt__formulario__alta($datos) {
        $this->dep('datos')->tabla(tipos_ejes_tematicos)->set($datos);
        $this->dep('datos')->tabla(tipos_ejes_tematicos)->sincronizar();
        $this->s__mostrar=0;
        $this->resetear();
    }

    function evt__formulario__modificacion($datos) {
        $this->dep('datos')->tabla('tipos_ejes_tematicos')->set($datos);
    }
    
     function evt__formulario__baja() {
        $this->dep('datos')->eliminar_todo();
        toba::notificacion()->agregar('Se ha eliminado el eje tematico', 'info');
        $this->s__mostrar = 0;
        $this->resetear();
    }

//el evento cancelar debe tener el tilde de manejo de datos desactivado
    function evt__formulario__cancelar() {
        $this->s__mostrar = 0;
        $this->resetear();
        $this->dep('formulario')->descolapsar(); //nueva
    }

    function resetear() {
        $this->dep('datos')->resetear();
    }

    //---- EVENTOS CI -------------------------------------------------------------------

    function evt__agregar() {
        $this->s__mostrar=1;
        $this->set_pantalla('pant_edicion');
    }

    function evt__volver() {
        $this->resetear();
        $this->s__mostrar=0;
    }

    /*
      function evt__eliminar() {
      $this->dep('datos')->eliminar_todo();
      $this->resetear();
      }

      function evt__guardar() {
      $this->dep('datos')->sincronizar();
      $this->resetear();
      }
     */
}

?>