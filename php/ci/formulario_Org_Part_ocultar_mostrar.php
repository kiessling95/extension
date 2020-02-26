<?php

    class formulario_Org_Part_ocultar_mostrar extends toba_ei_formulario
    {
        function extender_objeto_js()
	{
		$id_js = toba::escaper()->escapeJs($this->objeto_js);
                
                echo "
		
		{$id_js}.evt__id_tipo_organizacion__procesar = function(es_inicial) 
                    {
                    
			if(this.ef('id_tipo_organizacion').get_estado() == 8) 
                        {
                            this.ef('otra_descripcion').mostrar();
                        }
                        else
                        {
                            this.ef('otra_descripcion').ocultar();
                        }
                    }
                
                
                ";
                
        }
    }

?>