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
    protected $tamano_byte = 2000000;
    protected $tamano_mega = 2;
    protected $s__imprimir = 1;
    protected $s__imprimir_resumen = 0;
    protected $s__datos;
    protected $s__organizacion;
    protected $s__destinatario;
    protected $s__cv_interno;
    protected $s__cv_externo;
    protected $s__nombre;
    protected $s__pdf;
    protected $s__pextension;

    // GENERA O OBTIENE PDF
    function vista_pdf(toba_vista_pdf $salida) {
        if (isset($this->s__pextension)) {
            $pextension['id_pext'] = $this->s__pextension;
            $this->dep('datos')->tabla('pextension')->resetear(); //limpia
            $this->dep('datos')->tabla('pextension')->cargar($pextension); //carga el articulo que se selecciono
        }

        if ($this->s__imprimir == 1) {

            if ($this->dep('datos')->tabla('pextension')->esta_cargada()) {

                //Proyectos de extension
                $pextension = $this->dep('datos')->tabla('pextension')->get();

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
                $ejes = array();
                $aux = $datos['eje_tematico'];
                for ($i = 0; $i < strlen($aux); $i++) {
                    if ($aux[$i] != '{' AND $aux[$i] != ',' AND $aux[$i] != '}') {
                        if ($aux[$i + 1] != '{' AND $aux[$i + 1] != ',' AND $aux[$i + 1] != '}') {
                            $ejes . array_push($ejes, $aux[$i] . $aux[$i + 1]);
                            $i++;
                        } else {
                            $ejes . array_push($ejes, $aux[$i]);
                        }
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

                $destinatarios = $this->dep('datos')->tabla('destinatarios')->get_listado($datos[id_pext]);


                $datos[id_bases] = $bases['bases_titulo'];
                $datos[id_conv] = $bases[descripcion];

                //obtengo director 
                $director = $this->dep('datos')->tabla('integrante_interno_pe')->get_director($datos[id_pext]);
                $director = $director[0];

                //obtengo co-director
                $co_director = $this->dep('datos')->tabla('integrante_interno_pe')->get_co_director($datos[id_pext]);
                $co_director = $co_director[0];

                //Objetivos Especificos 
                $obj_especificos = $this->dep('datos')->tabla('objetivo_especifico')->get_listado($datos[id_pext]);

                $integrantes = $this->dep('datos')->tabla('integrante_externo_pe')->get_plantilla($datos[id_pext]);

                $presupuestos = $this->dep('datos')->tabla('presupuesto_extension')->get_listado($datos[id_pext]);

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
                $formato = utf8_decode('Mocovi - Extension       ' . date('d/m/Y h:i:s a') . '     Página {PAGENUM} de {TOTALPAGENUM} ');

                //Determinamos la ubicación del número página en el pié de pagina definiendo las coordenadas x y, tamaño de letra, posición, texto, pagina inicio 
                $pdf->ezStartPageNumbers(300, 20, 8, 'justify', $formato, 1);
                //$pdf->ezText('full');
                //Luego definimos la ubicación de la fecha en el pie de página.
                //$pdf->addText(380, 20, 8, 'Mocovi - Extension ' . date('d/m/Y h:i:s a'));

                $titulo = "   ";
                $opciones = array(
                    'splitRows' => 0,
                    'rowGap' => 1, //, the space between the text and the row lines on each row
                    // 'lineCol' => (r,g,b) array,// defining the colour of the lines, default, black.
                    'showLines' => 2, //coloca las lineas horizontales
                    'showHeadings' => true, //muestra el nombre de las columnas
                    'titleFontSize' => 12,
                    'fontSize' => 8,
                    //'shadeCol' => array(1,1,1,1,1,1,1,1,1,1,1,1),
                    'shadeCol' => array(100, 100, 100), //darle color a las filas intercaladamente
                    'outerLineThickness' => 0.7,
                    'innerLineThickness' => 0.7,
                    'xOrientation' => 'center',
                    'width' => 820//,
                        //'cols' =>array('col2'=>array('justification'=>'center') ,'col3'=>array('justification'=>'center'),'col4'=>array('justification'=>'center') ,'col5'=>array('justification'=>'center'),'col6'=>array('justification'=>'center') ,'col7'=>array('justification'=>'center') ,'col8'=>array('justification'=>'center'),'col9'=>array('justification'=>'center') ,'col10'=>array('justification'=>'center') ,'col11'=>array('justification'=>'center') ,'col12'=>array('justification'=>'center'),'col13'=>array('justification'=>'center') ,'col14'=>array('justification'=>'center') )
                );

                //Configuración de Título.
                $salida->titulo(utf8_d_seguro('UNIVERSIDAD NACIONAL DEL COMAHUE' . chr(10) . 'SECRETARÍA DE EXTENSIÓN UNIVERSITARIA'));


                $pdf->ezText("\n\n\n\n", 10, ['justification' => 'full']);
                //Pantalla Principal Formulario
                //Director 

                $datos_dir = array();
                $datos_dir[0] = array('col1' => '<b>Director del Proyecto</b>');
                $pdf->ezTable($datos_dir, array('col1' => ''), ' ', array('showHeadings' => 0, 'shaded' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'center', 'width' => 550))));
                $cols_dp = array('col1' => "<b>Datos Principales</b>", 'col2' => '');

                $tabla_dp = array();
                $tabla_dp[0] = array('col1' => "<b>Nombre</b>", 'col2' => '<b>' . mb_strtoupper($director[nombre], 'LATIN1') . '</b>');
                $tabla_dp[1] = array('col1' => utf8_d_seguro('Unidad Académica'), 'col2' => $director[ua]);
                $tabla_dp[2] = array('col1' => 'Tipo y Nro. de documento', 'col2' => $director[tipo_docum] . ' ' . $director[nro_docum]);
                $tabla_dp[3] = array('col1' => 'Telefono', 'col2' => $director[telefono]);
                $tabla_dp[4] = array('col1' => 'Correo', 'col2' => $director[correo_institucional]);
                //$cols_dp[] = array('col1' => '', 'col2' => );

                $pdf->ezTable($tabla_dp, $cols_dp, '', array('shaded' => 0, 'showLines' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'right', 'width' => 200), 'col2' => array('width' => 350))));

                //Co-Director 
                if ($this->s__imprimir_resumen == 0) {
                    $datos_CO = array();
                    $datos_CO[0] = array('col1' => '<b> Co-Director del Proyecto</b>');
                    $pdf->ezTable($datos_CO, array('col1' => ''), ' ', array('showHeadings' => 0, 'shaded' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'center', 'width' => 550))));
                    $cols_dp = array('col1' => "<b>Datos Principales</b>", 'col2' => '');

                    $tabla_dp = array();
                    $tabla_dp[0] = array('col1' => "<b>Nombre</b>", 'col2' => '<b>' . mb_strtoupper($co_director[nombre], 'LATIN1') . '</b>');
                    $tabla_dp[1] = array('col1' => utf8_d_seguro('Unidad Académica'), 'col2' => $co_director[ua]);
                    $tabla_dp[2] = array('col1' => 'Tipo y Nro. de documento', 'col2' => $co_director[tipo_docum] . ' ' . $co_director[nro_docum]);
                    $tabla_dp[3] = array('col1' => 'Telefono', 'col2' => $co_director[telefono]);
                    $tabla_dp[4] = array('col1' => 'Correo', 'col2' => $co_director[correo_institucional]);

                    $pdf->ezTable($tabla_dp, $cols_dp, '', array('shaded' => 0, 'showLines' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'right', 'width' => 200), 'col2' => array('width' => 350))));

                    //salto de linea
                    $pdf->ezText("\n", 10, ['justification' => 'full']);
                }

                //Indentificacion del Proyecto

                $datos_pext = array();
                $datos_pext[0] = array('col1' => '<b> Datos generales </b>');
                $pdf->ezTable($datos_pext, array('col1' => ''), ' ', array('showHeadings' => 0, 'shaded' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'center', 'width' => 550))));
                //$cols_dp = array('col1'=>"<b>Datos Principales</b>",'col2'=>'');

                $tabla_dp = array();
                //Nombre del Proyecto
                $tabla_dp[0] = array('col1' => "<b>Nombre del proyecto </b>", 'col2' => '<b>' . mb_strtoupper($datos['denominacion'], 'LATIN1') . '</b>');
                $tabla_dp[1] = array('col1' => utf8_d_seguro('Unidad Académica'), 'col2' => $datos['uni_acad']);


                $col2 = '';
                foreach ($ejes_tematicos as $eje) {
                    $col2 = '* ' . $eje . "\n";
                    //$tabla_dp[$i] = array('col1' => '', 'col2' => '- ' . $eje);
                    //$i = $i + 1;
                }
                $tabla_dp[2] = array('col1' => 'Ejes tematicos', 'col2' => $col2);
                $i = 3;

                $i = $i + 1;
                $tabla_dp[$i] = array('col1' => 'Palabras Claves', 'col2' => $datos['palabras_clave']);
                $i = $i + 1;
                $tabla_dp[$i] = array('col1' => 'Titulo Bases', 'col2' => $datos['id_bases']);
                $i = $i + 1;
                $tabla_dp[$i] = array('col1' => 'Tipo Convocatoria', 'col2' => $datos['id_conv']);


                $pdf->ezTable($tabla_dp, $cols_dp, '', array('shaded' => 0, 'showLines' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'right', 'width' => 200), 'col2' => array('width' => 350))));

                //---------------------------------------------------------------------------------------------------
                //salto linea
                $pdf->ezText("\n", 10, ['justification' => 'full']);
                if ($this->s__imprimir_resumen == 0) {
                    $datos_pext = array();
                    $datos_pext[0] = array('col1' => '<b>' . utf8_d_seguro('Fundamentación del origen del proyecto') . '</b>');
                    $pdf->ezTable($datos_pext, array('col1' => ''), ' ', array('showHeadings' => 0, 'shaded' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'center', 'width' => 550))));
                    //$cols_dp = array('col1'=>"<b>Datos Principales</b>",'col2'=>'');

                    $tabla_dp = array();
                    $tabla_dp[0] = array('col1' => '<b>' . utf8_d_seguro('Fundamentación del Proyecto') . '</b>', 'col2' => $datos['descripcion_situacion']);

                    $pdf->ezTable($tabla_dp, $cols_dp, '', array('shaded' => 0, 'showLines' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'right', 'width' => 200), 'col2' => array('width' => 350))));

                    $datos_pext = array();
                    $datos_pext[0] = array('col1' => '<b>' . utf8_d_seguro('Destinatarios') . '</b>');
                    $pdf->ezTable($datos_pext, array('col1' => ''), ' ', array('showHeadings' => 0, 'shaded' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'center', 'width' => 550))));
                    //$cols_dp = array('col1'=>"<b>Datos Principales</b>",'col2'=>'');
                    $tabla_dp[0] = array('col1' => utf8_d_seguro('Identificar destinatarios'), 'col2' => $datos['caracterizacion_poblacion']);
                    $i = 1;
                    foreach ($destinatarios as $destinatario) {
                        $text = '<b> * Domicilio : </b>' . $destinatario['domicilio'] . "\n";
                        $text = $text . '<b> * Telefono : </b>' . $destinatario['telefono'] . "\n";
                        $text = $text . '<b> * Correo : </b>' . $destinatario['email'] . "\n";
                        $text = $text . '<b> * Contacto </b>' . $destinatario['contacto'] . "\n";

                        $tabla_dp[$i] = array('col1' => '' . $destinatario['descripcion'], 'col2' => '' . $text);
                        $i = $i + 1;
                    }
                    $i = $i + 1;
                    $tabla_dp[$i] = array('col1' => utf8_d_seguro('Localización geográfica'), 'col2' => $datos['localizacion_geo']);


                    $pdf->ezTable($tabla_dp, $cols_dp, '', array('shaded' => 0, 'showLines' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'right', 'width' => 200), 'col2' => array('width' => 350))));

                    //--------------------------------------------------------------------------------------------------------
                    //salto de linea
                    $pdf->ezText("\n", 10, ['justification' => 'full']);

                    $datos_pext = array();
                    $datos_pext[0] = array('col1' => '<b>' . utf8_d_seguro('Resultados esperados') . '</b>');
                    $pdf->ezTable($datos_pext, array('col1' => ''), ' ', array('showHeadings' => 0, 'shaded' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'center', 'width' => 550))));
                    //$cols_dp = array('col1'=>"<b>Datos Principales</b>",'col2'=>'');

                    $tabla_dp = array();
                    $tabla_dp[0] = array('col1' => utf8_d_seguro('Resultados esperados del proyecto'), 'col2' => $datos[impacto]);

                    $pdf->ezTable($tabla_dp, $cols_dp, '', array('shaded' => 0, 'showLines' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'right', 'width' => 200), 'col2' => array('width' => 350))));
                    //-------------------------------------------------------------------------------------------------------------
                    //salto de linea
                    $pdf->ezText("\n", 10, ['justification' => 'full']);

                    $datos_pext = array();
                    $datos_pext[0] = array('col1' => '<b>' . utf8_d_seguro('Objetivo General') . '</b>');
                    $pdf->ezTable($datos_pext, array('col1' => ''), ' ', array('showHeadings' => 0, 'shaded' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'center', 'width' => 550))));
                    //$cols_dp = array('col1'=>"<b>Datos Principales</b>",'col2'=>'');

                    $tabla_dp = array();
                    //Nombre del Proyecto
                    $tabla_dp[0] = array('col1' => utf8_d_seguro('Objetivo General'), 'col2' => $datos[objetivo]);

                    $pdf->ezTable($tabla_dp, $cols_dp, '', array('shaded' => 0, 'showLines' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'right', 'width' => 200), 'col2' => array('width' => 350))));
                    //------------------------------------------------------------------------------------------------------------
                    //salto de linea
                    $pdf->ezText("\n", 10, ['justification' => 'full']);

                    $datos_pext = array();
                    $datos_pext[0] = array('col1' => '<b> Objetivos especificos </b>');
                    $pdf->ezTable($datos_pext, array('col1' => ''), ' ', array('showHeadings' => 0, 'shaded' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'center', 'width' => 550))));
                    $cols_dp = array('col1' => "<b>Nro</b>", 'col2' => utf8_d_seguro('Descripción'), 'col3' => 'Meta', 'col4' => utf8_d_seguro('Ponderación'));

                    $tabla_dp = array();
                    $i = 0;
                    foreach ($obj_especificos as $obj_especifico) {
                        $tabla_dp[$i] = array('col1' => $i, 'col2' => $obj_especifico[descripcion], 'col3' => $obj_especifico[meta], 'col4' => $obj_especifico[ponderacion]);
                        $i = $i + 1;
                        //$plan_actividades = $this->dep('datos')->tabla('plan_actividades')->get_listado($obj_especifico[id_objetivo]);
                    }


                    $pdf->ezTable($tabla_dp, $cols_dp, '', array('shaded' => 0, 'showLines' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'right', 'width' => 50), 'col2' => array('width' => 167), 'col3' => array('width' => 166), 'col4' => array('width' => 166))));

                    //------------------------------------------------------------------------------------------------------------
                    //salto de linea
                    $pdf->ezText("\n", 10, ['justification' => 'full']);

                    $datos_pext = array();
                    $datos_pext[0] = array('col1' => '<b> Plan de Actividades objetivos especificos </b>');
                    $pdf->ezTable($datos_pext, array('col1' => ''), ' ', array('showHeadings' => 0, 'shaded' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'center', 'width' => 550))));
                    $cols_dp = array('col1' => "<b> Nro </b>", 'col2' => utf8_d_seguro('Mes Ejecución'), 'col3' => utf8_d_seguro('Localización'), 'col4' => utf8_d_seguro('Destinatarios'), 'col5' => utf8_d_seguro('Descripción'));

                    $tabla_dp = array();
                    $i = 0;
                    $j = 0;
                    foreach ($obj_especificos as $obj_especifico) {
                        $plan_actividades = $this->dep('datos')->tabla('plan_actividades')->get_listado($obj_especifico[id_objetivo]);

                        for ($index = 0; $index < count($plan_actividades); $index++) {
                            $plan = $plan_actividades[$index];
                            $text = '';
                            foreach ($destinatarios as $destinatario) {
                                $destinatario_act = $this->dep('datos')->tabla('destinatarios')->get_descripciones($destinatario[id_destinatario]);
                                $text = $text . $destinatario_act[0][descripcion] . "\n";
                            }
                            $tabla_dp[$i] = array('col1' => $i . ' , ' . $index, 'col2' => $plan[fecha] . ' ' . $plan[anio], 'col3' => $plan[localizacion], 'col4' => $text, 'col5' => $plan[detalle]);
                        }
                        $i = $i + 1;
                    }


                    $pdf->ezTable($tabla_dp, $cols_dp, '', array('shaded' => 0, 'showLines' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'right', 'width' => 40), 'col2' => array('width' => 90), 'col3' => array('width' => 90), 'col4' => array('width' => 90), 'col5' => array('width' => 240))));

                    //------------------------------------------------------------------------------------------------------------
                    //salto de linea
                    $pdf->ezText("\n", 10, ['justification' => 'full']);
                }
                $datos_pext = array();
                $datos_pext[0] = array('col1' => '<b>' . utf8_d_seguro('Equipo y Organizaciones participantes') . '</b>');
                $pdf->ezTable($datos_pext, array('col1' => ''), ' ', array('showHeadings' => 0, 'shaded' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'center', 'width' => 550))));

                $tabla_dp = array();
                $i = 0;
                foreach ($integrantes as $integrante) {
                    if ($integrante[funcion_p] == 'Estudiante') {
                        $datos_pext[0] = array('col1' => '<b>' . utf8_d_seguro('Estudiantes') . '</b>');
                        $pdf->ezTable($datos_pext, array('col1' => ''), ' ', array('showHeadings' => 0, 'shaded' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'center', 'width' => 550))));
                        $cols_dp = array('col1' => "<b> Nro </b>", 'col2' => '<b>' . utf8_d_seguro('Función') . '</b>', 'col3' => 'Nombre y Apellido', 'col4' => utf8_d_seguro('Documento'), 'col5' => utf8_d_seguro('Universidad'), 'col6' => utf8_d_seguro('Unidad Academica'), 'col7' => utf8_d_seguro('e-mail'));

                        $tabla_dp = array();

                        $tabla_dp[$i] = array('col1' => $i, 'col2' => $integrante[funcion_p], 'col3' => $integrante[nombre], 'col4' => $integrante[tipo_docum] . '' . $integrante[nro_docum], 'col5' => 'Universidad Nacional del Comahue', 'col6' => $integrante[ua], 'col7' => $integrante[mail],);

                        $i = $i + 1;
                    }
                }
                if (count($tabla_dp) >= 1) {
                    $pdf->ezTable($tabla_dp, $cols_dp, '', array('shaded' => 0, 'showLines' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'right', 'width' => 20), 'col2' => array('width' => 60), 'col3' => array('width' => 85), 'col4' => array('width' => 85), 'col5' => array('width' => 130), 'col6' => array('width' => 70), 'col7' => array('width' => 100))));
                }

                $tabla_dp = array();
                $i = 0;

                foreach ($integrantes as $integrante) {
                    if ($integrante[funcion_p] == 'Director' || $integrante[funcion_p] == 'Codirector') {
                        if ($i == 0) {
                            $datos_pext[0] = array('col1' => '<b>' . utf8_d_seguro('Docentes / Investigadores') . '</b>');
                            $pdf->ezTable($datos_pext, array('col1' => ''), ' ', array('showHeadings' => 0, 'shaded' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'center', 'width' => 550))));
                            $cols_dp = array('col1' => "<b> Nro </b>", 'col2' => '<b>' . utf8_d_seguro('Función') . '</b>', 'col3' => 'Nombre y Apellido', 'col4' => utf8_d_seguro('Documento'), 'col5' => utf8_d_seguro('Universidad'), 'col6' => utf8_d_seguro('Unidad Academica'), 'col7' => utf8_d_seguro('e-mail'));

                            $tabla_dp = array();
                        }

                        $tabla_dp[$i] = array('col1' => $i, 'col2' => $integrante[funcion_p], 'col3' => $integrante[nombre], 'col4' => $integrante[tipo_docum] . '' . $integrante[nro_docum], 'col5' => 'Universidad Nacional del Comahue', 'col6' => $integrante[ua], 'col7' => $integrante[mail],);

                        $i = $i + 1;
                    }
                }
                if (count($tabla_dp) >= 1) {
                    $pdf->ezTable($tabla_dp, $cols_dp, '', array('shaded' => 0, 'showLines' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'right', 'width' => 20), 'col2' => array('width' => 60), 'col3' => array('width' => 85), 'col4' => array('width' => 85), 'col5' => array('width' => 130), 'col6' => array('width' => 70), 'col7' => array('width' => 100))));
                }

                $tabla_dp = array();
                $i = 0;
                foreach ($integrantes as $integrante) {
                    if ($integrante[funcion_p] == 'Graduado') {
                        if ($i == 0) {
                            $datos_pext[0] = array('col1' => '<b>' . utf8_d_seguro('Graduados') . '</b>');
                            $pdf->ezTable($datos_pext, array('col1' => ''), ' ', array('showHeadings' => 0, 'shaded' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'center', 'width' => 550))));
                            $cols_dp = array('col1' => "<b> Nro </b>", 'col2' => '<b>' . utf8_d_seguro('Función') . '</b>', 'col3' => 'Nombre y Apellido', 'col4' => utf8_d_seguro('Documento'), 'col5' => utf8_d_seguro('Universidad'), 'col6' => utf8_d_seguro('Unidad Academica'), 'col7' => utf8_d_seguro('e-mail'));

                            $tabla_dp = array();
                        }

                        $tabla_dp[$i] = array('col1' => $i, 'col2' => $integrante[funcion_p], 'col3' => $integrante[nombre], 'col4' => $integrante[tipo_docum] . '' . $integrante[nro_docum], 'col5' => 'Universidad Nacional del Comahue', 'col6' => $integrante[ua], 'col7' => $integrante[mail],);

                        $i = $i + 1;
                    }
                }
                if (count($tabla_dp) >= 1) {
                    $pdf->ezTable($tabla_dp, $cols_dp, '', array('shaded' => 0, 'showLines' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'right', 'width' => 20), 'col2' => array('width' => 60), 'col3' => array('width' => 85), 'col4' => array('width' => 85), 'col5' => array('width' => 130), 'col6' => array('width' => 70), 'col7' => array('width' => 100))));
                }

                $tabla_dp = array();
                $i = 0;
                foreach ($integrantes as $integrante) {
                    if ($integrante[funcion_p] == 'No Docente') {
                        if ($i == 0) {
                            $datos_pext[0] = array('col1' => '<b>' . utf8_d_seguro('No-Docentes') . '</b>');
                            $pdf->ezTable($datos_pext, array('col1' => ''), ' ', array('showHeadings' => 0, 'shaded' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'center', 'width' => 550))));
                            $cols_dp = array('col1' => "<b> Nro </b>", 'col2' => '<b>' . utf8_d_seguro('Función') . '</b>', 'col3' => 'Nombre y Apellido', 'col4' => utf8_d_seguro('Documento'), 'col5' => utf8_d_seguro('Universidad'), 'col6' => utf8_d_seguro('Unidad Academica'), 'col7' => utf8_d_seguro('e-mail'));

                            $tabla_dp = array();
                        }

                        $tabla_dp[$i] = array('col1' => $i, 'col2' => $integrante[funcion_p], 'col3' => $integrante[nombre], 'col4' => $integrante[tipo_docum] . '' . $integrante[nro_docum], 'col5' => 'Universidad Nacional del Comahue', 'col6' => $integrante[ua], 'col7' => $integrante[mail],);

                        $i = $i + 1;
                    }
                }
                if (count($tabla_dp) >= 1) {
                    $pdf->ezTable($tabla_dp, $cols_dp, '', array('shaded' => 0, 'showLines' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'right', 'width' => 20), 'col2' => array('width' => 60), 'col3' => array('width' => 85), 'col4' => array('width' => 85), 'col5' => array('width' => 130), 'col6' => array('width' => 70), 'col7' => array('width' => 100))));
                }

                $tabla_dp = array();
                $i = 0;
                foreach ($integrantes as $integrante) {
                    if ($integrante[funcion_p] == 'Colaborador Externo') {
                        if ($i == 0) {
                            $datos_pext[0] = array('col1' => '<b>' . utf8_d_seguro('Colaboradores Externo') . '</b>');
                            $pdf->ezTable($datos_pext, array('col1' => ''), ' ', array('showHeadings' => 0, 'shaded' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'center', 'width' => 550))));
                            $cols_dp = array('col1' => "<b> Nro </b>", 'col2' => '<b>' . utf8_d_seguro('Función') . '</b>', 'col3' => 'Nombre y Apellido', 'col4' => utf8_d_seguro('Documento'), 'col5' => utf8_d_seguro('Universidad'), 'col6' => utf8_d_seguro('Unidad Academica'), 'col7' => utf8_d_seguro('e-mail'));

                            $tabla_dp = array();
                        }

                        $tabla_dp[$i] = array('col1' => $i, 'col2' => $integrante[funcion_p], 'col3' => $integrante[nombre], 'col4' => $integrante[tipo_docum] . '' . $integrante[nro_docum], 'col5' => 'Universidad Nacional del Comahue', 'col6' => $integrante[ua], 'col7' => $integrante[mail],);

                        $i = $i + 1;
                    }
                }
                if (count($tabla_dp) >= 1) {
                    $pdf->ezTable($tabla_dp, $cols_dp, '', array('shaded' => 0, 'showLines' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'right', 'width' => 20), 'col2' => array('width' => 60), 'col3' => array('width' => 85), 'col4' => array('width' => 85), 'col5' => array('width' => 130), 'col6' => array('width' => 70), 'col7' => array('width' => 100))));
                }

                $tabla_dp = array();
                $i = 0;
                foreach ($integrantes as $integrante) {
                    if ($integrante[funcion_p] == 'Integrante') {
                        if ($i == 0) {
                            $datos_pext[0] = array('col1' => '<b>' . utf8_d_seguro('Integrantes') . '</b>');
                            $pdf->ezTable($datos_pext, array('col1' => ''), ' ', array('showHeadings' => 0, 'shaded' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'center', 'width' => 550))));
                            $cols_dp = array('col1' => "<b> Nro </b>", 'col2' => '<b>' . utf8_d_seguro('Función') . '</b>', 'col3' => 'Nombre y Apellido', 'col4' => utf8_d_seguro('Documento'), 'col5' => utf8_d_seguro('Universidad'), 'col6' => utf8_d_seguro('Unidad Academica'), 'col7' => utf8_d_seguro('e-mail'));

                            $tabla_dp = array();
                        }

                        $tabla_dp[$i] = array('col1' => $i, 'col2' => $integrante[funcion_p], 'col3' => $integrante[nombre], 'col4' => $integrante[tipo_docum] . '' . $integrante[nro_docum], 'col5' => 'Universidad Nacional del Comahue', 'col6' => $integrante[ua], 'col7' => $integrante[mail],);

                        $i = $i + 1;
                    }
                }
                if (count($tabla_dp) >= 1) {
                    $pdf->ezTable($tabla_dp, $cols_dp, '', array('shaded' => 0, 'showLines' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'right', 'width' => 20), 'col2' => array('width' => 60), 'col3' => array('width' => 85), 'col4' => array('width' => 85), 'col5' => array('width' => 130), 'col6' => array('width' => 70), 'col7' => array('width' => 100))));
                }

                $tabla_dp = array();
                $i = 0;
                foreach ($integrantes as $integrante) {
                    if ($integrante[funcion_p] == 'Asesor') {
                        if ($i == 0) {
                            $datos_pext[0] = array('col1' => '<b>' . utf8_d_seguro('Asesores') . '</b>');
                            $pdf->ezTable($datos_pext, array('col1' => ''), ' ', array('showHeadings' => 0, 'shaded' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'center', 'width' => 550))));
                            $cols_dp = array('col1' => "<b> Nro </b>", 'col2' => '<b>' . utf8_d_seguro('Función') . '</b>', 'col3' => 'Nombre y Apellido', 'col4' => utf8_d_seguro('Documento'), 'col5' => utf8_d_seguro('Universidad'), 'col6' => utf8_d_seguro('Unidad Academica'), 'col7' => utf8_d_seguro('e-mail'));

                            $tabla_dp = array();
                        }

                        $tabla_dp[$i] = array('col1' => $i, 'col2' => $integrante[funcion_p], 'col3' => $integrante[nombre], 'col4' => $integrante[tipo_docum] . '' . $integrante[nro_docum], 'col5' => 'Universidad Nacional del Comahue', 'col6' => $integrante[ua], 'col7' => $integrante[mail],);

                        $i = $i + 1;
                    }
                }
                if (count($tabla_dp) >= 1) {
                    $pdf->ezTable($tabla_dp, $cols_dp, '', array('shaded' => 0, 'showLines' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'right', 'width' => 20), 'col2' => array('width' => 60), 'col3' => array('width' => 85), 'col4' => array('width' => 85), 'col5' => array('width' => 130), 'col6' => array('width' => 70), 'col7' => array('width' => 100))));
                }
                $tabla_dp = array();
                $i = 0;
                foreach ($integrantes as $integrante) {
                    if ($integrante[funcion_p] == 'Colaborador') {
                        if ($i == 0) {
                            $datos_pext[0] = array('col1' => '<b>' . utf8_d_seguro('Colaboradores') . '</b>');
                            $pdf->ezTable($datos_pext, array('col1' => ''), ' ', array('showHeadings' => 0, 'shaded' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'center', 'width' => 550))));
                            $cols_dp = array('col1' => "<b> Nro </b>", 'col2' => '<b>' . utf8_d_seguro('Función') . '</b>', 'col3' => 'Nombre y Apellido', 'col4' => utf8_d_seguro('Documento'), 'col5' => utf8_d_seguro('Universidad'), 'col6' => utf8_d_seguro('Unidad Academica'), 'col7' => utf8_d_seguro('e-mail'));

                            $tabla_dp = array();
                        }

                        $tabla_dp[$i] = array('col1' => $i, 'col2' => $integrante[funcion_p], 'col3' => $integrante[nombre], 'col4' => $integrante[tipo_docum] . '' . $integrante[nro_docum], 'col5' => 'Universidad Nacional del Comahue', 'col6' => $integrante[ua], 'col7' => $integrante[mail],);

                        $i = $i + 1;
                    }
                }
                if (count($tabla_dp) >= 1) {
                    $pdf->ezTable($tabla_dp, $cols_dp, '', array('shaded' => 0, 'showLines' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'right', 'width' => 20), 'col2' => array('width' => 60), 'col3' => array('width' => 85), 'col4' => array('width' => 85), 'col5' => array('width' => 130), 'col6' => array('width' => 70), 'col7' => array('width' => 100))));
                }

                $tabla_dp = array();
                $i = 0;
                foreach ($integrantes as $integrante) {
                    if ($integrante[funcion_p] == 'Becario') {
                        if ($i == 0) {
                            $datos_pext[0] = array('col1' => '<b>' . utf8_d_seguro('Becarios') . '</b>');
                            $pdf->ezTable($datos_pext, array('col1' => ''), ' ', array('showHeadings' => 0, 'shaded' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'center', 'width' => 550))));
                            $cols_dp = array('col1' => "<b> Nro </b>", 'col2' => '<b>' . utf8_d_seguro('Función') . '</b>', 'col3' => 'Nombre y Apellido', 'col4' => utf8_d_seguro('Documento'), 'col5' => utf8_d_seguro('Universidad'), 'col6' => utf8_d_seguro('Unidad Academica'), 'col7' => utf8_d_seguro('e-mail'));

                            $tabla_dp = array();
                        }

                        $tabla_dp[$i] = array('col1' => $i, 'col2' => $integrante[funcion_p], 'col3' => $integrante[nombre], 'col4' => $integrante[tipo_docum] . '' . $integrante[nro_docum], 'col5' => 'Universidad Nacional del Comahue', 'col6' => $integrante[ua], 'col7' => $integrante[mail],);

                        $i = $i + 1;
                    }
                }
                if (count($tabla_dp) >= 1) {
                    $pdf->ezTable($tabla_dp, $cols_dp, '', array('shaded' => 0, 'showLines' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'right', 'width' => 20), 'col2' => array('width' => 60), 'col3' => array('width' => 85), 'col4' => array('width' => 85), 'col5' => array('width' => 130), 'col6' => array('width' => 70), 'col7' => array('width' => 100))));
                }

                //salto de linea
                $pdf->ezText("\n", 10, ['justification' => 'full']);

                // Organizaciones
                // Presupuesto
                $datos_pext = array();
                $datos_pext[0] = array('col1' => '<b>' . utf8_d_seguro('Presupuesto') . '</b>');
                $pdf->ezTable($datos_pext, array('col1' => ''), ' ', array('showHeadings' => 0, 'shaded' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'center', 'width' => 550))));

                $tabla_dp = array();
                $i = 0;
                foreach ($presupuestos as $presupuesto) {
                    if ($i == 0) {
                        $cols_dp = array('col1' => "<b> Rubro </b>", 'col2' => "<b> Concepto </b>", 'col3' => utf8_d_seguro('Cantidad'), 'col4' => 'Monto');

                        $tabla_dp = array();
                    }
                    $tabla_dp[$i] = array('col1' => $presupuesto[rubro], 'col2' => $presupuesto[concepto], 'col3' => $presupuesto[cantidad], 'col4' => $presupuesto[monto]);

                    $i = $i + 1;
                }
                if (count($tabla_dp) >= 1) {
                    $pdf->ezTable($tabla_dp, $cols_dp, '', array('shaded' => 1, 'showLines' => 2, 'width' => 550, 'cols' => array('col1' => array('justification' => 'center', 'width' => 200), 'col2' => array('width' => 200), 'col3' => array('width' => 75), 'col4' => array('width' => 75))));
                }


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
                $imagen = toba::proyecto()->get_path() . '/www/img/logo_uc.png';
                $imagen2 = toba::proyecto()->get_path() . '/www/img/logo.png';
                $pdf->addJpegFromFile($imagen, 40, 715, 70, 66);
                $pdf->addJpegFromFile($imagen2, 480, 715, 70, 66);
                $pdf->closeObject();
