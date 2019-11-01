<?php

class ci_proyectos_extension extends extension_ci {

    protected $s__datos_filtro;
    protected $s__where;
    protected $s__mostrar;
    protected $s__mostrar_e;
    protected $s__mostrar_presup;
    protected $s__mostrar_org;
    protected $s__guardar;
    protected $s__integrantes;
    protected $s__pantalla;

    function get_persona($id) {
        
    }

    function get_rubro($id) {
        
    }

    function fecha_desde_proyecto() {
        $datos = $this->dep('datos')->tabla('pextension')->get();
        return date("d/m/Y", strtotime($datos['fec_desde']));
    }

    function fecha_hasta_proyecto() {
        $datos = $this->dep('datos')->tabla('pextension')->get();
        return date("d/m/Y", strtotime($datos['fec_hasta']));
    }

    function resolucion_proyecto() {
        $datos = $this->dep('datos')->tabla('pextension')->get();
        return $datos['nro_resol'];
    }


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

        $this->pantalla()->tab("pant_integrantesi")->desactivar();
        $this->pantalla()->tab("pant_integrantese")->desactivar();
        $this->pantalla()->tab("pant_planilla")->desactivar();
        $this->pantalla()->tab("pant_formulario")->desactivar();
        $this->pantalla()->tab("pant_presupuesto")->desactivar();
        $this->pantalla()->tab("pant_organizaciones")->desactivar();
        $this->pantalla()->tab("pant_objetivos")->desactivar();
        //$this->pantalla()->tab("pant_impacto")->desactivar();


        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_planilla")->ocultar();
        $this->pantalla()->tab("pant_formulario")->ocultar();
        $this->pantalla()->tab("pant_presupuesto")->ocultar();
        $this->pantalla()->tab("pant_organizaciones")->ocultar();
        $this->pantalla()->tab("pant_objetivos")->ocultar();
        //$this->pantalla()->tab("pant_impacto")->ocultar();

