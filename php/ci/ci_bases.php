<?php

class ci_bases extends extension_ci {

    protected $nombre_tabla = 'bases_convocatoria';
    protected $s__mostrar;
    protected $s__where = null;
    protected $s__datos_filtro = null;

    function get_eje_tematico($id) {
        
    }

//------------------------------------------------------------------------------------
//------------------------------ CUADRO ----------------------------------------------
//------------------------------------------------------------------------------------

    function conf__cuadro(toba_ei_cuadro $cuadro) {
        $this->dep('datos')->resetear();
        if (!is_null($this->s__where)) {
            $datos = $this->dep('datos')->tabla($this->nombre_tabla)->get_listado($this->s__where);
        } else {
            $datos = $this->dep('datos')->tabla($this->nombre_tabla)->get_listado();
        }
        $cuadro->set_datos($datos);
    }

    function evt__cuadro__seleccion($datos) {
        $this->set_pantalla('pant_edicion');
        $this->dep('datos')->tabla($this->nombre_tabla)->cargar($datos);
    }

    function conf__cuadro_ejes(toba_ei_cuadro $cuadro) {
        $cuadro->set_datos($this->dep('datos')->tabla('eje_tematico_conv')->get_listado());
    }

    function evt__cuadro_ejes__seleccion($datos) {
        $this->set_pantalla('pant_ejes');
        $this->dep('datos')->tabla('eje_tematico_conv')->cargar($datos);
    }

//-----------------------------------------------------------------------------------
//---- filtro -----------------------------------------------------------------------
//-----------------------------------------------------------------------------------

    /**
     * Permite cambiar la configuraci�n del formulario previo a la generaci�n de la salida
     * El formato del carga debe ser array(<campo> => <valor>, ...)
     */
    function conf__filtro(toba_ei_filtro $filtro) {
        if (isset($this->s__datos_filtro))
            $filtro->set_datos($this->s__datos_filtro);
    }

    /**
     * Atrapa la interacci�n del usuario con el bot�n asociado
     * @param array $datos Estado del componente al momento de ejecutar el evento. 
     * El formato es el mismo que en la carga de la configuraci�n
     */
    function evt__filtro__filtrar($datos) {
        $this->s__where = $this->dep('filtro')->get_sql_where();
        $this->s__datos_filtro = $datos;
    }

    /**
     * Atrapa la interacci�n del usuario con el bot�n asociado
     */
    function evt__filtro__cancelar() {
//completar
//$this->dep('filtro')->limpiar_interface();
        $this->s__datos_filtro = array();
        $this->evt__filtro__filtrar($this->s__datos_filtro);
    }

// ----------------- Otros eventos -------------------

    function evt__ejes_tematicos() {
        $this->s__mostrar = 0;
        $this->set_pantalla('pant_ejes');
    }

    function evt__nuevo($datos) {
        $this->set_pantalla('pant_edicion');
    }

    function evt__agregar() {
        $this->s__mostrar = 1;
#$this->resetear();
    }

    function evt__volver() {
        $this->set_pantalla('pant_edicion');
    }

    function conf__pant_edicion(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_edicion";
    }

    function conf__pant_cuadro(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_cuadro";
    }

    function conf__pant_ejes(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_ejes";
    }

//---- Formulario -------------------------------------------------------------------

    function conf__form_ejes(toba_ei_formulario $form) {
        if ($this->s__mostrar == 1) {
            $this->dep('form_ejes')->descolapsar();
        } else {
            $this->dep('form_ejes')->colapsar();
        }

        if ($this->dep('datos')->tabla('eje_tematico_conv')->esta_cargada()) {
            $form->set_datos($this->dep('datos')->tabla('eje_tematico_conv')->get());
        }
    }

    function evt__form_ejes__alta($datos) {
        /*
         * todo: el periodo por defecto
         */

        $bases = $this->dep('datos')->tabla('bases_convocatoria')->get();
        $tipo = $this->dep('datos')->tabla('tipos_ejes_tematicos')->get_tipo($datos['descripcion'])[0];
        //print_r($tipo);
        $datos['id_bases'] = $bases[id_bases];
        $datos['descripcion'] = $tipo['descripcion'];
        $datos['id_eje'] = $tipo['id_eje'];
        //print_r($datos);        exit();
        // control clave unica

        $this->dep('datos')->tabla('eje_tematico_conv')->set($datos);
        $this->dep('datos')->tabla('eje_tematico_conv')->sincronizar();
        $this->s__mostrar = 0;
        $this->resetear();
    }

