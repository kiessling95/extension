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
						break;
					case 'No Presento':
						this.ef('fecha_inf_avance').ocultar();
						break;
					default:
						this.ef('fecha_inf_avance').ocultar();
						break;					
				}
                    }
                
                {$id_js}.evt__estado_informe_a__procesar = function(es_inicial) 
		{
                    switch (this.ef('estado_informe_a').get_estado()) {
                                    case 'A':
                                            this.ef('fecha_evaluacion_avance').mostrar();
                                            break;
                                    case 'D':
                                            this.ef('fecha_evaluacion_avance').ocultar();
                                            break;
                                    default:
                                            this.ef('fecha_evaluacion_avance').ocultar();
                                           break;
                    }
		}
                
                {$id_js}.evt__informe_final__procesar = function(es_inicial) 
                    {
			switch (this.ef('informe_final').get_estado()) {
					case 'Presento':
						this.ef('fecha_inf_final').mostrar();
						break;
					case 'No Presento':
						this.ef('fecha_inf_final').ocultar();
						break;
					default:
						this.ef('fecha_inf_final').ocultar();
						break;					
				}
                    }
                
                {$id_js}.evt__estado_informe_f__procesar = function(es_inicial) 
		{
                    switch (this.ef('estado_informe_f').get_estado()) {
                                    case 'A':
                                            this.ef('fecha_evaluacion_final').mostrar();
                                            break;
                                    case 'D':
                                            this.ef('fecha_evaluacion_final').ocultar();
                                            break;
                                    default:
                                            this.ef('fecha_evaluacion_final').ocultar();
                                           break;
                    }
		}
                
                ";
        }
    }

?>