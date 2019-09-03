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
-- Name: bases_convocatoria; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bases_convocatoria (
    id_bases integer NOT NULL,
    convocatoria character varying NOT NULL,
    objetivo character varying NOT NULL,
    eje_tematico character varying NOT NULL,
    destinatarios character varying NOT NULL,
    integrantes character varying NOT NULL,
    monto character varying NOT NULL,
    duracion character varying NOT NULL,
    fecha character varying NOT NULL,
    evaluacion character varying NOT NULL,
    adjudicacion character varying NOT NULL,
    consulta character varying NOT NULL,
    bases_titulo character varying NOT NULL,
    ordenanza character varying NOT NULL,
    tipo_convocatoria character varying
);


ALTER TABLE public.bases_convocatoria OWNER TO postgres;

--
-- Name: bases_convocatoria bases_convocatoria_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bases_convocatoria
    ADD CONSTRAINT bases_convocatoria_pkey PRIMARY KEY (id_bases);


--
-- PostgreSQL database dump complete
--

