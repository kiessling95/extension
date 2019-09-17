
------------------------------------------------------------
-- apex_dimension_gatillo
------------------------------------------------------------

--- INICIO Grupo de desarrollo 1001
INSERT INTO apex_dimension_gatillo (proyecto, dimension, gatillo, tipo, orden, tabla_rel_dim, columnas_rel_dim, tabla_gatillo, ruta_tabla_rel_dim) VALUES (
	'extension', --proyecto
	'1001000001', --dimension
	'1001000001', --gatillo
	'directo', --tipo
	'1', --orden
	'unidad_acad', --tabla_rel_dim
	'sigla', --columnas_rel_dim
	NULL, --tabla_gatillo
	NULL  --ruta_tabla_rel_dim
);
INSERT INTO apex_dimension_gatillo (proyecto, dimension, gatillo, tipo, orden, tabla_rel_dim, columnas_rel_dim, tabla_gatillo, ruta_tabla_rel_dim) VALUES (
	'extension', --proyecto
	'1001000002', --dimension
	'1001000002', --gatillo
	'directo', --tipo
	'1', --orden
	'departamento', --tabla_rel_dim
	'iddepto', --columnas_rel_dim
	NULL, --tabla_gatillo
	NULL  --ruta_tabla_rel_dim
);
INSERT INTO apex_dimension_gatillo (proyecto, dimension, gatillo, tipo, orden, tabla_rel_dim, columnas_rel_dim, tabla_gatillo, ruta_tabla_rel_dim) VALUES (
	'extension', --proyecto
	'1001000003', --dimension
	'1001000003', --gatillo
	'directo', --tipo
	'1', --orden
	'mocovi_programa', --tabla_rel_dim
	'id_unidad', --columnas_rel_dim
	NULL, --tabla_gatillo
	NULL  --ruta_tabla_rel_dim
);
--- FIN Grupo de desarrollo 1001
