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
-- Name: docente; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.docente (
    id_docente integer NOT NULL,
    email character varying,
    telefono integer
);


ALTER TABLE public.docente OWNER TO postgres;

--
-- Name: docente docente_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.docente
    ADD CONSTRAINT docente_pkey PRIMARY KEY (id_docente);


--
-- PostgreSQL database dump complete
--

