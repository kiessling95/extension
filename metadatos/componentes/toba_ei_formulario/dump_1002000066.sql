------------------------------------------------------------
--[1002000066]--  Proyectos Extension - CI - formulario_seg_ua 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 1002
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, punto_montaje, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'extension', --proyecto
	'1002000066', --objeto
	NULL, --anterior
	NULL, --identificador
	NULL, --reflexivo
	'toba', --clase_proyecto
	'toba_ei_formulario', --clase
	'1001000004', --punto_montaje
	NULL, --subclase
	NULL, --subclase_archivo
	NULL, --objeto_categoria_proyecto
	NULL, --objeto_categoria
	'Proyectos Extension - CI - formulario_seg_ua', --nombre
	NULL, --titulo
	'0', --colapsable
	NULL, --descripcion
	'extension', --fuente_datos_proyecto
	'designa', --fuente_datos
	NULL, --solicitud_registrar
	NULL, --solicitud_obj_obs_tipo
	NULL, --solicitud_obj_observacion
	NULL, --parametro_a
	NULL, --parametro_b
	NULL, --parametro_c
	NULL, --parametro_d
	NULL, --parametro_e
	NULL, --parametro_f
	NULL, --usuario
	'2019-12-11 14:47:39', --creacion
	'abajo'  --posicion_botonera
);
--- FIN Grupo de desarrollo 1002

------------------------------------------------------------
-- apex_objeto_eventos
------------------------------------------------------------

--- INICIO Grupo de desarrollo 1002
INSERT INTO apex_objeto_eventos (proyecto, evento_id, objeto, identificador, etiqueta, maneja_datos, sobre_fila, confirmacion, estilo, imagen_recurso_origen, imagen, en_botonera, ayuda, orden, ci_predep, implicito, defecto, display_datos_cargados, grupo, accion, accion_imphtml_debug, accion_vinculo_carpeta, accion_vinculo_item, accion_vinculo_objeto, accion_vinculo_popup, accion_vinculo_popup_param, accion_vinculo_target, accion_vinculo_celda, accion_vinculo_servicio, es_seleccion_multiple, es_autovinculo) VALUES (
	'extension', --proyecto
	'1002000064', --evento_id
	'1002000066', --objeto
	'alta', --identificador
	'&Guardar', --etiqueta
	'1', --maneja_datos
	NULL, --sobre_fila
	NULL, --confirmacion
	'ei-boton-alta', --estilo
	'apex', --imagen_recurso_origen
	'guardar.gif', --imagen
	'1', --en_botonera
	NULL, --ayuda
	'1', --orden
	NULL, --ci_predep
	'0', --implicito
	'1', --defecto
	NULL, --display_datos_cargados
	'no_cargado', --grupo
	NULL, --accion
	NULL, --accion_imphtml_debug
	NULL, --accion_vinculo_carpeta
	NULL, --accion_vinculo_item
	NULL, --accion_vinculo_objeto
	NULL, --accion_vinculo_popup
	NULL, --accion_vinculo_popup_param
	NULL, --accion_vinculo_target
	NULL, --accion_vinculo_celda
	NULL, --accion_vinculo_servicio
	'0', --es_seleccion_multiple
	'0'  --es_autovinculo
);
INSERT INTO apex_objeto_eventos (proyecto, evento_id, objeto, identificador, etiqueta, maneja_datos, sobre_fila, confirmacion, estilo, imagen_recurso_origen, imagen, en_botonera, ayuda, orden, ci_predep, implicito, defecto, display_datos_cargados, grupo, accion, accion_imphtml_debug, accion_vinculo_carpeta, accion_vinculo_item, accion_vinculo_objeto, accion_vinculo_popup, accion_vinculo_popup_param, accion_vinculo_target, accion_vinculo_celda, accion_vinculo_servicio, es_seleccion_multiple, es_autovinculo) VALUES (
	'extension', --proyecto
	'1002000065', --evento_id
	'1002000066', --objeto
	'baja', --identificador
	'&Eliminar', --etiqueta
	'0', --maneja_datos
	NULL, --sobre_fila
	'¿Desea ELIMINAR el registro?', --confirmacion
	'ei-boton-baja', --estilo
	'apex', --imagen_recurso_origen
	'borrar.gif', --imagen
	'1', --en_botonera
	NULL, --ayuda
	'2', --orden
	NULL, --ci_predep
	'0', --implicito
	'0', --defecto
	NULL, --display_datos_cargados
	'cargado', --grupo
	NULL, --accion
	NULL, --accion_imphtml_debug
	NULL, --accion_vinculo_carpeta
	NULL, --accion_vinculo_item
	NULL, --accion_vinculo_objeto
	NULL, --accion_vinculo_popup
	NULL, --accion_vinculo_popup_param
	NULL, --accion_vinculo_target
	NULL, --accion_vinculo_celda
	NULL, --accion_vinculo_servicio
	'0', --es_seleccion_multiple
	'0'  --es_autovinculo
);
INSERT INTO apex_objeto_eventos (proyecto, evento_id, objeto, identificador, etiqueta, maneja_datos, sobre_fila, confirmacion, estilo, imagen_recurso_origen, imagen, en_botonera, ayuda, orden, ci_predep, implicito, defecto, display_datos_cargados, grupo, accion, accion_imphtml_debug, accion_vinculo_carpeta, accion_vinculo_item, accion_vinculo_objeto, accion_vinculo_popup, accion_vinculo_popup_param, accion_vinculo_target, accion_vinculo_celda, accion_vinculo_servicio, es_seleccion_multiple, es_autovinculo) VALUES (
	'extension', --proyecto
	'1002000066', --evento_id
	'1002000066', --objeto
	'modificacion', --identificador
	'&Guardar Cambios', --etiqueta
	'1', --maneja_datos
	NULL, --sobre_fila
	NULL, --confirmacion
	'ei-boton-mod', --estilo
	'apex', --imagen_recurso_origen
	'editar.gif', --imagen
	'1', --en_botonera
	NULL, --ayuda
	'3', --orden
	NULL, --ci_predep
	'0', --implicito
	'1', --defecto
	NULL, --display_datos_cargados
	'cargado', --grupo
	NULL, --accion
	NULL, --accion_imphtml_debug
	NULL, --accion_vinculo_carpeta
	NULL, --accion_vinculo_item
	NULL, --accion_vinculo_objeto
	NULL, --accion_vinculo_popup
	NULL, --accion_vinculo_popup_param
	NULL, --accion_vinculo_target
	NULL, --accion_vinculo_celda
	NULL, --accion_vinculo_servicio
	'0', --es_seleccion_multiple
	'0'  --es_autovinculo
);
INSERT INTO apex_objeto_eventos (proyecto, evento_id, objeto, identificador, etiqueta, maneja_datos, sobre_fila, confirmacion, estilo, imagen_recurso_origen, imagen, en_botonera, ayuda, orden, ci_predep, implicito, defecto, display_datos_cargados, grupo, accion, accion_imphtml_debug, accion_vinculo_carpeta, accion_vinculo_item, accion_vinculo_objeto, accion_vinculo_popup, accion_vinculo_popup_param, accion_vinculo_target, accion_vinculo_celda, accion_vinculo_servicio, es_seleccion_multiple, es_autovinculo) VALUES (
	'extension', --proyecto
	'1002000067', --evento_id
	'1002000066', --objeto
	'cancelar', --identificador
	'Ca&ncelar', --etiqueta
	'1', --maneja_datos
	NULL, --sobre_fila
	NULL, --confirmacion
	'ei-boton-canc', --estilo
	'apex', --imagen_recurso_origen
	'volver.png', --imagen
	'1', --en_botonera
	NULL, --ayuda
	'4', --orden
	NULL, --ci_predep
	'0', --implicito
	'1', --defecto
	NULL, --display_datos_cargados
	'cargado', --grupo
	NULL, --accion
	NULL, --accion_imphtml_debug
	NULL, --accion_vinculo_carpeta
	NULL, --accion_vinculo_item
	NULL, --accion_vinculo_objeto
	NULL, --accion_vinculo_popup
	NULL, --accion_vinculo_popup_param
	NULL, --accion_vinculo_target
	NULL, --accion_vinculo_celda
	NULL, --accion_vinculo_servicio
	'0', --es_seleccion_multiple
	'0'  --es_autovinculo
);
INSERT INTO apex_objeto_eventos (proyecto, evento_id, objeto, identificador, etiqueta, maneja_datos, sobre_fila, confirmacion, estilo, imagen_recurso_origen, imagen, en_botonera, ayuda, orden, ci_predep, implicito, defecto, display_datos_cargados, grupo, accion, accion_imphtml_debug, accion_vinculo_carpeta, accion_vinculo_item, accion_vinculo_objeto, accion_vinculo_popup, accion_vinculo_popup_param, accion_vinculo_target, accion_vinculo_celda, accion_vinculo_servicio, es_seleccion_multiple, es_autovinculo) VALUES (
	'extension', --proyecto
	'1002000068', --evento_id
	'1002000066', --objeto
	'prorrogar', --identificador
	'&Prorrogar', --etiqueta
	'0', --maneja_datos
	NULL, --sobre_fila
	NULL, --confirmacion
	NULL, --estilo
	'apex', --imagen_recurso_origen
	'aplicar.png', --imagen
	'0', --en_botonera
	NULL, --ayuda
	'5', --orden
	NULL, --ci_predep
	'0', --implicito
	'0', --defecto
	NULL, --display_datos_cargados
	NULL, --grupo
	NULL, --accion
	NULL, --accion_imphtml_debug
	NULL, --accion_vinculo_carpeta
	NULL, --accion_vinculo_item
	NULL, --accion_vinculo_objeto
	NULL, --accion_vinculo_popup
	NULL, --accion_vinculo_popup_param
	NULL, --accion_vinculo_target
	NULL, --accion_vinculo_celda
	NULL, --accion_vinculo_servicio
	'0', --es_seleccion_multiple
	'0'  --es_autovinculo
);
--- FIN Grupo de desarrollo 1002

