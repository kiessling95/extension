<?php

class ci_bases extends abm_ci {

    protected $nombre_tabla = 'bases_convocatoria';

    function vista_pdf(toba_vista_pdf $salida) {
        if ($this->dep('datos')->tabla('bases_convocatoria')->esta_cargada()) {
            $bases = $this->dep('datos')->tabla('bases_convocatoria')->get();
            //print_r($bases);
            //exit();
            $dato = array();
            //configuramos el nombre que tendrá el archivo pdf
            $salida->set_nombre_archivo("Bases_Convocatoria.pdf");

            //recuperamos el objteo ezPDF para agregar la cabecera y el pie de página 
            $salida->set_papel_orientacion('portrait'); //landscape
            $salida->set_papel_tamanio('A4');
            $salida->inicializar();

            $pdf = $salida->get_pdf();
            //terc izquierda 
            $pdf->ezSetCmMargins(1.80, 1.10, 1.60, 1.60);

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