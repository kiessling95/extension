<?php

    class formulario_ocultar_mostrar extends toba_ei_formulario
    {
        function extender_objeto_js()
	{
		$id_js = toba::escaper()->escapeJs($this->objeto_js);
                
                echo "
		
		{$id_js}.evt__informe_avance__procesar = function(es_inicial) 
                    {
			switch (this.ef('informe_avance').get_estado()) {
					case 'Presento':
						this.ef('fecha_inf_avance').mostrar();
                                                this.ef('estado_informe_a').mostrar();
                                                
						break;
					case 'No Presento':
						this.ef('fecha_inf_avance').ocultar();
                                                this.ef('estado_informe_a').ocultar();
                                                
						break;
					default:
						this.ef('fecha_inf_avance').ocultar();
                                                this.ef('estado_informe_a').ocultar();
                                                
						break;					
				}
                    }
                
                {$id_js}.evt__estado_informe_a__procesar = function(es_inicial) 
		{
                    switch (this.ef('estado_informe_a').get_estado()) {
                                    case 'A':
                                            this.ef('fecha_evaluacion_avance').mostrar();
                                            this.ef('observacion_avance').mostrar();
                                                this.ef('num_acta_avance').mostrar();
                                            break;
                                    case 'D':
                                            this.ef('fecha_evaluacion_avance').ocultar();
                                            this.ef('observacion_avance').mostrar();
                                            this.ef('num_acta_avance').mostrar();
                                            break;
                                    default:
                                            this.ef('fecha_evaluacion_avance').ocultar();
                                            this.ef('observacion_avance').ocultar();
                                            this.ef('num_acta_avance').ocultar();
                                           break;
                    }
		}
                
                {$id_js}.evt__informe_final__procesar = function(es_inicial) 
                    {
			switch (this.ef('informe_final').get_estado()) {
					case 'Presento':
						this.ef('fecha_inf_final').mostrar();
                                                this.ef('estado_informe_f').mostrar();
						break;
					case 'No Presento':
						this.ef('fecha_inf_final').ocultar();
                                                this.ef('estado_informe_f').ocultar();
						break;
					default:
						this.ef('fecha_inf_final').ocultar();
                                                this.ef('estado_informe_f').ocultar();
						break;					
				}
                    }
                
                {$id_js}.evt__estado_informe_f__procesar = function(es_inicial) 
		{
                    switch (this.ef('estado_informe_f').get_estado()) {
                                    case 'A':
                                            this.ef('fecha_evaluacion_final').mostrar();
                                            this.ef('observacion_final').mostrar();
                                            this.ef('num_acta_final').mostrar();
                                            break;
                                    case 'D':
                                            this.ef('fecha_evaluacion_final').ocultar();
                                            this.ef('observacion_final').mostrar();
                                            this.ef('num_acta_final').mostrar();
                                            break;
                                    default:
                                            this.ef('fecha_evaluacion_final').ocultar();
                                            this.ef('observacion_final').ocultar();
                                            this.ef('num_acta_final').ocultar();
                                           break;
                    }
		}
                
                {$id_js}.evt__rendicion__procesar = function(es_inicial) 
                {
			switch (this.ef('rendicion').get_estado()) {
					case 'Presento':
						this.ef('fecha_rendicion').mostrar();
                                                this.ef('resolucion_pago').mostrar();
                                                this.ef('rendicion_monto').mostrar();
                                                this.ef('estado_rendicion').mostrar();
                                                
						break;
					case 'No Presento':
						this.ef('fecha_rendicion').ocultar();
                                                this.ef('resolucion_pago').ocultar();
                                                this.ef('rendicion_monto').ocultar();
                                                this.ef('estado_rendicion').ocultar();
                                                
						break;
					default:
						this.ef('fecha_rendicion').ocultar();
                                                this.ef('resolucion_pago').ocultar();
                                                this.ef('rendicion_monto').ocultar();
                                                this.ef('estado_rendicion').ocultar();
                                                
						break;					
                        }
                }
                    
                {$id_js}.evt__estado_rendicion__procesar = function(es_inicial) 
		{
                    switch (this.ef('estado_rendicion').get_estado()) {
                                    case 'A':
                                            this.ef('dictamen').mostrar();
                                            this.ef('num_acta').mostrar();
                                            break;
                                    case 'D':
                                            this.ef('dictamen').mostrar();
                                            this.ef('num_acta').mostrar();
                                            break;
                                    default:
                                            this.ef('dictamen').ocultar();
                                            this.ef('num_acta').ocultar();
                                           break;
                    }
		}
                
                ";
        }
    }

?>