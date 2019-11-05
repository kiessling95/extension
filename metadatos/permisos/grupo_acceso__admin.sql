
------------------------------------------------------------
-- apex_usuario_grupo_acc
------------------------------------------------------------
INSERT INTO apex_usuario_grupo_acc (proyecto, usuario_grupo_acc, nombre, nivel_acceso, descripcion, vencimiento, dias, hora_entrada, hora_salida, listar, permite_edicion, menu_usuario) VALUES (
	'extension', --proyecto
	'admin', --usuario_grupo_acc
	'Administrador', --nombre
	'0', --nivel_acceso
	'Accede a toda la funcionalidad', --descripcion
	NULL, --vencimiento
	NULL, --dias
	NULL, --hora_entrada
	NULL, --hora_salida
	NULL, --listar
	'1', --permite_edicion
	NULL  --menu_usuario
);

------------------------------------------------------------
-- apex_usuario_grupo_acc_item
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'extension', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'2'  --item
);
--- FIN Grupo de desarrollo 0

--- INICIO Grupo de desarrollo 1001
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'extension', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'1001000050'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'extension', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'1001000051'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'extension', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'1001000052'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'extension', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'1001000053'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'extension', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'1001000056'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'extension', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'1001000058'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'extension', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'1001000059'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'extension', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'1001000061'  --item
);
--- FIN Grupo de desarrollo 1001

--- INICIO Grupo de desarrollo 1002
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'extension', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'1002000004'  --item
);
--- FIN Grupo de desarrollo 1002
