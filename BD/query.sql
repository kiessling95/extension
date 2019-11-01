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



CREATE SEQUENCE public.rubro_presup_extension_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE ONLY public.rubro_presup_extension ALTER COLUMN id_rubro_extension SET DEFAULT nextval('public.rubro_presup_extension_seq'::regclass);

CREATE SEQUENCE public.presupuesto_extension_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE ONLY public.presupuesto_extension ALTER COLUMN id_presupuesto SET DEFAULT nextval('public.presupuesto_extension_seq'::regclass);


INSERT INTO rubro_presup_extension ( tipo ) VALUES ('pantalla')

ALTER TABLE organizaciones_participantes ADD COLUMN domicilio character varying;
