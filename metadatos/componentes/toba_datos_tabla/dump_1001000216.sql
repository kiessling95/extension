------------------------------------------------------------
--[1001000216]--  DT - tipo 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 1001
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, punto_montaje, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'extension', --proyecto
	'1001000216', --objeto
	NULL, --anterior
	NULL, --identificador
	NULL, --reflexivo
	'toba', --clase_proyecto
	'toba_datos_tabla', --clase
	'1001000004', --punto_montaje
	'dt_tipo', --subclase
	'datos/dt_tipo.php', --subclase_archivo
	NULL, --objeto_categoria_proyecto
	NULL, --objeto_categoria
	'DT - tipo', --nombre
	NULL, --titulo
	NULL, --colapsable
	NULL, --descripcion
	'extension', --fuente_datos_proyecto
	'extension', --fuente_datos
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
	'2019-09-17 10:40:30', --creacion
	NULL  --posicion_botonera
);
--- FIN Grupo de desarrollo 1001

------------------------------------------------------------
-- apex_objeto_db_registros
------------------------------------------------------------
INSERT INTO apex_objeto_db_registros (objeto_proyecto, objeto, max_registros, min_registros, punto_montaje, ap, ap_clase, ap_archivo, tabla, tabla_ext, alias, modificar_claves, fuente_datos_proyecto, fuente_datos, permite_actualizacion_automatica, esquema, esquema_ext) VALUES (
	'extension', --objeto_proyecto
	'1001000216', --objeto
	NULL, --max_registros
	NULL, --min_registros
	'1001000004', --punto_montaje
	'1', --ap
	NULL, --ap_clase
	NULL, --ap_archivo
	'tipo', --tabla
	NULL, --tabla_ext
	NULL, --alias
	'0', --modificar_claves
	'extension', --fuente_datos_proyecto
	'extension', --fuente_datos
	'1', --permite_actualizacion_automatica
	'public', --esquema
	'public'  --esquema_ext
);

------------------------------------------------------------
-- apex_objeto_db_registros_col
------------------------------------------------------------

--- INICIO Grupo de desarrollo 1001
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'extension', --objeto_proyecto
	'1001000216', --objeto
	'1001000451', --col_id
	'nro_tabla', --columna
	'E', --tipo
	'1', --pk
	'', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'1', --no_nulo_db
	NULL, --externa
	'tipo'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'extension', --objeto_proyecto
	'1001000216', --objeto
	'1001000452', --col_id
	'desc_abrev', --columna
	'C', --tipo
	'1', --pk
	'', --secuencia
	'4', --largo
	NULL, --no_nulo
	'1', --no_nulo_db
	NULL, --externa
	'tipo'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'extension', --objeto_proyecto
	'1001000216', --objeto
	'1001000453', --col_id
	'desc_item', --columna
	'C', --tipo
	'0', --pk
	'', --secuencia
	'30', --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	NULL, --externa
	'tipo'  --tabla
);
--- FIN Grupo de desarrollo 1001