        if (isset($this->s__where)) {
            $cuadro->set_datos($this->dep('datos')->tabla('pextension')->get_listado($this->s__where));
        }
    }

    function evt__cuadro__seleccion($datos) {
        //$this->s__mostrar = 1;


        $this->set_pantalla('pant_formulario');


        $this->pantalla()->tab("pant_edicion")->desactivar();
        $this->pantalla()->tab("pant_organizaciones")->desactivar();
        $this->pantalla()->tab("pant_integrantesi")->desactivar();
        $this->pantalla()->tab("pant_integrantese")->desactivar();

        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_organizaciones")->ocultar();

        print_r($datos);
        $this->dep('datos')->tabla('pextension')->cargar($datos);
    }

    //---- Formulario -------------------------------------------------------------------

    function conf__formulario(toba_ei_formulario $form) {
        if ($this->s__mostrar == 1) {// si presiono el boton alta entonces muestra el formulario para dar de alta un nuevo registro
            $this->dep('formulario')->descolapsar();
            $form->ef('uni_acad')->set_obligatorio('true');
            $form->ef('denominacion')->set_obligatorio('true');
            $form->ef('nro_resol')->set_obligatorio('true');
            $form->ef('fecha_resol')->set_obligatorio('true');
            $form->ef('fec_desde')->set_obligatorio('true');
            $form->ef('fec_hasta')->set_obligatorio('true');
            $form->ef('palabras_clave')->set_obligatorio('true');
            $form->ef('objetivo')->set_obligatorio('true');
        }

        if ($this->dep('datos')->tabla('pextension')->esta_cargada()) {
            $datos = $this->dep('datos')->tabla('pextension')->get();
            //print_r($datos);
            $where = array();
            $where['uni_acad'] = $datos[uni_acad];
            $where['id_pext'] = $datos[id_pext];
            //print_r($where);
            $datos = $this->dep('datos')->tabla('pextension')->get_datos($where);
            $datos = $datos[0];

            if ($datos['financiacion'] == true) {
                $datos['financiacion'] = 'SI';
            };
            if ($datos['financiacion'] == false) {
                $datos['financiacion'] = 'NO';
            };
            $form->set_datos($datos);
        }
        //pregunto si el usuario logueado esta asociado a un perfil para desactivar los campos que no debe completar

        $perfil = toba::usuario()->get_perfil_datos();
        if ($perfil != null) {//si esta asociado a un perfil de datos entonces no permito que toquen los sig campos
            //$form->ef('uni_acad')->set_solo_lectura(true);
            $form->ef('area')->set_solo_lectura(true);
            $form->ef('codigo')->set_solo_lectura(true);
            $form->ef('nro_ord_cs')->set_solo_lectura(true);
            $form->ef('res_rect')->set_solo_lectura(true);
            $form->ef('expediente')->set_solo_lectura(true);
            $form->ef('estado')->set_solo_lectura(true);
            $form->ef('financiacion')->set_solo_lectura(true);
            $form->ef('monto')->set_solo_lectura(true);
            $form->ef('fecha_rendicion')->set_solo_lectura(true);
            $form->ef('rendicion_monto')->set_solo_lectura(true);
            $form->ef('fecha_prorroga1')->set_solo_lectura(true);
            $form->ef('fecha_prorroga2')->set_solo_lectura(true);
            $form->ef('observacion')->set_solo_lectura(true);
            $form->ef('estado_informe_a')->set_solo_lectura(true);
            $form->ef('estado_informe_f')->set_solo_lectura(true);
        }
        //print_r($perfil);
    }

    function evt__formulario__alta($datos) {
        //print_r($datos);
        $perfil = toba::manejador_sesiones()->get_perfiles_funcionales();
        print_r($perfil[0]);
        if ($perfil != null) {
            $ua = $this->dep('datos')->tabla('unidad_acad')->get_ua(); //trae la ua de acuerdo al perfil de datos  
            $datos['uni_acad'] = $ua[0]['sigla'];
        }

        if (trim($datos['financiacion']) == 'SI') {
            $datos['financiacion'] = true;
        };
        if (trim($datos['financiacion']) == 'NO') {
            $datos['financiacion'] = false;
        };
        unset($datos[director]);
        unset($datos[departamento]);
        unset($datos[area]);
        unset($datos[tipo_convocatoria]);
        $datos[responsable_carga] = $perfil[0];

        $this->dep('datos')->tabla('pextension')->set($datos);
        $this->dep('datos')->tabla('pextension')->sincronizar();
        $this->dep('datos')->tabla('pextension')->cargar($datos);
        toba::notificacion()->agregar('El proyecto ha sido guardado exitosamente', 'info');
    }

    function evt__formulario__modificacion($datos) {
        if (trim($datos['financiacion']) == 'SI') {
            $datos['financiacion'] = true;
        };
        if (trim($datos['financiacion']) == 'NO') {
            $datos['financiacion'] = false;
        };
        //print_r($datos); exit();
        $this->dep('datos')->tabla('pextension')->set($datos);
        $this->dep('datos')->tabla('pextension')->sincronizar();
    }

    function evt__formulario__baja() {
        $this->dep('datos')->tabla('pextension')->eliminar_todo();
        $this->resetear();
        $this->set_pantalla('pant_edicion');
    }

    function evt__formulario__cancelar() {
        $this->resetear();
        $this->set_pantalla('pant_edicion');
    }

    /*
      function evt__formulario__integrantes($datos) {
      $this->set_pantalla('pant_planilla');
      }

      function evt__formulario__presupuesto($datos) {
      $this->set_pantalla('pant_presupuesto');
      } */

    function resetear() {
        $this->dep('datos')->resetear();
    }

    //-----------------------------------------------------------------------------------
    //---- JAVASCRIPT -------------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    function extender_objeto_js() {
        echo "
		//---- Eventos ---------------------------------------------
		
		{$this->objeto_js}.evt__alta = function()
		{
		}
		";
    }

    //-----------------------------------------------------------------------------------
    //---- form_pext --------------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    function conf__form_pext(toba_ei_formulario $form) {
        $this->pantalla()->tab("pant_edicion")->desactivar();
        $form->set_datos($this->dep('datos')->tabla('pextension')->get());
    }

    //-----------------------------------------------------------------------------------
    //---- Eventos ----------------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    function evt__alta() {
        switch ($this->s__pantalla) {
            case 'pant_interno':
                $this->s__mostrar = 1;
                $this->dep('datos')->tabla('integrante_interno_pe')->resetear();
                break;
            case 'pant_externo':
                $this->s__mostrar_e = 1;
                $this->dep('datos')->tabla('integrante_externo_pe')->resetear();
            case 'pant_presup':
                $this->s__mostrar_presup = 1;
                $this->dep('datos')->tabla('presupuesto_extension')->resetear();
                break;
            case 'pant_organizaciones':
                $this->s__mostrar_org = 1;
                $this->dep('datos')->tabla('organizaciones_participantes')->resetear();
                break;
            case 'pant_edicion':
                $this->set_pantalla('pant_formulario');

                $this->pantalla()->tab("pant_integrantesi")->desactivar();
                $this->pantalla()->tab("pant_integrantese")->desactivar();
                $this->pantalla()->tab("pant_planilla")->desactivar();
                $this->pantalla()->tab("pant_presupuesto")->desactivar();
                $this->pantalla()->tab("pant_organizaciones")->desactivar();
                $this->pantalla()->tab("pant_objetivos")->desactivar();
                //$this->pantalla()->tab("pant_impacto")->desactivar();


                $this->pantalla()->tab("pant_integrantesi")->ocultar();
                $this->pantalla()->tab("pant_integrantese")->ocultar();
                $this->pantalla()->tab("pant_planilla")->ocultar();
                $this->pantalla()->tab("pant_presupuesto")->ocultar();
                $this->pantalla()->tab("pant_organizaciones")->ocultar();
                $this->pantalla()->tab("pant_objetivos")->ocultar();
                //$this->pantalla()->tab("pant_impacto")->ocultar();

                $this->dep('datos')->tabla('pextension')->resetear();
                break;
        }
    }

    function evt__volver() {
        switch ($this->s__pantalla) {
            case 'pant_interno':
                $this->set_pantalla('pant_planilla');
                $this->dep('datos')->tabla('integrante_interno_pe')->resetear();
                break;
            case 'pant_externo':
                $this->set_pantalla('pant_planilla');
                $this->dep('datos')->tabla('integrante_externo_pe')->resetear();
                break;
            case 'pant_presup':
                $this->set_pantalla('pant_formulario');
                break;
            case 'pant_organizaciones':
                $this->set_pantalla('pant_planilla');
                $this->dep('datos')->tabla('organizaciones_participantes')->resetear();
                break;
            case 'pant_planilla':
                $this->set_pantalla('pant_formulario');
                break;
            default :
                $this->set_pantalla('pant_edicion');
                $this->dep('datos')->tabla('pextension')->resetear();
                break;
        }

        $this->s__mostrar = 0;
        $this->s__mostrar_e = 0;
        $this->s__mostrar_presup = 0;
        $thiis->s__mostrar_org = 0;
    }

    function evt__integrantesi() {
        $this->set_pantalla('pant_integrantesi');
    }

    function evt__integrantese() {
        $this->set_pantalla('pant_integrantese');
    }

    function evt__organizaciones() {
        $this->set_pantalla('pant_organizaciones');
    }

    //-----------------------------------------------------------------------------------
    //---- form_integrantes internos-------------------------------------------------------------
    //-----------------------------------------------------------------------------------


    function conf__form_integrantes(toba_ei_formulario $form) {
        if ($this->s__mostrar == 1) {// si presiono el boton alta entonces muestra el formulario para dar de alta un nuevo registro
            $this->dep('form_integrantes')->descolapsar();
            $form->ef('id_docente')->set_obligatorio('true');
            $form->ef('id_designacion')->set_obligatorio('true');
            $form->ef('funcion_p')->set_obligatorio('true');
            $form->ef('carga_horaria')->set_obligatorio('true');
            $form->ef('ua')->set_obligatorio('true');
            $form->ef('desde')->set_obligatorio('true');
            $form->ef('hasta')->set_obligatorio('true');
            $form->ef('rescd')->set_obligatorio('true');
            $form->ef('ad_honorem')->set_obligatorio('true');
        } else {
            $this->dep('form_integrantes')->colapsar();
        }

        //para la edicion de los integrantes ya cargados
        if ($this->dep('datos')->tabla('integrante_interno_pe')->esta_cargada()) {
            $datos = $this->dep('datos')->tabla('integrante_interno_pe')->get();

            $datos['funcion_p'] = str_pad($datos['funcion_p'], 5);
            $docente = $this->dep('datos')->tabla('docente')->get_id_docente($datos['id_designacion']);
            if (count($docente) > 0) {
                $datos['id_docente'] = $docente;
            }
            print_r($datos);
            $form->set_datos($datos);
        }
        //$form->set_datos($res);
    }

    function evt__form_integrantes__guardar($datos) {
        //proyecto de extension datos
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos[id_pext] = $pe['id_pext'];
        $datos['tipo'] = 'interno';
        //verifico que las fechas correspondan (FALTA)

        $this->dep('datos')->tabla('integrante_interno_pe')->set($datos);
        $this->dep('datos')->tabla('integrante_interno_pe')->sincronizar();
        $this->dep('datos')->tabla('integrante_interno_pe')->resetear();

        //$this->dep('datos')->tabla('integrante_interno_pe')->procesar_filas($datos);
        //$this->dep('datos')->tabla('integrante_interno_pe')->sincronizar();
        $this->s__mostrar = 0;
    }

    function evt__form_integrantes__baja($datos) {
        $this->dep('datos')->tabla('integrante_interno_pe')->eliminar_todo();
        $this->dep('datos')->tabla('integrante_interno_pe')->resetear();
        toba::notificacion()->agregar('El integrante se ha eliminado  correctamente.', 'info');
        $this->s__mostrar = 0;
    }

    function evt__form_integrantes__modificacion($datos) {
        $this->dep('datos')->tabla('integrante_interno_pe')->set($datos);
        $this->dep('datos')->tabla('integrante_interno_pe')->sincronizar();
    }

    function evt__form_integrantes__cancelar() {
        $this->s__mostrar = 0;
        $this->dep('datos')->tabla('integrante_interno_pe')->resetear();
    }

    //-----------------------------------------------------------------------------------
    //---- form_presupuesto-------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    function conf__form_presupuesto(toba_ei_formulario $form) {

        if ($this->s__mostrar_presup == 1) {// si presiono el boton alta entonces muestra el formulario para dar de alta un nuevo registro
            $this->dep('form_presupuesto')->descolapsar();
            $form->ef('concepto')->set_obligatorio('true');
            $form->ef('cantidad')->set_obligatorio('true');
            $form->ef('monto')->set_obligatorio('true');
        } else {
            $this->dep('form_presupuesto')->colapsar();
        }

        if ($this->dep('datos')->tabla('presupuesto_extension')->esta_cargada()) {

            $datos = $this->dep('datos')->tabla('presupuesto_extension')->get();


            ///print_r($datos);
            $form->set_datos($datos);
        }
    }

    function evt__form_presupuesto__guardar($datos) {

        $pe = $this->dep('datos')->tabla('pextension')->get();

        $datos[id_pext] = $pe['id_pext'];

        $this->dep('datos')->tabla('presupuesto_extension')->set($datos);
        $this->dep('datos')->tabla('presupuesto_extension')->sincronizar();
        $this->dep('datos')->tabla('presupuesto_extension')->resetear();
    }

    function evt__form_presupuesto__baja($datos) {
        $this->dep('datos')->tabla('presupuesto_extension')->eliminar_todo();
        $this->dep('datos')->tabla('presupuesto_extension')->resetear();
        toba::notificacion()->agregar('El presupuesto se ha eliminado  correctamente.', 'info');
        $this->s__mostrar_presup = 0;
    }

    function evt__form_presupuesto__modificacion($datos) {
        $this->dep('datos')->tabla('presupuesto_extension')->set($datos);
        $this->dep('datos')->tabla('presupuesto_extension')->sincronizar();
    }

    function evt__form_presupuesto__cancelar() {
        $this->s__mostrar_presup = 0;
        $this->dep('datos')->tabla('presupuesto_extension')->resetear();
    }

    //---- Filtro Organizacion-----------------------------------------------------------------------
    /*
      function conf__filtro_organizacion(toba_ei_filtro $filtro) {
      //print_r($this->s__datos_filtro);        exit();
      if (isset($this->s__datos_filtro)) {
      $filtro->set_datos($this->s__datos_filtro);
      }
      }

      function evt__filtro_organizacion__filtrar($datos) {
      print_r($datos);        exit();
      $this->s__datos_filtro = $datos;
      }

      function evt__filtro_organizacion__cancelar() {
      unset($this->s__datos_filtro);
      }

     */

    //-----------------------------------------------------------------------------------
    //---- formulario de organizaciones-------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    function conf__form_organizacion(toba_ei_formulario $form) {

        if ($this->s__mostrar_org == 1) {// si presiono el boton alta entonces muestra el formulario para dar de alta un nuevo registro
            $this->dep('form_organizacion')->descolapsar();
            $form->ef('nombre')->set_obligatorio('true');
            $form->ef('domicilio')->set_obligatorio('true');
           // $form->ef('provincia')->set_obligatorio('true');
            $form->ef('telefono')->set_obligatorio('true');
            $form->ef('email')->set_obligatorio('true');
            $form->ef('referencia_vinculacion_inst')->set_obligatorio('true');
        } else {
            $this->dep('form_organizacion')->colapsar();
        }

        if ($this->dep('datos')->tabla('organizaciones_participantes')->esta_cargada()) {

            $datos = $this->dep('datos')->tabla('organizaciones_participantes')->get();


            //print_r($datos);
            $form->set_datos($datos);
        }
    }

    function evt__form_organizacion__guardar($datos) {
        //print_r($datos);        exit();
        $pe = $this->dep('datos')->tabla('pextension')->get();

        $datos[id_pext] = $pe['id_pext'];

        $this->dep('datos')->tabla('organizaciones_participantes')->set($datos);
        $this->dep('datos')->tabla('organizaciones_participantes')->sincronizar();
        $this->dep('datos')->tabla('organizaciones_participantes')->resetear();
    }

    function evt__form_organizacion__baja($datos) {
        $this->dep('datos')->tabla('organizaciones_participantes')->eliminar_todo();
        $this->dep('datos')->tabla('organizaciones_participantes')->resetear();
        toba::notificacion()->agregar('La organizacion se ha eliminado  correctamente.', 'info');
        $this->s__mostrar_org = 0;
    }

    function evt__form_organizacion__modificacion($datos) {
        $this->dep('datos')->tabla('organizaciones_participantes')->set($datos);
        $this->dep('datos')->tabla('organizaciones_participantes')->sincronizar();
    }

    function evt__form_organizacion__cancelar() {
        $this->s__mostrar_org = 0;
        $this->dep('datos')->tabla('organizaciones_participantes')->resetear();
    }

    //-----------------------------------------------------------------------------------
    //---- Configuraciones --------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    function conf__pant_edicion(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_edicion";

        $this->pantalla()->tab("pant_organizaciones")->desactivar();
        $this->pantalla()->tab("pant_integrantesi")->desactivar();
        $this->pantalla()->tab("pant_integrantese")->desactivar();


        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_organizaciones")->ocultar();
    }

    function conf__pant_formulario(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_formulario";
        $this->pantalla()->tab("pant_edicion")->desactivar();
        $this->pantalla()->tab("pant_organizaciones")->desactivar();
        $this->pantalla()->tab("pant_integrantesi")->desactivar();
        $this->pantalla()->tab("pant_integrantese")->desactivar();

        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_organizaciones")->ocultar();
    }

    function conf__pant_integrantesi(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_interno";
        $this->pantalla()->tab("pant_edicion")->desactivar();
        $this->pantalla()->tab("pant_organizaciones")->desactivar();
        $this->pantalla()->tab("pant_integrantese")->desactivar();

        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_organizaciones")->ocultar();
    }

    function conf__pant_integrantese(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_externo";
        $this->pantalla()->tab("pant_edicion")->desactivar();
        $this->pantalla()->tab("pant_organizaciones")->desactivar();
        $this->pantalla()->tab("pant_integrantesi")->desactivar();

        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_organizaciones")->ocultar();
    }

    function conf__pant_planilla(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_planilla";

        $this->pantalla()->tab("pant_edicion")->desactivar();
        $this->pantalla()->tab("pant_organizaciones")->desactivar();
        $this->pantalla()->tab("pant_integrantesi")->desactivar();
        $this->pantalla()->tab("pant_integrantese")->desactivar();

        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_organizaciones")->ocultar();
    }

    function conf__pant_organizaciones(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_organizaciones";

        $this->pantalla()->tab("pant_edicion")->desactivar();
        //$this->pantalla()->tab("pant_organizaciones")->desactivar();
        $this->pantalla()->tab("pant_integrantesi")->desactivar();
        $this->pantalla()->tab("pant_integrantese")->desactivar();

        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        //$this->pantalla()->tab("pant_organizaciones")->ocultar();
    }

    function conf__pant_objetivos(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_objetivos";

        $this->pantalla()->tab("pant_edicion")->desactivar();
        $this->pantalla()->tab("pant_organizaciones")->desactivar();
        $this->pantalla()->tab("pant_integrantesi")->desactivar();
        $this->pantalla()->tab("pant_integrantese")->desactivar();

        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_organizaciones")->ocultar();
    }

    /*  function conf__pant_impacto(toba_ei_pantalla $pantalla) {
      $this->s__pantalla = "pant_impacto";

      $this->pantalla()->tab("pant_edicion")->desactivar();
      $this->pantalla()->tab("pant_organizaciones")->desactivar();
      $this->pantalla()->tab("pant_integrantesi")->desactivar();
      $this->pantalla()->tab("pant_integrantese")->desactivar();

      $this->pantalla()->tab("pant_edicion")->ocultar();
      $this->pantalla()->tab("pant_integrantesi")->ocultar();
      $this->pantalla()->tab("pant_integrantese")->ocultar();
      $this->pantalla()->tab("pant_organizaciones")->ocultar();
      } */

    function conf__pant_presupuesto(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_presup";

        $this->pantalla()->tab("pant_edicion")->desactivar();
        $this->pantalla()->tab("pant_organizaciones")->desactivar();
        $this->pantalla()->tab("pant_integrantesi")->desactivar();
        $this->pantalla()->tab("pant_integrantese")->desactivar();

        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_organizaciones")->ocultar();
    }

    // creo que todas estas conf ya no son necesarias 
    //-----------------------------------------------------------------------------------
    //---- cuadro_int -------------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    function conf__cuadro_int(toba_ei_cuadro $cuadro) {

        $pe = $this->dep('datos')->tabla('pextension')->get();
        $cuadro->set_datos($this->dep('datos')->tabla('integrante_externo_pe')->get_listado($pe['id_pext']));
    }

    function evt__cuadro_int__seleccion($datos) {

        $this->s__mostrar_e = 1;
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos['id_pext'] = $pe['id_pext'];
        $this->dep('datos')->tabla('integrante_externo_pe')->cargar($datos);
    }

    //-----------------------------------------------------------------------------------
    //---- cuadro_integrantes internos  -------------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    function conf__cuadro_ii(toba_ei_cuadro $cuadro) {
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $cuadro->set_datos($this->dep('datos')->tabla('integrante_interno_pe')->get_listado($pe['id_pext']));
    }

    function evt__cuadro_ii__seleccion($datos) {
        //habilito formulario
        $this->s__mostrar = 1;
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos['id_pext'] = $pe['id_pext'];
        $this->dep('datos')->tabla('integrante_interno_pe')->cargar($datos);
    }

    //-----------------------------------------------------------------------------------
    //---- cuadro_organizaciones  -------------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    function conf__cuadro_organizaciones(toba_ei_cuadro $cuadro) {
        //$cuadro->desactivar_modo_clave_segura();
        // print_r($this->s__datos_filtro);        exit();
        $pe = $this->dep('datos')->tabla('pextension')->get();
        //print_r($pe['id_pext']);
        $datos = $this->dep('datos')->tabla('organizaciones_participantes')->get_listado($pe['id_pext']);
