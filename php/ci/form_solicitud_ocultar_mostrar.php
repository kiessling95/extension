<?php

    class form_solicitud_ocultar_mostrar extends toba_ei_formulario
    {
        function extender_objeto_js()
	{
		$id_js = toba::escaper()->escapeJs($this->objeto_js);
                
                echo "
                    
                {$id_js}.evt__tipo_solicitud__procesar = function(es_inicial) 
                {
                    this.ef('cambio_integrante').ocultar();
                    this.ef('cambio_proyecto').ocultar();
                    
                    switch (this.ef('tipo_solicitud').get_estado()) {
                        case 'INTEGRANTE':
                            this.ef('cambio_integrante').mostrar();
                            break;
                        case 'PROYECTO':
                            this.ef('cambio_proyecto').mostrar();
                            break;
                        default:
                            break;
                    }
                }
		
		{$id_js}.evt__recibido__procesar = function(es_inicial) 
                {

                    if(this.ef('recibido').chequeado())
                    {
                        this.ef('fecha_solicitud').mostrar();
                        this.ef('fecha_recepcion').mostrar();
                        this.ef('estado_solicitud').mostrar();
                        this.ef('descrip_ua').mostrar();
                    }
                    else
                    {
                        this.ef('descrip_ua').ocultar();
                        this.ef('fecha_solicitud').ocultar();
                        this.ef('fecha_recepcion').ocultar();
                        this.ef('estado_solicitud').ocultar();
                    }
                }
                
                
                    
                {$id_js}.evt__estado_solicitud__procesar = function(es_inicial) 
                {
                    switch (this.ef('estado_solicitud').get_estado()) {
                                    case 'Aceptada':
                                            this.ef('nro_acta').mostrar();
                                            this.ef('fecha_dictamen').mostrar();
                                            this.ef('obs_resolucion').mostrar();
                                            this.ef('fecha_fin_prorroga').ocultar();

                                            switch (this.ef('cambio_proyecto').get_estado()) {
                                                    case 'BAJA':
                                                        this.ef('id_estado').mostrar();
                                                    break;

                                                    case 'PRORROGA': 
                                                            this.ef('fecha_fin_prorroga').mostrar();
                                                            this.ef('id_estado').mostrar();
                                                    break;

                                                    case 'FINALIZACIÓN':
                                                        this.ef('id_estado').mostrar();
                                                    break;

                                                    default:
                                                        this.ef('id_estado').ocultar();
                                                    break;
                                            }
                                            break;
                                    case 'Rechazada':
                                            this.ef('nro_acta').mostrar(); 
                                            this.ef('fecha_dictamen').mostrar();
                                            this.ef('obs_resolucion').mostrar();

                                            this.ef('fecha_fin_prorroga').ocultar();
                                            this.ef('id_estado').ocultar();
                                            break;
                                    case 'Enviada':
                                            this.ef('nro_acta').ocultar();
                                            this.ef('fecha_fin_prorroga').ocultar();
                                            this.ef('obs_resolucion').ocultar();
                                            this.ef('id_estado').ocultar();
                                            this.ef('fecha_dictamen').ocultar();
                                            break;
                                    case 'Recibida':
                                            this.ef('nro_acta').ocultar();
                                            this.ef('fecha_fin_prorroga').ocultar();
                                            this.ef('obs_resolucion').ocultar();
                                            this.ef('id_estado').ocultar();
                                            this.ef('fecha_dictamen').ocultar();
                                            break;
                                    default:
                                            this.ef('recibido').ocultar();
                                            this.ef('descrip_ua').ocultar();
                                            this.ef('nro_acta').ocultar();
                                            this.ef('fecha_fin_prorroga').ocultar();
                                            this.ef('obs_resolucion').ocultar();
                                            this.ef('id_estado').ocultar();
                                            this.ef('fecha_dictamen').ocultar();
                                           break;
                    }
                }
                
                
                ";
                
        }
    }

?>
