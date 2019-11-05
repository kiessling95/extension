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
-- Name: estado_pe; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.estado_pe (
    id_estado character(1) NOT NULL,
    descripcion character(30)
);


ALTER TABLE public.estado_pe OWNER TO postgres;

--
-- Name: estado_pe_descripcion_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.estado_pe_descripcion_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.estado_pe_descripcion_seq OWNER TO postgres;

--
-- Name: estado_pe_descripcion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.estado_pe_descripcion_seq OWNED BY public.estado_pe.descripcion;


--
-- Data for Name: estado_pe; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.estado_pe VALUES ('F', '	
Finalizado                  ');
INSERT INTO public.estado_pe VALUES ('I', '	
Inicial                     ');
INSERT INTO public.estado_pe VALUES ('A', '	
Activo                      ');
INSERT INTO public.estado_pe VALUES ('B', '	
Baja                        ');


--
-- Name: estado_pe_descripcion_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.estado_pe_descripcion_seq', 1, false);


--
-- Name: estado_pe estado_pe_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estado_pe
    ADD CONSTRAINT estado_pe_pkey PRIMARY KEY (id_estado);


--
-- PostgreSQL database dump complete
--

