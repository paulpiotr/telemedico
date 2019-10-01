--
-- PostgreSQL database dump
--

-- Dumped from database version 10.10 (Ubuntu 10.10-1.pgdg18.04+1)
-- Dumped by pg_dump version 10.10 (Ubuntu 10.10-1.pgdg18.04+1)

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

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: migration_versions; Type: TABLE; Schema: public; Owner: telemedico
--

CREATE TABLE public.migration_versions (
    version character varying(14) NOT NULL,
    executed_at timestamp(0) without time zone NOT NULL
);


ALTER TABLE public.migration_versions OWNER TO telemedico;

--
-- Name: COLUMN migration_versions.executed_at; Type: COMMENT; Schema: public; Owner: telemedico
--

COMMENT ON COLUMN public.migration_versions.executed_at IS '(DC2Type:datetime_immutable)';


--
-- Name: user; Type: TABLE; Schema: public; Owner: telemedico
--

CREATE TABLE public."user" (
    id integer NOT NULL,
    email character varying(64) NOT NULL,
    password character varying(128) NOT NULL,
    created timestamp with time zone NOT NULL,
    roles json
);


ALTER TABLE public."user" OWNER TO telemedico;

--
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: telemedico
--

CREATE SEQUENCE public.user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_id_seq OWNER TO telemedico;

--
-- Data for Name: migration_versions; Type: TABLE DATA; Schema: public; Owner: telemedico
--

COPY public.migration_versions (version, executed_at) FROM stdin;
\.


--
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: telemedico
--

COPY public."user" (id, email, password, created, roles) FROM stdin;
2	paul.piotr@wp.pl	$2y$13$y1mu9Ov8VPoDFh1xTt0xvORRNWG5PHo6xOnNN83k3lrYYe0rZ0uhy	2019-09-30 12:46:57+02	["ROLE_USER"]
1	paul.piotr@gmail.com	$2y$13$Y93h4k.9N0TWaD/NCKLoe.rr1vrkpCeEPiMDvrrmftFGwKCHmGwt2	2019-09-27 20:31:06+02	["ROLE_USER"]
\.


--
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: telemedico
--

SELECT pg_catalog.setval('public.user_id_seq', 5, true);


--
-- Name: migration_versions migration_versions_pkey; Type: CONSTRAINT; Schema: public; Owner: telemedico
--

ALTER TABLE ONLY public.migration_versions
    ADD CONSTRAINT migration_versions_pkey PRIMARY KEY (version);


--
-- Name: user user_email_unique; Type: CONSTRAINT; Schema: public; Owner: telemedico
--

ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_email_unique UNIQUE (email);


--
-- Name: user user_pkey; Type: CONSTRAINT; Schema: public; Owner: telemedico
--

ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);


--
-- Name: user_email_index; Type: INDEX; Schema: public; Owner: telemedico
--

CREATE INDEX user_email_index ON public."user" USING btree (email);


--
-- PostgreSQL database dump complete
--

