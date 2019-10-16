<?php
class form_ocultar_mostrar extends extension_ei_formulario
{
    function extender_objeto_js()
    {
        echo "
			{$this->objeto_js}.evt__efecto__procesar = function(es_inicial) 
			{
				if (! es_inicial) {
					this.evt__id_rubro_extension__procesar(es_inicial);
				}
			}
                        {$this->objeto_js}.evt__id_rubro_extension__procesar = function(es_inicial) 
			{
				
						this.mostrar_bloque_A(true);
                                                				
				}
			}
                        {$this->objeto_js}.mostrar_bloque_A = function(visible)
			{
				this.ef('id_rubro_extension').mostrar(visible);
			}
			
			
			
                        ";
    }
}

?>
