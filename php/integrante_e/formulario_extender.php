<?php

class formulario_extender extends toba_ei_formulario
    {
        function extender_objeto_js()
	{
		$id_js = toba::escaper()->escapeJs($this->objeto_js);
                echo "
		
		{$id_js}.evt__funcion_p__procesar = function(es_inicial) 
                    {
			switch (this.ef('funcion_p').get_estado()) {
                        
					case 'B    ':
						this.ef('res_desig').mostrar();
                                                this.ef('nro_expediente_pago').mostrar();
                                                this.ef('informe_becario').mostrar();
						break;
					default:
						this.ef('res_desig').ocultar();
                                                this.ef('nro_expediente_pago').ocultar();
                                                this.ef('informe_becario').ocultar();
						break;					
				}
                    }
                    
                {$id_js}.evt__informe_becario__procesar = function(es_inicial) 
                    {
			switch (this.ef('informe_becario').get_estado()) {
                        
					case 'Presento':
						this.ef('fecha_informe_becario').mostrar();
                                                this.ef('nro_acta_informe_becario').mostrar();
                                                this.ef('estado_becario').mostrar();
						break;
                                        case 'No Presento':
                                                this.ef('fecha_informe_becario').mostrar();
                                                this.ef('nro_acta_informe_becario').mostrar();
                                                this.ef('estado_becario').ocultar();
                                                break;
					default:
						this.ef('fecha_informe_becario').ocultar();
                                                this.ef('nro_acta_informe_becario').ocultar();
                                                this.ef('estado_becario').ocultar();
						break;					
				}
                    }
                    ";
        }
    }