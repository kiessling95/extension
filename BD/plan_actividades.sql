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
-- Name: plan_actividades; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.plan_actividades (
    id_plan integer NOT NULL,
    detalle character varying,
    fecha date,
    localizacion character varying,
    destinatarios character varying,
    meta character varying,
    id_rubro_extension integer
);


ALTER TABLE public.plan_actividades OWNER TO postgres;

--
-- Name: plan_actividades_id_plan_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.plan_actividades_id_plan_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.plan_actividades_id_plan_seq OWNER TO postgres;

--
-- Name: plan_actividades_id_plan_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.plan_actividades_id_plan_seq OWNED BY public.plan_actividades.id_plan;


--
-- Name: plan_actividades id_plan; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.plan_actividades ALTER COLUMN id_plan SET DEFAULT nextval('public.plan_actividades_id_plan_seq'::regclass);


--
-- Name: plan_actividades plan_actividades_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.plan_actividades
    ADD CONSTRAINT plan_actividades_pkey PRIMARY KEY (id_plan);


--
-- PostgreSQL database dump complete
--

