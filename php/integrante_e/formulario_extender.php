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
						break;
					default:
						this.ef('res_desig').ocultar();
						break;					
				}
                    }
                    ";
        }
    }