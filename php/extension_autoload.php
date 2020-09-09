<?php
/**
 * Esta clase fue y ser� generada autom�ticamente. NO EDITAR A MANO.
 * @ignore
 */
class extension_autoload 
{
	static function existe_clase($nombre)
	{
		return isset(self::$clases[$nombre]);
	}

	static function cargar($nombre)
	{
		if (self::existe_clase($nombre)) { 
			 require_once(dirname(__FILE__) .'/'. self::$clases[$nombre]); 
		}
	}

	static protected $clases = array(
        'abm_ci' => 'extension_toba/componentes/abm_ci.php',
		'extension_ci' => 'extension_toba/componentes/extension_ci.php',
		'extension_cn' => 'extension_toba/componentes/extension_cn.php',
		'extension_datos_relacion' => 'extension_toba/componentes/extension_datos_relacion.php',
		'extension_datos_tabla' => 'extension_toba/componentes/extension_datos_tabla.php',
		'extension_ei_arbol' => 'extension_toba/componentes/extension_ei_arbol.php',
		'extension_ei_archivos' => 'extension_toba/componentes/extension_ei_archivos.php',
		'extension_ei_calendario' => 'extension_toba/componentes/extension_ei_calendario.php',
		'extension_ei_codigo' => 'extension_toba/componentes/extension_ei_codigo.php',
		'extension_ei_cuadro' => 'extension_toba/componentes/extension_ei_cuadro.php',
		'extension_ei_esquema' => 'extension_toba/componentes/extension_ei_esquema.php',
		'extension_ei_filtro' => 'extension_toba/componentes/extension_ei_filtro.php',
		'extension_ei_firma' => 'extension_toba/componentes/extension_ei_firma.php',
		'extension_ei_formulario' => 'extension_toba/componentes/extension_ei_formulario.php',
		'extension_ei_formulario_ml' => 'extension_toba/componentes/extension_ei_formulario_ml.php',
		'extension_ei_grafico' => 'extension_toba/componentes/extension_ei_grafico.php',
		'extension_ei_mapa' => 'extension_toba/componentes/extension_ei_mapa.php',
		'extension_servicio_web' => 'extension_toba/componentes/extension_servicio_web.php',
		'extension_comando' => 'extension_toba/extension_comando.php',
		'extension_modelo' => 'extension_toba/extension_modelo.php',
	);
}