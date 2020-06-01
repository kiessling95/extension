<?php

    class form_solictud_ocultar extends toba_ei_formulario
    {
        function extender_objeto_js()
	{
		$id_js = toba::escaper()->escapeJs($this->objeto_js);
                
                echo "
		
		{$id_js}.evt__estado_solicitud__procesar = function(es_inicial) 
                    {
                    
                        switch (this.ef('estado_solicitud').get_estado()) {
                                case 'Abierto':
                                    this.ef('resolucion').mostrar();
                                    this.ef('observacion').mostrar();
                                    break;
                                case 'Cerrado':
                                    this.ef('').mostrar();
                                    this.ef('').mostrar();
                                    break;
                                
                        }
	
                    }
                
                
                ";
                
        }
    }

?>