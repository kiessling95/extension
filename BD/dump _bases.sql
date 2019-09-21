--
-- PostgreSQL database dump
--

-- Dumped from database version 11.5 (Ubuntu 11.5-1.pgdg18.04+1)
-- Dumped by pg_dump version 11.5 (Ubuntu 11.5-1.pgdg18.04+1)

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
-- Name: bases_convocatoria; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bases_convocatoria (
    id_bases integer NOT NULL,
    convocatoria character varying NOT NULL,
    objetivo character varying NOT NULL,
    eje_tematico character varying NOT NULL,
    destinatarios character varying NOT NULL,
    integrantes character varying NOT NULL,
    monto character varying NOT NULL,
    duracion character varying NOT NULL,
    fecha character varying NOT NULL,
    evaluacion character varying NOT NULL,
    adjudicacion character varying NOT NULL,
    consulta character varying NOT NULL,
    bases_titulo character varying NOT NULL,
    ordenanza character varying NOT NULL,
    tipo_convocatoria character varying
);


ALTER TABLE public.bases_convocatoria OWNER TO postgres;

--
-- Data for Name: bases_convocatoria; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.bases_convocatoria (id_bases, convocatoria, objetivo, eje_tematico, destinatarios, integrantes, monto, duracion, fecha, evaluacion, adjudicacion, consulta, bases_titulo, ordenanza, tipo_convocatoria) FROM stdin;
2018	Visto la Ordenanza Nº075/94 que regula la presentación, reglamentación y evaluación de los Poyectos de Extensión, cuyas características esenciales son constituir prácticas institucionales y comunitarias que vinculan a la Universidad con el medio social que la sustenta, basándose en el conocimiento científico, tecnológico y cultural para la transformación social, se presentan las siguientes Bases para la presentación de Proyectos de Extensión 2016, con ejecución 2017.	Los Proyectos de Extensión deberán articular el trabajo desde un enfoque territorial, estableciendo nexos y puentes de coordinación interinstitucional, bajo diversas formas organizadas de prácticas participativas, entre sujetos individuales y colectivos. Tendrán valor agregado aquellos equipos de extensión, que involucren un amplio espectro de participantes de la comunidad Universitaria. De\ntal manera, estudiantes, graduados, docentes, no docentes, profesionales, idóneos y actores sociales comprometidos en la construcción de un objetivo deseable, trabajarán por un período\nprevisto para lograr el impacto social planificado.\n \nEl diseño de este conjunto de prácticas de intervención territorial, deberá ser abordado desde los siguientes ejes transversales, tal como define Nirenberg, entre otros:\n\n* Sustentabilidad, ...se refiere a la posibilidad de arraigo y continuidad que tienen los proyectos, más allá del período de aporte subsidiado. Las estrategias para la sustentabilidad, son complejas y constituyen una construcción intencional desde la formulación y desde los inicios de formulación de un proyecto. (Nirenberg1)\n\n* Integralidad : ...se entiende por carácter integral, la inclusión de enfoques de la problemática social, lejos de los abordajes específicos que consideran los problemas en\nforma parcializada o fragmentada (Nirenberg2)\n\n* Carácter participativo : ...formas y metodologías de gestión que procuran incluir protagónicamente a los diversos actores, especialmente a los beneficiarios, en las diferentes etapas :desde la identificación del problema, la priorización de actividades, el destino de los recursos(...)la realización de acciones y la sistematización de la experiencia y evaluación.\n(Nirenberg3)\n\n* Perspectiva de género: durante el desarrollo de las prácticas extensionistas, se pondrá especial atención a la equidad e igualdad de género en los vínculos y responsabilidades.	Para esta convocatoria 2016, los ejes temáticos prioritarios para el desarrollo de las propuestas de\nacción serán los siguientes:\n\n* Derechos Económicos, Culturales y Sociales\n  - Hábitos Saludables\n  - Arte, Cultura y Diversidad\n  - Economía Social y Trabajo\n  - Educación e Inclusión social\n  - Desarrollo urbano y problemáticas ambientales\n* Nuevas Tecnologías\n  - Medios de Comunicación\n  - Innovación tecnológica\n* Derechos Humanos y Ciudadanía\n  - Memoria, Verdad y Justicia\n\nCada propuesta que se presente a la Convocatoria 2016 deberá indicar en detalle la pertenencia y/o adecuación del proyecto a alguno/s de estos ejes temáticos. Estos ejes temáticos no excluyen la presentación de proyectos en otras áreas o líneas de trabajo.	De la Convocatoria podrán participar todas las Unidades Académicas de la Universidad Nacional del Comahue que conformen Equipos de Extensión.	¿QUIENES PUEDEN PARTICIPAR?\n\nLos Proyectos de Extensión podrán ser conformados por estudiantes, graduados, docentes, no docentes, profesionales, idóneos y actores sociales comprometidos con el desarrollo de acciones que promuevan un impacto social destacable y concreto.\n\nEn particular, los Equipos de Extensión para presentar un Proyecto en la Convocatoria 2016 podrán conformarse de la siguiente manera:\n\n* Director: Docente Regular de la UNCo (de modo excepcional docente interino de la UNCo)\n* Co Director : Docente de la UNCo (de modo excepcional docente interino de la UNCo)\n* Equipo de Extensión:\n  - estudiantes (excluyente)\n  - docentes\n  - no docentes \n  - graduado\n  - otros integrantes (externos)	La asignación presupuestaria para la presente Convocatoria 2016 es por un total de $350.000.-, según lo aprobado por el Consejo Superior, y serán otorgados a los proyectos de extensión, distribuidos de la siguiente manera:\n\n* $320.000.- (91% del total) se distribuirá a 32 proyectos por un total de $10.000.- a cada uno.\n\n* $30.000.- (9% del total) como refuerzo presupuestario a los 10 proyectos mejor ponderados por $3.000.- a cada uno, según los criterios de evaluación priorizados.\n\nEl Consejo de Extensión podrá aprobar proyectos de extensión con o sin financiamiento luego de la conformación del Orden de Mérito correspondiente según el puntaje obtenido.	La ejecución de los Proyectos de Extensión de la Convocatoria tendrán una duración de un (1) año.	Los proyectos deberán ser presentados en 1 (una) copia en papel original firmada (carátula y formulario) y 1 (una) copia digital hasta el día 31 de octubre de 2016 en cada Unidad Académica, para solicitar el aval del Consejo Directivo correspondiente.\n\nPasada esa instancia, las Secretarías de Extensión de las Unidades Académicas deberán presentar en la Secretaría de Extensión Universitaria de la UNCo hasta el 11 de noviembre de 2016 los proyectos avalados y revisados para la evaluación posterior en el Consejo de Extensión de la Universidad Nacional del Comahue.	El Consejo de Extensión conformará Comisión/es para la evaluación y ponderación de las propuestas presentadas y conformará un Orden de Mérito de acuerdo al puntaje obtenido. La instancia evaluativa de los proyectos se dará en el marco del artículo N°6 de la Ordenanza N°075/94 "Artículo 60 : La aprobación del Proyecto por la Comisión Evaluadora, se hará en base al rédito social del Proyecto con especial atención a las siguientes pautas:\n\n* Vinculación con el medio.\n\n* Especificidad de la participación de la Uninversidad en el mismo.\n\n* Impacto sobre la sociedad que incluya la capacidad generación de autogestión en los destinatarios y el efecto multiplicador de la actividad de la Universidad.\n\n* Factibilidad.\n\n*  Políticas de promoción impulsadas por la Universidad Nacional del Comahue a través de la Secretaría de Extensión Universitaria.\n\n* Integración del equipo mayoritariamente por miembros de la Universidad Nacional del Comahue, de distintas Unidades Académicas (equipo interdisciplinario).\n\n* Constitución preferentemente heterogénea del equipo, con participación de docentes, no docentes, alumnos y graduados (equipos interclaustros ).\n\n* Contribución a la capacitación de los integrantes ...".\n\nPara esta convocatoria, se ponderarán especialmente como criterio de evaluación los siguientes items:\n\n* Articulación entre ejes temáticos\n\n* Conformación del equipo de extensión (de la universidad y de actores externos)\n\n* Articular la vinculación con distintas Unidades Académicas\n\n* Interdisciplinariedad\n\n* Integración Curricular. Articulación de los procesos de aprendizaje con acción en territorio\n\n* Articulación con proyectos de investigación\n\n* Articulación con otros organismos y organizaciones de la sociedad civil	Una vez establecido el Orden de Mérito por parte del Consejo de Extensión, se adjudicarán los proyectos de acuerdo a la distribución de fondos mencionada en el ítem correspondiente.\n\nEn caso que la propuesta presentada a la Convocatoria cuente con financiamiento externo de otras convocatorias (ejemplo, de la Secretaría de Políticas Universitarias), la asignación presupuestaria quedará a consideración del Consejo de Extensión.	En la Secretaría de Extensión Universitaria de la UNCo, por mail: seu.proyectos.unco@gmail.com con el Asunto: Convocatoria 2016 - Proyectos de Extensión	CONVOCATORIA 2016 (EJECUCIÓN 2017)	http://fadeweb.uncoma.edu.ar/extension/ord-0075-94.doc	Ordinaria
\.


--
-- Name: bases_convocatoria bases_convocatoria_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bases_convocatoria
    ADD CONSTRAINT bases_convocatoria_pkey PRIMARY KEY (id_bases);


--
-- PostgreSQL database dump complete
--

