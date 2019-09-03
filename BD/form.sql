--
-- PostgreSQL database dump
--

-- Dumped from database version 11.5 (Ubuntu 11.5-1.pgdg18.04+1)
-- Dumped by pg_dump version 11.5 (Ubuntu 11.5-1.pgdg18.04+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: form_pextension; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.form_pextension (
    nombre character varying NOT NULL,
    uni_acad character(5) NOT NULL,
    departamento integer NOT NULL,
    unidad_ejecutora character varying NOT NULL,
    domicilio_calle character varying NOT NULL,
    domicilio_numero integer NOT NULL,
    localidad character varying NOT NULL,
    provincia character varying NOT NULL,
    codigo_postal integer NOT NULL,
    telefono integer NOT NULL,
    denominacion character varying NOT NULL,
    palabras_claves character varying NOT NULL,
    id_formulario integer NOT NULL,
    id_destinatario character varying NOT NULL,
    caracteristica_situacion character varying NOT NULL,
    localizacion_geografica character(1) NOT NULL,
    id_problema_necesidad character varying NOT NULL,
    otro_aspecto_importante character varying NOT NULL,
    origen_situacion character varying NOT NULL,
    area_aspecto_involucrado character varying NOT NULL,
    relacion_situacion_problema character varying NOT NULL,
    id_recurso character varying NOT NULL,
    pronostico character varying NOT NULL,
    surgimiento_proyecto character varying NOT NULL,
    participante_en_idea character varying NOT NULL,
    informacion_basica character varying NOT NULL,
    antecedentes_participacion character varying NOT NULL,
    fundamentacion character varying NOT NULL,
    objetivos_generales_especificos character varying NOT NULL,
    meta character varying NOT NULL,
    marco_teorico character varying NOT NULL,
    metodologia character varying NOT NULL,
    impacto character varying NOT NULL,
    atividad character varying NOT NULL,
    cronograma character varying NOT NULL,
    apellido_director character varying NOT NULL,
    nombre_director character varying NOT NULL,
    titulo_director character varying NOT NULL,
    apellido_participante character varying NOT NULL,
    nombre_participante character(10) NOT NULL,
    carga_horaria_participante integer NOT NULL,
    nombre_institucion character(30) NOT NULL,
    personal_a_cargo character varying NOT NULL,
    carga_horaria_institucion integer NOT NULL,
    forma_participacion character varying NOT NULL,
    presupuesto character varying NOT NULL,
    fuente_financiamiento character varying NOT NULL,
    pase_patrimonial character varying NOT NULL,
    carga_horaria_director integer NOT NULL
);


ALTER TABLE public.form_pextension OWNER TO postgres;

--
-- Name: form_pextension_cronograma_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.form_pextension_cronograma_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.form_pextension_cronograma_seq OWNER TO postgres;

--
-- Name: form_pextension_cronograma_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.form_pextension_cronograma_seq OWNED BY public.form_pextension.cronograma;


--
-- Name: form_pextension_id_formulario_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.form_pextension_id_formulario_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.form_pextension_id_formulario_seq OWNER TO postgres;

--
-- Name: form_pextension_id_formulario_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.form_pextension_id_formulario_seq OWNED BY public.form_pextension.id_formulario;


--
-- Name: form_pextension_id_recurso_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.form_pextension_id_recurso_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.form_pextension_id_recurso_seq OWNER TO postgres;

--
-- Name: form_pextension_id_recurso_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.form_pextension_id_recurso_seq OWNED BY public.form_pextension.id_recurso;


--
-- Name: form_pextension_impacto_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.form_pextension_impacto_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.form_pextension_impacto_seq OWNER TO postgres;

--
-- Name: form_pextension_impacto_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.form_pextension_impacto_seq OWNED BY public.form_pextension.impacto;


--
-- Name: form_pextension id_formulario; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.form_pextension ALTER COLUMN id_formulario SET DEFAULT nextval('public.form_pextension_id_formulario_seq'::regclass);


--
-- Name: form_pextension id_recurso; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.form_pextension ALTER COLUMN id_recurso SET DEFAULT nextval('public.form_pextension_id_recurso_seq'::regclass);


--
-- Name: form_pextension impacto; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.form_pextension ALTER COLUMN impacto SET DEFAULT nextval('public.form_pextension_impacto_seq'::regclass);


--
-- Name: form_pextension form_pextension_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.form_pextension
    ADD CONSTRAINT form_pextension_pkey PRIMARY KEY (id_formulario);


--
-- Name: form_pextension form_pextension_departamento_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.form_pextension
    ADD CONSTRAINT form_pextension_departamento_fkey FOREIGN KEY (departamento) REFERENCES public.departamento(iddepto);


--
-- Name: form_pextension form_pextension_uni_acad_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.form_pextension
    ADD CONSTRAINT form_pextension_uni_acad_fkey FOREIGN KEY (uni_acad) REFERENCES public.unidad_acad(sigla);


--
-- PostgreSQL database dump complete
--

