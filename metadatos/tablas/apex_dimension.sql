
------------------------------------------------------------
-- apex_dimension
------------------------------------------------------------

--- INICIO Grupo de desarrollo 1001
INSERT INTO apex_dimension (proyecto, dimension, nombre, descripcion, schema, tabla, col_id, col_desc, col_desc_separador, multitabla_col_tabla, multitabla_id_tabla, fuente_datos_proyecto, fuente_datos) VALUES (
	'extension', --proyecto
	'1001000004', --dimension
	'unidad_acad', --nombre
	'UA', --descripcion
	NULL, --schema
	'unidad_acad', --tabla
	'sigla', --col_id
	'sigla', --col_desc
	NULL, --col_desc_separador
	NULL, --multitabla_col_tabla
	NULL, --multitabla_id_tabla
	'extension', --fuente_datos_proyecto
	'designa'  --fuente_datos
);
INSERT INTO apex_dimension (proyecto, dimension, nombre, descripcion, schema, tabla, col_id, col_desc, col_desc_separador, multitabla_col_tabla, multitabla_id_tabla, fuente_datos_proyecto, fuente_datos) VALUES (
	'extension', --proyecto
	'1001000005', --dimension
	'departamento', --nombre
	NULL, --descripcion
	NULL, --schema
	'departamento', --tabla
	'iddepto', --col_id
	'descripcion', --col_desc
	NULL, --col_desc_separador
	NULL, --multitabla_col_tabla
	NULL, --multitabla_id_tabla
	'extension', --fuente_datos_proyecto
	'designa'  --fuente_datos
);
INSERT INTO apex_dimension (proyecto, dimension, nombre, descripcion, schema, tabla, col_id, col_desc, col_desc_separador, multitabla_col_tabla, multitabla_id_tabla, fuente_datos_proyecto, fuente_datos) VALUES (
	'extension', --proyecto
	'1001000006', --dimension
	'mocovi_programa', --nombre
	NULL, --descripcion
	NULL, --schema
	'mocovi_programa', --tabla
	'id_unidad', --col_id
	'id_unidad', --col_desc
	NULL, --col_desc_separador
	NULL, --multitabla_col_tabla
	NULL, --multitabla_id_tabla
	'extension', --fuente_datos_proyecto
	'designa'  --fuente_datos
);
--- FIN Grupo de desarrollo 1001
