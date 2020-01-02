<?php

class ci_proyectos_extension extends extension_ci {

    protected $s__datos_filtro;
    protected $s__where;
    protected $s__mostrar;
    protected $s__mostrar_e;
    protected $s__mostrar_presup;
    protected $s__mostrar_org;
    protected $s__mostrar_obj;
    protected $s__mostrar_activ;
    protected $s__mostrar_dest;
    protected $s__guardar;
    protected $s__integrantes;
    protected $s__pantalla;

    function vista_pdf(toba_vista_pdf $salida) {

        if ($this->dep('datos')->tabla('pextension')->esta_cargada()) {

//Proyectos de extension
            $pextension = $this->dep('datos')->tabla('pextension')->get();

//$datos = $this->dep('datos')->tabla('pextension')->get();
//filtro para obtener solo la que quiero exp a pdf
            $where = array();
            $where['uni_acad'] = $pextension[uni_acad];
            $where['id_pext'] = $pextension[id_pext];

// datos generales del proyecto
            $datos = $this->dep('datos')->tabla('pextension')->get_datos($where);
            $datos = $datos[0];

//obtengo las bases correspondientes al proyecto
            $bases = $this->dep('datos')->tabla('bases_convocatoria')->get_datos($datos[id_bases]);
            $bases = $bases[0];

//ejes tematicos 
            $ejes_conv = $this->dep('datos')->tabla('eje_tematico_conv')->get_descripciones($datos[id_bases]);
            ;
            $ejes = array();
            $aux = $datos['eje_tematico'];
            for ($i = 0; $i < strlen($aux); $i++) {
                if ($aux[$i] != '{' AND $aux[$i] != ',' AND $aux[$i] != '}') {
                    $ejes . array_push($ejes, $aux[$i]);
                }
            }

            $aux = array();
            foreach ($ejes_conv as $eje_conv) {
                foreach ($ejes as $eje) {
                    if ($eje == $eje_conv[id_eje]) {
                        $aux . array_push($aux, $eje_conv[descripcion]);
                    }
                }
            }
            $ejes_tematicos = $aux;



            $datos[id_bases] = $bases['bases_titulo'];
            $datos[id_conv] = $bases[descripcion];

            //obtengo director 
            $director = $this->dep('datos')->tabla('integrante_interno_pe')->get_director($datos[id_pext]);
            $director = $director[0];

            //obtengo co-director
            $co_director = $this->dep('datos')->tabla('integrante_interno_pe')->get_co_director($datos[id_pext]);
            $co_director = $co_director[0];

            //Objetivos Especificos 
            $obj_especificos = $this->dep('datos')->tabla('objetivo_especifico')->get_datos($datos[id_pext]);

            $integrantes = $this->dep('datos')->tabla('integrante_externo_pe')->get_plantilla($datos[id_pext]);

            //configuramos el nombre que tendrá el archivo pdf
            $salida->set_nombre_archivo("Formulario Convocatoria.pdf");

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
            $salida->titulo(utf8_d_seguro('UNIVERSIDAD NACIONAL DEL COMAHUE' . chr(10) . 'SECRETARÍA DE EXTENSIÓN UNIVERSITARIA'));
            $titulo = "   ";




            $pdf->ezText("\n\n\n\n", 10, ['justification' => 'full']);
            //Pantalla Principal Formulario
            //Director 
            $pdf->ezText('' . utf8_d_seguro('<b>Director del Proyecto </b>') . ' : ', 10, ['justification' => 'full']);
            $pdf->ezText('' . utf8_d_seguro('Nombre') . ' :  ' . $director[nombre], 10, ['justification' => 'full']);
            $pdf->ezText('' . utf8_d_seguro('Unidad Académica') . ' :  ' . $director[ua], 10, ['justification' => 'full']);
            $pdf->ezText('' . utf8_d_seguro('Tipo y Nro. de documento') . ' :  ' . $director[tipo_docum] . ' ' . $director[nro_docum], 10, ['justification' => 'full']);
            $pdf->ezText('' . utf8_d_seguro('Telefono') . ' :  ' . $director[telefono], 10, ['justification' => 'full']);
            $pdf->ezText('' . utf8_d_seguro('Correo') . ' :  ' . $director[correo_institucional], 10, ['justification' => 'full']);

            //Co-Director 
            $pdf->ezText('' . utf8_d_seguro('<b>Co-Director del Proyecto </b>') . ' : ', 10, ['justification' => 'full']);
            $pdf->ezText('' . utf8_d_seguro('Nombre') . ' :  ' . $co_director[nombre], 10, ['justification' => 'full']);
            $pdf->ezText('' . utf8_d_seguro('Unidad Académica') . ' :  ' . $co_director[ua], 10, ['justification' => 'full']);
            $pdf->ezText('' . utf8_d_seguro('Tipo y Nro. de documento') . ' :  ' . $co_director[tipo_docum] . ' ' . $co_director[nro_docum], 10, ['justification' => 'full']);
            $pdf->ezText('' . utf8_d_seguro('Telefono') . ' :  ' . $co_director[telefono], 10, ['justification' => 'full']);
            $pdf->ezText('' . utf8_d_seguro('Correo') . ' :  ' . $co_director[correo_institucional], 10, ['justification' => 'full']);

            //salto de linea
            $pdf->ezText("\n", 10, ['justification' => 'full']);

            //Indentificacion del Proyecto
            $pdf->ezText('' . utf8_d_seguro('<b>Datos generales </b>'), 10, ['justification' => 'full']);
            //Nombre del Proyecto
            $pdf->ezText('Nombre del Proyecto :  ' . $datos['denominacion'], 10, ['justification' => 'full']);
            //Financiamiento Anterior
            //unidad academica
            $pdf->ezText('Unidad Academica :  ' . $datos['uni_acad'], 10, ['justification' => 'full']);
            //departamento
            //$pdf->ezText('Departamento :  ' . $datos['departamento'], 10, ['justification' => 'full']);
            //area
            //$pdf->ezText('Area :  ' . $datos['area'], 10, ['justification' => 'full']);
            //eje tematico
            $pdf->ezText('' . utf8_d_seguro('Ejes Tematicos : '), 10, ['justification' => 'full']);
            foreach ($ejes_tematicos as $eje) {
                $pdf->ezText(' - ' . $eje, 10, ['justification' => 'full']);
            }
            //palabras claves
            $pdf->ezText('Palabras Claves:  ' . $datos['palabras_clave'], 10, ['justification' => 'full']);
            //id bases 
            $pdf->ezText('Titulo Bases :  ' . $datos['id_bases'], 10, ['justification' => 'full']);
            //Tipo convocatoria
            $pdf->ezText(utf8_d_seguro('Tipo Convocatoria :  ') . $datos['id_conv'], 10, ['justification' => 'full']);


            //salto linea
            $pdf->ezText("\n", 10, ['justification' => 'full']);


            $pdf->ezText('<b>' . utf8_d_seguro('Fundamentación del origen del proyecto: ') . '</b>', 10, ['justification' => 'full']);
            //Fundamentación del Proyecto
            $pdf->ezText(utf8_d_seguro('Fundamentación del Proyecto :  ') . $datos['descripcion_situacion'], 10, ['justification' => 'full']);
            //Identificar destinatarios 
            $pdf->ezText(utf8_d_seguro('Identificar destinatarios:  ') . $datos['caracterizacion_poblacion'], 10, ['justification' => 'full']);
            //localizacion geografica
            $pdf->ezText(utf8_d_seguro('Localización geográfica :  ') . $datos['localizacion_geo'], 10, ['justification' => 'full']);

            //salto de linea
            $pdf->ezText("\n", 10, ['justification' => 'full']);

            $pdf->ezText('<b>' . utf8_d_seguro('Resultados esperados : ') . '</b>', 10, ['justification' => 'full']);
            $pdf->ezText(utf8_d_seguro('Resultados esperados del proyecto') . $datos[impacto], 10, ['justification' => 'full']);

            //salto de linea
            $pdf->ezText("\n", 10, ['justification' => 'full']);

            // Objetivo General
            $pdf->ezText('<b>' . utf8_d_seguro('Objetivo General : ') . '</b>', 10, ['justification' => 'full']);
            $pdf->ezText(utf8_d_seguro('Objetivo General :') . $datos[objetivo], 10, ['justification' => 'full']);

            //salto de linea
            $pdf->ezText("\n", 10, ['justification' => 'full']);

            //Objetivo Especifico
            $pdf->ezText('<b>' . utf8_d_seguro('Objetivos especificos : ') . '</b>', 10, ['justification' => 'full']);
            foreach ($obj_especificos as $obj_especifico) {

                $pdf->ezText(utf8_d_seguro(' * Descripción: ') . $obj_especifico[descripcion], 10, ['justification' => 'full']);
                $pdf->ezText(utf8_d_seguro('   - Meta: ') . $obj_especifico[meta], 10, ['justification' => 'full']);
                $pdf->ezText(utf8_d_seguro('   - Ponderacion: ') . $obj_especifico[ponderacion] . "% ", 10, ['justification' => 'full']);
                //actividades de obj especifico

                $plan_actividades = $this->dep('datos')->tabla('plan_actividades')->get_listado($obj_especifico[id_objetivo]);

                for ($index = 0; $index < count($plan_actividades); $index++) {
                    $plan = $plan_actividades[$index];

                    $pdf->ezText(utf8_d_seguro('     + Detalle de la Actividad : ') . $plan[detalle], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('     + Destinatarios : ') . $plan[destinatarios], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('     + Mes de Inicio : ') . $plan[fecha], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('     + Localizacion : ') . $plan[localizacion], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('     + Año de comienzo de actividad : ') . $plan[anio], 10, ['justification' => 'full']);
                }
                //salto de linea
                $pdf->ezText("\n", 10, ['justification' => 'full']);
            }

            // Integrantes
            $pdf->ezText('<b>' . utf8_d_seguro('Equipo y Organizaciones participantes : ') . '</b>', 10, ['justification' => 'full']);

            //salto de linea
            $pdf->ezText("\n", 10, ['justification' => 'full']);

            // Estudiantes
            $pdf->ezText('<b>' . utf8_d_seguro('Estudiantes : ') . '</b>', 10, ['justification' => 'full']);
            foreach ($integrantes as $integrante) {
                if ($integrante[funcion_p] == 'Estudiante') {
                    $pdf->ezText(utf8_d_seguro('Nombre y Apellido : ') . $integrante[nombre], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Tipo y Nro Documento : ') . $integrante[tipo_docum] . '' . $integrante[nro_docum], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Horas dedicadas : ') . $integrante[carga_horaria], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Mail : ') . $integrante[mail], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Telefono : ') . $integrante[telefono], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Ad Honorem ? : ') . $integrante[ad_honorem], 10, ['justification' => 'full']);
                    $pdf->ezText("\n", 10, ['justification' => 'full']);
                }
            }
            //salto de linea
            $pdf->ezText("\n", 10, ['justification' => 'full']);

            //Becario
            $pdf->ezText('<b>' . utf8_d_seguro('Becario : ') . '</b>', 10, ['justification' => 'full']);
            foreach ($integrantes as $integrante) {
                if ($integrante[funcion_p] == 'Becario') {
                    $pdf->ezText(utf8_d_seguro('Nombre y Apellido : ') . $integrante[nombre], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Tipo y Nro Documento : ') . $integrante[tipo_docum] . '' . $integrante[nro_docum], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Horas dedicadas : ') . $integrante[carga_horaria], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Mail : ') . $integrante[mail], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Telefono : ') . $integrante[telefono], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Ad Honorem ? : ') . $integrante[ad_honorem], 10, ['justification' => 'full']);
                    $pdf->ezText("\n", 10, ['justification' => 'full']);
                }
            }
            //salto de linea
            $pdf->ezText("\n", 10, ['justification' => 'full']);