    function evt__form_ejes__modificacion($datos) {
        $this->dep('datos')->tabla('eje_tematico_conv')->set($datos);
        $this->dep('datos')->tabla('eje_tematico_conv')->sincronizar();
        $this->s__mostrar = 0;
        $this->resetear();
    }

    function evt__form_ejes__baja() {
        $this->dep('datos')->eliminar_todo();
        toba::notificacion()->agregar('El registro se ha eliminado correctamente', 'info');
        $this->s__mostrar = 0;
        $this->resetear();
    }

    function evt__form_ejes__cancelar() {
        $this->dep('datos')->resetear();
        $this->set_pantalla('pant_ediccion');
    }

    function conf__formulario(toba_ei_formulario $form) {
        if ($this->dep('datos')->tabla($this->nombre_tabla)->esta_cargada()) {
            $form->set_datos($this->dep('datos')->tabla($this->nombre_tabla)->get());
        }
    }

    function evt__formulario__alta($datos) {
        /*
         * todo: el periodo por defecto
         */
        $this->dep('datos')->tabla($this->nombre_tabla)->set($datos);
        $this->dep('datos')->tabla($this->nombre_tabla)->sincronizar();
        $this->resetear();
    }

    function evt__formulario__modificacion($datos) {
        $this->dep('datos')->tabla($this->nombre_tabla)->set($datos);
        $this->dep('datos')->tabla($this->nombre_tabla)->sincronizar();
        $this->resetear();
    }

    function evt__formulario__baja() {
        $this->dep('datos')->eliminar_todo();
        toba::notificacion()->agregar('El registro se ha eliminado correctamente', 'info');
        $this->resetear();
    }

    function evt__formulario__cancelar() {
        $this->resetear();
    }

    function resetear() {
        $this->dep('datos')->resetear();
        $this->set_pantalla('pant_cuadro');
    }

