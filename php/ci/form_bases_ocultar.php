<?php

    class form_bases_ocultar extends toba_ei_formulario
    {
        function extender_objeto_js()
	{
		$id_js = toba::escaper()->escapeJs($this->objeto_js);
                
                echo "
		
		{$id_js}.evt__tiene_monto__procesar = function(es_inicial) 
                    {
                    
			if(this.ef('tiene_monto').chequeado())
                        {
                            this.ef('monto_max').mostrar();
                        }
                        else
                        {
                            this.ef('monto_max').ocultar();
                        }
                    }
                
                
                ";
                
        }
    }

?>