            //Asesor
            $pdf->ezText('<b>' . utf8_d_seguro('Asesor : ') . '</b>', 10, ['justification' => 'full']);
            foreach ($integrantes as $integrante) {
                if ($integrante[funcion_p] == 'Asesor') {
                    $pdf->ezText(utf8_d_seguro('Nombre y Apellido : ') . $integrante[nombre], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Tipo y Nro Documento : ') . $integrante[tipo_docum] . '' . $integrante[nro_docum], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Horas dedicadas : ') . $integrante[carga_horaria], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Mail : ') . $integrante[mail], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Telefono : ') . $integrante[telefono], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Ad Honorem ? : ') . $integrante[ad_honorem], 10, ['justification' => 'full']);
                    $pdf->ezText("\n", 10, ['justification' => 'full']);
                }
            }
            //salto de linea
            $pdf->ezText("\n", 10, ['justification' => 'full']);

            //Colaborador
            $pdf->ezText('<b>' . utf8_d_seguro('Colaborador : ') . '</b>', 10, ['justification' => 'full']);
            foreach ($integrantes as $integrante) {
                if ($integrante[funcion_p] == 'Colaborador') {
                    $pdf->ezText(utf8_d_seguro('Nombre y Apellido : ') . $integrante[nombre], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Tipo y Nro Documento : ') . $integrante[tipo_docum] . '' . $integrante[nro_docum], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Horas dedicadas : ') . $integrante[carga_horaria], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Mail : ') . $integrante[mail], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Telefono : ') . $integrante[telefono], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Ad Honorem ? : ') . $integrante[ad_honorem], 10, ['justification' => 'full']);
                    $pdf->ezText("\n", 10, ['justification' => 'full']);
                }
            }
            //salto de linea
            $pdf->ezText("\n", 10, ['justification' => 'full']);

            // Colaborador Externo
            $pdf->ezText('<b>' . utf8_d_seguro('Colaborador Externo : ') . '</b>', 10, ['justification' => 'full']);
            foreach ($integrantes as $integrante) {
                if ($integrante[funcion_p] == 'Colaborador Externo') {
                    $pdf->ezText(utf8_d_seguro('Nombre y Apellido : ') . $integrante[nombre], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Tipo y Nro Documento : ') . $integrante[tipo_docum] . '' . $integrante[nro_docum], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Horas dedicadas : ') . $integrante[carga_horaria], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Mail : ') . $integrante[mail], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Telefono : ') . $integrante[telefono], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Ad Honorem ? : ') . $integrante[ad_honorem], 10, ['justification' => 'full']);
                    $pdf->ezText("\n", 10, ['justification' => 'full']);
                }
            }
            //salto de linea
            $pdf->ezText("\n", 10, ['justification' => 'full']);

            // Integrante 
            $pdf->ezText('<b>' . utf8_d_seguro('Integrante : ') . '</b>', 10, ['justification' => 'full']);
            foreach ($integrantes as $integrante) {
                if ($integrante[funcion_p] == 'Integrante') {
                    $pdf->ezText(utf8_d_seguro('Nombre y Apellido : ') . $integrante[nombre], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Tipo y Nro Documento : ') . $integrante[tipo_docum] . '' . $integrante[nro_docum], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Horas dedicadas : ') . $integrante[carga_horaria], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Mail : ') . $integrante[mail], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Telefono : ') . $integrante[telefono], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Ad Honorem ? : ') . $integrante[ad_honorem], 10, ['justification' => 'full']);
                    $pdf->ezText("\n", 10, ['justification' => 'full']);
                }
            }
            //salto de linea
            $pdf->ezText("\n", 10, ['justification' => 'full']);

            // Docentes / Investigadores Universitarios 
            $pdf->ezText('<b>' . utf8_d_seguro('Docentes / Investigadores Universitarios : ') . '</b>', 10, ['justification' => 'full']);
            foreach ($integrantes as $integrante) {

                if ($integrante[funcion_p] == 'Director' || $integrante[funcion_p] == 'Codirector') {
                    $pdf->ezText(utf8_d_seguro('Nombre y Apellido : ') . $integrante[nombre], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Tipo y Nro Documento : ') . $integrante[tipo_docum] . '' . $integrante[nro_docum], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Horas dedicadas : ') . $integrante[carga_horaria], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Mail : ') . $integrante[mail], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Telefono : ') . $integrante[telefono], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Ad Honorem ? : ') . $integrante[ad_honorem], 10, ['justification' => 'full']);
                    $pdf->ezText("\n", 10, ['justification' => 'full']);
                }
            }
            //salto de linea
            $pdf->ezText("\n", 10, ['justification' => 'full']);

            // Graduados
            $pdf->ezText('<b>' . utf8_d_seguro('Graduados : ') . '</b>', 10, ['justification' => 'full']);
            foreach ($integrantes as $integrante) {
                if ($integrante[funcion_p] == 'Graduado') {
                    $pdf->ezText(utf8_d_seguro('Nombre y Apellido : ') . $integrante[nombre], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Tipo y Nro Documento : ') . $integrante[tipo_docum] . '' . $integrante[nro_docum], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Horas dedicadas : ') . $integrante[carga_horaria], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Mail : ') . $integrante[mail], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Telefono : ') . $integrante[telefono], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Ad Honorem ? : ') . $integrante[ad_honorem], 10, ['justification' => 'full']);
                    $pdf->ezText("\n", 10, ['justification' => 'full']);
                }
            }
            //salto de linea
            $pdf->ezText("\n", 10, ['justification' => 'full']);

            // No Docentes
            $pdf->ezText('<b>' . utf8_d_seguro('No Docentes : ') . '</b>', 10, ['justification' => 'full']);
            foreach ($integrantes as $integrante) {
                if ($integrante[funcion_p] == 'No Docente') {
                    $pdf->ezText(utf8_d_seguro('Nombre y Apellido : ') . $integrante[nombre], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Tipo y Nro Documento : ') . $integrante[tipo_docum] . '' . $integrante[nro_docum], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Horas dedicadas : ') . $integrante[carga_horaria], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Mail : ') . $integrante[mail], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Telefono : ') . $integrante[telefono], 10, ['justification' => 'full']);
                    $pdf->ezText(utf8_d_seguro('Ad Honorem ? : ') . $integrante[ad_honorem], 10, ['justification' => 'full']);
                    $pdf->ezText("\n", 10, ['justification' => 'full']);
                }
            }
            //salto de linea
            $pdf->ezText("\n", 10, ['justification' => 'full']);

            // Organizaciones