    function vista_pdf(toba_vista_pdf $salida) {

//print_r($salida); exit();
        if ($this->dep('datos')->tabla('bases_convocatoria')->esta_cargada()) {
            $bases = $this->dep('datos')->tabla('bases_convocatoria')->get();

//configuramos el nombre que tendrá el archivo pdf
            $salida->set_nombre_archivo("Bases_Convocatoria.pdf");

//recuperamos el objteo ezPDF para agregar la cabecera y el pie de página 
            $salida->set_papel_orientacion('portrait'); //landscape
            $salida->inicializar();
//$salida->set_pdf_fuente('Times-Roman.afm');
//$salida->set_papel_tamanio('A4');

            $pdf = $salida->get_pdf();
//terc izquierda 
//bajo normas Icontec y APA
            $pdf->ezSetCmMargins(2.54, 2.54, 2.54, 2.54);

//Configuramos el pie de página. El mismo, tendra el número de página centrado en la página y la fecha ubicada a la derecha. 
//Primero definimos la plantilla para el número de página.
            $formato = utf8_decode('Página {PAGENUM} de {TOTALPAGENUM} ');

//Determinamos la ubicación del número página en el pié de pagina definiendo las coordenadas x y, tamaño de letra, posición, texto, pagina inicio 
            $pdf->ezStartPageNumbers(300, 20, 8, 'justify', utf8_d_seguro($formato), 1);
//$pdf->ezText('full');
//Luego definimos la ubicación de la fecha en el pie de página.
            $pdf->addText(380, 20, 8, 'Mocovi - Extension ' . date('d/m/Y h:i:s a'));

//Configuración de Título.
            $salida->titulo(utf8_d_seguro('UNIVERSIDAD NACIONAL DEL COMAHUE' . chr(10) . 'SECRETARÍA DE EXTENSIÓN UNIVERSITARIA' . chr(10) . 'BASES DE CONVOCATORIA '));
            $titulo = "   ";




            $pdf->ezText("\n\n\n\n", 10, ['justification' => 'full']);
//titulo ej: Convocatoria 2017 ( Ejecucion 2018)
            $pdf->ezText('' . utf8_d_seguro('<b>' . $bases['bases_titulo'] . '</b>'), 10, ['justification' => 'full']);
//introduccion
            $pdf->ezText($bases['convocatoria'], 10, ['justification' => 'full']);
//salto de linea
            $pdf->ezText('  ', 10, ['justification' => 'full']);
//objetivo
            $pdf->ezText('<b>' . utf8_d_seguro('OBJETIVOS: ') . '</b>', 10, ['justification' => 'full']);
            $pdf->ezText(utf8_d_seguro($bases['objetivo']), 10, ['justification' => 'full']);
//salto de linea
            $pdf->ezText('  ', 10, ['justification' => 'full']);

            $pdf->ezText(utf8_d_seguro('<b> EJES TEMÁTICOS: </b>'), 10, ['justification' => 'full']);
            $pdf->ezText(utf8_d_seguro($bases['eje_tematico']), 10, ['justification' => 'full']);
//salto de linea
            $pdf->ezText('  ', 10, ['justification' => 'full']);

            $pdf->ezText(utf8_d_seguro('<b> DESTINATARIOS: </b>'), 10, ['justification' => 'full']);
            $pdf->ezText(utf8_d_seguro($bases['destinatarios']), 10, ['justification' => 'full']);
//salto de linea
            $pdf->ezText('  ', 10, ['justification' => 'full']);

            $pdf->ezText(utf8_d_seguro('<b> INTEGRANTES - ¿QUIENES PUEDEN PARTIPAR? : </b>'), 10, ['justification' => 'full']);
            $pdf->ezText(utf8_d_seguro($bases['integrantes']), 10, ['justification' => 'full']);
//salto de linea
            $pdf->ezText('  ', 10, ['justification' => 'full']);

            $pdf->ezText(utf8_d_seguro('<b> MONTO A FINANCIAR: </b>'), 10, ['justification' => 'full']);
            $pdf->ezText(utf8_d_seguro($bases['monto']), 10, ['justification' => 'full']);
//salto de linea
            $pdf->ezText('  ', 10, ['justification' => 'full']);

            $pdf->ezText(utf8_d_seguro('<b> DURACIÓN DE LOS PROYECTOS (EJECUCIÓN DE LOS PROYECTOS): </b>'), 10);
            $pdf->ezText(utf8_d_seguro($bases['duracion']), 10, ['justification' => 'full']);
//salto de linea
            $pdf->ezText('  ', 10, ['justification' => 'full']);

            $pdf->ezText(utf8_d_seguro('<b> FECHA DE PRESENTACIÓN: </b>'), 10, ['justification' => 'full']);
            $pdf->ezText(utf8_d_seguro($bases['fecha']), 10, ['justification' => 'full']);
//salto de linea
            $pdf->ezText('  ', 10, ['justification' => 'full']);

            $pdf->ezText(utf8_d_seguro('<b> EVALUACIÓN: </b>'), 10, ['justification' => 'full']);
            $pdf->ezText(utf8_d_seguro($bases['evaluacion']), 10, ['justification' => 'full']);
//salto de linea
            $pdf->ezText('  ', 10, ['justification' => 'full']);

            $pdf->ezText(utf8_d_seguro('<b> ADJUDICACIÓN DE LOS PROYECTOS: </b>'), 10, ['justification' => 'full']);
            $pdf->ezText(utf8_d_seguro($bases['adjudicacion']), 10, ['justification' => 'full']);
//salto de linea
            $pdf->ezText('  ', 10, ['justification' => 'full']);

            $pdf->ezText(utf8_d_seguro('<b> CONSULTAS: </b>'), 10, ['justification' => 'full']);
            $pdf->ezText(utf8_d_seguro($bases['consulta']), 10, ['justification' => 'full']);
//salto de linea
            $pdf->ezText('  ', 10, ['justification' => 'full']);




// Logos pimera pagina
            $id = 7;
            $pdf->reopenObject($id); //definimos el path a la imagen de logo de la organizacion 
//agregamos al documento la imagen y definimos su posición a través de las coordenadas (x,y) y el ancho y el alto.
            $imagen = toba::proyecto()->get_path() . '/www/img/logo_uc.jpg';
            $imagen2 = toba::proyecto()->get_path() . '/www/img/ext.jpeg';
            $pdf->addJpegFromFile($imagen, 40, 715, 70, 66);
            $pdf->addJpegFromFile($imagen2, 480, 715, 70, 66);
            $pdf->closeObject();
//}
        }
    }

}

?>