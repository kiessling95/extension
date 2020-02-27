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
-- Name: rubro_presup_extension; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.rubro_presup_extension (
    id_rubro_extension integer NOT NULL,
    tipo character varying NOT NULL
);


ALTER TABLE public.rubro_presup_extension OWNER TO postgres;

--
-- Name: rubro_presup_extension rubro_presup_extension_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rubro_presup_extension
    ADD CONSTRAINT rubro_presup_extension_pkey PRIMARY KEY (id_rubro_extension);


--
-- PostgreSQL database dump complete
--