//

            /*
              //
              $pdf->ezText(utf8_d_seguro('').$datos[''], 10, ['justification' => 'full']);

             */

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

    function get_persona($id) {
        
    }

    function get_docente($id) {
        
    }

    function get_rubro($id) {
        
    }

    function fecha_desde_proyecto() {
        $datos = $this->dep('datos')->tabla('pextension')->get();
        $date = date("d/m/Y", strtotime($datos['fec_desde']));
        return $date;
    }

    function fecha_hasta_proyecto() {
        $datos = $this->dep('datos')->tabla('pextension')->get();

        return date("d/m/Y", strtotime($datos['fec_hasta']));
    }

    function resolucion_proyecto() {
        $datos = $this->dep('datos')->tabla('pextension')->get();
        return $datos['nro_resol'];
    }

    function destinatarios() {
        $id_pext = $this->dep('datos')->tabla('pextension')->get()['id_pext'];
        return $this->dep('datos')->tabla('destinatarios')->get_descripciones($id_pext);
    }

    function convocatorias() {
        if ($this->dep('datos')->tabla('pextension')->esta_cargada()) {
            $pext = $this->dep('datos')->tabla('pextension')->get()['id_pext'];
            $id_estado = $pext['id_estado'];
        } else {
            $id_estado = 'FORM';
        }
        return $this->dep('datos')->tabla('bases_convocatoria')->get_convocatorias_vigentes($id_estado);
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

    /* --------------------------------------------------------------------------
     * ----------------------------- ESTADOS ------------------------------------
     * -------------------------------------------------------------------------
     */

    // enviar cuando el formulador termina la carga pasa a estar en evaluacion por la UA
    function evt__enviar() {
        if ($this->dep('datos')->tabla('pextension')->esta_cargada()) {
            $pextension = $this->dep('datos')->tabla('pextension')->get();


            /* Listado condiciones carga :
             * 1) Director 
             * 2) Co Director
             * 
             */

            //obtengo director 
            $director = $this->dep('datos')->tabla('integrante_interno_pe')->get_director($pextension[id_pext]);
            $director = $director[0];


            //obtengo co-director
            $co_director = $this->dep('datos')->tabla('integrante_interno_pe')->get_co_director($pextension[id_pext]);
            $co_director = $co_director[0];

            if (count($director) > 1 && count($co_director) > 1) {
                // Cambio de estado 
                $pextension[id_estado] = 'EUA ';
                $where = array();
                $where[uni_acad] = $pextension[uni_acad];
                $where[id_pext] = $pextension[id_pext];

                $this->dep('datos')->tabla('pextension')->set($pextension);
                $this->dep('datos')->tabla('pextension')->sincronizar();


                $pextension = $this->dep('datos')->tabla('pextension')->get_datos($where);

                if (($pextension[0][id_estado] == 'EUA ') == 1) {//Obtengo de la BD y verifico que hizo cambios en la BD
                    //Se enviaron correctamente los datos
                    toba::notificacion()->agregar(utf8_decode("Los datos fueron enviados con éxito"), "info");
                } else {
                    //Se generó algún error al guardar en la BD
                    toba::notificacion()->agregar(utf8_decode("Error al enviar la información, verifique su conexión a internet"), "info");
                }
            } else {
                toba::notificacion()->agregar(utf8_decode("Falta alguno de los siguientes datos ( Director/a ,  Director/a)  "), "info");
            }
        }
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
        $this->pantalla()->tab("pant_actividad")->desactivar();
        $this->pantalla()->tab("pant_destinatarios")->desactivar();


        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_planilla")->ocultar();
        $this->pantalla()->tab("pant_formulario")->ocultar();
        $this->pantalla()->tab("pant_presupuesto")->ocultar();
        $this->pantalla()->tab("pant_organizaciones")->ocultar();
        $this->pantalla()->tab("pant_objetivos")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_destinatarios")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();

        $perfil = toba::manejador_sesiones()->get_id_usuario_instancia();
        if ($perfil == formulador) {
            $this->pantalla()->tab("pant_seguimiento")->ocultar();
        }

        if (isset($this->s__where)) {
            $cuadro->set_datos($this->dep('datos')->tabla('pextension')->get_listado($this->s__where));
        }
    }

    function evt__cuadro__seleccion($datos) {
        $this->set_pantalla('pant_formulario');

        $this->pantalla()->tab("pant_edicion")->desactivar();
        $this->pantalla()->tab("pant_integrantesi")->desactivar();
        $this->pantalla()->tab("pant_integrantese")->desactivar();
        $this->pantalla()->tab("pant_actividad")->desactivar();

        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();



        $perfil = toba::manejador_sesiones()->get_id_usuario_instancia();
        if ($perfil == formulador) {
            $this->pantalla()->tab("pant_seguimiento")->ocultar();
        }

        $this->dep('datos')->tabla('pextension')->cargar($datos);
    }

//---- Formulario -------------------------------------------------------------------

    function conf__formulario(toba_ei_formulario $form) {
        $perfil = toba::manejador_sesiones()->get_id_usuario_instancia();
        $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
        // si presiono el boton enviar no puede editar nada mas 
        if ($estado != 'FORM' && $perfil == formulador) {
            $this->dep('formulario')->set_solo_lectura();
            $this->dep('formulario')->evento('modificacion')->ocultar();
            $this->dep('formulario')->evento('baja')->ocultar();
            $this->dep('formulario')->evento('cancelar')->ocultar();
        }

        // Si esta cargado, traigo los datos de la base de datos
        if ($this->dep('datos')->tabla('pextension')->esta_cargada()) {
            $datos = $this->dep('datos')->tabla('pextension')->get();
            $seg = $this->dep('datos')->tabla('seguimiento_central')->get_listado($datos['id_pext']);


//            $datos[res_rect] = $seg[res_rect];
//            $datos[nro_ord_cs] = $seg[nro_ord_cs];

            $where = array();
            $where['uni_acad'] = $datos[uni_acad];
            $where['id_pext'] = $datos[id_pext];
            $datos = $this->dep('datos')->tabla('pextension')->get_datos($where);
            $datos = $datos[0];
            $datos[codigo] = $seg[0][codigo];
            $ejes = array();
            $aux = $datos['eje_tematico'];
            for ($i = 0; $i < strlen($aux); $i++) {
                if ($aux[$i] != '{' AND $aux[$i] != ',' AND $aux[$i] != '}') {
                    $ejes . array_push($ejes, $aux[$i]);
                }
            }
            $datos['eje_tematico'] = $ejes;
            $form->set_datos($datos);
        }
    }

    function evt__formulario__alta($datos) {

        $perfil = toba::usuario()->get_perfil_datos();

        if ($perfil != null) {
            $ua = $this->dep('datos')->tabla('unidad_acad')->get_ua(); //trae la ua de acuerdo al perfil de datos  
            $datos['uni_acad'] = $ua[0]['sigla'];
        }
        $ejes = $datos['eje_tematico'];
        $array = '{' . $ejes[0];
        unset($ejes[0]);
        foreach ($ejes as $eje) {
            $array = $array . ',' . $eje;
        }
        $array = $array . '}';
        $datos['eje_tematico'] = $array;

        // Solo se muestran, no se guardan directamente en la tabla pextension
        unset($datos[director]);
        unset($datos[dir_email]);
        unset($datos[dir_telefono]);
        unset($datos[co_director]);
        unset($datos[co_email]);
        unset($datos[co_telefono]);
        unset($datos[tipo_convocatoria]);
        unset($datos[codigo]);
        unset($datos[res_rect]);
        unset($datos[nro_ord_cs]);

        //Cambio de estado a en formulacion
        $datos[id_estado] = 'FORM';

        //responsable de carga proyecto
        $datos[responsable_carga] = toba::manejador_sesiones()->get_id_usuario_instancia();

        //control fechas

        $this->dep('datos')->tabla('pextension')->set($datos);
        $this->dep('datos')->tabla('pextension')->sincronizar();
        $this->dep('datos')->tabla('pextension')->cargar($datos);

        toba::notificacion()->agregar('El proyecto ha sido guardado exitosamente', 'info');
    }

    function evt__formulario__modificacion($datos) {

        $ejes = $datos['eje_tematico'];
        $array = '{' . $ejes[0];
        unset($ejes[0]);
        foreach ($ejes as $eje) {
            $array = $array . ',' . $eje;
        }
        $array = $array . '}';
        $datos['eje_tematico'] = $array;

        $id_estado = $this->dep('datos')->tabla('estado_pe')->get_id($datos['id_estado'])[0];

        $datos['id_estado'] = $id_estado['id_estado'];

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

    function resetear() {
        $this->dep('datos')->resetear();
    }

    //------------------------------------------------------------------------------------------------
    //---- Formulario Seguimiento Central-------------------------------------------------------------
    //------------------------------------------------------------------------------------------------

    function conf__formulario_seguimiento(toba_ei_formulario $form) {

        $perfil = toba::manejador_sesiones()->get_id_usuario_instancia();
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $estado = $pe[id_estado];
        if ($estado != 'FORM' && $perfil == formulador) {
            $this->dep('formulario_seguimiento')->set_solo_lectura();
            $this->dep('formulario_seguimiento')->evento('modificacion')->ocultar();
            $this->dep('formulario_seguimiento')->evento('baja')->ocultar();
            $this->dep('formulario_seguimiento')->evento('cancelar')->ocultar();
        }



        if ($this->dep('datos')->tabla('seguimiento_central')->esta_cargada()) {

            $datos = $this->dep('datos')->tabla('seguimiento_central')->get();

            $datos[denominacion] = $pe[denominacion];
            $datos[id_bases] = $pe[id_bases];
            $datos[duracion] = $pe[duracion];
            $datos[monto] = $pe[monto];
            $datos[fec_desde] = $pe[fec_desde];
            $datos[fec_hasta] = $pe[fec_hasta];

            $form->set_datos($datos);
        }
    }

    function evt__formulario_seguimiento__alta($datos) {
//        $perfil = toba::manejador_sesiones()->get_perfiles_funcionales();
//        if($perfil != null && $perfil != formulador)
        unset($datos[denominacion]);
        unset($datos[duracion]);
        unset($datos[monto]);
        unset($datos[id_bases]);
        unset($datos[fec_desde]);
        unset($datos[fec_hasta]);

        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos['id_pext'] = $pe['id_pext'];

        $this->dep('datos')->tabla('seguimiento_central')->set($datos);
        $this->dep('datos')->tabla('seguimiento_central')->sincronizar();
        $this->dep('datos')->tabla('seguimiento_central')->cargar($datos);
        toba::notificacion()->agregar('Los datos del seguimiento se han guardado exitosamente', 'info');
    }

    function evt__formulario_seguimiento__modificacion($datos) {
        if ($datos['fecha_prorroga2'] != null) {
            $datos['fec_hasta'] = $datos['fecha_prorroga2'];
        }

        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos['id_pext'] = $pe['id_pext'];

        $this->dep('datos')->tabla('seguimiento_central')->set($datos);
        $this->dep('datos')->tabla('seguimiento_central')->sincronizar();
    }

    function evt__formulario_seguimiento__baja() {
        $this->dep('datos')->tabla('seguimiento_central')->eliminar_todo();
        $this->resetear();
        $this->set_pantalla('pant_edicion');
    }

    function evt__formulario_seguimiento__cancelar() {
        $this->dep('datos')->tabla('seguimiento_central')->resetear();
    }

    //------------------------------------------------------------------------------------------------
    //---- Formulario Seguimiento UA-------------------------------------------------------------------
    //------------------------------------------------------------------------------------------------

    function conf__formulario_seg_ua(toba_ei_formulario $form) {

        $perfil = toba::manejador_sesiones()->get_id_usuario_instancia();
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $estado = $pe[id_estado];
        if ($estado != 'FORM' && $perfil == formulador) {
            $this->dep('formulario_seg_ua')->set_solo_lectura();
            $this->dep('formulario_seg_ua')->evento('modificacion')->ocultar();
            $this->dep('formulario_seg_ua')->evento('baja')->ocultar();
            $this->dep('formulario_seg_ua')->evento('cancelar')->ocultar();
        }

        if ($this->dep('datos')->tabla('seguimiento_ua')->esta_cargada()) {


            $datos = $this->dep('datos')->tabla('seguimiento_ua')->get();

            $datos[uni_acad] = $pe[uni_acad];
            $datos[duracion] = $pe[duracion];
            $datos[estado] = $pe[estado];
            $datos[financiacion] = $pe[financiacion];
            $datos[monto] = $pe[monto];
            $datos[id_bases] = $pe[id_bases];
            $datos[responsable_carga] = $pe[responsable_carga];
            $datos[departamento] = $pe[departamento];
            $datos[area] = $pe[area];
            $datos[fec_desde] = $pe[fec_desde];
            $datos[fec_hasta] = $pe[fec_hasta];
            $datos[denominacion] = $pe[denominacion];
            $datos[codigo] = $pe[codigo];

            $form->set_datos($datos);
        }
    }

    function evt__formulario_seg_ua__alta($datos) {

        unset($datos[uni_acad]);
        unset($datos[duracion]);
        unset($datos[estado]);
        unset($datos[financiacion]);
        unset($datos[monto]);
        unset($datos[id_bases]);
        unset($datos[responsable_carga]);
        unset($datos[departamento]);
        unset($datos[area]);
        unset($datos[fec_desde]);
        unset($datos[fec_hasta]);
        unset($datos[denominacion]);
        unset($datos[codigo]);

        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos['id_pext'] = $pe['id_pext'];

        $this->dep('datos')->tabla('seguimiento_ua')->set($datos);
        $this->dep('datos')->tabla('seguimiento_ua')->sincronizar();
        $this->dep('datos')->tabla('seguimiento_ua')->cargar($datos);

        toba::notificacion()->agregar('Los datos del seguimiento se han guardado exitosamente', 'info');
    }

    function evt__formulario_seg_ua__modificacion($datos) {


        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos['id_pext'] = $pe['id_pext'];

        $this->dep('datos')->tabla('seguimiento_ua')->set($datos);
        $this->dep('datos')->tabla('seguimiento_ua')->sincronizar();
    }

    function evt__formulario_seg_ua__baja() {
        $this->dep('datos')->tabla('seguimiento_ua')->eliminar_todo();
        $this->resetear();
        $this->set_pantalla('pant_edicion');
    }

    function evt__formulario_seg_ua__cancelar() {
        $this->resetear();
        $this->set_pantalla('pant_seguimiento_ua');
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
            case 'pant_presup':
                $this->s__mostrar_org = 1;
                $this->dep('datos')->tabla('organizaciones_participantes')->resetear();
                break;
            case 'pant_objetivos':
                $this->s__mostrar_obj = 1;
                $this->dep('datos')->tabla('objetivo_especifico')->resetear();
                break;
            case 'pant_actividad':
                $this->s__mostrar_activ = 1;
                $this->dep('datos')->tabla('plan_actividades')->resetear();
                break;
            case 'pant_destinatarios':
                $this->s__mostrar_dest = 1;
                $this->dep('datos')->tabla('destinatarios')->resetear();
                break;
            case 'pant_edicion':
                $this->set_pantalla('pant_formulario');
                $this->s__mostrar = 1;

                $this->pantalla()->tab("pant_integrantesi")->desactivar();
                $this->pantalla()->tab("pant_integrantese")->desactivar();
                $this->pantalla()->tab("pant_planilla")->desactivar();
                $this->pantalla()->tab("pant_presupuesto")->desactivar();
                $this->pantalla()->tab("pant_organizaciones")->desactivar();
                $this->pantalla()->tab("pant_objetivos")->desactivar();
                $this->pantalla()->tab("pant_actividad")->desactivar();

                $this->pantalla()->tab("pant_integrantesi")->ocultar();
                $this->pantalla()->tab("pant_integrantese")->ocultar();
                $this->pantalla()->tab("pant_planilla")->ocultar();
                $this->pantalla()->tab("pant_presupuesto")->ocultar();
                $this->pantalla()->tab("pant_organizaciones")->ocultar();
                $this->pantalla()->tab("pant_objetivos")->ocultar();
                $this->pantalla()->tab("pant_actividad")->ocultar();

                $perfil = toba::manejador_sesiones()->get_id_usuario_instancia();

                if ($perfil == formulador) {
                    $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
                }

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
                $this->set_pantalla('pant_formulario');
                $this->dep('datos')->tabla('organizaciones_participantes')->resetear();
                break;
            case 'pant_objetivos':
                $this->set_pantalla('pant_formulario');
                break;
            case 'pant_planilla':
                $this->set_pantalla('pant_formulario');
                break;
            case 'pant_actividad':
                $this->set_pantalla('pant_objetivos');
                $this->dep('datos')->tabla('plan_actividades')->resetear();
                break;
            case 'pant_destinatarios':
                $this->set_pantalla('pant_formulario');
                $this->dep('datos')->tabla('destinatarios')->resetear();
                break;
            default :
                $this->set_pantalla('pant_edicion');
                $this->dep('datos')->tabla('pextension')->resetear();
                break;
        }

        $this->s__mostrar = 0;
        $this->s__mostrar_e = 0;
        $this->s__mostrar_presup = 0;
        $this->s__mostrar_org = 0;
        $this->s__mostrar_obj = 0;
        $this->s__mostrar_activ = 0;
        $this->s__mostrar_dest = 0;
    }

    function evt__integrantesi() {
        $this->set_pantalla('pant_integrantesi');
    }

    function evt__integrantese() {

        $this->set_pantalla('pant_integrantese');
    }

    function evt__seg_central() {
        $this->set_pantalla('pant_seguimiento_central');
    }

    function evt__seg_ua() {
        $this->set_pantalla('pant_seguimiento_ua');
    }

    /* ------------------------------------------------------------------------------
     * -------------------------- Fotmulario Destinatarios --------------------------
     * ------------------------------------------------------------------------------
     */

    function conf__formulario_destinatarios(toba_ei_formulario $form) {
        if ($this->s__mostrar_dest == 1) {
            $perfil = toba::manejador_sesiones()->get_id_usuario_instancia();
            $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
            // si presiono el boton enviar no puede editar nada mas 
            if ($estado != 'FORM' && $perfil == formulador) {
                $this->dep('formulario_destinatarios')->set_solo_lectura();
                $this->dep('formulario_destinatarios')->evento('modificacion')->ocultar();
                $this->dep('formulario_destinatarios')->evento('baja')->ocultar();
                $this->dep('formulario_destinatarios')->evento('cancelar')->ocultar();
            }
            $this->dep('formulario_destinatarios')->descolapsar();
        } else {
            $this->dep('formulario_destinatarios')->colapsar();
        }

        if ($this->dep('datos')->tabla('destinatarios')->esta_cargada()) {
            $datos = $this->dep('datos')->tabla('destinatarios')->get();

            $form->set_datos($datos);
        }
    }

    function evt__formulario_destinatarios__alta($datos) {

        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos['id_pext'] = $pe['id_pext'];

        $this->dep('datos')->tabla('destinatarios')->set($datos);
        $this->dep('datos')->tabla('destinatarios')->sincronizar();
        $this->dep('datos')->tabla('destinatarios')->resetear();
        $this->s__mostrar_dest = 0;
    }

    function evt__formulario_destinatarios__modificacion($datos) {
        $this->dep('datos')->tabla('destinatarios')->set($datos);
        $this->dep('datos')->tabla('destinatarios')->sincronizar();
        $this->s__mostrar_dest = 0;
    }

    function evt__formulario_destinatarios__baja($datos) {
        $this->dep('datos')->tabla('destinatarios')->eliminar_todo();
        $this->dep('datos')->tabla('destinatarios')->resetear();
        toba::notificacion()->agregar('El integrante se ha eliminado  correctamente.', 'info');
        $this->s__mostrar_dest = 0;
    }

    function evt__formulario_destinatarios__cancelar() {
        $this->s__mostrar_dest = 0;
        $this->dep('datos')->tabla('destinatarios')->resetear();
    }

//-----------------------------------------------------------------------------------
//---- form_integrantes internos-------------------------------------------------------------
//-----------------------------------------------------------------------------------


    function conf__form_integrantes(toba_ei_formulario $form) {
        if ($this->s__mostrar == 1) {
            $perfil = toba::manejador_sesiones()->get_id_usuario_instancia();
            $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
            // si presiono el boton enviar no puede editar nada mas 
            if ($estado != 'FORM' && $perfil == formulador) {
                $this->dep('form_integrantes')->set_solo_lectura();
                $this->dep('form_integrantes')->evento('modificacion')->ocultar();
                $this->dep('form_integrantes')->evento('baja')->ocultar();
                $this->dep('form_integrantes')->evento('cancelar')->ocultar();
            }
            $this->dep('form_integrantes')->descolapsar();
        } else {
            $this->dep('form_integrantes')->colapsar();
        }

        //para la edicion de los integrantes ya cargados
        if ($this->dep('datos')->tabla('integrante_interno_pe')->esta_cargada()) {
            $datos = $this->dep('datos')->tabla('integrante_interno_pe')->get();

            $datos['funcion_p'] = str_pad($datos['funcion_p'], 5);
            $docente = $this->dep('datos')->tabla('docente')->get_id_docente($datos['id_designacion']);

            if (count($docente) > 0) {
                $datos['id_docente'] = $docente['id_docente'];
            }
            $form->set_datos($datos);
        }
    }

    function evt__form_integrantes__guardar($datos) {
        //proyecto de extension datos
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $integrantes = $this->dep('datos')->tabla('integrante_interno_pe')->get_listado($pe['id_pext']);
        $boolean = false;
        foreach ($integrantes as $integrante) {
            if (($integrante['funcion_p'] == $datos['funcion_p']) == 'D    ' OR ( $integrante['funcion_p'] == $datos['funcion_p']) == 'CD-Co ') {
                $boolean = true;
            }
        }
        if (!$boolean) {

            $datos[id_pext] = $pe['id_pext'];
            $datos['tipo'] = 'docente';
//verifico que las fechas correspondan (FALTA)

            $this->dep('datos')->tabla('integrante_interno_pe')->set($datos);
            $this->dep('datos')->tabla('integrante_interno_pe')->sincronizar();
            $this->dep('datos')->tabla('integrante_interno_pe')->resetear();


//$this->dep('datos')->tabla('integrante_interno_pe')->procesar_filas($datos);
//$this->dep('datos')->tabla('integrante_interno_pe')->sincronizar();
            $this->s__mostrar = 0;
        } else {
            toba::notificacion()->agregar(utf8_decode('Función dumplicada el director y co-director debe ser unico.'), 'info');
        }
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
//---- Formulario Integrante Externo ------------------------------------------------------------
//-----------------------------------------------------------------------------------


    function conf__form_integrante_e(toba_ei_formulario $form) {
        if ($this->s__mostrar_e == 1) {
            $perfil = toba::manejador_sesiones()->get_id_usuario_instancia();
            $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
            // si presiono el boton enviar no puede editar nada mas 
            if ($estado != 'FORM' && $perfil == formulador) {
                $this->dep('form_integrante_e')->set_solo_lectura();
                $this->dep('form_integrante_e')->evento('modificacion')->ocultar();
                $this->dep('form_integrante_e')->evento('baja')->ocultar();
                $this->dep('form_integrante_e')->evento('cancelar')->ocultar();
            }
            $this->dep('form_integrante_e')->descolapsar();
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

            $form->set_datos($datos);
        }
    }

    //ingresa un nuevo integrante 
    function evt__form_integrante_e__guardar($datos) {
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos['id_pext'] = $pe['id_pext'];
        $datos['tipo'] = 'Otro';
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

    // -------------------------------------------------------------------------
    //------------------------- Cuadro Destinatarios ---------------------------
    //--------------------------------------------------------------------------

    function conf__cuadro_destinatarios(toba_ei_cuadro $cuadro) {
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos = $this->dep('datos')->tabla('destinatarios')->get_listado($pe['id_pext']);

        $cuadro->set_datos($datos);
    }

    function evt__cuadro_destinatarios__seleccion($datos) {
        $this->dep('datos')->tabla('destinatarios')->cargar($datos);
        $this->s__mostrar_dest = 1;
    }

    // -------------------------------------------------------------------------
    //------------------------- Cuadro Seg_central ---------------------------
    //--------------------------------------------------------------------------

    function conf__cuadro_seg_central(toba_ei_cuadro $cuadro) {
        $pe = $this->dep('datos')->tabla('pextension')->get();

        $datos = $this->dep('datos')->tabla('seguimiento_central')->get_listado($pe['id_pext']);
        $datos[0]['denominacion'] = $pe['denominacion'];

        $cuadro->set_datos($datos);
        $perfil = toba::manejador_sesiones()->get_perfiles_funcionales()[0];
        if ($perfil != 'sec_ext_central') {
            $this->dep('cuadro_seg_central')->evento('alta')->ocultar();
            $this->dep('cuadro_seg_central')->evento('editar')->ocultar();
        } else {
            $pext = $this->dep('datos')->tabla('pextension')->get();
            if ($this->dep('datos')->tabla('seguimiento_central')->get_listado($pext['id_pext'])[0]) {
                $this->dep('cuadro_seg_central')->evento('alta')->ocultar();
            } else {
                $this->dep('cuadro_seg_central')->evento('editar')->ocultar();
            }
        }
    }

    function evt__cuadro_seg_central__seleccion($datos) {
        $this->dep('datos')->tabla('seguimiento_central')->cargar($datos);
        $this->set_pantalla('pant_seguimiento_central');
        $this->dep('formulario_seguimiento')->set_solo_lectura();
        $this->dep('formulario_seguimiento')->evento('modificacion')->ocultar();
        $this->dep('formulario_seguimiento')->evento('baja')->ocultar();
        $this->dep('formulario_seguimiento')->evento('cancelar')->ocultar();
    }

    function evt__cuadro_seg_central__editar($datos) {
        $this->dep('datos')->tabla('seguimiento_central')->cargar($datos);
        $this->set_pantalla('pant_seguimiento_central');
    }

    function evt__cuadro_seg_central__alta($datos) {
        $this->dep('datos')->tabla('seguimiento_central')->cargar($datos);
        $this->set_pantalla('pant_seguimiento_central');
    }

    // -------------------------------------------------------------------------
    //------------------------- Cuadro Seg_ua ---------------------------
    //--------------------------------------------------------------------------

    function conf__cuadro_seg_ua(toba_ei_cuadro $cuadro) {
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos = $this->dep('datos')->tabla('seguimiento_ua')->get_listado($pe['id_pext']);
        $datos[0]['denominacion'] = $pe['denominacion'];

        $cuadro->set_datos($datos);


        $perfil = toba::manejador_sesiones()->get_perfiles_funcionales()[0];
        if ($perfil != 'sec_ext_ua') {
            $this->dep('cuadro_seg_ua')->evento('alta')->ocultar();
            $this->dep('cuadro_seg_ua')->evento('editar')->ocultar();
        } else {
            $pext = $this->dep('datos')->tabla('pextension')->get();
            if ($this->dep('datos')->tabla('seguimiento_ua')->get_listado($pext['id_pext'])[0]) {
                $this->dep('cuadro_seg_ua')->evento('alta')->ocultar();
            } else {
                $this->dep('cuadro_seg_ua')->evento('editar')->ocultar();
            }
        }
    }

    function evt__cuadro_seg_ua__seleccion($datos) {
        $this->dep('datos')->tabla('seguimiento_ua')->cargar($datos);
        $this->set_pantalla('pant_seguimiento_ua');
        $this->dep('formulario_seg_ua')->set_solo_lectura();
        $this->dep('formulario_seg_ua')->evento('modificacion')->ocultar();
        $this->dep('formulario_seg_ua')->evento('baja')->ocultar();
        $this->dep('formulario_seg_ua')->evento('cancelar')->ocultar();
    }

    function evt__cuadro_seg_ua__editar($datos) {
        $this->dep('datos')->tabla('seguimiento_ua')->cargar($datos);
        $this->set_pantalla('pant_seguimiento_ua');
    }
    
    function evt__cuadro_seg_ua__alta($datos) {
        $this->dep('datos')->tabla('seguimiento_ua')->cargar($datos);
        $this->set_pantalla('pant_seguimiento_ua');
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

//-----------------------------------------------------------------------------------
//---- form_presupuesto-------------------------------------------------------------
//-----------------------------------------------------------------------------------

    function conf__form_presupuesto(toba_ei_formulario $form) {

        if ($this->s__mostrar_presup == 1) {
            $perfil = toba::manejador_sesiones()->get_id_usuario_instancia();
            $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
            // si presiono el boton enviar no puede editar nada mas 
            if ($estado != 'FORM' && $perfil == formulador) {
                $this->dep('form_presupuesto')->set_solo_lectura();
                $this->dep('form_presupuesto')->evento('modificacion')->ocultar();
                $this->dep('form_presupuesto')->evento('baja')->ocultar();
                $this->dep('form_presupuesto')->evento('cancelar')->ocultar();
            }
            $this->dep('form_presupuesto')->descolapsar();
            $form->ef('concepto')->set_obligatorio('true');
            $form->ef('cantidad')->set_obligatorio('true');
            $form->ef('monto')->set_obligatorio('true');
        } else {
            $this->dep('form_presupuesto')->colapsar();
        }

        if ($this->dep('datos')->tabla('presupuesto_extension')->esta_cargada()) {

            $datos = $this->dep('datos')->tabla('presupuesto_extension')->get();

            $form->set_datos($datos);
        }
    }

    function evt__form_presupuesto__guardar($datos) {

        $pe = $this->dep('datos')->tabla('pextension')->get();

        $datos[id_pext] = $pe['id_pext'];

        $monto_max = $this->dep('datos')->tabla('bases_convocatoria')->get_monto($pe[id_bases])[0][monto_max];

        if (($pe[monto] + $datos[monto]) <= $monto_max) {

            $this->dep('datos')->tabla('presupuesto_extension')->set($datos);
            $this->dep('datos')->tabla('presupuesto_extension')->sincronizar();
            $this->dep('datos')->tabla('presupuesto_extension')->resetear();
            $this->s__mostrar_presup = 0;
        } else {
            $monto_restante = $monto_max - $pe[monto];
            toba::notificacion()->agregar('Se supero el monto maximo de presupuesto , restantes: ' . $monto_restante, 'info');
        }
    }

    function evt__form_presupuesto__baja($datos) {
        $this->dep('datos')->tabla('presupuesto_extension')->eliminar_todo();
        $this->dep('datos')->tabla('presupuesto_extension')->resetear();
        toba::notificacion()->agregar('El presupuesto se ha eliminado  correctamente.', 'info');
        $this->s__mostrar_presup = 0;
    }

    function evt__form_presupuesto__modificacion($datos) {

        $pe = $this->dep('datos')->tabla('pextension')->get();

        $datos[id_pext] = $pe['id_pext'];

        $monto_max = $this->dep('datos')->tabla('bases_convocatoria')->get_monto($pe[id_bases])[0][monto_max];


        if (($pe[monto] + $datos[monto]) <= $monto_max) {

            $this->dep('datos')->tabla('presupuesto_extension')->set($datos);
            $this->dep('datos')->tabla('presupuesto_extension')->sincronizar();
            $this->s__mostrar_presup = 0;
        } else {
            $monto_restante = $monto_max - $pe[monto];
            toba::notificacion()->agregar('Se supero el monto maximo de presupuesto , restantes: ' . $monto_restante, 'info');
        }
    }

    function evt__form_presupuesto__cancelar() {
        $this->s__mostrar_presup = 0;
        $this->dep('datos')->tabla('presupuesto_extension')->resetear();
    }

//-----------------------------------------------------------------------------------
//---- cuadro filtro de organizaciones-------------------------------------------------------------
//-----------------------------------------------------------------------------------

    function conf__cuadro_org_filtro(toba_ei_cuadro $cuadro) {
        $pe = $this->dep('datos')->tabla('pextension')->get();

        $datos = $this->dep('datos')->tabla('organizaciones_participantes')->get_listado_filtro($pe['id_pext'], $this->s__where);

        $cuadro->set_datos($datos);
    }

    function evt__cuadro_org_filtro__seleccion($datos) {
//$this->s__mostrar = 1;
        /* aca deberia ser capas de diferencia entre si es interno o externo para poder derivar
         * a las diferentes pantallas */
        $this->set_pantalla('pant_formulario');
        $this->dep('datos')->tabla('pextension')->cargar($datos);
    }

//---- Filtro Organizacion-----------------------------------------------------------------------

    function conf__filtro_organizaciones(toba_ei_filtro $filtro) {
        if (isset($this->s__datos_filtro)) {
            $filtro->set_datos($this->s__datos_filtro);
        }
    }

    function evt__filtro_organizaciones__filtrar($datos) {
//      print_r($datos);        exit();
        $this->s__datos_filtro = $datos;
        $this->s__where = $this->dep('filtro')->get_sql_where();
    }

    function evt__filtro_organizaciones__cancelar() {
        unset($this->s__datos_filtro);
    }

//-----------------------------------------------------------------------------------
//---- formulario pextension de organizaciones-------------------------------------------------------------
//-----------------------------------------------------------------------------------

    function conf__form_pexten(toba_ei_formulario $form) {
        $this->pantalla()->tab("pant_edicion")->desactivar();
        $form->set_datos($this->dep('datos')->tabla('pextension')->get());
    }

//-----------------------------------------------------------------------------------
//---- formulario de organizaciones-------------------------------------------------------------
//-----------------------------------------------------------------------------------

    function conf__form_organizacion(toba_ei_formulario $form) {

        if ($this->s__mostrar_org == 1) {// si presiono el boton alta entonces muestra el formulario para dar de alta un nuevo registro
            $perfil = toba::manejador_sesiones()->get_id_usuario_instancia();
            $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
            // si presiono el boton enviar no puede editar nada mas 
            if ($estado != 'FORM' && $perfil == formulador) {
                $this->dep('form_organizacion')->set_solo_lectura();
                $this->dep('form_organizacion')->evento('modificacion')->ocultar();
                $this->dep('form_organizacion')->evento('baja')->ocultar();
                $this->dep('form_organizacion')->evento('cancelar')->ocultar();
            }
            $this->dep('form_organizacion')->descolapsar();
            $form->ef('nombre')->set_obligatorio('true');
            $form->ef('domicilio')->set_obligatorio('true');
            $form->ef('telefono')->set_obligatorio('true');
            $form->ef('email')->set_obligatorio('true');
            $form->ef('referencia_vinculacion_inst')->set_obligatorio('true');
        } else {
            $this->dep('form_organizacion')->colapsar();
        }

        if ($this->dep('datos')->tabla('organizaciones_participantes')->esta_cargada()) {
            $datos = $this->dep('datos')->tabla('organizaciones_participantes')->get();
            $form->set_datos($datos);
        }
    }

    function evt__form_organizacion__guardar($datos) {
        $pe = $this->dep('datos')->tabla('pextension')->get();

        $datos[id_pext] = $pe['id_pext'];

        $this->dep('datos')->tabla('organizaciones_participantes')->set($datos);
        $this->dep('datos')->tabla('organizaciones_participantes')->sincronizar();
        $this->dep('datos')->tabla('organizaciones_participantes')->resetear();
        $this->s__mostrar_org = 0;
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
        $this->s__mostrar_org = 0;
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

        $this->pantalla()->tab("pant_integrantesi")->desactivar();
        $this->pantalla()->tab("pant_integrantese")->desactivar();
        $this->pantalla()->tab("pant_actividad")->desactivar();

        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();
        $this->pantalla()->tab("pant_seguimiento")->ocultar();
    }

    function conf__pant_seguimiento(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_seguimiento";

        $this->pantalla()->tab("pant_integrantesi")->desactivar();
        $this->pantalla()->tab("pant_integrantese")->desactivar();
        $this->pantalla()->tab("pant_actividad")->desactivar();

        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();
        /*
          $pext =$this->dep('datos')->tabla('pextension')->get();
          $seg_ua = $this->dep('datos')->tabla('seguimiento_ua')->get_listado($pext['id_pext']);
          if (!is_null($seg_ua)) {
          $this->controlador()->evento('seg_ua')->ocultar();
          }else{
          $seg_central = $this->dep('datos')->tabla('seguimiento_central')->get_listado($pext['id_pext']);
          if (!is_null($seg_ua)) {
          $this->controlador()->evento('seg_central')->ocultar();
          } */
    }

    function conf__pant_destinatarios(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_destinatarios";

        $this->pantalla()->tab("pant_edicion")->desactivar();
        $this->pantalla()->tab("pant_integrantesi")->desactivar();
        $this->pantalla()->tab("pant_integrantese")->desactivar();
        $this->pantalla()->tab("pant_actividad")->desactivar();

        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();

        $perfil = toba::manejador_sesiones()->get_id_usuario_instancia();
        if ($perfil == formulador) {
            $this->pantalla()->tab("pant_seguimiento")->ocultar();
        }
    }

    function conf__pant_seguimiento_central(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_seguimiento_central";

        $this->pantalla()->tab("pant_edicion")->desactivar();
        $this->pantalla()->tab("pant_integrantesi")->desactivar();
        $this->pantalla()->tab("pant_integrantese")->desactivar();
        $this->pantalla()->tab("pant_actividad")->desactivar();

        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();
    }

    function conf__pant_seguimiento_ua(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_seguimiento_central";

        $this->pantalla()->tab("pant_edicion")->desactivar();
        $this->pantalla()->tab("pant_integrantesi")->desactivar();
        $this->pantalla()->tab("pant_integrantese")->desactivar();
        $this->pantalla()->tab("pant_actividad")->desactivar();

        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
    }

    function conf__pant_formulario(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_formulario";

        $this->pantalla()->tab("pant_edicion")->desactivar();
        $this->pantalla()->tab("pant_integrantesi")->desactivar();
        $this->pantalla()->tab("pant_integrantese")->desactivar();
        $this->pantalla()->tab("pant_actividad")->desactivar();

        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();

        $perfil = toba::manejador_sesiones()->get_id_usuario_instancia();

        if ($perfil == formulador) {

            $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
            // si presiono el boton enviar no puede editar nada mas 
            if ($estado != 'FORM') {
                $this->controlador()->evento('enviar')->ocultar();
            } else {
                $this->pantalla()->tab("pant_seguimiento")->ocultar();
            }
        }
    }

    function conf__pant_integrantesi(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_interno";
        $this->pantalla()->tab("pant_edicion")->desactivar();
        $this->pantalla()->tab("pant_integrantese")->desactivar();
        $this->pantalla()->tab("pant_actividad")->desactivar();

        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();

        $perfil = toba::manejador_sesiones()->get_id_usuario_instancia();
        if ($perfil == formulador) {

            $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
            // si presiono el boton enviar no puede editar nada mas 
            if ($estado != 'FORM') {
                $this->controlador()->evento('alta')->ocultar();
            }
            $this->pantalla()->tab("pant_seguimiento")->ocultar();
        }
    }

    function conf__pant_integrantese(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_externo";
        $this->pantalla()->tab("pant_edicion")->desactivar();
        $this->pantalla()->tab("pant_integrantesi")->desactivar();
        $this->pantalla()->tab("pant_actividad")->desactivar();

        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();

        $perfil = toba::manejador_sesiones()->get_id_usuario_instancia();
        if ($perfil == formulador) {

            $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
            // si presiono el boton enviar no puede editar nada mas 
            if ($estado != 'FORM') {
                $this->controlador()->evento('alta')->ocultar();
            }
            $this->pantalla()->tab("pant_seguimiento")->ocultar();
        }
    }

    function conf__pant_planilla(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_planilla";

        $this->pantalla()->tab("pant_edicion")->desactivar();
        $this->pantalla()->tab("pant_integrantesi")->desactivar();
        $this->pantalla()->tab("pant_integrantese")->desactivar();
        $this->pantalla()->tab("pant_actividad")->desactivar();

        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();

        $perfil = toba::manejador_sesiones()->get_id_usuario_instancia();
        if ($perfil == formulador) {
            $this->pantalla()->tab("pant_seguimiento")->ocultar();
        }
    }

    function conf__pant_organizaciones(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_organizaciones";

        $this->pantalla()->tab("pant_edicion")->desactivar();
        $this->pantalla()->tab("pant_integrantesi")->desactivar();
        $this->pantalla()->tab("pant_integrantese")->desactivar();
        $this->pantalla()->tab("pant_actividad")->desactivar();

        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();

        $perfil = toba::manejador_sesiones()->get_id_usuario_instancia();
        if ($perfil == formulador) {
            $this->pantalla()->tab("pant_seguimiento")->ocultar();

            $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
            // si presiono el boton enviar no puede editar nada mas 
            if ($estado != 'FORM') {
                $this->controlador()->evento('alta')->ocultar();
            }
        }
    }

    function conf__pant_objetivos(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_objetivos";

        $this->pantalla()->tab("pant_edicion")->desactivar();
        $this->pantalla()->tab("pant_integrantesi")->desactivar();
        $this->pantalla()->tab("pant_integrantese")->desactivar();
        $this->pantalla()->tab("pant_actividad")->desactivar();

        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();

        $perfil = toba::manejador_sesiones()->get_id_usuario_instancia();
        if ($perfil == formulador) {
            $this->pantalla()->tab("pant_seguimiento")->ocultar();

            $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
            // si presiono el boton enviar no puede editar nada mas 
            if ($estado != 'FORM') {
                $this->controlador()->evento('alta')->ocultar();
            }
        }
    }

    function conf__pant_actividad(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_actividad";

        $this->pantalla()->tab("pant_edicion")->desactivar();
        $this->pantalla()->tab("pant_integrantesi")->desactivar();
        $this->pantalla()->tab("pant_integrantese")->desactivar();

        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();

        $perfil = toba::manejador_sesiones()->get_id_usuario_instancia();
        if ($perfil == formulador) {
            $this->pantalla()->tab("pant_seguimiento")->ocultar();

            $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
            // si presiono el boton enviar no puede editar nada mas 
            if ($estado != 'FORM') {
                $this->controlador()->evento('alta')->ocultar();
            }
        }
    }

    function conf__pant_presupuesto(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_presup";

        $this->pantalla()->tab("pant_edicion")->desactivar();
        $this->pantalla()->tab("pant_integrantesi")->desactivar();
        $this->pantalla()->tab("pant_integrantese")->desactivar();
        $this->pantalla()->tab("pant_actividad")->desactivar();

        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();

        $perfil = toba::manejador_sesiones()->get_id_usuario_instancia();
        if ($perfil == formulador) {
            $this->pantalla()->tab("pant_seguimiento")->ocultar();

            $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
            // si presiono el boton enviar no puede editar nada mas 
            if ($estado != 'FORM') {
                $this->controlador()->evento('alta')->ocultar();
            }
        }
    }

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
        $pe = $this->dep('datos')->tabla('pextension')->get();

        $cuadro->set_datos($this->dep('datos')->tabla('organizaciones_participantes')->get_listado($pe['id_pext']));
    }

    function evt__cuadro_organizaciones__seleccion($datos) {

        $this->s__mostrar_org = 1;
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos['id_pext'] = $pe['id_pext'];

        $this->dep('datos')->tabla('organizaciones_participantes')->cargar($datos);
    }

//-----------------------------------------------------------------------------------
//---- cuadro_presup  -------------------------------------------------------------------
//-----------------------------------------------------------------------------------

    function conf__cuadro_presup(toba_ei_cuadro $cuadro) {
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $cuadro->set_datos($this->dep('datos')->tabla('presupuesto_extension')->get_listado($pe['id_pext']));

        $datos = $cuadro->get_datos();
        $monto = 0;
        foreach ($datos as $dato) {
            $monto = $monto + $dato[monto];
        }

        $pe[monto] = $monto;

        $this->dep('datos')->tabla('pextension')->set($pe);
        $this->dep('datos')->tabla('pextension')->sincronizar();
    }

    function evt__cuadro_presup__seleccion($datos) {

        $this->s__mostrar_presup = 1;
        $presup = $this->dep('datos')->tabla('presupuesto_extension')->get_datos($datos);

        $this->dep('datos')->tabla('presupuesto_extension')->cargar($presup[0]);
    }

//-----------------------------------------------------------------------------------
//---- formulario_pext de objetivos--------------------------------------------------------------------
//-----------------------------------------------------------------------------------

    function conf__formulario_pext(toba_ei_formulario $form) {
        $this->pantalla()->tab("pant_edicion")->desactivar();
        $form->set_datos($this->dep('datos')->tabla('pextension')->get());
    }

//-----------------------------------------------------------------------------------
//---- cuadro_objetivo  -------------------------------------------------------------------
//-----------------------------------------------------------------------------------

    function conf__cuadro_objetivo(toba_ei_cuadro $cuadro) {

        $pe = $this->dep('datos')->tabla('pextension')->get();
        $cuadro->set_datos($this->dep('datos')->tabla('objetivo_especifico')->get_listado($pe['id_pext']));
    }

    function evt__cuadro_objetivo__seleccion($datos) {
        $this->s__where = $datos;
        $this->set_pantalla('pant_actividad');
    }

    function evt__cuadro_objetivo__modificacion($datos) {

        $this->s__mostrar_obj = 1;
        $obj_esp = $this->dep('datos')->tabla('objetivo_especifico')->get_datos($datos[id_objetivo]);
        $this->dep('datos')->tabla('objetivo_especifico')->cargar($obj_esp[0]);
    }

//-----------------------------------------------------------------------------------
//---- formulario de objetivos-------------------------------------------------------------
//-----------------------------------------------------------------------------------

    function conf__form_objetivos_esp(toba_ei_formulario $form) {

        if ($this->s__mostrar_obj == 1) {
            $perfil = toba::manejador_sesiones()->get_id_usuario_instancia();
            $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
            // si presiono el boton enviar no puede editar nada mas 
            if ($estado != 'FORM' && $perfil == formulador) {
                $this->dep('form_objetivos_esp')->set_solo_lectura();
                $this->dep('form_objetivos_esp')->evento('modificacion')->ocultar();
                $this->dep('form_objetivos_esp')->evento('baja')->ocultar();
                $this->dep('form_objetivos_esp')->evento('cancelar')->ocultar();
            }
            $this->dep('form_objetivos_esp')->descolapsar();
            $form->ef('descripcion')->set_obligatorio('true');
            $form->ef('meta')->set_obligatorio('true');
            $form->ef('ponderacion')->set_obligatorio('true');
        } else {
            $this->dep('form_objetivos_esp')->colapsar();
        }

        if ($this->dep('datos')->tabla('objetivo_especifico')->esta_cargada()) {
            $datos = $this->dep('datos')->tabla('objetivo_especifico')->get();
            $form->set_datos($datos);
        }
    }

    function evt__form_objetivos_esp__guardar($datos) {
        $pe = $this->dep('datos')->tabla('pextension')->get();

        $datos[id_pext] = $pe['id_pext'];

        $this->dep('datos')->tabla('objetivo_especifico')->set($datos);
        $this->dep('datos')->tabla('objetivo_especifico')->sincronizar();
        $this->dep('datos')->tabla('objetivo_especifico')->resetear();
    }

    function evt__form_objetivos_esp__baja($datos) {
        $this->dep('datos')->tabla('objetivo_especifico')->eliminar_todo();
        $this->dep('datos')->tabla('objetivo_especifico')->resetear();
        toba::notificacion()->agregar('El objetivo se ha eliminado  correctamente.', 'info');
        $this->s__mostrar_obj = 0;
    }

    function evt__form_objetivos_esp__modificacion($datos) {
        $this->dep('datos')->tabla('objetivo_especifico')->set($datos);
        $this->dep('datos')->tabla('objetivo_especifico')->sincronizar();
    }

    function evt__form_objetivos_esp__cancelar() {
        $this->s__mostrar_obj = 0;
        $this->dep('datos')->tabla('objetivo_especifico')->resetear();
    }

//-----------------------------------------------------------------------------------
//---- cuadro_objetivo  -------------------------------------------------------------------
//-----------------------------------------------------------------------------------


    /*
     * * Posiblemente haya que modificar el cuadro una vez que esté bien definido el plan
     */
    function conf__cuadro_plan(toba_ei_cuadro $cuadro) {
        $pe = $this->dep('datos')->tabla('pextension')->get();

        $obj_esp = $this->s__where;


        $cuadro->set_datos($this->dep('datos')->tabla('plan_actividades')->get_listado($obj_esp['id_objetivo']));
    }

    function evt__cuadro_plan__seleccion($datos) {

        $this->s__mostrar_activ = 1;

        $pe = $this->dep('datos')->tabla('pextension')->get();
        $obj_esp = $this->dep('datos')->tabla('objetivo_especifico')->get_datos($pe['id_pext']);

        $datos[id_obj_especifico] = $obj_esp[0]['id_objetivo'];

        $plan = $this->dep('datos')->tabla('plan_actividades')->get_datos($datos);

        $this->dep('datos')->tabla('plan_actividades')->cargar($plan[0]);
    }

//-----------------------------------------------------------------------------------
//---- formulario de objetivos-------------------------------------------------------------
//-----------------------------------------------------------------------------------

    function conf__form_actividad(toba_ei_formulario $form) {

        if ($this->s__mostrar_activ == 1) {
            $perfil = toba::manejador_sesiones()->get_id_usuario_instancia();
            $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
            // si presiono el boton enviar no puede editar nada mas 
            if ($estado != 'FORM' && $perfil == formulador) {
                $this->dep('form_actividad')->set_solo_lectura();
                $this->dep('form_actividad')->evento('modificacion')->ocultar();
                $this->dep('form_actividad')->evento('baja')->ocultar();
                $this->dep('form_actividad')->evento('cancelar')->ocultar();
            }
            $this->dep('form_actividad')->descolapsar();
        } else {
            $this->dep('form_actividad')->colapsar();
        }

        if ($this->dep('datos')->tabla('plan_actividades')->esta_cargada()) {

            $datos = $this->dep('datos')->tabla('plan_actividades')->get();

            $dest = array();
            $aux = $datos['destinatarios'];
            for ($i = 0; $i < strlen($aux); $i++) {
                if ($aux[$i] != '{' AND $aux[$i] != ',' AND $aux[$i] != '}') {
                    $dest . array_push($dest, $aux[$i]);
                }
            }
            $datos['destinatarios'] = $dest;


            $form->set_datos($datos);
        }
    }

    function evt__form_actividad__guardar($datos) {
        print_r($datos);
        $pe = $this->dep('datos')->tabla('pextension')->get();

        //$obj_esp = $this->dep('datos')->tabla('objetivo_especifico')->get_datos($pe['id_pext']);
        $obj_esp = $this->s__where;
        $datos[id_obj_especifico] = $obj_esp['id_objetivo'];

        $destinatarios = $datos['destinatarios'];

        $array = '{' . $destinatarios[0];
        unset($destinatarios[0]);
        foreach ($destinatarios as $destinatario) {
            $array = $array . ',' . $destinatario;
        }
        $array = $array . '}';
        $datos['destinatarios'] = $array;


        if ($datos[anio] > date('Y') + 1) {
            toba::notificacion()->agregar('La actividad tendra fecha de comienzo el anio entrante', 'info');
            $datos[anio] = date('Y') + 1;
        }
        $this->dep('datos')->tabla('plan_actividades')->set($datos);
        $this->dep('datos')->tabla('plan_actividades')->sincronizar();
        $this->dep('datos')->tabla('plan_actividades')->resetear();
        $this->s__mostrar_activ = 0;
    }

    function evt__form_actividad__baja($datos) {
        $this->dep('datos')->tabla('plan_actividades')->eliminar_todo();
        $this->dep('datos')->tabla('plan_actividades')->resetear();
        toba::notificacion()->agregar('El plan de actividades se ha eliminado  correctamente.', 'info');

        $this->s__mostrar_activ = 0;
    }

    function evt__form_actividad__modificacion($datos) {
        if ($datos[anio] > date('Y') + 1) {
            toba::notificacion()->agregar('La actividad tendra fecha de comienzo el anio entrante', 'info');
            $datos[anio] = date('Y') + 1;
        }
        $destinatarios = $datos['destinatarios'];

        $destinatarios = $datos['destinatarios'];

        $array = '{' . $destinatarios[0];
        unset($destinatarios[0]);
        foreach ($destinatarios as $destinatario) {
            $array = $array . ',' . $destinatario;
        }
        $array = $array . '}';
        $datos['destinatarios'] = $array;

        $this->dep('datos')->tabla('plan_actividades')->set($datos);
        $this->dep('datos')->tabla('plan_actividades')->sincronizar();
        $this->s__mostrar_activ = 0;
    }

    function evt__form_actividad__cancelar() {
        $this->s__mostrar_activ = 0;
        $this->dep('datos')->tabla('plan_actividades')->resetear();
    }

}

?>
