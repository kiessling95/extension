<?php

    class form_principal_ocultar extends toba_ei_formulario
    {
        function extender_objeto_js()
	{
		$id_js = toba::escaper()->escapeJs($this->objeto_js);
                
                echo "
		
		{$id_js}.evt__es_multi__procesar = function(es_inicial) 
                    {
                    
			if(this.ef('es_multi').chequeado())
                        {
                            this.ef('multi_uni').mostrar();
                        }
                        else
                        {
                            this.ef('multi_uni').ocultar();
                        }
                    }
                
                
                ";
                
        }
    }

?>
