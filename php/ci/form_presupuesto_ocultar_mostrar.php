<?php

    class form_presupuesto_ocultar_mostrar extends toba_ei_formulario
    {
        function extender_objeto_js()
	{
		$id_js = toba::escaper()->escapeJs($this->objeto_js);
                
                echo "
		
		{$id_js}.evt__monto_max__procesar = function(es_inicial) 
                    {
                    
			if(this.ef('monto_max').get_estado()== 9999)
                        {
                            this.ef('monto_max').ocultar();
                        }
                    }
                
                
                ";
                
        }
    }

?>