--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'SQL_ASCII';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: matchups; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE matchups (
    hometeam text NOT NULL,
    awayteam text NOT NULL,
    "time" timestamp without time zone NOT NULL
);


ALTER TABLE public.matchups OWNER TO postgres;

--
-- Name: players; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE players (
    name text NOT NULL,
    "position" text NOT NULL,
    team text,
    summary text NOT NULL
);


ALTER TABLE public.players OWNER TO postgres;

--
-- Name: teams; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE teams (
    name text NOT NULL,
    location text NOT NULL,
    summary text NOT NULL
);


ALTER TABLE public.teams OWNER TO postgres;

--
-- Name: pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY matchups
    ADD CONSTRAINT pk PRIMARY KEY (hometeam, awayteam, "time");


--
-- Name: players_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY players
    ADD CONSTRAINT players_pkey PRIMARY KEY (name);


--
-- Name: teams_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY teams
    ADD CONSTRAINT teams_pkey PRIMARY KEY (name);


--
-- Name: matchups_awayteam_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY matchups
    ADD CONSTRAINT matchups_awayteam_fkey FOREIGN KEY (awayteam) REFERENCES teams(name);


--
-- Name: matchups_hometeam_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY matchups
    ADD CONSTRAINT matchups_hometeam_fkey FOREIGN KEY (hometeam) REFERENCES teams(name);


--
-- Name: players_team_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY players
    ADD CONSTRAINT players_team_fkey FOREIGN KEY (team) REFERENCES teams(name);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

