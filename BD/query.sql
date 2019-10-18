ALTER TABLE pextension ADD COLUMN  eje_tematico character(20);

ALTER TABLE pextension ADD COLUMN descripcion_situacion character(200);

ALTER TABLE pextension ADD COLUMN caracterizacion_poblacion character(150);

ALTER TABLE pextension ADD COLUMN localizacion_geo character(20);

ALTER TABLE pextension ADD COLUMN antecedente_participacion character(200);

ALTER TABLE pextension ADD COLUMN importancia_necesidad character(200);

ALTER TABLE presupuesto_extension ADD COLUMN rubro character varying;

ALTER TABLE presupuesto_extension ADD COLUMN concepto character varying;

ALTER TABLE presupuesto_extension ADD COLUMN cantidad integer;

ALTER TABLE presupuesto_extension ADD COLUMN monto real;

ALTER TABLE presupuesto_extension ADD COLUMN cantidad integer;

ALTER TABLE presupuesto_extension ADD COLUMN id_presupuesto integer;

ALTER TABLE presupuesto_extension ADD COLUMN id_pext integer;

ALTER TABLE rubro_presup_extension ADD COLUMN id_rubro_extension integer;

ALTER TABLE rubro_presup_extension ADD COLUMN tipo character varying;
