<?php

class cuadro_descargar extends extension_ei_cuadro {

    function extender_objeto_js() {

        echo "
		//---- Eventos ---------------------------------------------
		
		
		
		{$this->objeto_js}.invocar_vinculo = function(vista, id_vinculo)
		{
                    if(vista=='pdf_aval'){
                            this.controlador.ajax('cargar_aval',id_vinculo,this,this.retorno);
                        }
                    
                    return false;
		}
		 {$this->objeto_js}.retorno = function(datos)
		{
                 if(datos==-1){alert('No tiene un acta adjunto');
                   }else{vinculador.invocar(datos);}
		}
		{$this->objeto_js}.retorno_r = function(datos)
		{
                 if(datos==-1){alert('No tiene adjunto en la resol');
                   }else{vinculador.invocar(datos);}
		}
		";
    }

}

?>