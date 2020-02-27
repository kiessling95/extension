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
-- Name: objetivo_especifico; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.objetivo_especifico (
    id_objetivo integer NOT NULL,
    descripcion character varying,
    id_plan_actividad integer,
    id_pext integer,
    meta character varying
);


ALTER TABLE public.objetivo_especifico OWNER TO postgres;

--
-- Name: objetivo_especifico_id_objetivo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.objetivo_especifico_id_objetivo_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.objetivo_especifico_id_objetivo_seq OWNER TO postgres;

--
-- Name: objetivo_especifico_id_objetivo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.objetivo_especifico_id_objetivo_seq OWNED BY public.objetivo_especifico.id_objetivo;


--
-- Name: objetivo_especifico id_objetivo; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.objetivo_especifico ALTER COLUMN id_objetivo SET DEFAULT nextval('public.objetivo_especifico_id_objetivo_seq'::regclass);


--
-- Name: objetivo_especifico objetivo_especifico_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.objetivo_especifico
    ADD CONSTRAINT objetivo_especifico_pkey PRIMARY KEY (id_objetivo);


--
-- Name: objetivo_especifico objetivo_especifico_id_pext_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.objetivo_especifico
    ADD CONSTRAINT objetivo_especifico_id_pext_fkey FOREIGN KEY (id_pext) REFERENCES public.pextension(id_pext);


--
-- PostgreSQL database dump complete
--