------------------------------------------------------------
-- apex_objeto_ut_formulario
------------------------------------------------------------
INSERT INTO apex_objeto_ut_formulario (objeto_ut_formulario_proyecto, objeto_ut_formulario, tabla, titulo, ev_agregar, ev_agregar_etiq, ev_mod_modificar, ev_mod_modificar_etiq, ev_mod_eliminar, ev_mod_eliminar_etiq, ev_mod_limpiar, ev_mod_limpiar_etiq, ev_mod_clave, clase_proyecto, clase, auto_reset, ancho, ancho_etiqueta, expandir_descripcion, campo_bl, scroll, filas, filas_agregar, filas_agregar_online, filas_agregar_abajo, filas_agregar_texto, filas_borrar_en_linea, filas_undo, filas_ordenar, filas_ordenar_en_linea, columna_orden, filas_numerar, ev_seleccion, alto, analisis_cambios, no_imprimir_efs_sin_estado, resaltar_efs_con_estado, template, template_impresion) VALUES (
	'extension', --objeto_ut_formulario_proyecto
	'1002000066', --objeto_ut_formulario
	NULL, --tabla
	NULL, --titulo
	NULL, --ev_agregar
	NULL, --ev_agregar_etiq
	NULL, --ev_mod_modificar
	NULL, --ev_mod_modificar_etiq
	NULL, --ev_mod_eliminar
	NULL, --ev_mod_eliminar_etiq
	NULL, --ev_mod_limpiar
	NULL, --ev_mod_limpiar_etiq
	NULL, --ev_mod_clave
	NULL, --clase_proyecto
	NULL, --clase
	NULL, --auto_reset
	'100%', --ancho
	'150px', --ancho_etiqueta
	'0', --expandir_descripcion
	NULL, --campo_bl
	NULL, --scroll
	NULL, --filas
	NULL, --filas_agregar
	'1', --filas_agregar_online
	'0', --filas_agregar_abajo
	NULL, --filas_agregar_texto
	'0', --filas_borrar_en_linea
	NULL, --filas_undo
	NULL, --filas_ordenar
	'0', --filas_ordenar_en_linea
	NULL, --columna_orden
	NULL, --filas_numerar
	NULL, --ev_seleccion
	NULL, --alto
	NULL, --analisis_cambios
	'0', --no_imprimir_efs_sin_estado
	'0', --resaltar_efs_con_estado
	'<table>
	<tbody>
		<tr>
			<td>
				&nbsp;</td>
			<td>
				&nbsp;</td>
		</tr>
	</tbody>
</table>
<table>
	<tbody>
		<tr>
			<td>
				<span style="font-size: 20px;"><b>TITULO DEL PROYECTO</b></span></td>
			<td>
				<span style="font-size: 20px;"><b>CODIGO</b></span></td>
		</tr>
		<tr>
			<td>
				&nbsp;</td>
		</tr>
		<tr>
			<td>
				[ef id=denominacion]</td>
			<td>
				[ef id=codigo]</td>
		</tr>
		<tr>
			<td>
				[ef id=ord_priori]</td>
			<td>
				[ef id=nro_resol]</td>
		</tr>
		<tr>
			<td>
				&nbsp;</td>
			<td>
				[ef id=fecha_resol]</td>
		</tr>
		<tr>
			<td>
				[ef id=uni_acad]</td>
		</tr>
		<tr>
			<td>
				[ef id=responsable_carga]</td>
		</tr>
		<tr>
			<td>
				&nbsp;</td>
			<td>
				&nbsp;</td>
		</tr>
		<tr>
			<td>
				[ef id=fec_desde]</td>
			<td>
				&nbsp;</td>
		</tr>
		<tr>
			<td>
				[ef id=fec_hasta]</td>
			<td>
				&nbsp;</td>
		</tr>
		<tr>
			<td>
				[ef id=id_bases]</td>
		</tr>
		<tr>
			<td>
				[ef id=duracion]</td>
			<td>
				&nbsp;</td>
		</tr>
		<tr>
			<td>
				&nbsp;</td>
			<td>
				&nbsp;</td>
		</tr>
		<tr>
			<td>
				&nbsp;</td>
			<td>
				&nbsp;</td>
		</tr>
		<tr>
			<td>
				&nbsp;</td>
			<td>
				[ef id=integrante]</td>
		</tr>
		<tr>
			<td>
				[ef id=monto]</td>
		</tr>
		<tr>
			<td>
				&nbsp;</td>
		</tr>
		<tr>
			<td>
				[ef id=observacion_ua]</td>
		</tr>
		<tr>
			<td>
				[ef id=id_estado]</td>
		</tr>
		<tr>
			<td>
				&nbsp;</td>
			<td>
				&nbsp;</td>
		</tr>
		<tr>
			<td>
				&nbsp;</td>
			<td>
				&nbsp;</td>
		</tr>
		<tr>
			<td>
				&nbsp;</td>
			<td>
				&nbsp;</td>
		</tr>
		<tr>
			<td>
				&nbsp;</td>
		</tr>
	</tbody>
</table>
<p>&nbsp;</p>', --template
	NULL  --template_impresion
);

------------------------------------------------------------
-- apex_objeto_ei_formulario_ef
------------------------------------------------------------