//}
            }
        } else {
            if (isset($this->s__organizacion)) {
                $aval['id_organizacion'] = $this->s__organizacion;
                $this->dep('datos')->tabla('organizaciones_participantes')->resetear(); //limpia
                $this->dep('datos')->tabla('organizaciones_participantes')->cargar($aval); //carga el articulo que se selecciono
                $fp_imagen = $this->dep('datos')->tabla('organizaciones_participantes')->get_blob('aval');
                if (isset($fp_imagen)) {
                    header("Content-type:applicattion/pdf");
                    header("Content-Disposition:attachment;filename=" . $this->s__nombre);
                    echo(stream_get_contents($fp_imagen));
                    exit;
                }
                unset($this->s__organizacion);
                unset($this->s__pdf);
            } else {
                if (isset($this->s__cv_interno)) {
                    print_r($this->s__cv_interno);
                    $cv['id_pext'] = $this->s__cv_interno[id_pext];
                    $cv['desde'] = $this->s__cv_interno[desde];
                    $cv['id_designacion'] = $this->s__cv_interno[id_designacion];
                    $this->dep('datos')->tabla('integrante_interno_pe')->resetear(); //limpia
                    $this->dep('datos')->tabla('integrante_interno_pe')->cargar($cv); //carga el articulo que se selecciono
                    $fp_imagen = $this->dep('datos')->tabla('organizaciones_participantes')->get_blob('cv');
                    print_r($fp_imagen);
                    if (isset($fp_imagen)) {
                        header("Content-type:applicattion/pdf");
                        header("Content-Disposition:attachment;filename=" . $this->s__nombre);
                        echo(stream_get_contents($fp_imagen));
                        exit;
                    }
                    unset($this->s__cv_interno);
                    unset($this->s__pdf);
                }
            }
        }
    }

    //esta funcion es invocada desde javascript
    //cuando se presiona el boton pdf_acta
    function ajax__cargar_aval($id_fila, toba_ajax_respuesta $respuesta) {
        if ($id_fila != 0) {
            $id_fila = $id_fila / 2;
        }
        $this->s__organizacion = $this->s__datos[$id_fila]['id_organizacion'];

        $this->s__nombre = "aval_" . str_replace(' ', '', $this->s__datos[$id_fila]['nombre']) . ".pdf";
        $this->s__pdf = 'aval';
        $tiene = $this->dep('datos')->tabla('organizaciones_participantes')->tiene_aval($this->s__organizacion);
        if ($tiene == 1) {
            $respuesta->set($id_fila);
        } else {
            $respuesta->set(-1);
        }
    }

    function ajax__cargar_aval_destinatario($id_fila, toba_ajax_respuesta $respuesta) {
        if ($id_fila != 0) {
            $id_fila = $id_fila / 2;
        }
        $this->s_destinatario = $this->s__datos[$id_fila]['id_destinatario'];

        $this->s__nombre = "aval_" . str_replace(' ', '', $this->s__datos[$id_fila]['contacto']) . ".pdf";
        $this->s__pdf = 'aval';
        $tiene = $this->dep('datos')->tabla('destinatarios')->tiene_aval($this->s__organizacion);
        if ($tiene == 1) {
            $respuesta->set($id_fila);
        } else {
            $respuesta->set(-1);
        }
    }

    function ajax__descargar_cv_docente($id_fila, toba_ajax_respuesta $respuesta) {
        if ($id_fila != 0) {
            $id_fila = $id_fila / 2;
        }
        $datos['id_pext'] = $this->s__datos[$id_fila]['id_pext'];
        $datos['desde'] = $this->s__datos[$id_fila]['desde'];
        $datos['id_designacion'] = $this->s__datos[$id_fila]['id_designacion'];
        $this->s__cv_interno = $datos;

        $this->s__nombre = "cv_" . str_replace(' ', '', $this->s__datos[$id_fila]['nombre']) . ".pdf";
        $this->s__pdf = 'cv';
        //$tiene = $this->dep('datos')->tabla('integrante_interno')->tiene_cv($this->s__cv_interno);
        $tiene = 1;
        if ($tiene == 1) {
            $respuesta->set($id_fila);
        } else {
            $respuesta->set(-1);
        }
    }

    function ajax__descargar_cv_otro($id_fila, toba_ajax_respuesta $respuesta) {
        if ($id_fila != 0) {
            $id_fila = $id_fila / 2;
        }
        $datos['id_pext'] = $this->s__datos[$id_fila]['id_pext'];
        $datos['desde'] = $this->s__datos[$id_fila]['desde'];
        $datos['tipo_docum'] = $this->s__datos[$id_fila]['tipo_docum'];
        $datos['nro_docum'] = $this->s__datos[$id_fila]['nro_docum'];
        $this->s__cv_externo = $datos;

        $this->s__nombre = "aval_" . str_replace(' ', '', $this->s__datos[$id_fila]['integrante']) . ".pdf";
        $this->s__pdf = 'aval';
        //$tiene = $this->dep('datos')->tabla('integrante_externo')->tiene_aval($this->s__cv_externo);
        $tiene = 1;
        if ($tiene == 1) {
            $respuesta->set($id_fila);
        } else {
            $respuesta->set(-1);
        }
    }

    function ajax__descargar_pext_completo($id_fila, toba_ajax_respuesta $respuesta) {
        if ($id_fila != 0) {
            $id_fila = $id_fila / 2;
        }
        $this->s__imprimir_resumen = 0;
        $this->s__pextension = $this->s__datos[$id_fila]['id_pext'];

        $respuesta->set($id_fila);
    }

    function ajax__descargar_pext_resumen($id_fila, toba_ajax_respuesta $respuesta) {
        if ($id_fila != 0) {
            $id_fila = $id_fila / 2;
        }
        $this->s__imprimir_resumen = 1;
        $this->s__pextension = $this->s__datos[$id_fila]['id_pext'];

        $respuesta->set(1);
    }

    // METODOS POPUP
    function get_persona($id) {
        
    }

    function get_docente($id) {
        
    }

    function get_rubro($id) {
        
    }

    // METODOS AUXILIARES PARA COMBOS 
    function fecha_desde_proyecto() {
        $datos = $this->dep('datos')->tabla('pextension')->get();
        $date = date("d/m/Y", strtotime($datos['fec_desde']));
        return $date;
    }

    function fecha_hasta_proyecto() {
        $datos = $this->dep('datos')->tabla('pextension')->get();
        $date = date("d/m/Y", strtotime($datos['fec_hasta']));
        return $date;
    }

    function fecha_fin_proyecto($duracion) {
        $datos = $this->dep('datos')->tabla('pextension')->get();
        $fecha_desde = $datos['fec_desde'];
        $fecha_hasta = date("d-m-Y", strtotime($fecha_desde . "+" . $duracion . " month"));
        return date("d/m/Y", strtotime($fecha_hasta));
    }

    function meses_ejecucion() {
        $datos = $this->dep('datos')->tabla('pextension')->get();
        $bases = $this->dep('datos')->tabla('bases_convocatoria')->get_duracion($datos[id_bases])[0];
        $cant_meses = $bases[duracion_convocatoria] * 12;
        $meses = array();
        for ($i = 1; $i <= $cant_meses; $i++) {
            $meses_aux = array();
            $meses_aux[id] = $i;
            $meses_aux[descripcion] = $i;
            $meses[$i] = $meses_aux;
        }
        return $meses;
    }

    function resolucion_proyecto() {
        $datos = $this->dep('datos')->tabla('pextension')->get();
        return $datos['nro_resol'];
    }

    function destinatarios() {
        $id_pext = $this->dep('datos')->tabla('pextension')->get()['id_pext'];
        return $this->dep('datos')->tabla('destinatarios')->get_listado($id_pext);
    }

    function monto_rubro($id_rubro_extension) {
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $bases = $this->dep('datos')->tabla('bases_convocatoria')->get_datos($pe[id_bases])[0];
        $monto = $this->dep('datos')->tabla('montos_convocatoria')->get_descripciones($id_rubro_extension, $bases[id_bases])[0];
        if ($bases[monto_max] != 0) {
            $presupuesto = $this->dep('datos')->tabla('presupuesto_extension')->get_listado_rubro($id_rubro_extension);
            $count = 0;
            foreach ($presupuesto as $value) {
                $count = $count + $value[monto];
            }
            return ($monto[monto_max] - $count);
        } else {
            return 9999;
        }
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

    //--------------------------------------------------------------------------------
    //----------------------- EVENTOS CI PROYECTO DE EXTENSION -----------------------
    //--------------------------------------------------------------------------------

    function evt__nuevo_proyecto() {

        $this->set_pantalla('pant_alta_proyecto');

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
        $this->pantalla()->tab("pant_seguimiento")->ocultar();
        $this->pantalla()->tab("pant_destinatarios")->ocultar();
    }

    function evt__alta() {
        switch ($this->s__pantalla) {
            case 'pant_alta_proyecto':
                $this->set_pantalla('pant_formulario');
                break;
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

    // --------------------- ESTADOS ------------------------------------------------
    // enviar cuando el formulador termina la carga pasa a estar en evaluacion por la UA
    function evt__enviar() {
        if ($this->dep('datos')->tabla('pextension')->esta_cargada()) {
            $pextension = $this->dep('datos')->tabla('pextension')->get();

            /* Listado condiciones carga :
             * 1) Director 
             * 2) Co Director
             * 3) al menos un destinatario 
             */

            //obtengo director 
            $director = $this->dep('datos')->tabla('integrante_interno_pe')->get_director($pextension[id_pext])[0];

            //obtengo co-director
            $co_director = $this->dep('datos')->tabla('integrante_interno_pe')->get_co_director($pextension[id_pext])[0];
            if (count($co_director) < 1) {
                $co_director = $this->dep('datos')->tabla('integrante_externo_pe')->get_co_director($pextension[id_pext])[0];
            }

            // Destinatarios
            $destinatarios = $this->dep('datos')->tabla('destinatarios')->get_listado($pextension[id_pext]);

            $validacion = "";
            if (count($director) > 1) {
                $correcto = true;
                if (count($proyectos) > 1) {
                    foreach ($proyectos as $proyecto) {
                        if ($proyecto['id_pext'] != $pextension['id_pext'] && $proyecto['id_estado'] != 'FORM') {
                            $director_aux = $this->dep('datos')->tabla('integrante_interno_pe')->get_director($proyecto['id_pext'])[0];
                            if ($director['id_designacion'] == $director_aux['id_designacion']) {
                                $validacion = 'El director seleccionado adeuda rendimientos';
                                toba::notificacion()->agregar($validacion, "error");
                                $correcto = false;
                            }
                        }
                    }
                }
                if ($correcto) {
                    $validacion = " + Director \n";
                    toba::notificacion()->agregar($validacion, "info");
                    $count++;
                }
            } else {
                $validacion = " - Director \n";
                toba::notificacion()->agregar($validacion, "error");
            }

            if (count($co_director) > 1) {
                $validacion = " + Co-Director \n";
                toba::notificacion()->agregar($validacion, "info");
                $count++;
            } else {
                $validacion = " - Co-Director \n";
                toba::notificacion()->agregar($validacion, "error");
            }

            if (count($destinatarios) > 0) {
                $validacion = " + Destinatarios \n";
                toba::notificacion()->agregar($validacion, "info");
                $count++;
            } else {
                $validacion = " - Destinatarios \n";
                toba::notificacion()->agregar($validacion, "error");
            }


            if ($count == 3) {
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
            }
        }
    }

    function evt__validar() {
        if ($this->dep('datos')->tabla('pextension')->esta_cargada()) {
            $pextension = $this->dep('datos')->tabla('pextension')->get();

            /* Listado condiciones carga :
             * 1) Director ( control si adeuda )
             * 2) Co Director
             * 3) al menos un destinatario 
             * 4) ponderacion 100 % 
             */

            // listado de todos los proyectos // hacer metodo que traiga solo los que no esten finalizados 
            $proyectos = $this->dep('datos')->tabla('pextension')->get_listado();

            //obtengo director 
            $director = $this->dep('datos')->tabla('integrante_interno_pe')->get_director($pextension[id_pext])[0];

            //obtengo co-director
            $co_director = $this->dep('datos')->tabla('integrante_interno_pe')->get_co_director($pextension[id_pext])[0];
            if (count($co_director) < 1) {
                $co_director = $this->dep('datos')->tabla('integrante_externo_pe')->get_co_director($pextension[id_pext])[0];
            }

            // Destinatarios
            $destinatarios = $this->dep('datos')->tabla('destinatarios')->get_listado($pextension[id_pext]);

            $validacion = "";
            if (count($director) > 1) {
                $correcto = true;
                if (count($proyectos) > 1) {
                    foreach ($proyectos as $proyecto) {
                        if ($proyecto['id_pext'] != $pextension['id_pext'] && $proyecto['id_estado'] != 'FORM') {
                            $director_aux = $this->dep('datos')->tabla('integrante_interno_pe')->get_director($proyecto['id_pext'])[0];
                            if ($director['id_designacion'] == $director_aux['id_designacion']) {
                                $validacion = 'El director seleccionado adeuda rendimientos';
                                toba::notificacion()->agregar($validacion, "error");
                                $correcto = false;
                            }
                        }
                    }
                }
                if ($correcto) {
                    $validacion = " + Director \n";
                    toba::notificacion()->agregar($validacion, "info");
                }
            } else {
                $validacion = " - Director \n";
                toba::notificacion()->agregar($validacion, "error");
            }

            if (count($co_director) > 1) {
                $validacion = " + Co-Director \n";
                toba::notificacion()->agregar($validacion, "info");
            } else {
                $validacion = " - Co-Director \n";
                toba::notificacion()->agregar($validacion, "error");
            }

            if (count($destinatarios) > 0) {
                $validacion = " + Destinatarios \n";
                toba::notificacion()->agregar($validacion, "info");
            } else {
                $validacion = " - Destinatat_serios \n";
                toba::notificacion()->agregar($validacion, "error");
            }
        }
    }

    //-------------------------------------------------------------------------------
    //-------------------------- PANTALLAS ------------------------------------------
    //-------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------
    //------------------------- PANTALLA EDICION ------------------------------------
    //-------------------------------------------------------------------------------

    function conf__pant_edicion(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_edicion";

        // OCULTO PANTALLAS DE EDICION DEL PROYECTO HASTA QUE SE SELECCIONE UNO O SE QUIERA CREAR UNO
        $this->pantalla()->tab("pant_alta_proyecto")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();
        $this->pantalla()->tab("pant_seguimiento")->ocultar();
    }

    //-------------------------- FILTRO ---------------------------------------------

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

    //------------------------- CUADRO ----------------------------------------------

    function conf__cuadro(toba_ei_cuadro $cuadro) {
        $this->s__imprimir = 1;

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
        $this->pantalla()->tab("pant_seguimiento")->ocultar();

        if (isset($this->s__where)) {
            $this->s__datos = $this->dep('datos')->tabla('pextension')->get_listado($this->s__where);
        } else {
            $this->s__datos = $this->dep('datos')->tabla('pextension')->get_listado();
        }

        $cuadro->set_datos($this->s__datos);
    }

    function evt__cuadro__seleccion($datos) {
        $this->set_pantalla('pant_formulario');
        $this->dep('datos')->tabla('pextension')->cargar($datos);
    }

    //-------------------------------------------------------------------------------
    //------------------------- PANTALLA ALTA PROYECTO  -----------------------------
    //-------------------------------------------------------------------------------

    function conf__pant_alta_proyecto(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = 'pant_alta_proyecto';

        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();
        $this->pantalla()->tab("pant_seguimiento")->ocultar();
        $this->pantalla()->tab("pant_formulario")->ocultar();
        $this->pantalla()->tab("pant_destinatarios")->ocultar();
        $this->pantalla()->tab("pant_planilla")->ocultar();
        $this->pantalla()->tab("pant_organizaciones")->ocultar();
        $this->pantalla()->tab("pant_objetivos")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_presupuesto")->ocultar();
    }

    //------------------------- FORMULARIO ALTA PROYECTO ----------------------------

    function conf__form_alta_proyecto(toba_ei_formulario $form) {
        
    }

    function evt__form_alta_proyecto__alta($datos) {

        $perfil = toba::usuario()->get_perfil_datos();

        if ($perfil != null) {
            $ua = $this->dep('datos')->tabla('unidad_acad')->get_ua(); //trae la ua de acuerdo al perfil de datos  
            $datos['uni_acad'] = $ua[0]['sigla'];
        }

        //Cambio de estado a en formulacion ( ESTADO INICIAL )
        $datos[id_estado] = 'FORM';
        $datos[fec_carga] = date('Y-m-d');

        //responsable de carga proyecto
        $datos[responsable_carga] = toba::manejador_sesiones()->get_id_usuario_instancia();

        unset($datos[tipo_convocatoria]);

        $this->dep('datos')->tabla('pextension')->set($datos);
        $this->dep('datos')->tabla('pextension')->sincronizar();
        $this->dep('datos')->tabla('pextension')->cargar($datos);

        toba::notificacion()->agregar('El Nuevo Proyecto se a creado correctamente', 'info');
        $this->set_pantalla('pant_formulario');
    }

    //-------------------------------------------------------------------------------
    //------------------------- PANTALLA SEGUIMIENTO  -------------------------------
    //-------------------------------------------------------------------------------

    function conf__pant_seguimiento(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_seguimiento";

        $this->pantalla()->tab("pant_alta_proyecto")->ocultar();
        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();
    }

    // ------------------------------------------------------------------------------
    //------------------------- CUADRO SEGUIMIENTO CENTRAL --------------------------
    //-------------------------------------------------------------------------------

    function conf__cuadro_seg_central(toba_ei_cuadro $cuadro) {
        // CARGO DE EXISTIR UN ACCEDO AL FORMULARIO SEGUIMIENTO CENTRAL
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos = $this->dep('datos')->tabla('seguimiento_central')->get_listado($pe['id_pext']);
        $datos[0]['denominacion'] = $pe['denominacion'];
        $cuadro->set_datos($datos);

        // BOTON SELECCION 
        // SI EXISTE UN FORMULARIO CARGADO 
        if ($this->dep('datos')->tabla('seguimiento_central')->get_listado($pe['id_pext'])) {
            $this->dep('cuadro_seg_central')->evento('seleccion')->mostrar();
        } else {
            $this->dep('cuadro_seg_central')->evento('seleccion')->ocultar();
        }
        $perfil = toba::manejador_sesiones()->get_perfiles_funcionales()[0];
        // BOTON ALTA Y EDITAR -> SI NO ES UN USUARIO VALIDO LOS BOTONES DE ALTA Y EDICCION NO SE HABILITAN 
        if ($perfil != 'sec_ext_central' && $perfil != 'admin') {
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
        // SOLO SE HABRE EL FORMULARIO EN MODO LECTURA
        $this->set_pantalla('pant_seguimiento_central');
        $this->dep('datos')->tabla('seguimiento_central')->cargar($datos);

        $this->dep('formulario_seguimiento')->set_solo_lectura();
        $this->dep('formulario_seguimiento')->evento('modificacion')->ocultar();
        $this->dep('formulario_seguimiento')->evento('baja')->ocultar();
        $this->dep('formulario_seguimiento')->evento('cancelar')->ocultar();
    }

    function evt__cuadro_seg_central__editar($datos) {
        $this->set_pantalla('pant_seguimiento_central');
        $this->dep('datos')->tabla('seguimiento_central')->cargar($datos);
    }

    function evt__cuadro_seg_central__alta($datos) {
        $this->set_pantalla('pant_seguimiento_central');
        $this->dep('datos')->tabla('seguimiento_central')->cargar($datos);
    }

    // -----------------------------------------------------------------------------
    //------------------------- CUADRO SEGUIMINETO UA ------------------------------
    //------------------------------------------------------------------------------

    function conf__cuadro_seg_ua(toba_ei_cuadro $cuadro) {
        // CARGO DE EXISTIR UN ACCEDO AL FORMULARIO SEGUIMIENTO UA
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos = $this->dep('datos')->tabla('seguimiento_ua')->get_listado($pe['id_pext']);
        $datos[0]['denominacion'] = $pe['denominacion'];
        $cuadro->set_datos($datos);

        // BOTON SELECCION
        if ($this->dep('datos')->tabla('seguimiento_ua')->get_listado($pe['id_pext'])) {
            $this->dep('cuadro_seg_ua')->evento('seleccion')->mostrar();
        } else {
            $this->dep('cuadro_seg_ua')->evento('seleccion')->ocultar();
        }
        $perfil = toba::manejador_sesiones()->get_perfiles_funcionales()[0];
        if ($perfil != 'sec_ext_ua' && $perfil != 'admin') {
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
        // HABILITA FORM SOLO LECTURA
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

    //-------------------------------------------------------------------------------
    //------------------------- PANTALLA SEGUIMIENTO CENTRAL ------------------------
    //-------------------------------------------------------------------------------

    function conf__pant_seguimiento_central(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_seguimiento_central";

        $this->pantalla()->tab("pant_alta_proyecto")->ocultar();
        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();
    }

    //--------------------------------------------------------------------------------
    //---- -------------------- FORMULARIO SEGUIMIENTO CENTRAL -----------------------
    //--------------------------------------------------------------------------------

    function conf__formulario_seguimiento(toba_ei_formulario $form) {

        $perfil = toba::manejador_sesiones()->get_perfiles_funcionales()[0];
        $pe = $this->dep('datos')->tabla('pextension')->get();

        $estado = $pe[id_estado];
        if ($estado == 'FORM' && $perfil != 'admin') {
            $this->dep('formulario_seguimiento')->set_solo_lectura();
            $this->dep('formulario_seguimiento')->evento('modificacion')->ocultar();
            $this->dep('formulario_seguimiento')->evento('baja')->ocultar();
            $this->dep('formulario_seguimiento')->evento('cancelar')->ocultar();
        }

        // DATOS DE REFERENCIA DEL PROYECTO SOLO LECTURA
        $form->ef('duracion')->set_solo_lectura();
        $form->ef('id_bases')->set_solo_lectura();
        $form->ef('fec_desde')->set_solo_lectura();
        $form->ef('fec_hasta')->set_solo_lectura();

        // OBTENGO DE EXISTIR EL BECARIO
        $seg_ua = $this->dep('datos')->tabla('seguimiento_ua')->get_listado($pe['id_pext']);
        if ($seg_ua[0]['nro_docum'] != null) {
            $int = $this->dep('datos')->tabla('integrante_externo_pe')->get_integrante($seg_ua[0]['nro_docum'], $pe['id_pext']);
        }

        if ($this->dep('datos')->tabla('seguimiento_central')->esta_cargada()) {
            $datos = $this->dep('datos')->tabla('seguimiento_central')->get();

            $datos[denominacion] = $pe[denominacion];
            $datos[id_bases] = $pe[id_bases];
            $datos[duracion] = $pe[duracion];
            $datos[monto] = $pe[monto];
            $datos[fec_desde] = $pe[fec_desde];
            $datos[fec_hasta] = $pe[fec_hasta];

            if (!is_null($int)) {
                $datos[nombre_becario] = $int[0][nombre];
                $datos[dni_becario] = $int[0][tipo_docum] . $int[0][nro_docum];
            }

            $form->set_datos($datos);
        } else {
            $form->ef('denominacion')->set_estado($pe[denominacion]);
            $form->ef('duracion')->set_estado($pe[duracion]);
            $form->ef('monto')->set_estado($pe[monto]);
            $form->ef('fec_desde')->set_estado($pe[fec_desde]);
            $form->ef('fec_hasta')->set_estado($pe[fec_hasta]);
            if (!is_null($int)) {
                $form->ef('nombre_becario')->set_estado($int[0][nombre]);
                $form->ef('dni_becario')->set_estado($int[0][tipo_docum] . $int[0][nro_docum]);
            }
        }
    }

    function evt__formulario_seguimiento__alta($datos) {

        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos['id_pext'] = $pe['id_pext'];

        // ACTUALIZO FECHA DE PROYECTO DE HABER PRORROGA
        if ($datos['fecha_prorroga2'] != null) {
            $sql = "UPDATE pextension SET fec_hasta ='" . $datos['fecha_prorroga2'] . "' WHERE id_pext =" . $pe[id_pext];
            toba::db('extension')->consultar($sql);
        }

        unset($datos[denominacion]);
        unset($datos[duracion]);
        unset($datos[monto]);
        unset($datos[id_bases]);
        unset($datos[fec_desde]);
        unset($datos[fec_hasta]);
        unset($datos[nombre_becario]);
        unset($datos[dni_becario]);

        $this->dep('datos')->tabla('seguimiento_central')->set($datos);
        $this->dep('datos')->tabla('seguimiento_central')->sincronizar();
        $this->dep('datos')->tabla('seguimiento_central')->cargar($datos);

        toba::notificacion()->agregar('Los datos del seguimiento se han guardado exitosamente', 'info');
    }

    function evt__formulario_seguimiento__modificacion($datos) {
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos['id_pext'] = $pe['id_pext'];

        if ($datos['fecha_prorroga2'] != null) {
            $sql = "UPDATE pextension SET fec_hasta =' " . $datos['fecha_prorroga2'] . "' where id_pext = " . $pe[id_pext];
            toba::db('extension')->consultar($sql);
        }

        $this->dep('datos')->tabla('seguimiento_central')->set($datos);
        $this->dep('datos')->tabla('seguimiento_central')->sincronizar();
    }

    function evt__formulario_seguimiento__baja() {
        $this->dep('datos')->tabla('seguimiento_central')->eliminar_todo();
        $this->dep('datos')->tabla('seguimiento_central')->resetear();
        $this->set_pantalla('pant_seguimiento');
    }

    function evt__formulario_seguimiento__cancelar() {
        $this->dep('datos')->tabla('seguimiento_central')->resetear();
        $this->set_pantalla('pant_seguimiento');
    }

    //-------------------------------------------------------------------------------
    //------------------------- PANTALLA SEGUIMIENTO UA -----------------------------
    //-------------------------------------------------------------------------------

    function conf__pant_seguimiento_ua(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_seguimiento_central";

        $this->pantalla()->tab("pant_alta_proyecto")->ocultar();
        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
    }

    //-------------------------------------------------------------------------------
    //-------------------------- FORMULARIO SEGUIMIENTO UA --------------------------
    //-------------------------------------------------------------------------------

    function conf__formulario_seg_ua(toba_ei_formulario $form) {

        $perfil = toba::manejador_sesiones()->get_perfiles_funcionales()[0];
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $estado = $pe[id_estado];

        if ($estado == 'FORM' && $perfil != 'admin') {
            $this->dep('formulario_seg_ua')->set_solo_lectura();
            $this->dep('formulario_seg_ua')->evento('modificacion')->ocultar();
            $this->dep('formulario_seg_ua')->evento('baja')->ocultar();
            $this->dep('formulario_seg_ua')->evento('cancelar')->ocultar();
        }

        $form->ef('id_bases')->set_solo_lectura();
        $form->ef('fec_desde')->set_solo_lectura();
        $form->ef('fec_hasta')->set_solo_lectura();
        $form->ef('duracion')->set_solo_lectura();


        if ($this->dep('datos')->tabla('seguimiento_ua')->esta_cargada()) {
            $datos = $this->dep('datos')->tabla('seguimiento_ua')->get();

            if ($datos['nro_docum'] != null) {
                $ext = $this->dep('datos')->tabla('integrante_externo_pe')->get_integrante($datos[nro_docum], $datos[id_pext])[0];
                $datos[integrante] = $ext[nro_docum];
            }

            $datos[uni_acad] = $pe[uni_acad];
            $datos[duracion] = $pe[duracion];
            $datos[monto] = $pe[monto];
            $datos[id_bases] = $pe[id_bases];
            $datos[responsable_carga] = $pe[responsable_carga];
            $datos[fec_desde] = $pe[fec_desde];
            $datos[fec_hasta] = $pe[fec_hasta];
            $datos[denominacion] = $pe[denominacion];
            $datos[ord_priori] = $pe[ord_priori];
            $datos[codigo] = $pe[codigo];
            $datos['id_estado'] = $pe['id_estado'];

            $form->set_datos($datos);
        } else {
            $form->ef('denominacion')->set_estado($pe[denominacion]);
            $form->ef('fec_desde')->set_estado($pe[fec_desde]);
            $form->ef('fec_hasta')->set_estado($pe[fec_hasta]);
            $form->ef('duracion')->set_estado($pe[duracion]);
            $form->ef('uni_acad')->set_estado($pe[uni_acad]);
            $form->ef('monto')->set_estado($pe[monto]);
            $form->ef('responsable_carga')->set_estado($pe[responsable_carga]);
        }
    }

    function evt__formulario_seg_ua__alta($datos) {

        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos['id_pext'] = $pe['id_pext'];

        if ($datos['integrante'] != null) {
            $ext = $this->dep('datos')->tabla('integrante_externo_pe')->get_integrante($datos['integrante'], $datos[id_pext])[0];
            if (!is_null($ext)) {
                $sql = "UPDATE integrante_externo_pe SET funcion_p = 'B    ' WHERE nro_docum=" . $ext[nro_docum] . " AND tipo_docum='" . $ext[tipo_docum] . "' AND desde='" . $ext[desde] . "' AND id_pext =" . $ext[id_pext];
                toba::db('extension')->consultar($sql);
            }
            $datos['tipo_docum'] = $ext['tipo_docum'];
            $datos['nro_docum'] = $ext['nro_docum'];
            $datos['desde'] = $ext['desde'];
        }
        if ($datos[ord_priori] != $pe[ord_priori] || $datos[id_estado] != $pe[id_estado]) {
            unset($pe[x_dbr_clave]);
            $pe[ord_priori] = $datos[ord_priori];
            if ($datos['id_estado'] != null) {
                $pe['id_estado'] = $datos['id_estado'];
            }
            $this->dep('datos')->tabla('pextension')->set($pe);
            $this->dep('datos')->tabla('pextension')->sincronizar();
            $this->dep('datos')->tabla('pextension')->cargar($pe);
        }
        unset($datos[ord_priori]);
        unset($datos[uni_acad]);
        unset($datos[duracion]);
        unset($datos[financiacion]);
        unset($datos[monto]);
        unset($datos[id_bases]);
        unset($datos[responsable_carga]);
        unset($datos[fec_desde]);
        unset($datos[fec_hasta]);
        unset($datos[denominacion]);
        unset($datos[codigo]);
        unset($datos[integrante]);

        $this->dep('datos')->tabla('seguimiento_ua')->set($datos);
        $this->dep('datos')->tabla('seguimiento_ua')->sincronizar();
        $this->dep('datos')->tabla('seguimiento_ua')->cargar($datos);

        toba::notificacion()->agregar('Los datos del seguimiento se han guardado exitosamente', 'info');
    }

    function evt__formulario_seg_ua__modificacion($datos) {

        //obtengo los datos antes de modificar para verificar que se modificara el becario
        $datos_seg = $this->dep('datos')->tabla('seguimiento_ua')->get();

        if ($datos_seg['nro_docum'] != null) {
            $ext_anterior = $this->dep('datos')->tabla('integrante_externo_pe')->get_integrante($datos_seg['nro_docum'], $datos_seg[id_pext])[0];
        }

        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos['id_pext'] = $pe['id_pext'];

        if ($datos['integrante'] != null) {
            $ext = $this->dep('datos')->tabla('integrante_externo_pe')->get_integrante($datos['integrante'], $datos[id_pext])[0];

            if (!is_null($ext_anterior)) {
                if ($datos[integrante] != $datos_seg[nro_docum]) {
                    $sql = "UPDATE integrante_externo_pe SET funcion_p = 'I    ' WHERE nro_docum=" . $ext_anterior[nro_docum] . " AND tipo_docum='" . $ext_anterior[tipo_docum] . "' AND desde='" . $ext_anterior[desde] . "' AND id_pext =" . $ext_anterior[id_pext];
                    toba::db('extension')->consultar($sql);
                }
            }
//            
            $sql = "UPDATE integrante_externo_pe SET funcion_p = 'B    ' WHERE nro_docum=" . $ext[nro_docum] . " AND tipo_docum='" . $ext[tipo_docum] . "' AND desde='" . $ext[desde] . "' AND id_pext =" . $ext[id_pext];
            toba::db('extension')->consultar($sql);
//            
            $datos['tipo_docum'] = $ext['tipo_docum'];
            $datos['nro_docum'] = $ext['nro_docum'];
            $datos['desde'] = $ext['desde'];
        } else {
            if (!is_null($ext_anterior)) {

                $sql = "UPDATE integrante_externo_pe SET funcion_p = 'I    ' WHERE nro_docum=" . $ext_anterior[nro_docum] . " AND tipo_docum='" . $ext_anterior[tipo_docum] . "' AND desde='" . $ext_anterior[desde] . "' AND id_pext =" . $ext_anterior[id_pext];
                toba::db('extension')->consultar($sql);
            }
            $datos['tipo_docum'] = null;
            $datos['nro_docum'] = null;
            $datos['desde'] = null;
        }
        if ($datos[ord_priori] != $pe[ord_priori] || $datos[id_estado] != $pe[id_estado]) {
            unset($pe[x_dbr_clave]);
            $pe[ord_priori] = $datos[ord_priori];
            if ($datos['id_estado'] != null) {
                $pe['id_estado'] = $datos['id_estado'];
            }
            $this->dep('datos')->tabla('pextension')->set($pe);
            $this->dep('datos')->tabla('pextension')->sincronizar();
            $this->dep('datos')->tabla('pextension')->cargar($pe);
        }
        unset($datos[ord_priori]);

        $this->dep('datos')->tabla('seguimiento_ua')->set($datos);
        $this->dep('datos')->tabla('seguimiento_ua')->sincronizar();
    }

    function evt__formulario_seg_ua__baja() {
        $this->dep('datos')->tabla('seguimiento_ua')->eliminar_todo();
        $this->dep('datos')->tabla('seguimiento_ua')->resetear();
        $this->set_pantalla('pant_seguimiento');
    }

    function evt__formulario_seg_ua__cancelar() {
        $this->dep('datos')->tabla('seguimiento_ua')->resetear();
        $this->set_pantalla('pant_seguimiento');
    }

    //-------------------------------------------------------------------------------
    //------------------------- PANTALLA FORMULARIO PRINCIPAL  ----------------------
    //-------------------------------------------------------------------------------

    function conf__pant_formulario(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_formulario";

        $this->pantalla()->tab("pant_alta_proyecto")->ocultar();
        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();

        $perfil = toba::manejador_sesiones()->get_perfiles_funcionales()[0];

        if ($this->dep('datos')->tabla('pextension')->esta_cargada()) {
            $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];

            // si presiono el boton enviar no puede editar nada mas 
            if ($estado != 'FORM' && $estado != 'MODF') {
                $this->controlador()->evento('enviar')->ocultar();
            } else {
                if ($perfil != 'admin') {
                    $this->pantalla()->tab("pant_seguimiento")->ocultar();
                }
            }
        } else {
            $this->controlador()->evento('enviar')->ocultar();
            $this->controlador()->evento('pdf')->ocultar();
            $this->pantalla()->tab("pant_seguimiento")->ocultar();
        }
        $this->s__imprimir = 1;
    }

    //------------------------- FORMULARIO PRINCIPAL ---------------------------------

    function conf__formulario(toba_ei_formulario $form) {
        $perfil = toba::manejador_sesiones()->get_perfiles_funcionales()[0];
        $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
        // si presiono el boton enviar no puede editar nada mas 
        // Si esta cargado, traigo los datos de la base de datos
        if ($this->dep('datos')->tabla('pextension')->esta_cargada()) {

            if ($estado != 'FORM' && $estado != 'MODF' && $perfil != 'admin') {
                $this->dep('formulario')->set_solo_lectura();
                $this->dep('formulario')->evento('modificacion')->ocultar();
                $this->dep('formulario')->evento('baja')->ocultar();
                $this->dep('formulario')->evento('cancelar')->ocultar();
            }
            $form->ef('fec_carga')->set_solo_lectura();
            $form->ef('fec_desde')->set_solo_lectura();
            $form->ef('fec_hasta')->set_solo_lectura();

            $datos = $this->dep('datos')->tabla('pextension')->get();
            $seg_central = $this->dep('datos')->tabla('seguimiento_central')->get_listado($datos['id_pext']);

            $where = array();
            $where['uni_acad'] = $datos[uni_acad];
            $where['id_pext'] = $datos[id_pext];

            $datos = $this->dep('datos')->tabla('pextension')->get_datos($where);
            $bases = $this->dep('datos')->tabla('bases_convocatoria')->get_datos($datos[id_bases])[0];

            $datos[0][fec_desde] = $bases[fecha_hasta];

            if (count($datos[0]['co_director']) < 1) {
                $datos[0]['co_director'] = $datos[0]['co_director_e'];
                $datos['co_email'][0] = $datos[0]['co_email_e'];
            }
            $datos = $datos[0];
            $datos[codigo] = $seg_central[0][codigo];
            $ejes = array();
            $aux = $datos['eje_tematico'];

            for ($i = 0; $i < strlen($aux); $i++) {
                if ($aux[$i] != '{' AND $aux[$i] != ',' AND $aux[$i] != '}') {
                    if ($aux[$i + 1] != '{' AND $aux[$i + 1] != ',' AND $aux[$i + 1] != '}') {
                        $ejes . array_push($ejes, $aux[$i] . $aux[$i + 1]);
                        $i++;
                    } else {
                        $ejes . array_push($ejes, $aux[$i]);
                    }
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

        //Cambio de estado a en formulacion ( ESTADO INICIAL )
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

        //Obtengo los datos del proyecto cargado
        $datos_pe = $this->dep('datos')->tabla('pextension')->get();
        //Obtengo datos de integrantes externos cargados
        $datos_integrantes_e = $this->dep('datos')->tabla('integrante_externo_pe')->get_listado($datos_pe['id_pext']);
        //Obtengo datos de integrantes internos cargados
        $datos_integrantes_i = $this->dep('datos')->tabla('integrante_interno_pe')->get_listado($datos_pe['id_pext']);

        if ($datos_pe['fec_desde'] != $datos['fec_desde']) {
            if (!is_null($datos_integrantes_e)) {
                foreach ($datos_integrantes_e as $externo) {
                    //Si es integrante vigente
                    if (strcasecmp(date('Y-m-d'), date('Y-m-d', strtotime($externo['hasta']))) <= 0 && $datos_pe['fec_desde'] == $externo['desde']) {
                        $sql = "UPDATE integrante_externo_pe SET desde ='" . $datos['fec_desde'] . "' where id_pext = " . $externo[id_pext] .
                                " AND tipo_docum ='" . $externo['tipo_docum'] . " ' AND nro_docum = " . $externo['nro_docum'];
                        toba::db('extension')->consultar($sql);
                    }
                }
            }
            if (!is_null($datos_integrantes_i)) {
                foreach ($datos_integrantes_i as $interno) {
                    //Si es integrante vigente
                    if (strcasecmp(date('Y-m-d'), date('Y-m-d', strtotime($interno['hasta']))) <= 0 && $datos_pe['fec_desde'] == $interno['desde']) {
                        $sql = "UPDATE integrante_interno_pe SET desde ='" . $datos['fec_desde'] . "' where id_pext = " . $datos_pe[id_pext] .
                                " AND id_designacion = " . $interno['id_designacion'];
                        toba::db('extension')->consultar($sql);
                    }
                }
            }
        }

        if ($datos_pe['fec_hasta'] != $datos['fec_hasta']) {
            if (!is_null($datos_integrantes_e)) {
                foreach ($datos_integrantes_e as $externo) {
                    //Si es integrante vigente
                    if (strcasecmp(date('Y-m-d'), date('Y-m-d', strtotime($externo['hasta']))) <= 0) {
                        $sql = "UPDATE integrante_externo_pe SET hasta ='" . $datos['fec_hasta'] . "' where id_pext = " . $datos_pe[id_pext] .
                                " AND tipo_docum ='" . $externo['tipo_docum'] . "' AND nro_docum = " . $externo['nro_docum'];
                        toba::db('extension')->consultar($sql);
                    }
                }
            }
            if (!is_null($datos_integrantes_i)) {
                foreach ($datos_integrantes_i as $interno) {
                    //Si es integrante vigente
                    if (strcasecmp(date('Y-m-d'), date('Y-m-d', strtotime($interno['hasta']))) <= 0) {
                        $sql = "UPDATE integrante_interno_pe SET hasta =' " . $datos['fec_hasta'] . "' where id_pext = " . $datos_pe[id_pext] .
                                " AND id_designacion = " . $interno['id_designacion'];
                        toba::db('extension')->consultar($sql);
                    }
                }
            }
        }

        $ejes = $datos['eje_tematico'];
        $array = '{' . $ejes[0];
        unset($ejes[0]);
        foreach ($ejes as $eje) {
            $array = $array . ',' . $eje;
        }
        $array = $array . '}';
        $datos['eje_tematico'] = $array;

        $datos[id_estado] = $datos_pe[id_estado];

        $this->dep('datos')->tabla('pextension')->set($datos);
        $this->dep('datos')->tabla('pextension')->sincronizar();
    }

    function evt__formulario__baja() {
        $this->dep('datos')->tabla('pextension')->eliminar_todo();
        $this->dep('datos')->tabla('pextension')->resetear();
        $this->set_pantalla('pant_edicion');
    }

    function evt__formulario__cancelar() {
        $this->dep('datos')->tabla('pextension')->resetear();
        $this->set_pantalla('pant_edicion');
    }

    //-------------------------------------------------------------------------------
    //------------------------- PANTALLA DESTINATARIOS ------------------------------
    //-------------------------------------------------------------------------------

    function conf__pant_destinatarios(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_destinatarios";

        $this->pantalla()->tab("pant_alta_proyecto")->ocultar();
        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();

        $perfil = toba::manejador_sesiones()->get_perfiles_funcionales()[0];

        if ($perfil == formulador) {
            $this->pantalla()->tab("pant_seguimiento")->ocultar();
        }
        $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
        // si presiono el boton enviar no puede editar nada mas 
        if ($estado != 'FORM' && $estado != 'MODF') {
            $this->controlador()->evento('alta')->ocultar();
        }
    }

    //------------------------- CUADRO DESTINATARIOS --------------------------------


    function conf__cuadro_destinatarios(toba_ei_cuadro $cuadro) {
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos = $this->dep('datos')->tabla('destinatarios')->get_listado($pe['id_pext']);

        $cuadro->set_datos($datos);
    }

    function evt__cuadro_destinatarios__seleccion($datos) {
        $this->dep('datos')->tabla('destinatarios')->cargar($datos);
        $this->s__mostrar_dest = 1;
    }

    //------------------------- FORMULARIO DESTINATARIO ------------------------------

    function conf__formulario_destinatarios(toba_ei_formulario $form) {
        if ($this->s__mostrar_dest == 1) {
            $$perfil = toba::manejador_sesiones()->get_perfiles_funcionales()[0];
            $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
            // si presiono el boton enviar no puede editar nada mas 
            if ($estado != 'FORM' && $estado != 'MODF' && $perfil != 'admin') {
                $this->dep('formulario_destinatarios')->set_solo_lectura();
                $this->dep('formulario_destinatarios')->evento('modificacion')->ocultar();
                $this->dep('formulario_destinatarios')->evento('baja')->ocultar();
                $this->dep('formulario_destinatarios')->evento('cancelar')->ocultar();
            }
            $this->controlador()->evento('alta')->ocultar();
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

        toba::notificacion()->agregar('El destinatario se ha eliminado  correctamente.', 'info');

        $this->s__mostrar_dest = 0;
    }

    function evt__formulario_destinatarios__cancelar() {
        $this->s__mostrar_dest = 0;
        $this->dep('datos')->tabla('destinatarios')->resetear();
    }

    //-------------------------------------------------------------------------------
    //------------------------- PANTALLA INTEGRANTES --------------------------------
    //-------------------------------------------------------------------------------

    function conf__pant_planilla(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_planilla";

        $this->pantalla()->tab("pant_alta_proyecto")->ocultar();
        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();

        $perfil = toba::manejador_sesiones()->get_perfiles_funcionales()[0];
        if ($perfil == formulador) {
            $this->pantalla()->tab("pant_seguimiento")->ocultar();
        }
        $this->s__imprimir = 0;
    }

    //------------------------- CUADRO INTEGRANTES ----------------------------------


    function conf__cuadro_plantilla(toba_ei_cuadro $cuadro) {
        $pe = $this->dep('datos')->tabla('pextension')->get();
        // OBTENGO TODOS LOS INTEGRANTES VIGENTES
        $datos = $this->dep('datos')->tabla('integrante_externo_pe')->get_plantilla($pe['id_pext'], $this->s__datos_filtro);

        $cuadro->set_datos($datos);
    }

    //------------------------- FILTRO INTEGRANTES ----------------------------------

    function conf__filtro_integrantes(toba_ei_filtro $filtro) {
        if (isset($this->s__datos_filtro)) {
            $filtro->set_datos($this->s__datos_filtro);
        }
    }

    function evt__filtro_integrantes__filtrar($datos) {
        $this->s__datos_filtro = $datos;
    }

    function evt__filtro_integrantes__cancelar() {
        // LIMPIAR 
        unset($this->s__datos_filtro);
    }

    //------------------------- FILTRO INTEGRANTES VIGENTES -------------------------------------

    function conf__filtro_vigentes(toba_ei_filtro $filtro) {
        if (isset($this->s__datos_filtro)) {
            $filtro->set_datos($this->s__datos_filtro);
        }
    }

    function evt__filtro_vigentes__filtrar($datos) {
        $this->s__datos_filtro = $datos;
        $this->s__where = $this->dep('filtro_vigentes')->get_sql_where();
    }

    function evt__filtro_vigentes__cancelar() {
        unset($this->s__datos_filtro);
        unset($this->s__where);
    }

    //-------------------------------------------------------------------------------
    //------------------------- PANTALLA INTEGRANTES INTERNOS -----------------------
    //-------------------------------------------------------------------------------

    function conf__pant_integrantesi(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_interno";

        $this->pantalla()->tab("pant_alta_proyecto")->ocultar();
        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();

        $perfil = toba::manejador_sesiones()->get_perfiles_funcionales()[0];
        $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
        // si presiono el boton enviar no puede editar nada mas 
        if ($estado != 'FORM' && $estado != 'MODF') {
            $this->controlador()->evento('alta')->ocultar();
        } else {
            if ($perfil == formulador) {
                $this->pantalla()->tab("pant_seguimiento")->ocultar();
            }
        }
        $this->s__imprimir = 0;
    }

    //------------------------- CUADRO INTEGRANTE INTERNO  --------------------------


    function conf__cuadro_ii(toba_ei_cuadro $cuadro) {
        $pe = $this->dep('datos')->tabla('pextension')->get();
        if (isset($this->s__where)) {
            $this->s__datos = $this->dep('datos')->tabla('integrante_interno_pe')->get_vigentes($this->s__where, $pe['id_pext']);
        } else {
            $this->s__datos = $this->dep('datos')->tabla('integrante_interno_pe')->get_listado($pe['id_pext']);
        }
        $cuadro->set_datos($this->s__datos);
    }

    function evt__cuadro_ii__seleccion($datos) {
        $this->s__mostrar = 1;
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos['id_pext'] = $pe['id_pext'];

        $this->dep('datos')->tabla('integrante_interno_pe')->cargar($datos);
    }

    //-------------------------- FORMULARIO INTEGRANTE INTERNO  ---------------------

    function conf__form_integrantes(toba_ei_formulario $form) {
        if ($this->s__mostrar == 1) {
            $perfil = toba::manejador_sesiones()->get_id_usuario_instancia();
            $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
            // si presiono el boton enviar no puede editar nada mas 
            if ($estado != 'FORM' && $estado != 'MODF') {
                $this->dep('form_integrantes')->set_solo_lectura();
                $this->dep('form_integrantes')->evento('modificacion')->ocultar();
                $this->dep('form_integrantes')->evento('baja')->ocultar();
                $this->dep('form_integrantes')->evento('cancelar')->ocultar();
            }
            $this->controlador()->evento('alta')->ocultar();
            $this->dep('form_integrantes')->descolapsar();
        } else {
            $this->dep('form_integrantes')->colapsar();
        }

        //para la edicion de los integrantes ya cargados
        if ($this->dep('datos')->tabla('integrante_interno_pe')->esta_cargada()) {
            $datos = $this->dep('datos')->tabla('integrante_interno_pe')->get();
            $fp_imagen = $this->dep('datos')->tabla('integrante_interno_pe')->get_blob('cv');

            if (isset($fp_imagen)) {
                $temp_nombre = md5(uniqid(time())) . '.pdf';
                $temp_archivo = toba::proyecto()->get_www_temp($temp_nombre);
                $tamano = round(filesize($temp_archivo['path']) / 1024);
                $datos['cv'] = 'tamano: ' . $tamano . ' KB';
            } else {
                $datos['cv'] = null;
            }

            $form->ef('id_docente')->set_solo_lectura();

            $datos['funcion_p'] = str_pad($datos['funcion_p'], 5);
            $docente = $this->dep('datos')->tabla('docente')->get_id_docente($datos['id_designacion']);
            if (count($docente) > 0) {
                $datos['id_docente'] = $docente['id_docente'];
            }
            $form->set_datos($datos);
        }
    }

    function evt__form_integrantes__alta($datos) {

        $datos[ua] = $this->dep('datos')->tabla('designacion')->get_ua($datos['id_designacion']);
        //proyecto de extension datos
        $pe = $this->dep('datos')->tabla('pextension')->get();

        // control fechas hasta mayo que desde
        if ($datos['hasta'] > $datos['desde']) {
            //control de fecha actual superior a fecha desde
            if (strcasecmp(date('Y-m-d'), date('Y-m-d', strtotime($datos['desde']))) <= 0) {
                // control fecha hasta menor o igual fin proyecto
                if (strcasecmp(date('Y-m-d', strtotime($pe['fec_hasta'])), date('Y-m-d', strtotime($datos['hasta']))) >= 0) {
                    // control fecha desde mayor o igual fecha inicio proyecto
                    if (strcasecmp(date('Y-m-d', strtotime($pe['fec_desde'])), date('Y-m-d', strtotime($datos['desde']))) <= 0) {
                        $integrantes_i = $this->dep('datos')->tabla('integrante_interno_pe')->get_listado($pe['id_pext']);
                        $integrantes_e = $this->dep('datos')->tabla('integrante_externo_pe')->get_listado($pe['id_pext']);
                        $boolean = true;
                        //control de director o codirector no repetido 
                        if ($datos['funcion_p'] != $integrante_datos_almacenados['funcion_p']) {
                            $perfil_ua = $this->dep('datos')->tabla('unidad_acad')->get_ua()[0];

                            $perfil = toba::manejador_sesiones()->get_perfiles_funcionales()[0];
                            if ($perfil == 'admin') {
                                $perfil_ua = $datos[ua];
                            }

                            $director_ua = true;
                            if ($datos['funcion_p'] == 'D    ') {
                                if ($perfil_ua[sigla] == $datos[ua]) {
                                    foreach ($integrantes_i as $integrante) {
                                        if ($integrante['funcion_p'] == 'Director') {
                                            $boolean = false;
                                        }
                                    }
                                } else {
                                    $director_ua = false;
                                }
                            }

                            //control de director o codirector no repetido 

                            if ($datos['funcion_p'] == 'CD-Co') {
                                foreach ($integrantes_i as $integrante) {
                                    if ($integrante['funcion_p'] == 'Codirector') {
                                        $boolean = false;
                                    }
                                }
                                foreach ($integrantes_e as $integrante) {
                                    if ($integrante['funcion_p'] == 'Codirector') {
                                        $boolean = false;
                                    }
                                }
                            }
                        }
                        if ($boolean) {
                            if ($director_ua) {
                                $int_interno = $this->dep('datos')->tabla('integrante_interno_pe')->get_integrante($datos[id_docente], $pe['id_pext'])[0];
                                if (!is_null($int_interno)) {
                                    // date('Y-m-d') fecha actual 
                                    if (strcasecmp(date('Y-m-d'), date('Y-m-d', strtotime($int_interno['hasta']))) <= 0) {
                                        toba::notificacion()->agregar('El integrante seleccionado ya es un integrante vigente dentro del proyecto', 'info');
                                    } else {
                                        $datos['id_pext'] = $pe['id_pext'];
                                        $datos['tipo'] = 'Docente';
                                        $this->dep('datos')->tabla('integrante_interno_pe')->set($datos);


                                        //-----------cv interno-----------------------
                                        //si adjunto un pdf entonces "pdf" viene con los datos del archivo adjuntado
                                        if (is_array($datos['cv'])) {
                                            if ($datos['cv']['size'] > $this->tamano_byte) {
                                                toba::notificacion()->agregar(utf8_d_seguro('El tamaño del archivo debe ser menor a ') . $this->tamano_mega . 'MB', 'error');
                                                $fp = null;
                                            } else {
                                                $fp = fopen($datos['cv']['tmp_name'], 'rb');
                                                $this->dep('datos')->tabla('integrante_interno_pe')->set_blob('cv', $fp);
                                            }
                                        } else {
                                            $this->dep('datos')->tabla('integrante_interno_pe')->set_blob('cv', null);
                                        }

                                        $this->dep('datos')->tabla('integrante_interno_pe')->sincronizar();
                                        $this->dep('datos')->tabla('integrante_interno_pe')->resetear();
                                        $this->s__mostrar = 0;
                                    }
                                } else {
                                    $datos['id_pext'] = $pe['id_pext'];
                                    $datos['tipo'] = 'Docente';
                                    $this->dep('datos')->tabla('integrante_interno_pe')->set($datos);

                                    //-----------cv interno-----------------------
                                    //si adjunto un pdf entonces "pdf" viene con los datos del archivo adjuntado
                                    if (is_array($datos['cv'])) {
                                        if ($datos['cv']['size'] > $this->tamano_byte) {
                                            toba::notificacion()->agregar(utf8_d_seguro('El tamaño del archivo debe ser menor a ') . $this->tamano_mega . 'MB', 'error');
                                            $fp = null;
                                        } else {
                                            $fp = fopen($datos['cv']['tmp_name'], 'rb');
                                            $this->dep('datos')->tabla('integrante_interno_pe')->set_blob('cv', $fp);
                                        }
                                    } else {
                                        $this->dep('datos')->tabla('integrante_interno_pe')->set_blob('cv', null);
                                    }

                                    $this->dep('datos')->tabla('integrante_interno_pe')->sincronizar();
                                    $this->dep('datos')->tabla('integrante_interno_pe')->resetear();
                                    $this->s__mostrar = 0;
                                }
                            } else {
                                toba::notificacion()->agregar(utf8_decode('El director del proyecto debe permanecer a la misma unidad que la del formulador.'), 'info');
                            }
                        } else {
                            toba::notificacion()->agregar(utf8_decode('Función duplicada el director y co-director debe ser unico.'), 'info');
                        }
                    } else {
                        toba::notificacion()->agregar('La fecha de inicio de vigencia dentro del proyecto es inferior a la fecha de inicio de proyecto', 'info');
                    }
                } else {
                    toba::notificacion()->agregar('La fecha de fin de vigencia dentro del proyecto excede la fecha de fin de proyecto', 'info');
                }
            } else {
                toba::notificacion()->agregar(utf8_d_seguro('La fecha de inicio dentro del proyecto no corresponde a una fecha validad (" fecha desde anterior a fecha actual ")'), 'info');
            }
        } else {
            toba::notificacion()->agregar('Las fechas de participación del integrantes estan incorrectas ("hasta es menor que desde")', 'info');
        }
    }

    function evt__form_integrantes__baja($datos) {
        $this->dep('datos')->tabla('integrante_interno_pe')->eliminar_todo();
        $this->dep('datos')->tabla('integrante_interno_pe')->resetear();
        toba::notificacion()->agregar('El integrante se ha eliminado  correctamente.', 'info');
        $this->s__mostrar = 0;
    }

    function evt__form_integrantes__modificacion($datos) {
        //proyecto de extension datos
        $pe = $this->dep('datos')->tabla('pextension')->get();
        // obtengo informacion integrante antes de posibles modificaciones 
        $integrante_datos_almacenados = $this->dep('datos')->tabla('integrante_interno_pe')->get();

        // control fechas hasta mayo que desde
        if ($datos['hasta'] > $datos['desde']) {
            //si las fecha no cambio omito control de fecha actual superior a fecha desde
            if ($integrante_datos_almacenados['desde'] == $datos['desde'] || strcasecmp(date('Y-m-d'), date('Y-m-d', strtotime($datos['desde']))) <= 0) {
                // si las fecha no cambio omito control fecha hasta menor o igual fin proyecto
                if ($integrante_datos_almacenados['hasta'] == $datos['hasta'] || strcasecmp(date('Y-m-d', strtotime($pe['fec_hasta'])), date('Y-m-d', strtotime($datos['hasta']))) >= 0) {
                    // si las fecha no cambio omito control fecha desde mayor o igual fecha inicio proyecto
                    if ($integrante_datos_almacenados['desde'] == $datos['desde'] || strcasecmp(date('Y-m-d', strtotime($pe['fec_desde'])), date('Y-m-d', strtotime($datos['desde']))) <= 0) {
                        $integrantes_i = $this->dep('datos')->tabla('integrante_interno_pe')->get_listado($pe['id_pext']);
                        $integrantes_e = $this->dep('datos')->tabla('integrante_externo_pe')->get_listado($pe['id_pext']);
                        $boolean = true;
                        $director_ua = true;
                        //control de director o codirector no repetido 
                        if ($datos['funcion_p'] != $integrante_datos_almacenados['funcion_p']) {
                            $perfil_ua = $this->dep('datos')->tabla('unidad_acad')->get_ua()[0];

                            $perfil = toba::manejador_sesiones()->get_perfiles_funcionales()[0];
                            if ($perfil == 'admin') {
                                $perfil_ua = $datos[ua];
                            }


                            if ($datos['funcion_p'] == 'D    ') {
                                if ($perfil_ua[sigla] == $datos[ua]) {
                                    foreach ($integrantes_i as $integrante) {
                                        if ($integrante['funcion_p'] == 'Director') {
                                            $boolean = false;
                                        }
                                    }
                                } else {
                                    $director_ua = false;
                                }
                            }

                            //control de director o codirector no repetido 

                            if ($datos['funcion_p'] == 'CD-Co') {
                                foreach ($integrantes_i as $integrante) {
                                    if ($integrante['funcion_p'] == 'Codirector') {
                                        $boolean = false;
                                    }
                                }
                                foreach ($integrantes_e as $integrante) {
                                    if ($integrante['funcion_p'] == 'Codirector') {
                                        $boolean = false;
                                    }
                                }
                            }
                        }


                        if ($boolean) {
                            if ($director_ua) {
                                $datos['id_pext'] = $pe['id_pext'];
                                $datos['tipo'] = 'Docente';

                                if (is_array($datos['cv'])) {//si adjunto un pdf entonces "pdf" viene con los datos del archivo adjuntado
                                    if ($datos['cv']['size'] > 0) {
                                        if ($datos['cv']['size'] > $this->tamano_byte) {
                                            toba::notificacion()->agregar(utf8_d_seguro('El tamaño del archivo debe ser menor a ') . $this->tamano_mega . 'MB', 'error');
                                            $fp = null;
                                        } else {
                                            $fp = fopen($datos['cv']['tmp_name'], 'rb');
                                        }
                                    } else {
                                        $fp = null;
                                    }
                                    $this->dep('datos')->tabla('integrante_interno_pe')->set_blob('cv', $fp);
                                }

                                $this->dep('datos')->tabla('integrante_interno_pe')->set($datos);
                                $this->dep('datos')->tabla('integrante_interno_pe')->sincronizar();
                                $this->s__mostrar = 0;
                            } else {
                                toba::notificacion()->agregar(utf8_decode('El director del proyecto debe permanecer a la misma unidad que la del formulador.'), 'info');
                            }
                        } else {
                            toba::notificacion()->agregar(utf8_decode('Función duplicada el director y co-director debe ser unico.'), 'info');
                        }
                    } else {
                        toba::notificacion()->agregar('La fecha de inicio de vigencia dentro del proyecto es inferior a la fecha de inicio de proyecto', 'info');
                    }
                } else {
                    toba::notificacion()->agregar('La fecha de fin de vigencia dentro del proyecto excede la fecha de fin de proyecto', 'info');
                }
            } else {
                toba::notificacion()->agregar(utf8_d_seguro('La fecha de inicio dentro del proyecto no corresponde a una fecha validad (" fecha desde anterior a fecha actual ")'), 'info');
            }
        } else {
            toba::notificacion()->agregar('Las fechas de participación del integrantes estan incorrectas ("hasta es menor que desde")', 'info');
        }
    }

    function evt__form_integrantes__cancelar() {
        $this->s__mostrar = 0;
        $this->dep('datos')->tabla('integrante_interno_pe')->resetear();
    }

    //-------------------------------------------------------------------------------
    //------------------------- PANTALLA INTEGRANTES EXTERNOS -----------------------
    //-------------------------------------------------------------------------------

    function conf__pant_integrantese(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_externo";

        $this->pantalla()->tab("pant_alta_proyecto")->ocultar();
        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();

        $perfil = toba::manejador_sesiones()->get_perfiles_funcionales()[0];
        $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
        // si presiono el boton enviar no puede editar nada mas 
        if ($estado != 'FORM' && $estado != 'MODF') {
            $this->controlador()->evento('alta')->ocultar();
        }
        if ($perfil == formulador) {
            $this->pantalla()->tab("pant_seguimiento")->ocultar();
        }
        $this->s__imprimir = 0;
    }

    //------------------------- CUADRO INTEGRANTE EXTERNO ---------------------------


    function conf__cuadro_int(toba_ei_cuadro $cuadro) {
        $pe = $this->dep('datos')->tabla('pextension')->get();
        if (isset($this->s__where)) {
            $this->s__datos = $this->dep('datos')->tabla('integrante_externo_pe')->get_vigentes($this->s__where, $pe['id_pext']);
        } else {
            $this->s__datos= $this->dep('datos')->tabla('integrante_externo_pe')->get_listado($pe['id_pext']);
        }
        $cuadro->set_datos($this->s__datos);
    }

    function evt__cuadro_int__seleccion($datos) {
        $this->s__mostrar_e = 1;
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos['id_pext'] = $pe['id_pext'];
        $this->dep('datos')->tabla('integrante_externo_pe')->cargar($datos);
    }

    //------------------------- CUADRO INTEGRANTE EXTERNO ---------------------------

    function conf__form_integrante_e(toba_ei_formulario $form) {
        if ($this->s__mostrar_e == 1) {
            $perfil = toba::manejador_sesiones()->get_id_usuario_instancia();
            $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
            // si presiono el boton enviar no puede editar nada mas 
            if ($estado != 'FORM' && $estado != 'MODF') {
                $this->dep('form_integrante_e')->set_solo_lectura();
                $this->dep('form_integrante_e')->evento('modificacion')->ocultar();
                $this->dep('form_integrante_e')->evento('baja')->ocultar();
                $this->dep('form_integrante_e')->evento('cancelar')->ocultar();
            }
            $this->controlador()->evento('alta')->ocultar();
            $this->dep('form_integrante_e')->descolapsar();
        } else {
            $this->dep('form_integrante_e')->colapsar();
        }

        //para la edicion de los integrantes ya cargados
        if ($this->dep('datos')->tabla('integrante_externo_pe')->esta_cargada()) {
            $datos = $this->dep('datos')->tabla('integrante_externo_pe')->get();
            $datos['funcion_p'] = str_pad($datos['funcion_p'], 5);
            $datos['tipo'] = str_pad($datos['tipo'], 5);
            $persona = $this->dep('datos')->tabla('persona')->get_datos($datos['tipo_docum'], $datos['nro_docum']);

            if (count($persona) > 0) {
                $datos['integrante'] = $persona[0]['nombre'];
            }
            $fp_imagen = $this->dep('datos')->tabla('integrante_externo_pe')->get_blob('cv');
            if (isset($fp_imagen)) {
                $temp_nombre = md5(uniqid(time())) . '.pdf';
                $temp_archivo = toba::proyecto()->get_www_temp($temp_nombre);
                $tamano = round(filesize($temp_archivo['path']) / 1024);
                $datos['cv'] = 'tamano: ' . $tamano . ' KB';
            } else {
                $datos['cv'] = null;
            }

            $form->set_datos($datos);
        }
    }

    //ingresa un nuevo integrante 
    function evt__form_integrante_e__alta($datos) {
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $int_ext = $this->dep('datos')->tabla('integrante_externo_pe')->get_integrante($datos['integrante'][1], $pe['id_pext'])[0];
        if ($datos['hasta'] > $datos['desde']) {
            //control de fecha actual superior a fecha desde
            if (strcasecmp(date('Y-m-d'), date('Y-m-d', strtotime($datos['desde']))) <= 0) {
                if (strcasecmp(date('Y-m-d', strtotime($pe['fec_hasta'])), date('Y-m-d', strtotime($datos['hasta']))) >= 0) {
                    if (strcasecmp(date('Y-m-d', strtotime($pe['fec_desde'])), date('Y-m-d', strtotime($datos['desde']))) <= 0) {
                        if (!is_null($int_ext)) {
                            // date('Y-m-d') fecha actual 
                            if (strcasecmp(date('Y-m-d'), date('Y-m-d', strtotime($int_ext['hasta']))) <= 0) {
                                toba::notificacion()->agregar('El integrante seleccionado ya es un integrante vigente dentro del proyecto', 'info');
                            } else {
                                $integrantes_i = $this->dep('datos')->tabla('integrante_interno_pe')->get_listado($pe['id_pext']);
                                $integrantes_e = $this->dep('datos')->tabla('integrante_externo_pe')->get_listado($pe['id_pext']);
                                $boolean = true;
                                //control de director o codirector no repetido 
                                if ($datos['funcion_p'] != $int_ext['funcion_p']) {

                                    if ($datos['funcion_p'] == 'CD-Co') {
                                        foreach ($integrantes_i as $integrante) {
                                            if ($integrante['funcion_p'] == 'Codirector') {
                                                $boolean = false;
                                            }
                                        }
                                        foreach ($integrantes_e as $integrante) {
                                            if ($integrante['funcion_p'] == 'Codirector') {
                                                $boolean = false;
                                            }
                                        }
                                    }
                                }
                                if ($boolean) {
                                    $datos['id_pext'] = $pe['id_pext'];
                                    $datos['tipo_docum'] = $datos['integrante'][0];
                                    $datos['nro_docum'] = $datos['integrante'][1];

                                    $this->dep('datos')->tabla('integrante_externo_pe')->set($datos);

                                    //-----------cv interno-----------------------
                                    //si adjunto un pdf entonces "pdf" viene con los datos del archivo adjuntado
                                    if (is_array($datos['cv'])) {
                                        if ($datos['cv']['size'] > $this->tamano_byte) {
                                            toba::notificacion()->agregar(utf8_d_seguro('El tamaño del archivo debe ser menor a ') . $this->tamano_mega . 'MB', 'error');
                                            $fp = null;
                                        } else {
                                            $fp = fopen($datos['cv']['tmp_name'], 'rb');
                                            $this->dep('datos')->tabla('integrante_externo_pe')->set_blob('cv', $fp);
                                        }
                                    } else {
                                        $this->dep('datos')->tabla('integrante_externo_pe')->set_blob('cv', null);
                                    }

                                    $this->dep('datos')->tabla('integrante_externo_pe')->sincronizar();
                                    $this->dep('datos')->tabla('integrante_externo_pe')->resetear();
                                    $this->s__mostrar_e = 0;
                                } else {
                                    toba::notificacion()->agregar(utf8_decode('Función duplicada co-director debe ser unico.'), 'info');
                                }
                            }
                        } else {
                            $datos['id_pext'] = $pe['id_pext'];
                            $datos['tipo_docum'] = $datos['integrante'][0];
                            $datos['nro_docum'] = $datos['integrante'][1];

                            $this->dep('datos')->tabla('integrante_externo_pe')->set($datos);

                            //-----------cv interno-----------------------
                            //si adjunto un pdf entonces "pdf" viene con los datos del archivo adjuntado
                            if (is_array($datos['cv'])) {
                                if ($datos['cv']['size'] > $this->tamano_byte) {
                                    toba::notificacion()->agregar(utf8_d_seguro('El tamaño del archivo debe ser menor a ') . $this->tamano_mega . 'MB', 'error');
                                    $fp = null;
                                } else {
                                    $fp = fopen($datos['cv']['tmp_name'], 'rb');
                                    $this->dep('datos')->tabla('integrante_externo_pe')->set_blob('cv', $fp);
                                }
                            } else {
                                $this->dep('datos')->tabla('integrante_externo_pe')->set_blob('cv', null);
                            }

                            $this->dep('datos')->tabla('integrante_externo_pe')->sincronizar();
                            $this->dep('datos')->tabla('integrante_externo_pe')->resetear();
                            $this->s__mostrar_e = 0;
                        }
                    } else {
                        toba::notificacion()->agregar('La fecha de inicio de vigencia dentro del proyecto es inferior a la fecha de inicio de proyecto', 'info');
                    }
                } else {
                    toba::notificacion()->agregar('La fecha de fin de vigencia dentro del proyecto excede la fecha de fin de proyecto', 'info');
                }
            } else {
                toba::notificacion()->agregar(utf8_d_seguro('La fecha de inicio dentro del proyecto no corresponde a una fecha validad (" fecha desde anterior a fecha actual ")'), 'info');
            }
        } else {
            toba::notificacion()->agregar('Las fechas de participación del integrantes estan incorrectas ("hasta es menor que desde")', 'info');
        }
    }

    function evt__form_integrante_e__baja($datos) {
        $this->dep('datos')->tabla('integrante_externo_pe')->eliminar_todo();
        $this->dep('datos')->tabla('integrante_externo_pe')->resetear();
        toba::notificacion()->agregar('El integrante se ha eliminado  correctamente.', 'info');
        $this->s__mostrar_e = 0;
    }

    function evt__form_integrante_e__modificacion($datos) {
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $integrante_datos_almacenados = $this->dep('datos')->tabla('integrante_externo_pe')->get();

        //Si count == 2 se modifico la persona asociada
        $count = count($datos['integrante']);
        if ($count == 2) {
            $int_ext = array();
            $int_ext = $this->dep('datos')->tabla('integrante_externo_pe')->get_integrante($datos['integrante'][1])[0];
        }
        //control fecha hasta mayor a desde
        if ($datos['hasta'] > $datos['desde']) {
            //control de fecha actual superior a fecha desde
            if ($integrante_datos_almacenados['desde'] == $datos['desde'] || strcasecmp(date('Y-m-d'), date('Y-m-d', strtotime($datos['desde']))) <= 0) {
                //control fecha hasta menor o igual a fecha fin proyecto
                if ($integrante_datos_almacenados['hasta'] == $datos['hasta'] || strcasecmp(date('Y-m-d', strtotime($pe['fec_hasta'])), date('Y-m-d', strtotime($datos['hasta']))) >= 0) {
                    //control fecha desde mayor o igual a fecha inicio proyecto
                    if ($integrante_datos_almacenados['desde'] == $datos['desde'] || strcasecmp(date('Y-m-d', strtotime($pe['fec_desde'])), date('Y-m-d', strtotime($datos['desde']))) <= 0) {

                        // date('Y-m-d') fecha actual 
                        if (strcasecmp(date('Y-m-d'), date('Y-m-d', strtotime($int_ext['hasta']))) <= 0) {
                            toba::notificacion()->agregar(utf8_d_seguro('El integrante seleccionado ya es un integrante vigente dentro del proyecto'), 'info');
                        } else {
                            $integrantes_i = $this->dep('datos')->tabla('integrante_interno_pe')->get_listado($pe['id_pext']);
                            $integrantes_e = $this->dep('datos')->tabla('integrante_externo_pe')->get_listado($pe['id_pext']);
                            $boolean = true;
                            //control de director o codirector no repetido 
                            if ($datos['funcion_p'] != $integrante_datos_almacenados['funcion_p']) {

                                if ($datos['funcion_p'] == 'CD-Co') {
                                    foreach ($integrantes_i as $integrante) {
                                        if ($integrante['funcion_p'] == 'Codirector') {
                                            $boolean = false;
                                        }
                                    }
                                    foreach ($integrantes_e as $integrante) {
                                        if ($integrante['funcion_p'] == 'Codirector') {
                                            $boolean = false;
                                        }
                                    }
                                }
                            }
                            if ($boolean) {
                                if ($count == 2) {
                                    $datos['id_pext'] = $pe['id_pext'];
                                    $datos['tipo_docum'] = $datos['integrante'][0];
                                    $datos['nro_docum'] = $datos['integrante'][1];
                                }

                                $this->dep('datos')->tabla('integrante_externo_pe')->set($datos);

                                //-----------cv interno-----------------------
                                //si adjunto un pdf entonces "pdf" viene con los datos del archivo adjuntado
                                if (is_array($datos['cv'])) {
                                    if ($datos['cv']['size'] > $this->tamano_byte) {
                                        toba::notificacion()->agregar(utf8_d_seguro('El tamaño del archivo debe ser menor a ') . $this->tamano_mega . 'MB', 'error');
                                        $fp = null;
                                    } else {
                                        $fp = fopen($datos['cv']['tmp_name'], 'rb');
                                        $this->dep('datos')->tabla('integrante_externo_pe')->set_blob('cv', $fp);
                                    }
                                } else {
                                    $this->dep('datos')->tabla('integrante_externo_pe')->set_blob('cv', null);
                                }
                                $this->dep('datos')->tabla('integrante_externo_pe')->sincronizar();
                                $this->dep('datos')->tabla('integrante_externo_pe')->resetear();
                                $this->s__mostrar_e = 0;
                            } else {
                                toba::notificacion()->agregar(utf8_decode('Función duplicada co-director debe ser unico.'), 'info');
                            }
                        }
                    } else {
                        toba::notificacion()->agregar(utf8_d_seguro('La fecha de inicio de vigencia dentro del proyecto es inferior a la fecha de inicio de proyecto'), 'info');
                    }
                } else {
                    toba::notificacion()->agregar(utf8_d_seguro('La fecha de fin de vigencia dentro del proyecto excede la fecha de fin de proyecto'), 'info');
                }
            } else {
                toba::notificacion()->agregar(utf8_d_seguro('La fecha de inicio dentro del proyecto no corresponde a una fecha validad (" fecha desde anterior a fecha actual ")'), 'info');
            }
        } else {
            toba::notificacion()->agregar(utf8_d_seguro('Las fechas de participación del integrantes estan incorrectas ("hasta es menor que desde")'), 'info');
        }
    }

    function evt__form_integrante_e__cancelar() {
        $this->s__mostrar_e = 0;
        $this->dep('datos')->tabla('integrante_externo_pe')->resetear();
    }

    //-------------------------------------------------------------------------------
    //------------------------- PANTALLA ORGANIZACIONES -----------------------------
    //-------------------------------------------------------------------------------

    function conf__pant_organizaciones(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_organizaciones";

        $this->pantalla()->tab("pant_alta_proyecto")->ocultar();
        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();

        $perfil = toba::manejador_sesiones()->get_perfiles_funcionales()[0];
        if ($perfil == formulador) {
            $this->pantalla()->tab("pant_seguimiento")->ocultar();
        }
        $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
        // si presiono el boton enviar no puede editar nada mas 
        if ($estado != 'FORM' && $estado != 'MODF') {
            $this->controlador()->evento('alta')->ocultar();
        }
        $this->s__imprimir = 0;
    }

    //-------------------------- CUADRO ORGANIZACIONES ------------------------------

    function conf__cuadro_organizaciones(toba_ei_cuadro $cuadro) {
        //$cuadro->desactivar_modo_clave_segura();
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $this->s__datos = $this->dep('datos')->tabla('organizaciones_participantes')->get_listado($pe['id_pext']);
        $cuadro->set_datos($this->s__datos);
    }

    function evt__cuadro_organizaciones__seleccion($datos) {

        $this->s__mostrar_org = 1;
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos['id_pext'] = $pe['id_pext'];

        $this->dep('datos')->tabla('organizaciones_participantes')->cargar($datos);
    }

    //-------------------------- FORMULARIO ORGANIZACIONES --------------------------

    function conf__form_organizacion(toba_ei_formulario $form) {

        // si presiono el boton alta entonces muestra el formulario para dar de alta un nuevo registro
        if ($this->s__mostrar_org == 1) {
            $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
            // si presiono el boton enviar no puede editar nada mas 
            if ($estado != 'FORM' && $estado != 'MODF') {
                $this->dep('form_organizacion')->set_solo_lectura();
                $this->dep('form_organizacion')->evento('modificacion')->ocultar();
                $this->dep('form_organizacion')->evento('baja')->ocultar();
                $this->dep('form_organizacion')->evento('cancelar')->ocultar();
            }
            $this->controlador()->evento('alta')->ocultar();
            $this->dep('form_organizacion')->descolapsar();
        } else {
            $this->dep('form_organizacion')->colapsar();
        }

        if ($this->dep('datos')->tabla('organizaciones_participantes')->esta_cargada()) {
            $datos = $this->dep('datos')->tabla('organizaciones_participantes')->get();
            $fp_imagen = $this->dep('datos')->tabla('organizaciones_participantes')->get_blob('aval');
            if (isset($fp_imagen)) {
                $temp_nombre = md5(uniqid(time())) . '.pdf';
                $temp_archivo = toba::proyecto()->get_www_temp($temp_nombre);
                $tamano = round(filesize($temp_archivo['path']) / 1024);
                $datos['aval'] = 'tamano: ' . $tamano . ' KB';
            } else {
                $datos['aval'] = null;
            }
        }
        $form->set_datos($datos);
    }

    function evt__form_organizacion__alta($datos) {
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos[id_pext] = $pe['id_pext'];

        $this->dep('datos')->tabla('organizaciones_participantes')->set($datos);

        //-----------aval-----------------------
        //si adjunto un pdf entonces "pdf" viene con los datos del archivo adjuntado
        if (is_array($datos['aval'])) {
            if ($datos['aval']['size'] > $this->tamano_byte) {
                toba::notificacion()->agregar(utf8_d_seguro('El tamaño del archivo debe ser menor a ') . $this->tamano_mega . 'MB', 'error');
                $fp = null;
            } else {
                $fp = fopen($datos['aval']['tmp_name'], 'rb');
                $this->dep('datos')->tabla('organizaciones_participantes')->set_blob(aval, $fp);
            }
        } else {
            $this->dep('datos')->tabla('organizaciones_participantes')->set_blob(aval, null);
        }
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

        if (is_array($datos['aval'])) {//si adjunto un pdf entonces "pdf" viene con los datos del archivo adjuntado
            if ($datos['aval']['size'] > 0) {
                if ($datos['aval']['size'] > $this->tamano_byte) {
                    toba::notificacion()->agregar(utf8_d_seguro('El tamaño del archivo debe ser menor a ') . $this->tamano_mega . 'MB', 'error');
                    $fp = null;
                } else {
                    $fp = fopen($datos['aval']['tmp_name'], 'rb');
                }
            } else {
                $fp = null;
            }
            $this->dep('datos')->tabla('organizaciones_participantes')->set_blob('aval', $fp);
            // fclose($fp); esto borra el archivo!!!!
        }
        $this->dep('datos')->tabla('organizaciones_participantes')->sincronizar();
        $this->dep('datos')->tabla('organizaciones_participantes')->resetear();
        $this->s__mostrar_org = 0;
    }

    function evt__form_organizacion__cancelar() {
        $this->s__mostrar_org = 0;
        $this->dep('datos')->tabla('organizaciones_participantes')->resetear();
    }

    //-------------------------------------------------------------------------------
    //------------------------- PANTALLA OBJETIVOS ESPECIFICOS ----------------------
    //-------------------------------------------------------------------------------

    function conf__pant_objetivos(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_objetivos";

        $this->pantalla()->tab("pant_alta_proyecto")->ocultar();
        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();

        $perfil = toba::manejador_sesiones()->get_perfiles_funcionales()[0];
        if ($perfil == formulador) {
            $this->pantalla()->tab("pant_seguimiento")->ocultar();
        }

        $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
        // si presiono el boton enviar no puede editar nada mas 
        if ($estado != 'FORM' && $estado != 'MODF') {
            $this->controlador()->evento('alta')->ocultar();
        }
    }

    //------------------------- CUADRO OBJETIVOS ESPECIFICOS ------------------------

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

    //------------------------- FORMULARIO OBJETIVO ESPECIFICO ----------------------

    function conf__form_objetivos_esp(toba_ei_formulario $form) {

        if ($this->s__mostrar_obj == 1) {
            $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
            // si presiono el boton enviar no puede editar nada mas 
            if ($estado != 'FORM' && $estado != 'MODF') {
                $this->dep('form_objetivos_esp')->set_solo_lectura();
                $this->dep('form_objetivos_esp')->evento('modificacion')->ocultar();
                $this->dep('form_objetivos_esp')->evento('baja')->ocultar();
                $this->dep('form_objetivos_esp')->evento('cancelar')->ocultar();
            }
            $this->controlador()->evento('alta')->ocultar();
            $this->dep('form_objetivos_esp')->descolapsar();
        } else {
            $this->dep('form_objetivos_esp')->colapsar();
        }

        if ($this->dep('datos')->tabla('objetivo_especifico')->esta_cargada()) {
            $datos = $this->dep('datos')->tabla('objetivo_especifico')->get();
            $form->set_datos($datos);
        }
    }

    function evt__form_objetivos_esp__alta($datos) {
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $obj_esp = $this->dep('datos')->tabla('objetivo_especifico')->get_listado($pe[id_pext]);

        $count = 0;
        $cant_obj = 0;
        foreach ($obj_esp as $value) {
            $count = $count + $value[ponderacion];
            $cant_obj++;
        }
        $count = $count + $datos[ponderacion];

        $datos[id_pext] = $pe['id_pext'];
        if ($cant_obj < 5) {
            if ($count <= 100) {
                $this->dep('datos')->tabla('objetivo_especifico')->set($datos);
                $this->dep('datos')->tabla('objetivo_especifico')->sincronizar();
                $this->dep('datos')->tabla('objetivo_especifico')->resetear();
                $this->s__mostrar_obj = 0;
            } else {
                toba::notificacion()->agregar(utf8_decode('Se supero el porcetaje de ponderación maximo disponible.'), 'info');
            }
        } else {
            toba::notificacion()->agregar(utf8_decode('Maximo de Objeticos Especificos superado ( Maximo 5 Objetivos Especificos ).'), 'info');
        }
    }

    function evt__form_objetivos_esp__baja() {
        $this->dep('datos')->tabla('objetivo_especifico')->eliminar_todo();
        $this->dep('datos')->tabla('objetivo_especifico')->resetear();
        toba::notificacion()->agregar(utf8_decode('El objetivo se ha eliminado correctamente.'), 'info');
        $this->s__mostrar_obj = 0;
    }

    function evt__form_objetivos_esp__modificacion($datos) {

        $pe = $this->dep('datos')->tabla('pextension')->get();
        $obj_esp = $this->dep('datos')->tabla('objetivo_especifico')->get_listado($pe[id_pext]);
        $obj_modif = $this->dep('datos')->tabla('objetivo_especifico')->get();
        $count = 0;
        foreach ($obj_esp as $value) {
            if ($obj_modif[id_objetivo] != $value[id_objetivo])
                $count = $count + $value[ponderacion];
        }
        $count = $count + $datos[ponderacion];

        if ($count <= 100) {
            $this->dep('datos')->tabla('objetivo_especifico')->set($datos);
            $this->dep('datos')->tabla('objetivo_especifico')->sincronizar();
            $this->s__mostrar_obj = 0;
        } else {
            toba::notificacion()->agregar(utf8_decode('Se supero el porcetaje de ponderación maximo disponible.'), 'info');
        }
    }

    function evt__form_objetivos_esp__cancelar() {
        $this->s__mostrar_obj = 0;
        $this->dep('datos')->tabla('objetivo_especifico')->resetear();
    }

    //-------------------------------------------------------------------------------
    //------------------------- PANTALLA PLAN ACTIVIDADES  --------------------------
    //-------------------------------------------------------------------------------

    function conf__pant_actividad(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_actividad";

        $this->pantalla()->tab("pant_alta_proyecto")->ocultar();
        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();

        $perfil = toba::manejador_sesiones()->get_perfiles_funcionales()[0];
        if ($perfil == formulador) {
            $this->pantalla()->tab("pant_seguimiento")->ocultar();
        }

        $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
        // si presiono el boton enviar no puede editar nada mas 
        if ($estado != 'FORM' && $estado != 'MODF') {
            $this->controlador()->evento('alta')->ocultar();
        }
    }

    //------------------------- CUADRO PLAN ACTIVIDADES -----------------------------

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

    //------------------------- FORMULARIO INFORMATICO OBJ --------------------------

    function conf__form_obj(toba_ei_formulario $form) {
        $obj_esp = $this->s__where;
        $datos = $this->dep('datos')->tabla('objetivo_especifico')->get_datos($obj_esp['id_objetivo'])[0];
        $form->ef('meta')->set_solo_lectura();
        $form->ef('descripcion')->set_solo_lectura();
        $form->set_datos($datos);
    }

    //------------------------- FORMULARIO PLAN ACTIVIDADES -------------------------

    function conf__form_actividad(toba_ei_formulario $form) {

        if ($this->s__mostrar_activ == 1) {
            $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
            // si presiono el boton enviar no puede editar nada mas 
            if ($estado != 'FORM' && $estado != 'MODF') {
                $this->dep('form_actividad')->set_solo_lectura();
                $this->dep('form_actividad')->evento('modificacion')->ocultar();
                $this->dep('form_actividad')->evento('baja')->ocultar();
                $this->dep('form_actividad')->evento('cancelar')->ocultar();
            }
            $this->controlador()->evento('alta')->ocultar();
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

    function evt__form_actividad__alta($datos) {

        $pe = $this->dep('datos')->tabla('pextension')->get();
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

    function evt__form_actividad__baja() {
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

    //-------------------------------------------------------------------------------
    //------------------------- PANTALLA PRESUPUESTO  -------------------------------
    //-------------------------------------------------------------------------------

    function conf__pant_presupuesto(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_presup";

        $this->pantalla()->tab("pant_alta_proyecto")->ocultar();
        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_integrantesi")->ocultar();
        $this->pantalla()->tab("pant_integrantese")->ocultar();
        $this->pantalla()->tab("pant_actividad")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_central")->ocultar();
        $this->pantalla()->tab("pant_seguimiento_ua")->ocultar();

        $perfil = toba::manejador_sesiones()->get_perfiles_funcionales()[0];
        if ($perfil == formulador) {
            $this->pantalla()->tab("pant_seguimiento")->ocultar();
        }
        $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
        // si presiono el boton enviar no puede editar nada mas 
        if ($estado != 'FORM' && $estado != 'MODF') {
            $this->controlador()->evento('alta')->ocultar();
        }
    }

    //------------------------- CUADRO PRESUPUESTO ----------------------------------

    function conf__cuadro_presup(toba_ei_cuadro $cuadro) {
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $cuadro->set_datos($this->dep('datos')->tabla('presupuesto_extension')->get_listado($pe['id_pext']));

        // MONTO DECLARADO 
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
        $presup = $this->dep('datos')->tabla('presupuesto_extension')->get_datos($datos['id_presupuesto'])[0];

        $this->dep('datos')->tabla('presupuesto_extension')->cargar($presup);
    }

    //------------------------- FORMULARIO PRESUPUESTO ------------------------------

    function conf__form_presupuesto(toba_ei_formulario $form) {

        if ($this->s__mostrar_presup == 1) {
            $estado = $this->dep('datos')->tabla('pextension')->get()[id_estado];
            // si presiono el boton enviar no puede editar nada mas 
            if ($estado != 'FORM' && $estado != 'MODF') {
                $this->dep('form_presupuesto')->set_solo_lectura();
                $this->dep('form_presupuesto')->evento('modificacion')->ocultar();
                $this->dep('form_presupuesto')->evento('baja')->ocultar();
                $this->dep('form_presupuesto')->evento('cancelar')->ocultar();
            }
            $this->controlador()->evento('alta')->ocultar();
            $this->dep('form_presupuesto')->descolapsar();
        } else {
            $this->dep('form_presupuesto')->colapsar();
        }

        if ($this->dep('datos')->tabla('presupuesto_extension')->esta_cargada()) {

            $datos = $this->dep('datos')->tabla('presupuesto_extension')->get();

            $form->set_datos($datos);
        }
    }

    function evt__form_presupuesto__alta($datos) {

        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos[id_pext] = $pe['id_pext'];

        $presupuesto = $this->dep('datos')->tabla('presupuesto_extension')->get_listado_rubro($datos[id_rubro_extension]);
        $count = 0;
        foreach ($presupuesto as $value) {
            $count = $count + $value[monto];
        }

        $bases = $this->dep('datos')->tabla('bases_convocatoria')->get_datos($pe[id_bases])[0];
        $monto_max = $bases[monto_max];
        $rubro = $this->dep('datos')->tabla('montos_convocatoria')->get_descripciones($datos[id_rubro_extension], $bases[id_bases])[0];
        if ($monto_max != 0) {
            if (($pe[monto] + $datos[monto]) <= $monto_max) {
                if ($datos[monto] + $count <= $rubro[monto_max]) {
                    $this->dep('datos')->tabla('presupuesto_extension')->set($datos);
                    $this->dep('datos')->tabla('presupuesto_extension')->sincronizar();
                    $this->dep('datos')->tabla('presupuesto_extension')->resetear();
                } else {
                    toba::notificacion()->agregar('Se supero el monto maximo para el rubro seleccionado', 'info');
                }
            } else {
                $monto_restante = $monto_max - $pe[monto];
                toba::notificacion()->agregar('Se supero el monto maximo de presupuesto , restantes: ' . $monto_restante, 'info');
            }
        } else {
            $this->dep('datos')->tabla('presupuesto_extension')->set($datos);
            $this->dep('datos')->tabla('presupuesto_extension')->sincronizar();
            $this->dep('datos')->tabla('presupuesto_extension')->resetear();
        }
        $this->s__mostrar_presup = 0;
    }

    function evt__form_presupuesto__baja() {
        $this->dep('datos')->tabla('presupuesto_extension')->eliminar_todo();
        $this->dep('datos')->tabla('presupuesto_extension')->resetear();
        toba::notificacion()->agregar('El presupuesto se ha eliminado correctamente.', 'info');
        $this->s__mostrar_presup = 0;
    }

    function evt__form_presupuesto__modificacion($datos) {

        $presuesto_datos_anterior = $this->dep('datos')->tabla('presupuesto_extension')->get();
        $pe = $this->dep('datos')->tabla('pextension')->get();
        $datos[id_pext] = $pe['id_pext'];

        $presupuesto = $this->dep('datos')->tabla('presupuesto_extension')->get_listado_rubro($datos[id_rubro_extension]);
        $count = 0;
        foreach ($presupuesto as $value) {
            $count = $count + $value[monto];
        }
        $count = $count + $datos[monto] - $presuesto_datos_anterior[monto];

        $bases = $this->dep('datos')->tabla('bases_convocatoria')->get_datos($pe[id_bases])[0];
        $monto_max = $bases[monto_max];
        $rubro = $this->dep('datos')->tabla('montos_convocatoria')->get_descripciones($datos[id_rubro_extension], $bases[id_bases])[0];
        if ($monto_max != 0) {
            if ((($pe[monto] - $presuesto_datos_anterior[monto]) + $datos[monto]) <= $monto_max) {
                if ($count <= $rubro[monto_max]) {
                    $this->dep('datos')->tabla('presupuesto_extension')->set($datos);
                    $this->dep('datos')->tabla('presupuesto_extension')->sincronizar();
                    $this->dep('datos')->tabla('presupuesto_extension')->resetear();
                } else {
                    toba::notificacion()->agregar('Se supero el monto maximo para el rubro seleccionado', 'info');
                }
            } else {
                $monto_restante = $monto_max - $pe[monto];
                toba::notificacion()->agregar('Se supero el monto maximo de presupuesto , restantes: ' . $monto_restante, 'info');
            }
        } else {
            $this->dep('datos')->tabla('presupuesto_extension')->set($datos);
            $this->dep('datos')->tabla('presupuesto_extension')->sincronizar();
            $this->dep('datos')->tabla('presupuesto_extension')->resetear();
        }
        $this->s__mostrar_presup = 0;
    }

    function evt__form_presupuesto__cancelar() {
        $this->s__mostrar_presup = 0;
        $this->dep('datos')->tabla('presupuesto_extension')->resetear();
    }

}

?>
