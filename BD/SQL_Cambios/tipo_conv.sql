--
-- PostgreSQL database dump
--

-- Dumped from database version 11.5 (Ubuntu 11.5-3.pgdg18.04+1)
-- Dumped by pg_dump version 11.5 (Ubuntu 11.5-3.pgdg18.04+1)

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
-- Name: tipo_convocatoria; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tipo_convocatoria (
    id_conv character(1) NOT NULL,
    descripcion character(30)
);


ALTER TABLE public.tipo_convocatoria OWNER TO postgres;

--
-- Data for Name: tipo_convocatoria; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tipo_convocatoria VALUES ('O', 'Ordinaria                     ');


--
-- Name: tipo_convocatoria tipo_convocatoria_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_convocatoria
    ADD CONSTRAINT tipo_convocatoria_pkey PRIMARY KEY (id_conv);


--
-- PostgreSQL database dump complete
--

