--
-- PostgreSQL database dump
--

-- Dumped from database version 10.10 (Ubuntu 10.10-0ubuntu0.18.04.1)
-- Dumped by pg_dump version 10.10 (Ubuntu 10.10-0ubuntu0.18.04.1)

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
-- Name: tipo_organizacion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tipo_organizacion (
    descripcion character varying,
    id_tipo_organizacion integer NOT NULL
);


ALTER TABLE public.tipo_organizacion OWNER TO postgres;

--
-- Name: tipo_organizacion_id_organizacion_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tipo_organizacion_id_organizacion_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tipo_organizacion_id_organizacion_seq OWNER TO postgres;

--
-- Name: tipo_organizacion_id_organizacion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tipo_organizacion_id_organizacion_seq OWNED BY public.tipo_organizacion.id_tipo_organizacion;


--
-- Name: tipo_organizacion id_tipo_organizacion; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_organizacion ALTER COLUMN id_tipo_organizacion SET DEFAULT nextval('public.tipo_organizacion_id_organizacion_seq'::regclass);


--
-- Data for Name: tipo_organizacion; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tipo_organizacion VALUES ('Escuela', 1);
INSERT INTO public.tipo_organizacion VALUES ('ONG', 2);
INSERT INTO public.tipo_organizacion VALUES ('Sindicato', 3);
INSERT INTO public.tipo_organizacion VALUES ('Municipio', 4);
INSERT INTO public.tipo_organizacion VALUES ('Comision Vecinal', 5);
INSERT INTO public.tipo_organizacion VALUES ('Organismo Provincial', 6);
INSERT INTO public.tipo_organizacion VALUES ('Organismo Nacional', 7);


--
-- Name: tipo_organizacion_id_organizacion_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tipo_organizacion_id_organizacion_seq', 7, true);


--
-- Name: tipo_organizacion tipo_organizacion_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_organizacion
    ADD CONSTRAINT tipo_organizacion_pkey PRIMARY KEY (id_tipo_organizacion);


--
-- PostgreSQL database dump complete
--

