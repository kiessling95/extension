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



CREATE TABLE public.presupuesto_extension (
    id_presupuesto integer NOT NULL,
    id_pext integer NOT NULL,
    id_rubro_extension integer NOT NULL,
    concepto character varying,
    cantidad integer,
    monto real
);


ALTER TABLE public.presupuesto_extension OWNER TO postgres;



CREATE SEQUENCE public.presupuesto_extension_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.presupuesto_extension_id_seq OWNER TO postgres;



ALTER SEQUENCE public.presupuesto_extension_id_seq OWNED BY public.presupuesto_extension.id_pext;



ALTER TABLE ONLY public.presupuesto_extension
    ADD CONSTRAINT presupuesto_extension_pkey PRIMARY KEY (id_presupuesto, id_pext, id_rubro_extension);




ALTER TABLE ONLY public.presupuesto_extension
    ADD CONSTRAINT presupuesto_extension_id_pext_fkey FOREIGN KEY (id_pext) REFERENCES public.pextension(id_pext);



ALTER TABLE ONLY public.presupuesto_extension
    ADD CONSTRAINT presupuesto_extension_id_rubro_fkey FOREIGN KEY (id_rubro_extension) REFERENCES public.rubro_presup_extension(id_rubro_extension);


