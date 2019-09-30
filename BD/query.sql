ALTER TABLE pextension ADD COLUMN  eje_tematico character(20);

ALTER TABLE pextension ADD COLUMN descripcion_situacion character(200);

ALTER TABLE pextension ADD COLUMN caracterizacion_poblacion character(150);

ALTER TABLE pextension ADD COLUMN localizacion_geo character(20);

ALTER TABLE pextension ADD COLUMN antecedente_participacion character(200);

ALTER TABLE pextension ADD COLUMN importancia_necesidad character(200);

ALTER TABLE pextension ADD COLUMN rubro character varying;

ALTER TABLE pextension ADD COLUMN concepto character varying;

ALTER TABLE pextension ADD COLUMN cantidad integer;

ALTER TABLE pextension ADD COLUMN rubro_presupuestario character varying;

ALTER TABLE pextension ADD COLUMN total_rubro real;

ALTER TABLE pextension ADD COLUMN porcentaje real;
