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
                    if(vista=='pdf_bases'){
                        this.controlador.ajax('descargar_bases',id_vinculo,this,this.retorno);
                    }
                    if(vista=='pdf_completo'){
                        this.controlador.ajax('descargar_pext_completo',id_vinculo,this,this.retorno);
                    }else{
                        if(vista=='pdf_resumen'){
                            this.controlador.ajax('descargar_pext_resumen',id_vinculo,this,this.retorno);
                        }
                    }
                    
                    return false;
		}
		 {$this->objeto_js}.retorno = function(datos)
		{
                 if(datos==-1){alert('No tiene un aval adjunto');
                   }else{vinculador.invocar(datos);}
		}
		";
    }

}

?>