--- INICIO Grupo de desarrollo 1001
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_fila, objeto_ei_formulario, objeto_ei_formulario_proyecto, identificador, elemento_formulario, columnas, obligatorio, oculto_relaja_obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, permitir_html, deshabilitar_rest_func, estado_defecto, solo_lectura, solo_lectura_modificacion, carga_metodo, carga_clase, carga_include, carga_dt, carga_consulta_php, carga_sql, carga_fuente, carga_lista, carga_col_clave, carga_col_desc, carga_maestros, carga_cascada_relaj, cascada_mantiene_estado, carga_permite_no_seteado, carga_no_seteado, carga_no_seteado_ocultar, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, edit_confirmar_clave, edit_expreg, popup_item, popup_proyecto, popup_editable, popup_ventana, popup_carga_desc_metodo, popup_carga_desc_clase, popup_carga_desc_include, popup_puede_borrar_estado, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, check_ml_toggle, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano, selec_ancho, selec_serializar, selec_cant_columnas, upload_extensiones, punto_montaje, placeholder) VALUES (
	'1001001204', --objeto_ei_formulario_fila
	'1002000066', --objeto_ei_formulario
	'extension', --objeto_ei_formulario_proyecto
	'ord_priori', --identificador
	'ef_editable', --elemento_formulario
	'ord_priori', --columnas
	'0', --obligatorio
	'0', --oculto_relaja_obligatorio
	'13', --orden
	'Orden de prioridad del Poryecto', --etiqueta
	NULL, --etiqueta_estilo
	NULL, --descripcion
	'0', --colapsado
	'0', --desactivado
	NULL, --estilo
	NULL, --total
	NULL, --inicializacion
	'0', --permitir_html
	'0', --deshabilitar_rest_func
	NULL, --estado_defecto
	'0', --solo_lectura
	'0', --solo_lectura_modificacion
	NULL, --carga_metodo
	NULL, --carga_clase
	NULL, --carga_include
	NULL, --carga_dt
	NULL, --carga_consulta_php
	NULL, --carga_sql
	NULL, --carga_fuente
	NULL, --carga_lista
	NULL, --carga_col_clave
	NULL, --carga_col_desc
	NULL, --carga_maestros
	NULL, --carga_cascada_relaj
	'0', --cascada_mantiene_estado
	'0', --carga_permite_no_seteado
	NULL, --carga_no_seteado
	NULL, --carga_no_seteado_ocultar
	NULL, --edit_tamano
	NULL, --edit_maximo
	NULL, --edit_mascara
	NULL, --edit_unidad
	NULL, --edit_rango
	NULL, --edit_filas
	NULL, --edit_columnas
	NULL, --edit_wrap
	NULL, --edit_resaltar
	NULL, --edit_ajustable
	NULL, --edit_confirmar_clave
	NULL, --edit_expreg
	NULL, --popup_item
	NULL, --popup_proyecto
	NULL, --popup_editable
	NULL, --popup_ventana
	NULL, --popup_carga_desc_metodo
	NULL, --popup_carga_desc_clase
	NULL, --popup_carga_desc_include
	NULL, --popup_puede_borrar_estado
	NULL, --fieldset_fin
	NULL, --check_valor_si
	NULL, --check_valor_no
	NULL, --check_desc_si
	NULL, --check_desc_no
	NULL, --check_ml_toggle
	NULL, --fijo_sin_estado
	NULL, --editor_ancho
	NULL, --editor_alto
	NULL, --editor_botonera
	NULL, --selec_cant_minima
	NULL, --selec_cant_maxima
	NULL, --selec_utilidades
	NULL, --selec_tamano
	NULL, --selec_ancho
	NULL, --selec_serializar
	NULL, --selec_cant_columnas
	NULL, --upload_extensiones
	NULL, --punto_montaje
	NULL  --placeholder
);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_fila, objeto_ei_formulario, objeto_ei_formulario_proyecto, identificador, elemento_formulario, columnas, obligatorio, oculto_relaja_obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, permitir_html, deshabilitar_rest_func, estado_defecto, solo_lectura, solo_lectura_modificacion, carga_metodo, carga_clase, carga_include, carga_dt, carga_consulta_php, carga_sql, carga_fuente, carga_lista, carga_col_clave, carga_col_desc, carga_maestros, carga_cascada_relaj, cascada_mantiene_estado, carga_permite_no_seteado, carga_no_seteado, carga_no_seteado_ocultar, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, edit_confirmar_clave, edit_expreg, popup_item, popup_proyecto, popup_editable, popup_ventana, popup_carga_desc_metodo, popup_carga_desc_clase, popup_carga_desc_include, popup_puede_borrar_estado, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, check_ml_toggle, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano, selec_ancho, selec_serializar, selec_cant_columnas, upload_extensiones, punto_montaje, placeholder) VALUES (
	'1001001214', --objeto_ei_formulario_fila
	'1002000066', --objeto_ei_formulario
	'extension', --objeto_ei_formulario_proyecto
	'id_estado', --identificador
	'ef_combo', --elemento_formulario
	'id_estado', --columnas
	'0', --obligatorio
	'0', --oculto_relaja_obligatorio
	'15', --orden
	'Estado del Proyecto', --etiqueta
	NULL, --etiqueta_estilo
	NULL, --descripcion
	'0', --colapsado
	'0', --desactivado
	NULL, --estilo
	NULL, --total
	NULL, --inicializacion
	'0', --permitir_html
	'0', --deshabilitar_rest_func
	NULL, --estado_defecto
	'0', --solo_lectura
	'0', --solo_lectura_modificacion
	'evaluacion_ua', --carga_metodo
	NULL, --carga_clase
	NULL, --carga_include
	'1001000217', --carga_dt
	NULL, --carga_consulta_php
	NULL, --carga_sql
	'designa', --carga_fuente
	NULL, --carga_lista
	'id_estado', --carga_col_clave
	'descripcion', --carga_col_desc
	NULL, --carga_maestros
	'0', --carga_cascada_relaj
	'0', --cascada_mantiene_estado
	'1', --carga_permite_no_seteado
	'--Seleccione--', --carga_no_seteado
	'0', --carga_no_seteado_ocultar
	NULL, --edit_tamano
	NULL, --edit_maximo
	NULL, --edit_mascara
	NULL, --edit_unidad
	NULL, --edit_rango
	NULL, --edit_filas
	NULL, --edit_columnas
	NULL, --edit_wrap
	NULL, --edit_resaltar
	NULL, --edit_ajustable
	NULL, --edit_confirmar_clave
	NULL, --edit_expreg
	NULL, --popup_item
	NULL, --popup_proyecto
	NULL, --popup_editable
	NULL, --popup_ventana
	NULL, --popup_carga_desc_metodo
	NULL, --popup_carga_desc_clase
	NULL, --popup_carga_desc_include
	NULL, --popup_puede_borrar_estado
	NULL, --fieldset_fin
	NULL, --check_valor_si
	NULL, --check_valor_no
	NULL, --check_desc_si
	NULL, --check_desc_no
	NULL, --check_ml_toggle
	NULL, --fijo_sin_estado
	NULL, --editor_ancho
	NULL, --editor_alto
	NULL, --editor_botonera
	NULL, --selec_cant_minima
	NULL, --selec_cant_maxima
	NULL, --selec_utilidades
	NULL, --selec_tamano
	NULL, --selec_ancho
	NULL, --selec_serializar
	NULL, --selec_cant_columnas
	NULL, --upload_extensiones
	'1001000004', --punto_montaje
	NULL  --placeholder
);
--- FIN Grupo de desarrollo 1001