//        if (isset($this->s__datos_filtro)) {
//            
//            $cuadro->set_datos($this->dep('datos')->tabla('organizaciones_participantes')->get_listado_filtro($this->s__datos_filtro));
//        }
//        else
//        {
        $cuadro->set_datos($datos);
//        }
    }

    function evt__cuadro_organizaciones__seleccion($datos) {
        //print_r($datos);
        $this->s__mostrar_org = 1;
        $this->dep('datos')->tabla('organizaciones_participantes')->cargar($datos);
    }

    //-----------------------------------------------------------------------------------
    //---- cuadro_presup  -------------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    function conf__cuadro_presup(toba_ei_cuadro $cuadro) {
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $cuadro->set_datos($this->dep('datos')->tabla('presupuesto_extension')->get_listado($pe['id_pext']));
    }

    function evt__cuadro_presup__seleccion($datos) {


        $this->s__mostrar_presup = 1;
        $presup = $this->dep('datos')->tabla('presupuesto_extension')->get_datos($datos);

        //print_r($presup[0]);        exit();

        $this->dep('datos')->tabla('presupuesto_extension')->cargar($presup[0]);
    }

    //-----------------------------------------------------------------------------------
    //---- Formulario Integrante Externo ------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    function conf__form_integrante_e(toba_ei_formulario $form) {
        if ($this->s__mostrar_e == 1) {// si presiono el boton alta entonces muestra el formulario para dar de alta un nuevo registro
            $this->dep('form_integrante_e')->descolapsar();
            $form->ef('integrante')->set_obligatorio('true');
            $form->ef('funcion_p')->set_obligatorio('true');
            $form->ef('carga_horaria')->set_obligatorio('true');
            $form->ef('desde')->set_obligatorio('true');
            $form->ef('hasta')->set_obligatorio('true');
            $form->ef('rescd')->set_obligatorio('true');
        } else {
            $this->dep('form_integrante_e')->colapsar();
        }

        //para la edicion de los integrantes ya cargados
        if ($this->dep('datos')->tabla('integrante_externo_pe')->esta_cargada()) {
            $datos = $this->dep('datos')->tabla('integrante_externo_pe')->get();
            $datos['funcion_p'] = str_pad($datos['funcion_p'], 5);
            $persona = $this->dep('datos')->tabla('persona')->get_datos($datos['tipo_docum'], $datos['nro_docum']);

            if (count($persona) > 0) {
                $datos['integrante'] = $persona[0]['nombre'];
            }
            //print_r($datos);
            $form->set_datos($datos);
        }
    }

    //ingresa un nuevo integrante 
    function evt__form_integrante_e__guardar($datos) {
        print_r($datos);
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos['id_pext'] = $pe['id_pext'];
        $datos['tipo'] = 'externo';
        $datos['nro_tabla'] = 1;
        //recupero todas las personas, Las recupero igual que como aparecen en operacion Configuracion->Personas
        //$personas=$this->dep('datos')->tabla('persona')->get_listado();           
        $datos['tipo_docum'] = $datos['integrante'][0];
        $datos['nro_docum'] = $datos['integrante'][1];
        $this->dep('datos')->tabla('integrante_externo_pe')->set($datos);
        $this->dep('datos')->tabla('integrante_externo_pe')->sincronizar();
        $this->dep('datos')->tabla('integrante_externo_pe')->resetear();
    }

    function evt__form_integrante_e__baja($datos) {
        $this->dep('datos')->tabla('integrante_externo_pe')->eliminar_todo();
        $this->dep('datos')->tabla('integrante_externo_pe')->resetear();
        toba::notificacion()->agregar('El integrante se ha eliminado  correctamente.', 'info');
        $this->s__mostrar_e = 0;
    }

    function evt__form_integrante_e__modificacion($datos) {
        $this->dep('datos')->tabla('integrante_externo_pe')->set($datos);
        $this->dep('datos')->tabla('integrante_externo_pe')->sincronizar();
    }

    function evt__form_integrante_e__cancelar() {
        $this->s__mostrar_e = 0;
        $this->dep('datos')->tabla('integrante_externo_pe')->resetear();
    }

    //-----------------------------------------------------------------------------------
    //---- cuadro_plantilla -------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    function conf__cuadro_plantilla(toba_ei_cuadro $cuadro) {
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos = $this->dep('datos')->tabla('integrante_externo_pe')->get_plantilla($pe['id_pext'], $this->s__datos_filtro);
        $duracion = '';
        $fecha = date('d-m-Y', strtotime($pe['fecha_resol']));

        if (isset($pe['duracion'])) {
            $duracion = $pe['duracion'] . utf8_decode(' años');
        }
        //str_replace(':','' ,$pe['denominacion']) reemplaza el : por blanco, dado que da error con algunos caracteres
        $cuadro->set_titulo(str_replace(':', '', $pe['denominacion']) . '(ResCD: ' . $pe['nro_resol'] . $fecha . ')' . $duracion);
        $cuadro->set_datos($datos);
    }

    function evt__cuadro_plantilla__seleccion($datos) {
        //$this->s__mostrar = 1;
        /* aca deberia ser capas de diferencia entre si es interno o externo para poder derivar
         * a las diferentes pantallas */
        $this->set_pantalla('pant_formulario');
        $this->dep('datos')->tabla('pextension')->cargar($datos);
    }

    function conf__filtro_integrantes(toba_ei_filtro $filtro) {
        if (isset($this->s__datos_filtro)) {
            $filtro->set_datos($this->s__datos_filtro);
        }
    }

    function evt__filtro_integrantes__filtrar($datos) {
        $this->s__datos_filtro = $datos;
    }

    function evt__filtro_integrantes__cancelar() {
        unset($this->s__datos_filtro);
    }

    //----------------Filtro Presupuesto--------------------------------------

    /* function conf__filtro_presup(toba_ei_formulario $filtro) {
      if (isset($this->s__datos_filtro)) {
      $filtro->set_datos($this->s__datos_filtro);
      }
      }

      function evt__filtro_presup__filtrar($datos) {
      $this->s__datos_filtro = $datos;
      }

      function evt__filtro_presup__cancelar() {
      unset($this->s__datos_filtro);
      }
     */
}

?>
