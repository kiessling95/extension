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
                                                this.ef('fecha_inf_avance').set_obligatorio(true);
                                                this.ef('estado_informe_a').mostrar();
                                                
						break;
					case 'No Presento':
						this.ef('fecha_inf_avance').ocultar();
                                                this.ef('fecha_inf_avance').set_obligatorio(false);
                                                this.ef('estado_informe_a').ocultar();
                                                
						break;
					default:
						this.ef('fecha_inf_avance').ocultar();
                                                this.ef('fecha_inf_avance').set_obligatorio(false);
                                                this.ef('estado_informe_a').ocultar();
                                                
						break;					
				}
                    }
                
                {$id_js}.evt__estado_informe_a__procesar = function(es_inicial) 
		{
                    switch (this.ef('estado_informe_a').get_estado()) {
                                    case 'A':
                                            this.ef('fecha_evaluacion_avance').mostrar();
                                            this.ef('fecha_evaluacion_avance').set_obligatorio(true);
                                            this.ef('observacion_avance').mostrar();
                                            this.ef('num_acta_avance').mostrar();
                                            break;
                                    case 'D':
                                            this.ef('fecha_evaluacion_avance').ocultar();
                                            this.ef('fecha_evaluacion_avance').set_obligatorio(false);
                                            this.ef('observacion_avance').mostrar();
                                            this.ef('num_acta_avance').mostrar();
                                            break;
                                    default:
                                            this.ef('fecha_evaluacion_avance').ocultar();
                                            this.ef('fecha_evaluacion_avance').set_obligatorio(false);
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
                                                this.ef('fecha_inf_final').set_obligatorio(true);
                                                this.ef('estado_informe_f').mostrar();
						break;
					case 'No Presento':
						this.ef('fecha_inf_final').ocultar();
                                                this.ef('fecha_inf_final').set_obligatorio(false);
                                                this.ef('estado_informe_f').ocultar();
						break;
					default:
						this.ef('fecha_inf_final').ocultar();
                                                this.ef('fecha_inf_final').set_obligatorio(false);
                                                this.ef('estado_informe_f').ocultar();
						break;					
				}
                    }
                
                {$id_js}.evt__estado_informe_f__procesar = function(es_inicial) 
		{
                    switch (this.ef('estado_informe_f').get_estado()) {
                                    case 'A':
                                            this.ef('fecha_evaluacion_final').mostrar();
                                            this.ef('fecha_evaluacion_final').set_obligatorio(true);
                                            this.ef('observacion_final').mostrar();
                                            this.ef('num_acta_final').mostrar();
                                            break;
                                    case 'D':
                                            this.ef('fecha_evaluacion_final').ocultar();
                                            this.ef('fecha_evaluacion_final').set_obligatorio(false);
                                            this.ef('observacion_final').mostrar();
                                            this.ef('num_acta_final').mostrar();
                                            break;
                                    default:
                                            this.ef('fecha_evaluacion_final').ocultar();
                                            this.ef('fecha_evaluacion_final').set_obligatorio(false);
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
                                                this.ef('fecha_rendicion').set_obligatorio(true);
                                                this.ef('resolucion_pago').mostrar();
                                                this.ef('rendicion_monto').mostrar();
                                                this.ef('estado_rendicion').mostrar();
                                                
						break;
					case 'No Presento':
						this.ef('fecha_rendicion').ocultar();
                                                this.ef('fecha_rendicion').set_obligatorio(false);
                                                this.ef('resolucion_pago').ocultar();
                                                this.ef('rendicion_monto').ocultar();
                                                this.ef('estado_rendicion').ocultar();
                                                
						break;
					default:
						this.ef('fecha_rendicion').ocultar();
                                                this.ef('fecha_rendicion').set_obligatorio(false);
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
                
                {$id_js}.evt__prorrogar__procesar = function(es_inicial)
                {
                    if(this.ef('prorrogar').chequeado())
                    {
                        this.ef('fecha_prorroga1').mostrar();
                        this.ef('estado_prorroga').mostrar();
                    }
                    else
                    {
                        this.ef('fecha_prorroga1').ocultar();
                        this.ef('estado_prorroga').ocultar();
                    }
                }
                
                {$id_js}.evt__estado_prorroga__procesar = function(es_inicial) 
		{
                    switch (this.ef('estado_prorroga').get_estado()) {
                                    case 'A':
                                            this.ef('num_acta_prorroga').mostrar();
                                            this.ef('fecha_prorroga2').mostrar();
                                            this.ef('observacion_prorroga').mostrar();
                                            break;
                                    case 'D':
                                            this.ef('num_acta_prorroga').mostrar();
                                            this.ef('fecha_prorroga2').ocultar();
                                            this.ef('observacion_prorroga').mostrar();
                                            break;
                                    default:
                                            this.ef('num_acta_prorroga').ocultar();
                                            this.ef('fecha_prorroga2').ocultar();
                                            this.ef('observacion_prorroga').ocultar();
                                           break;
                    }
		}
                
                {$id_js}.evt__informe_becario__procesar = function(es_inicial) 
                    {
			switch (this.ef('informe_becario').get_estado()) {
                        
					case 'Presento':
						this.ef('fecha_informe_becario').mostrar();
                                                this.ef('estado_becario').mostrar();
						break;
                                        case 'No Presento':
                                                this.ef('fecha_informe_becario').ocultar();
                                                this.ef('estado_becario').ocultar();
                                                break;
					default:
						this.ef('fecha_informe_becario').ocultar();
                                                this.ef('estado_becario').ocultar();
						break;					
				}
                    }
                    
                    {$id_js}.evt__estado_becario__procesar = function(es_inicial) 
                    {
			switch (this.ef('estado_becario').get_estado()) {
                        
					case 'A':
                                                this.ef('nro_acta_informe_becario').mostrar();
						break;
                                        case 'D':
                                                this.ef('nro_acta_informe_becario').mostrar();
                                                break;
					default:
                                                this.ef('nro_acta_informe_becario').ocultar();
						break;					
				}
                    }
                

                    {$id_js}.evt__nombre_becario__procesar = function(es_inicial) 
                    {
                        if(this.ef('nombre_becario').tiene_estado())
                        {
                            this.ef('res_desig').mostrar();
                            this.ef('nro_expediente_pago').mostrar();
                            this.ef('informe_becario').mostrar();
                            this.ef('nombre_becario').mostrar();
                            this.ef('dni_becario').mostrar();
                        }
                        else
                        {
                            this.ef('res_desig').ocultar();
                            this.ef('nro_expediente_pago').ocultar();
                            this.ef('informe_becario').ocultar();
                            this.ef('nombre_becario').ocultar();
                            this.ef('dni_becario').ocultar();
                        }
                    }
                    
                    {$id_js}.evt__id_estado__procesar = function(es_inicial) 
                    {
                        switch (this.ef('id_estado').get_estado()) {
                        
					case 'ECEN':
                                                this.ef('id_estado').mostrar();
						break;
                                        case 'APRB':
                                                this.ef('id_estado').mostrar();
						break;
                                        case 'DES ':
                                                this.ef('id_estado').mostrar();
						break;
                                        case 'EUA ':
                                                this.ef('id_estado').mostrar();
						break;
					default:
                                                this.ef('id_estado').ocultar();
						break;					
				}
                    }
                ";
        }
    }

?>