--- INICIO Grupo de desarrollo 1002
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_fila, objeto_ei_formulario, objeto_ei_formulario_proyecto, identificador, elemento_formulario, columnas, obligatorio, oculto_relaja_obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, permitir_html, deshabilitar_rest_func, estado_defecto, solo_lectura, solo_lectura_modificacion, carga_metodo, carga_clase, carga_include, carga_dt, carga_consulta_php, carga_sql, carga_fuente, carga_lista, carga_col_clave, carga_col_desc, carga_maestros, carga_cascada_relaj, cascada_mantiene_estado, carga_permite_no_seteado, carga_no_seteado, carga_no_seteado_ocultar, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, edit_confirmar_clave, edit_expreg, popup_item, popup_proyecto, popup_editable, popup_ventana, popup_carga_desc_metodo, popup_carga_desc_clase, popup_carga_desc_include, popup_puede_borrar_estado, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, check_ml_toggle, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano, selec_ancho, selec_serializar, selec_cant_columnas, upload_extensiones, punto_montaje, placeholder) VALUES (
	'1002000054', --objeto_ei_formulario_fila
	'1002000066', --objeto_ei_formulario
	'extension', --objeto_ei_formulario_proyecto
	'codigo', --identificador
	'ef_fijo', --elemento_formulario
	'codigo', --columnas
	'0', --obligatorio
	'0', --oculto_relaja_obligatorio
	'1', --orden
	'Codigo', --etiqueta
	NULL, --etiqueta_estilo
	NULL, --descripcion
	NULL, --colapsado
	NULL, --desactivado
	NULL, --estilo
	NULL, --total
	NULL, --inicializacion
	NULL, --permitir_html
	NULL, --deshabilitar_rest_func
	NULL, --estado_defecto
	NULL, --solo_lectura
	'0', --solo_lectura_modificacion
	NULL, --carga_metodo
	NULL, --carga_clase
	NULL, --carga_include
	NULL, --carga_dt
	NULL, --carga_consulta_php
	NULL, --carga_sql
	NULL, --carga_fuente
	NULL, --carga_lista
	NULL, --carga_col_clave
	NULL, --carga_col_desc
	NULL, --carga_maestros
	NULL, --carga_cascada_relaj
	'0', --cascada_mantiene_estado
	'0', --carga_permite_no_seteado
	NULL, --carga_no_seteado
	NULL, --carga_no_seteado_ocultar
	NULL, --edit_tamano
	NULL, --edit_maximo
	NULL, --edit_mascara
	NULL, --edit_unidad
	NULL, --edit_rango
	NULL, --edit_filas
	NULL, --edit_columnas
	NULL, --edit_wrap
	NULL, --edit_resaltar
	NULL, --edit_ajustable
	NULL, --edit_confirmar_clave
	NULL, --edit_expreg
	NULL, --popup_item
	NULL, --popup_proyecto
	NULL, --popup_editable
	NULL, --popup_ventana
	NULL, --popup_carga_desc_metodo
	NULL, --popup_carga_desc_clase
	NULL, --popup_carga_desc_include
	NULL, --popup_puede_borrar_estado
	NULL, --fieldset_fin
	NULL, --check_valor_si
	NULL, --check_valor_no
	NULL, --check_desc_si
	NULL, --check_desc_no
	NULL, --check_ml_toggle
	NULL, --fijo_sin_estado
	NULL, --editor_ancho
	NULL, --editor_alto
	NULL, --editor_botonera
	NULL, --selec_cant_minima
	NULL, --selec_cant_maxima
	NULL, --selec_utilidades
	NULL, --selec_tamano
	NULL, --selec_ancho
	NULL, --selec_serializar
	NULL, --selec_cant_columnas
	NULL, --upload_extensiones
	NULL, --punto_montaje
	NULL  --placeholder
);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_fila, objeto_ei_formulario, objeto_ei_formulario_proyecto, identificador, elemento_formulario, columnas, obligatorio, oculto_relaja_obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, permitir_html, deshabilitar_rest_func, estado_defecto, solo_lectura, solo_lectura_modificacion, carga_metodo, carga_clase, carga_include, carga_dt, carga_consulta_php, carga_sql, carga_fuente, carga_lista, carga_col_clave, carga_col_desc, carga_maestros, carga_cascada_relaj, cascada_mantiene_estado, carga_permite_no_seteado, carga_no_seteado, carga_no_seteado_ocultar, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, edit_confirmar_clave, edit_expreg, popup_item, popup_proyecto, popup_editable, popup_ventana, popup_carga_desc_metodo, popup_carga_desc_clase, popup_carga_desc_include, popup_puede_borrar_estado, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, check_ml_toggle, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano, selec_ancho, selec_serializar, selec_cant_columnas, upload_extensiones, punto_montaje, placeholder) VALUES (
	'1002000055', --objeto_ei_formulario_fila
	'1002000066', --objeto_ei_formulario
	'extension', --objeto_ei_formulario_proyecto
	'nro_resol', --identificador
	'ef_editable', --elemento_formulario
	'nro_resol', --columnas
	'0', --obligatorio
	'0', --oculto_relaja_obligatorio
	'2', --orden
	'Nro Resolucion', --etiqueta
	NULL, --etiqueta_estilo
	NULL, --descripcion
	NULL, --colapsado
	NULL, --desactivado
	NULL, --estilo
	NULL, --total
	NULL, --inicializacion
	NULL, --permitir_html
	NULL, --deshabilitar_rest_func
	NULL, --estado_defecto
	NULL, --solo_lectura
	'0', --solo_lectura_modificacion
	NULL, --carga_metodo
	NULL, --carga_clase
	NULL, --carga_include
	NULL, --carga_dt
	NULL, --carga_consulta_php
	NULL, --carga_sql
	NULL, --carga_fuente
	NULL, --carga_lista
	NULL, --carga_col_clave
	NULL, --carga_col_desc
	NULL, --carga_maestros
	NULL, --carga_cascada_relaj
	'0', --cascada_mantiene_estado
	'0', --carga_permite_no_seteado
	NULL, --carga_no_seteado
	NULL, --carga_no_seteado_ocultar
	NULL, --edit_tamano
	NULL, --edit_maximo
	NULL, --edit_mascara
	NULL, --edit_unidad
	NULL, --edit_rango
	NULL, --edit_filas
	NULL, --edit_columnas
	NULL, --edit_wrap
	NULL, --edit_resaltar
	NULL, --edit_ajustable
	NULL, --edit_confirmar_clave
	NULL, --edit_expreg
	NULL, --popup_item
	NULL, --popup_proyecto
	NULL, --popup_editable
	NULL, --popup_ventana
	NULL, --popup_carga_desc_metodo
	NULL, --popup_carga_desc_clase
	NULL, --popup_carga_desc_include
	NULL, --popup_puede_borrar_estado
	NULL, --fieldset_fin
	NULL, --check_valor_si
	NULL, --check_valor_no
	NULL, --check_desc_si
	NULL, --check_desc_no
	NULL, --check_ml_toggle
	NULL, --fijo_sin_estado
	NULL, --editor_ancho
	NULL, --editor_alto
	NULL, --editor_botonera
	NULL, --selec_cant_minima
	NULL, --selec_cant_maxima
	NULL, --selec_utilidades
	NULL, --selec_tamano
	NULL, --selec_ancho
	NULL, --selec_serializar
	NULL, --selec_cant_columnas
	NULL, --upload_extensiones
	NULL, --punto_montaje
	NULL  --placeholder
);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_fila, objeto_ei_formulario, objeto_ei_formulario_proyecto, identificador, elemento_formulario, columnas, obligatorio, oculto_relaja_obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, permitir_html, deshabilitar_rest_func, estado_defecto, solo_lectura, solo_lectura_modificacion, carga_metodo, carga_clase, carga_include, carga_dt, carga_consulta_php, carga_sql, carga_fuente, carga_lista, carga_col_clave, carga_col_desc, carga_maestros, carga_cascada_relaj, cascada_mantiene_estado, carga_permite_no_seteado, carga_no_seteado, carga_no_seteado_ocultar, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, edit_confirmar_clave, edit_expreg, popup_item, popup_proyecto, popup_editable, popup_ventana, popup_carga_desc_metodo, popup_carga_desc_clase, popup_carga_desc_include, popup_puede_borrar_estado, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, check_ml_toggle, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano, selec_ancho, selec_serializar, selec_cant_columnas, upload_extensiones, punto_montaje, placeholder) VALUES (
	'1002000056', --objeto_ei_formulario_fila
	'1002000066', --objeto_ei_formulario
	'extension', --objeto_ei_formulario_proyecto
	'fecha_resol', --identificador
	'ef_editable_fecha', --elemento_formulario
	'fecha_resol', --columnas
	'0', --obligatorio
	'0', --oculto_relaja_obligatorio
	'3', --orden
	'Fecha Resolucion', --etiqueta
	NULL, --etiqueta_estilo
	NULL, --descripcion
	NULL, --colapsado
	NULL, --desactivado
	NULL, --estilo
	NULL, --total
	NULL, --inicializacion
	NULL, --permitir_html
	NULL, --deshabilitar_rest_func
	NULL, --estado_defecto
	NULL, --solo_lectura
	'0', --solo_lectura_modificacion
	NULL, --carga_metodo
	NULL, --carga_clase
	NULL, --carga_include
	NULL, --carga_dt
	NULL, --carga_consulta_php
	NULL, --carga_sql
	NULL, --carga_fuente
	NULL, --carga_lista
	NULL, --carga_col_clave
	NULL, --carga_col_desc
	NULL, --carga_maestros
	NULL, --carga_cascada_relaj
	'0', --cascada_mantiene_estado
	'0', --carga_permite_no_seteado
	NULL, --carga_no_seteado
	NULL, --carga_no_seteado_ocultar
	NULL, --edit_tamano
	NULL, --edit_maximo
	NULL, --edit_mascara
	NULL, --edit_unidad
	NULL, --edit_rango
	NULL, --edit_filas
	NULL, --edit_columnas
	NULL, --edit_wrap
	NULL, --edit_resaltar
	NULL, --edit_ajustable
	NULL, --edit_confirmar_clave
	NULL, --edit_expreg
	NULL, --popup_item
	NULL, --popup_proyecto
	NULL, --popup_editable
	NULL, --popup_ventana
	NULL, --popup_carga_desc_metodo
	NULL, --popup_carga_desc_clase
	NULL, --popup_carga_desc_include
	NULL, --popup_puede_borrar_estado
	NULL, --fieldset_fin
	NULL, --check_valor_si
	NULL, --check_valor_no
	NULL, --check_desc_si
	NULL, --check_desc_no
	NULL, --check_ml_toggle
	NULL, --fijo_sin_estado
	NULL, --editor_ancho
	NULL, --editor_alto
	NULL, --editor_botonera
	NULL, --selec_cant_minima
	NULL, --selec_cant_maxima
	NULL, --selec_utilidades
	NULL, --selec_tamano
	NULL, --selec_ancho
	NULL, --selec_serializar
	NULL, --selec_cant_columnas
	NULL, --upload_extensiones
	NULL, --punto_montaje
	NULL  --placeholder
);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_fila, objeto_ei_formulario, objeto_ei_formulario_proyecto, identificador, elemento_formulario, columnas, obligatorio, oculto_relaja_obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, permitir_html, deshabilitar_rest_func, estado_defecto, solo_lectura, solo_lectura_modificacion, carga_metodo, carga_clase, carga_include, carga_dt, carga_consulta_php, carga_sql, carga_fuente, carga_lista, carga_col_clave, carga_col_desc, carga_maestros, carga_cascada_relaj, cascada_mantiene_estado, carga_permite_no_seteado, carga_no_seteado, carga_no_seteado_ocultar, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, edit_confirmar_clave, edit_expreg, popup_item, popup_proyecto, popup_editable, popup_ventana, popup_carga_desc_metodo, popup_carga_desc_clase, popup_carga_desc_include, popup_puede_borrar_estado, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, check_ml_toggle, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano, selec_ancho, selec_serializar, selec_cant_columnas, upload_extensiones, punto_montaje, placeholder) VALUES (
	'1002000057', --objeto_ei_formulario_fila
	'1002000066', --objeto_ei_formulario
	'extension', --objeto_ei_formulario_proyecto
	'uni_acad', --identificador
	'ef_fijo', --elemento_formulario
	'uni_acad', --columnas
	'0', --obligatorio
	'0', --oculto_relaja_obligatorio
	'4', --orden
	'Unidad Academica', --etiqueta
	NULL, --etiqueta_estilo
	NULL, --descripcion
	NULL, --colapsado
	NULL, --desactivado
	NULL, --estilo
	NULL, --total
	NULL, --inicializacion
	NULL, --permitir_html
	NULL, --deshabilitar_rest_func
	NULL, --estado_defecto
	NULL, --solo_lectura
	'0', --solo_lectura_modificacion
	NULL, --carga_metodo
	NULL, --carga_clase
	NULL, --carga_include
	NULL, --carga_dt
	NULL, --carga_consulta_php
	NULL, --carga_sql
	NULL, --carga_fuente
	NULL, --carga_lista
	NULL, --carga_col_clave
	NULL, --carga_col_desc
	NULL, --carga_maestros
	NULL, --carga_cascada_relaj
	'0', --cascada_mantiene_estado
	'0', --carga_permite_no_seteado
	NULL, --carga_no_seteado
	NULL, --carga_no_seteado_ocultar
	NULL, --edit_tamano
	NULL, --edit_maximo
	NULL, --edit_mascara
	NULL, --edit_unidad
	NULL, --edit_rango
	NULL, --edit_filas
	NULL, --edit_columnas
	NULL, --edit_wrap
	NULL, --edit_resaltar
	NULL, --edit_ajustable
	NULL, --edit_confirmar_clave
	NULL, --edit_expreg
	NULL, --popup_item
	NULL, --popup_proyecto
	NULL, --popup_editable
	NULL, --popup_ventana
	NULL, --popup_carga_desc_metodo
	NULL, --popup_carga_desc_clase
	NULL, --popup_carga_desc_include
	NULL, --popup_puede_borrar_estado
	NULL, --fieldset_fin
	NULL, --check_valor_si
	NULL, --check_valor_no
	NULL, --check_desc_si
	NULL, --check_desc_no
	NULL, --check_ml_toggle
	NULL, --fijo_sin_estado
	NULL, --editor_ancho
	NULL, --editor_alto
	NULL, --editor_botonera
	NULL, --selec_cant_minima
	NULL, --selec_cant_maxima
	NULL, --selec_utilidades
	NULL, --selec_tamano
	NULL, --selec_ancho
	NULL, --selec_serializar
	NULL, --selec_cant_columnas
	NULL, --upload_extensiones
	NULL, --punto_montaje
	NULL  --placeholder
);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_fila, objeto_ei_formulario, objeto_ei_formulario_proyecto, identificador, elemento_formulario, columnas, obligatorio, oculto_relaja_obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, permitir_html, deshabilitar_rest_func, estado_defecto, solo_lectura, solo_lectura_modificacion, carga_metodo, carga_clase, carga_include, carga_dt, carga_consulta_php, carga_sql, carga_fuente, carga_lista, carga_col_clave, carga_col_desc, carga_maestros, carga_cascada_relaj, cascada_mantiene_estado, carga_permite_no_seteado, carga_no_seteado, carga_no_seteado_ocultar, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, edit_confirmar_clave, edit_expreg, popup_item, popup_proyecto, popup_editable, popup_ventana, popup_carga_desc_metodo, popup_carga_desc_clase, popup_carga_desc_include, popup_puede_borrar_estado, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, check_ml_toggle, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano, selec_ancho, selec_serializar, selec_cant_columnas, upload_extensiones, punto_montaje, placeholder) VALUES (
	'1002000058', --objeto_ei_formulario_fila
	'1002000066', --objeto_ei_formulario
	'extension', --objeto_ei_formulario_proyecto
	'duracion', --identificador
	'ef_combo', --elemento_formulario
	'duracion', --columnas
	'0', --obligatorio
	'0', --oculto_relaja_obligatorio
	'5', --orden
	'Duracion', --etiqueta
	NULL, --etiqueta_estilo
	NULL, --descripcion
	'0', --colapsado
	'0', --desactivado
	NULL, --estilo
	NULL, --total
	NULL, --inicializacion
	'0', --permitir_html
	'0', --deshabilitar_rest_func
	NULL, --estado_defecto
	'0', --solo_lectura
	'0', --solo_lectura_modificacion
	'get_duracion', --carga_metodo
	NULL, --carga_clase
	NULL, --carga_include
	'1001000156', --carga_dt
	NULL, --carga_consulta_php
	NULL, --carga_sql
	'designa', --carga_fuente
	NULL, --carga_lista
	'id_bases', --carga_col_clave
	'duracion_convocatoria', --carga_col_desc
	'id_bases', --carga_maestros
	'0', --carga_cascada_relaj
	'0', --cascada_mantiene_estado
	'1', --carga_permite_no_seteado
	'--Seleccione--', --carga_no_seteado
	'0', --carga_no_seteado_ocultar
	NULL, --edit_tamano
	NULL, --edit_maximo
	NULL, --edit_mascara
	NULL, --edit_unidad
	NULL, --edit_rango
	NULL, --edit_filas
	NULL, --edit_columnas
	NULL, --edit_wrap
	NULL, --edit_resaltar
	NULL, --edit_ajustable
	NULL, --edit_confirmar_clave
	NULL, --edit_expreg
	NULL, --popup_item
	NULL, --popup_proyecto
	NULL, --popup_editable
	NULL, --popup_ventana
	NULL, --popup_carga_desc_metodo
	NULL, --popup_carga_desc_clase
	NULL, --popup_carga_desc_include
	NULL, --popup_puede_borrar_estado
	NULL, --fieldset_fin
	NULL, --check_valor_si
	NULL, --check_valor_no
	NULL, --check_desc_si
	NULL, --check_desc_no
	NULL, --check_ml_toggle
	'0', --fijo_sin_estado
	NULL, --editor_ancho
	NULL, --editor_alto
	NULL, --editor_botonera
	NULL, --selec_cant_minima
	NULL, --selec_cant_maxima
	NULL, --selec_utilidades
	NULL, --selec_tamano
	NULL, --selec_ancho
	NULL, --selec_serializar
	NULL, --selec_cant_columnas
	NULL, --upload_extensiones
	'1001000004', --punto_montaje
	NULL  --placeholder
);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_fila, objeto_ei_formulario, objeto_ei_formulario_proyecto, identificador, elemento_formulario, columnas, obligatorio, oculto_relaja_obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, permitir_html, deshabilitar_rest_func, estado_defecto, solo_lectura, solo_lectura_modificacion, carga_metodo, carga_clase, carga_include, carga_dt, carga_consulta_php, carga_sql, carga_fuente, carga_lista, carga_col_clave, carga_col_desc, carga_maestros, carga_cascada_relaj, cascada_mantiene_estado, carga_permite_no_seteado, carga_no_seteado, carga_no_seteado_ocultar, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, edit_confirmar_clave, edit_expreg, popup_item, popup_proyecto, popup_editable, popup_ventana, popup_carga_desc_metodo, popup_carga_desc_clase, popup_carga_desc_include, popup_puede_borrar_estado, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, check_ml_toggle, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano, selec_ancho, selec_serializar, selec_cant_columnas, upload_extensiones, punto_montaje, placeholder) VALUES (
	'1002000061', --objeto_ei_formulario_fila
	'1002000066', --objeto_ei_formulario
	'extension', --objeto_ei_formulario_proyecto
	'monto', --identificador
	'ef_fijo', --elemento_formulario
	'monto', --columnas
	'0', --obligatorio
	'0', --oculto_relaja_obligatorio
	'6', --orden
	'Monto', --etiqueta
	NULL, --etiqueta_estilo
	NULL, --descripcion
	NULL, --colapsado
	NULL, --desactivado
	NULL, --estilo
	NULL, --total
	NULL, --inicializacion
	NULL, --permitir_html
	NULL, --deshabilitar_rest_func
	NULL, --estado_defecto
	NULL, --solo_lectura
	'0', --solo_lectura_modificacion
	NULL, --carga_metodo
	NULL, --carga_clase
	NULL, --carga_include
	NULL, --carga_dt
	NULL, --carga_consulta_php
	NULL, --carga_sql
	NULL, --carga_fuente
	NULL, --carga_lista
	NULL, --carga_col_clave
	NULL, --carga_col_desc
	NULL, --carga_maestros
	NULL, --carga_cascada_relaj
	'0', --cascada_mantiene_estado
	'0', --carga_permite_no_seteado
	NULL, --carga_no_seteado
	NULL, --carga_no_seteado_ocultar
	NULL, --edit_tamano
	NULL, --edit_maximo
	NULL, --edit_mascara
	NULL, --edit_unidad
	NULL, --edit_rango
	NULL, --edit_filas
	NULL, --edit_columnas
	NULL, --edit_wrap
	NULL, --edit_resaltar
	NULL, --edit_ajustable
	NULL, --edit_confirmar_clave
	NULL, --edit_expreg
	NULL, --popup_item
	NULL, --popup_proyecto
	NULL, --popup_editable
	NULL, --popup_ventana
	NULL, --popup_carga_desc_metodo
	NULL, --popup_carga_desc_clase
	NULL, --popup_carga_desc_include
	NULL, --popup_puede_borrar_estado
	NULL, --fieldset_fin
	NULL, --check_valor_si
	NULL, --check_valor_no
	NULL, --check_desc_si
	NULL, --check_desc_no
	NULL, --check_ml_toggle
	NULL, --fijo_sin_estado
	NULL, --editor_ancho
	NULL, --editor_alto
	NULL, --editor_botonera
	NULL, --selec_cant_minima
	NULL, --selec_cant_maxima
	NULL, --selec_utilidades
	NULL, --selec_tamano
	NULL, --selec_ancho
	NULL, --selec_serializar
	NULL, --selec_cant_columnas
	NULL, --upload_extensiones
	NULL, --punto_montaje
	NULL  --placeholder
);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_fila, objeto_ei_formulario, objeto_ei_formulario_proyecto, identificador, elemento_formulario, columnas, obligatorio, oculto_relaja_obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, permitir_html, deshabilitar_rest_func, estado_defecto, solo_lectura, solo_lectura_modificacion, carga_metodo, carga_clase, carga_include, carga_dt, carga_consulta_php, carga_sql, carga_fuente, carga_lista, carga_col_clave, carga_col_desc, carga_maestros, carga_cascada_relaj, cascada_mantiene_estado, carga_permite_no_seteado, carga_no_seteado, carga_no_seteado_ocultar, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, edit_confirmar_clave, edit_expreg, popup_item, popup_proyecto, popup_editable, popup_ventana, popup_carga_desc_metodo, popup_carga_desc_clase, popup_carga_desc_include, popup_puede_borrar_estado, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, check_ml_toggle, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano, selec_ancho, selec_serializar, selec_cant_columnas, upload_extensiones, punto_montaje, placeholder) VALUES (
	'1002000066', --objeto_ei_formulario_fila
	'1002000066', --objeto_ei_formulario
	'extension', --objeto_ei_formulario_proyecto
	'observacion_ua', --identificador
	'ef_editable_textarea', --elemento_formulario
	'observacion_ua', --columnas
	'0', --obligatorio
	'0', --oculto_relaja_obligatorio
	'7', --orden
	'Observacion', --etiqueta
	NULL, --etiqueta_estilo
	NULL, --descripcion
	NULL, --colapsado
	NULL, --desactivado
	NULL, --estilo
	NULL, --total
	NULL, --inicializacion
	NULL, --permitir_html
	NULL, --deshabilitar_rest_func
	NULL, --estado_defecto
	NULL, --solo_lectura
	'0', --solo_lectura_modificacion
	NULL, --carga_metodo
	NULL, --carga_clase
	NULL, --carga_include
	NULL, --carga_dt
	NULL, --carga_consulta_php
	NULL, --carga_sql
	NULL, --carga_fuente
	NULL, --carga_lista
	NULL, --carga_col_clave
	NULL, --carga_col_desc
	NULL, --carga_maestros
	NULL, --carga_cascada_relaj
	'0', --cascada_mantiene_estado
	'0', --carga_permite_no_seteado
	NULL, --carga_no_seteado
	NULL, --carga_no_seteado_ocultar
	NULL, --edit_tamano
	NULL, --edit_maximo
	NULL, --edit_mascara
	NULL, --edit_unidad
	NULL, --edit_rango
	NULL, --edit_filas
	NULL, --edit_columnas
	NULL, --edit_wrap
	NULL, --edit_resaltar
	NULL, --edit_ajustable
	NULL, --edit_confirmar_clave
	NULL, --edit_expreg
	NULL, --popup_item
	NULL, --popup_proyecto
	NULL, --popup_editable
	NULL, --popup_ventana
	NULL, --popup_carga_desc_metodo
	NULL, --popup_carga_desc_clase
	NULL, --popup_carga_desc_include
	NULL, --popup_puede_borrar_estado
	NULL, --fieldset_fin
	NULL, --check_valor_si
	NULL, --check_valor_no
	NULL, --check_desc_si
	NULL, --check_desc_no
	NULL, --check_ml_toggle
	NULL, --fijo_sin_estado
	NULL, --editor_ancho
	NULL, --editor_alto
	NULL, --editor_botonera
	NULL, --selec_cant_minima
	NULL, --selec_cant_maxima
	NULL, --selec_utilidades
	NULL, --selec_tamano
	NULL, --selec_ancho
	NULL, --selec_serializar
	NULL, --selec_cant_columnas
	NULL, --upload_extensiones
	NULL, --punto_montaje
	NULL  --placeholder
);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_fila, objeto_ei_formulario, objeto_ei_formulario_proyecto, identificador, elemento_formulario, columnas, obligatorio, oculto_relaja_obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, permitir_html, deshabilitar_rest_func, estado_defecto, solo_lectura, solo_lectura_modificacion, carga_metodo, carga_clase, carga_include, carga_dt, carga_consulta_php, carga_sql, carga_fuente, carga_lista, carga_col_clave, carga_col_desc, carga_maestros, carga_cascada_relaj, cascada_mantiene_estado, carga_permite_no_seteado, carga_no_seteado, carga_no_seteado_ocultar, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, edit_confirmar_clave, edit_expreg, popup_item, popup_proyecto, popup_editable, popup_ventana, popup_carga_desc_metodo, popup_carga_desc_clase, popup_carga_desc_include, popup_puede_borrar_estado, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, check_ml_toggle, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano, selec_ancho, selec_serializar, selec_cant_columnas, upload_extensiones, punto_montaje, placeholder) VALUES (
	'1002000069', --objeto_ei_formulario_fila
	'1002000066', --objeto_ei_formulario
	'extension', --objeto_ei_formulario_proyecto
	'id_bases', --identificador
	'ef_combo', --elemento_formulario
	'id_bases', --columnas
	'0', --obligatorio
	'0', --oculto_relaja_obligatorio
	'8', --orden
	'Titulo Convocatoria', --etiqueta
	NULL, --etiqueta_estilo
	NULL, --descripcion
	'0', --colapsado
	'0', --desactivado
	NULL, --estilo
	NULL, --total
	NULL, --inicializacion
	'0', --permitir_html
	'0', --deshabilitar_rest_func
	NULL, --estado_defecto
	'0', --solo_lectura
	'0', --solo_lectura_modificacion
	'get_titulo', --carga_metodo
	NULL, --carga_clase
	NULL, --carga_include
	'1001000156', --carga_dt
	NULL, --carga_consulta_php
	NULL, --carga_sql
	'designa', --carga_fuente
	NULL, --carga_lista
	'id_bases', --carga_col_clave
	'bases_titulo', --carga_col_desc
	NULL, --carga_maestros
	'0', --carga_cascada_relaj
	'0', --cascada_mantiene_estado
	'1', --carga_permite_no_seteado
	'--Seleccione--', --carga_no_seteado
	'0', --carga_no_seteado_ocultar
	NULL, --edit_tamano
	NULL, --edit_maximo
	NULL, --edit_mascara
	NULL, --edit_unidad
	NULL, --edit_rango
	NULL, --edit_filas
	NULL, --edit_columnas
	NULL, --edit_wrap
	NULL, --edit_resaltar
	NULL, --edit_ajustable
	NULL, --edit_confirmar_clave
	NULL, --edit_expreg
	NULL, --popup_item
	NULL, --popup_proyecto
	NULL, --popup_editable
	NULL, --popup_ventana
	NULL, --popup_carga_desc_metodo
	NULL, --popup_carga_desc_clase
	NULL, --popup_carga_desc_include
	NULL, --popup_puede_borrar_estado
	NULL, --fieldset_fin
	NULL, --check_valor_si
	NULL, --check_valor_no
	NULL, --check_desc_si
	NULL, --check_desc_no
	NULL, --check_ml_toggle
	NULL, --fijo_sin_estado
	NULL, --editor_ancho
	NULL, --editor_alto
	NULL, --editor_botonera
	NULL, --selec_cant_minima
	NULL, --selec_cant_maxima
	NULL, --selec_utilidades
	NULL, --selec_tamano
	NULL, --selec_ancho
	NULL, --selec_serializar
	NULL, --selec_cant_columnas
	NULL, --upload_extensiones
	'1001000004', --punto_montaje
	NULL  --placeholder
);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_fila, objeto_ei_formulario, objeto_ei_formulario_proyecto, identificador, elemento_formulario, columnas, obligatorio, oculto_relaja_obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, permitir_html, deshabilitar_rest_func, estado_defecto, solo_lectura, solo_lectura_modificacion, carga_metodo, carga_clase, carga_include, carga_dt, carga_consulta_php, carga_sql, carga_fuente, carga_lista, carga_col_clave, carga_col_desc, carga_maestros, carga_cascada_relaj, cascada_mantiene_estado, carga_permite_no_seteado, carga_no_seteado, carga_no_seteado_ocultar, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, edit_confirmar_clave, edit_expreg, popup_item, popup_proyecto, popup_editable, popup_ventana, popup_carga_desc_metodo, popup_carga_desc_clase, popup_carga_desc_include, popup_puede_borrar_estado, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, check_ml_toggle, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano, selec_ancho, selec_serializar, selec_cant_columnas, upload_extensiones, punto_montaje, placeholder) VALUES (
	'1002000070', --objeto_ei_formulario_fila
	'1002000066', --objeto_ei_formulario
	'extension', --objeto_ei_formulario_proyecto
	'responsable_carga', --identificador
	'ef_fijo', --elemento_formulario
	'responsable_carga', --columnas
	'0', --obligatorio
	'0', --oculto_relaja_obligatorio
	'9', --orden
	'Responsable carga', --etiqueta
	NULL, --etiqueta_estilo
	NULL, --descripcion
	NULL, --colapsado
	NULL, --desactivado
	NULL, --estilo
	NULL, --total
	NULL, --inicializacion
	NULL, --permitir_html
	NULL, --deshabilitar_rest_func
	NULL, --estado_defecto
	NULL, --solo_lectura
	'0', --solo_lectura_modificacion
	NULL, --carga_metodo
	NULL, --carga_clase
	NULL, --carga_include
	NULL, --carga_dt
	NULL, --carga_consulta_php
	NULL, --carga_sql
	NULL, --carga_fuente
	NULL, --carga_lista
	NULL, --carga_col_clave
	NULL, --carga_col_desc
	NULL, --carga_maestros
	NULL, --carga_cascada_relaj
	'0', --cascada_mantiene_estado
	'0', --carga_permite_no_seteado
	NULL, --carga_no_seteado
	NULL, --carga_no_seteado_ocultar
	'30', --edit_tamano
	'30', --edit_maximo
	NULL, --edit_mascara
	NULL, --edit_unidad
	NULL, --edit_rango
	NULL, --edit_filas
	NULL, --edit_columnas
	NULL, --edit_wrap
	NULL, --edit_resaltar
	NULL, --edit_ajustable
	NULL, --edit_confirmar_clave
	NULL, --edit_expreg
	NULL, --popup_item
	NULL, --popup_proyecto
	NULL, --popup_editable
	NULL, --popup_ventana
	NULL, --popup_carga_desc_metodo
	NULL, --popup_carga_desc_clase
	NULL, --popup_carga_desc_include
	NULL, --popup_puede_borrar_estado
	NULL, --fieldset_fin
	NULL, --check_valor_si
	NULL, --check_valor_no
	NULL, --check_desc_si
	NULL, --check_desc_no
	NULL, --check_ml_toggle
	NULL, --fijo_sin_estado
	NULL, --editor_ancho
	NULL, --editor_alto
	NULL, --editor_botonera
	NULL, --selec_cant_minima
	NULL, --selec_cant_maxima
	NULL, --selec_utilidades
	NULL, --selec_tamano
	NULL, --selec_ancho
	NULL, --selec_serializar
	NULL, --selec_cant_columnas
	NULL, --upload_extensiones
	NULL, --punto_montaje
	NULL  --placeholder
);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_fila, objeto_ei_formulario, objeto_ei_formulario_proyecto, identificador, elemento_formulario, columnas, obligatorio, oculto_relaja_obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, permitir_html, deshabilitar_rest_func, estado_defecto, solo_lectura, solo_lectura_modificacion, carga_metodo, carga_clase, carga_include, carga_dt, carga_consulta_php, carga_sql, carga_fuente, carga_lista, carga_col_clave, carga_col_desc, carga_maestros, carga_cascada_relaj, cascada_mantiene_estado, carga_permite_no_seteado, carga_no_seteado, carga_no_seteado_ocultar, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, edit_confirmar_clave, edit_expreg, popup_item, popup_proyecto, popup_editable, popup_ventana, popup_carga_desc_metodo, popup_carga_desc_clase, popup_carga_desc_include, popup_puede_borrar_estado, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, check_ml_toggle, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano, selec_ancho, selec_serializar, selec_cant_columnas, upload_extensiones, punto_montaje, placeholder) VALUES (
	'1002000081', --objeto_ei_formulario_fila
	'1002000066', --objeto_ei_formulario
	'extension', --objeto_ei_formulario_proyecto
	'fec_desde', --identificador
	'ef_editable_fecha', --elemento_formulario
	'fec_desde', --columnas
	'0', --obligatorio
	'0', --oculto_relaja_obligatorio
	'10', --orden
	'Fecha de Inicio del Proyecto', --etiqueta
	NULL, --etiqueta_estilo
	NULL, --descripcion
	NULL, --colapsado
	NULL, --desactivado
	NULL, --estilo
	NULL, --total
	NULL, --inicializacion
	NULL, --permitir_html
	NULL, --deshabilitar_rest_func
	NULL, --estado_defecto
	NULL, --solo_lectura
	'0', --solo_lectura_modificacion
	NULL, --carga_metodo
	NULL, --carga_clase
	NULL, --carga_include
	NULL, --carga_dt
	NULL, --carga_consulta_php
	NULL, --carga_sql
	NULL, --carga_fuente
	NULL, --carga_lista
	NULL, --carga_col_clave
	NULL, --carga_col_desc
	NULL, --carga_maestros
	NULL, --carga_cascada_relaj
	'0', --cascada_mantiene_estado
	'0', --carga_permite_no_seteado
	NULL, --carga_no_seteado
	NULL, --carga_no_seteado_ocultar
	NULL, --edit_tamano
	NULL, --edit_maximo
	NULL, --edit_mascara
	NULL, --edit_unidad
	NULL, --edit_rango
	NULL, --edit_filas
	NULL, --edit_columnas
	NULL, --edit_wrap
	NULL, --edit_resaltar
	NULL, --edit_ajustable
	NULL, --edit_confirmar_clave
	NULL, --edit_expreg
	NULL, --popup_item
	NULL, --popup_proyecto
	NULL, --popup_editable
	NULL, --popup_ventana
	NULL, --popup_carga_desc_metodo
	NULL, --popup_carga_desc_clase
	NULL, --popup_carga_desc_include
	NULL, --popup_puede_borrar_estado
	NULL, --fieldset_fin
	NULL, --check_valor_si
	NULL, --check_valor_no
	NULL, --check_desc_si
	NULL, --check_desc_no
	NULL, --check_ml_toggle
	NULL, --fijo_sin_estado
	NULL, --editor_ancho
	NULL, --editor_alto
	NULL, --editor_botonera
	NULL, --selec_cant_minima
	NULL, --selec_cant_maxima
	NULL, --selec_utilidades
	NULL, --selec_tamano
	NULL, --selec_ancho
	NULL, --selec_serializar
	NULL, --selec_cant_columnas
	NULL, --upload_extensiones
	NULL, --punto_montaje
	NULL  --placeholder
);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_fila, objeto_ei_formulario, objeto_ei_formulario_proyecto, identificador, elemento_formulario, columnas, obligatorio, oculto_relaja_obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, permitir_html, deshabilitar_rest_func, estado_defecto, solo_lectura, solo_lectura_modificacion, carga_metodo, carga_clase, carga_include, carga_dt, carga_consulta_php, carga_sql, carga_fuente, carga_lista, carga_col_clave, carga_col_desc, carga_maestros, carga_cascada_relaj, cascada_mantiene_estado, carga_permite_no_seteado, carga_no_seteado, carga_no_seteado_ocultar, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, edit_confirmar_clave, edit_expreg, popup_item, popup_proyecto, popup_editable, popup_ventana, popup_carga_desc_metodo, popup_carga_desc_clase, popup_carga_desc_include, popup_puede_borrar_estado, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, check_ml_toggle, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano, selec_ancho, selec_serializar, selec_cant_columnas, upload_extensiones, punto_montaje, placeholder) VALUES (
	'1002000082', --objeto_ei_formulario_fila
	'1002000066', --objeto_ei_formulario
	'extension', --objeto_ei_formulario_proyecto
	'fec_hasta', --identificador
	'ef_editable_fecha', --elemento_formulario
	'fec_hasta', --columnas
	'0', --obligatorio
	'0', --oculto_relaja_obligatorio
	'11', --orden
	'Fecha Fin del Proyecto', --etiqueta
	NULL, --etiqueta_estilo
	NULL, --descripcion
	NULL, --colapsado
	NULL, --desactivado
	NULL, --estilo
	NULL, --total
	NULL, --inicializacion
	NULL, --permitir_html
	NULL, --deshabilitar_rest_func
	NULL, --estado_defecto
	NULL, --solo_lectura
	'0', --solo_lectura_modificacion
	NULL, --carga_metodo
	NULL, --carga_clase
	NULL, --carga_include
	NULL, --carga_dt
	NULL, --carga_consulta_php
	NULL, --carga_sql
	NULL, --carga_fuente
	NULL, --carga_lista
	NULL, --carga_col_clave
	NULL, --carga_col_desc
	NULL, --carga_maestros
	NULL, --carga_cascada_relaj
	'0', --cascada_mantiene_estado
	'0', --carga_permite_no_seteado
	NULL, --carga_no_seteado
	NULL, --carga_no_seteado_ocultar
	NULL, --edit_tamano
	NULL, --edit_maximo
	NULL, --edit_mascara
	NULL, --edit_unidad
	NULL, --edit_rango
	NULL, --edit_filas
	NULL, --edit_columnas
	NULL, --edit_wrap
	NULL, --edit_resaltar
	NULL, --edit_ajustable
	NULL, --edit_confirmar_clave
	NULL, --edit_expreg
	NULL, --popup_item
	NULL, --popup_proyecto
	NULL, --popup_editable
	NULL, --popup_ventana
	NULL, --popup_carga_desc_metodo
	NULL, --popup_carga_desc_clase
	NULL, --popup_carga_desc_include
	NULL, --popup_puede_borrar_estado
	NULL, --fieldset_fin
	NULL, --check_valor_si
	NULL, --check_valor_no
	NULL, --check_desc_si
	NULL, --check_desc_no
	NULL, --check_ml_toggle
	NULL, --fijo_sin_estado
	NULL, --editor_ancho
	NULL, --editor_alto
	NULL, --editor_botonera
	NULL, --selec_cant_minima
	NULL, --selec_cant_maxima
	NULL, --selec_utilidades
	NULL, --selec_tamano
	NULL, --selec_ancho
	NULL, --selec_serializar
	NULL, --selec_cant_columnas
	NULL, --upload_extensiones
	NULL, --punto_montaje
	NULL  --placeholder
);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_fila, objeto_ei_formulario, objeto_ei_formulario_proyecto, identificador, elemento_formulario, columnas, obligatorio, oculto_relaja_obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, permitir_html, deshabilitar_rest_func, estado_defecto, solo_lectura, solo_lectura_modificacion, carga_metodo, carga_clase, carga_include, carga_dt, carga_consulta_php, carga_sql, carga_fuente, carga_lista, carga_col_clave, carga_col_desc, carga_maestros, carga_cascada_relaj, cascada_mantiene_estado, carga_permite_no_seteado, carga_no_seteado, carga_no_seteado_ocultar, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, edit_confirmar_clave, edit_expreg, popup_item, popup_proyecto, popup_editable, popup_ventana, popup_carga_desc_metodo, popup_carga_desc_clase, popup_carga_desc_include, popup_puede_borrar_estado, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, check_ml_toggle, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano, selec_ancho, selec_serializar, selec_cant_columnas, upload_extensiones, punto_montaje, placeholder) VALUES (
	'1002000085', --objeto_ei_formulario_fila
	'1002000066', --objeto_ei_formulario
	'extension', --objeto_ei_formulario_proyecto
	'denominacion', --identificador
	'ef_fijo', --elemento_formulario
	'denominacion', --columnas
	'0', --obligatorio
	'0', --oculto_relaja_obligatorio
	'12', --orden
	'Titulo del Proyecto', --etiqueta
	NULL, --etiqueta_estilo
	NULL, --descripcion
	NULL, --colapsado
	NULL, --desactivado
	NULL, --estilo
	NULL, --total
	NULL, --inicializacion
	NULL, --permitir_html
	NULL, --deshabilitar_rest_func
	NULL, --estado_defecto
	NULL, --solo_lectura
	'0', --solo_lectura_modificacion
	NULL, --carga_metodo
	NULL, --carga_clase
	NULL, --carga_include
	NULL, --carga_dt
	NULL, --carga_consulta_php
	NULL, --carga_sql
	NULL, --carga_fuente
	NULL, --carga_lista
	NULL, --carga_col_clave
	NULL, --carga_col_desc
	NULL, --carga_maestros
	NULL, --carga_cascada_relaj
	'0', --cascada_mantiene_estado
	'0', --carga_permite_no_seteado
	NULL, --carga_no_seteado
	NULL, --carga_no_seteado_ocultar
	NULL, --edit_tamano
	NULL, --edit_maximo
	NULL, --edit_mascara
	NULL, --edit_unidad
	NULL, --edit_rango
	NULL, --edit_filas
	NULL, --edit_columnas
	NULL, --edit_wrap
	NULL, --edit_resaltar
	NULL, --edit_ajustable
	NULL, --edit_confirmar_clave
	NULL, --edit_expreg
	NULL, --popup_item
	NULL, --popup_proyecto
	NULL, --popup_editable
	NULL, --popup_ventana
	NULL, --popup_carga_desc_metodo
	NULL, --popup_carga_desc_clase
	NULL, --popup_carga_desc_include
	NULL, --popup_puede_borrar_estado
	NULL, --fieldset_fin
	NULL, --check_valor_si
	NULL, --check_valor_no
	NULL, --check_desc_si
	NULL, --check_desc_no
	NULL, --check_ml_toggle
	NULL, --fijo_sin_estado
	NULL, --editor_ancho
	NULL, --editor_alto
	NULL, --editor_botonera
	NULL, --selec_cant_minima
	NULL, --selec_cant_maxima
	NULL, --selec_utilidades
	NULL, --selec_tamano
	NULL, --selec_ancho
	NULL, --selec_serializar
	NULL, --selec_cant_columnas
	NULL, --upload_extensiones
	NULL, --punto_montaje
	NULL  --placeholder
);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_fila, objeto_ei_formulario, objeto_ei_formulario_proyecto, identificador, elemento_formulario, columnas, obligatorio, oculto_relaja_obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, permitir_html, deshabilitar_rest_func, estado_defecto, solo_lectura, solo_lectura_modificacion, carga_metodo, carga_clase, carga_include, carga_dt, carga_consulta_php, carga_sql, carga_fuente, carga_lista, carga_col_clave, carga_col_desc, carga_maestros, carga_cascada_relaj, cascada_mantiene_estado, carga_permite_no_seteado, carga_no_seteado, carga_no_seteado_ocultar, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, edit_confirmar_clave, edit_expreg, popup_item, popup_proyecto, popup_editable, popup_ventana, popup_carga_desc_metodo, popup_carga_desc_clase, popup_carga_desc_include, popup_puede_borrar_estado, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, check_ml_toggle, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano, selec_ancho, selec_serializar, selec_cant_columnas, upload_extensiones, punto_montaje, placeholder) VALUES (
	'1002000112', --objeto_ei_formulario_fila
	'1002000066', --objeto_ei_formulario
	'extension', --objeto_ei_formulario_proyecto
	'integrante', --identificador
	'ef_combo', --elemento_formulario
	'integrante', --columnas
	'0', --obligatorio
	'0', --oculto_relaja_obligatorio
	'14', --orden
	'Becario', --etiqueta
	NULL, --etiqueta_estilo
	NULL, --descripcion
	'0', --colapsado
	'1', --desactivado
	NULL, --estilo
	NULL, --total
	NULL, --inicializacion
	'0', --permitir_html
	'0', --deshabilitar_rest_func
	NULL, --estado_defecto
	'0', --solo_lectura
	'0', --solo_lectura_modificacion
	'get_descripciones', --carga_metodo
	NULL, --carga_clase
	NULL, --carga_include
	'1001000174', --carga_dt
	NULL, --carga_consulta_php
	NULL, --carga_sql
	'designa', --carga_fuente
	NULL, --carga_lista
	'nro_docum', --carga_col_clave
	'nombre', --carga_col_desc
	NULL, --carga_maestros
	'0', --carga_cascada_relaj
	'0', --cascada_mantiene_estado
	'1', --carga_permite_no_seteado
	'--Seleccione--', --carga_no_seteado
	'0', --carga_no_seteado_ocultar
	NULL, --edit_tamano
	NULL, --edit_maximo
	NULL, --edit_mascara
	NULL, --edit_unidad
	NULL, --edit_rango
	NULL, --edit_filas
	NULL, --edit_columnas
	NULL, --edit_wrap
	NULL, --edit_resaltar
	NULL, --edit_ajustable
	NULL, --edit_confirmar_clave
	NULL, --edit_expreg
	NULL, --popup_item
	NULL, --popup_proyecto
	NULL, --popup_editable
	NULL, --popup_ventana
	NULL, --popup_carga_desc_metodo
	NULL, --popup_carga_desc_clase
	NULL, --popup_carga_desc_include
	NULL, --popup_puede_borrar_estado
	NULL, --fieldset_fin
	NULL, --check_valor_si
	NULL, --check_valor_no
	NULL, --check_desc_si
	NULL, --check_desc_no
	NULL, --check_ml_toggle
	NULL, --fijo_sin_estado
	NULL, --editor_ancho
	NULL, --editor_alto
	NULL, --editor_botonera
	NULL, --selec_cant_minima
	NULL, --selec_cant_maxima
	NULL, --selec_utilidades
	NULL, --selec_tamano
	NULL, --selec_ancho
	NULL, --selec_serializar
	NULL, --selec_cant_columnas
	NULL, --upload_extensiones
	'1001000004', --punto_montaje
	NULL  --placeholder
);
--- FIN Grupo de desarrollo 1002
