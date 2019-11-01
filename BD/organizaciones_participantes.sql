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
-- Name: organizaciones_participantes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.organizaciones_participantes (
    nombre character varying,
    localidad character varying,
    provincia character varying,
    telefono integer,
    email character varying,
    referencia_vinculacion_inst character varying,
    id_pext integer NOT NULL,
    id_tipo_organizacion integer NOT NULL,
    id_organizacion integer NOT NULL
);


ALTER TABLE public.organizaciones_participantes OWNER TO postgres;

--
-- Name: organizaciones_participantes_email_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.organizaciones_participantes_email_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.organizaciones_participantes_email_seq OWNER TO postgres;

--
-- Name: organizaciones_participantes_email_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.organizaciones_participantes_email_seq OWNED BY public.organizaciones_participantes.email;


--
-- Name: organizaciones_participantes_id_organizacion_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.organizaciones_participantes_id_organizacion_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.organizaciones_participantes_id_organizacion_seq OWNER TO postgres;

--
-- Name: organizaciones_participantes_id_organizacion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.organizaciones_participantes_id_organizacion_seq OWNED BY public.organizaciones_participantes.id_organizacion;


--
-- Name: organizaciones_participantes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.organizaciones_participantes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.organizaciones_participantes_id_seq OWNER TO postgres;

--
-- Name: organizaciones_participantes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.organizaciones_participantes_id_seq OWNED BY public.organizaciones_participantes.id_pext;


--
-- Name: organizaciones_participantes id_organizacion; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organizaciones_participantes ALTER COLUMN id_organizacion SET DEFAULT nextval('public.organizaciones_participantes_id_organizacion_seq'::regclass);


--
-- Name: organizaciones_participantes organizaciones_participantes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organizaciones_participantes
    ADD CONSTRAINT organizaciones_participantes_pkey PRIMARY KEY (id_organizacion);


--
-- Name: organizaciones_participantes organizaciones_participantes_id_pext_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organizaciones_participantes
    ADD CONSTRAINT organizaciones_participantes_id_pext_fkey FOREIGN KEY (id_pext) REFERENCES public.pextension(id_pext);


--
-- Name: organizaciones_participantes organizaciones_participantes_id_tipo_organizacion_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organizaciones_participantes
    ADD CONSTRAINT organizaciones_participantes_id_tipo_organizacion_fkey FOREIGN KEY (id_tipo_organizacion) REFERENCES public.tipo_organizacion(id_tipo_organizacion);


--
-- PostgreSQL database dump complete
--

