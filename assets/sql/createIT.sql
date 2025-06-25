------------------------------------------------------------
--        Script Postgre 
------------------------------------------------------------



------------------------------------------------------------
-- Table: vesseltype
------------------------------------------------------------
CREATE TABLE public.vesseltype(
	type          INT  NOT NULL ,
	description   VARCHAR (32) NOT NULL  ,
	CONSTRAINT vesseltype_PK PRIMARY KEY (type)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: cluster
------------------------------------------------------------
CREATE TABLE public.cluster(
	num_cluster   INT  NOT NULL ,
	description   VARCHAR (32) NOT NULL  ,
	CONSTRAINT cluster_PK PRIMARY KEY (num_cluster)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: ship
------------------------------------------------------------
CREATE TABLE public.ship(
	MMSI          CHAR (9)  NOT NULL ,
	VesselName    VARCHAR (32) NOT NULL ,
	IMO           CHAR (7)  NOT NULL ,
	Length        FLOAT  NOT NULL ,
	Width         FLOAT  NOT NULL ,
	Draft         FLOAT  NOT NULL ,
	type          INT  NOT NULL ,
	num_cluster   INT  NOT NULL  ,
	CONSTRAINT ship_PK PRIMARY KEY (MMSI)

	,CONSTRAINT ship_vesseltype_FK FOREIGN KEY (type) REFERENCES public.vesseltype(type)
	,CONSTRAINT ship_cluster0_FK FOREIGN KEY (num_cluster) REFERENCES public.cluster(num_cluster)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: position
------------------------------------------------------------
CREATE TABLE public.position(
	id          SERIAL NOT NULL ,
	LAT         FLOAT8  NOT NULL ,
	LON         FLOAT8  NOT NULL ,
	Timestamp   TIMESTAMP  NOT NULL ,
	SOG         FLOAT  NOT NULL ,
	COG         FLOAT  NOT NULL ,
	Heading     FLOAT  NOT NULL ,
	Status      INT2  NOT NULL ,
	MMSI        CHAR (9)  NOT NULL  ,
	CONSTRAINT position_PK PRIMARY KEY (id)

	,CONSTRAINT position_ship_FK FOREIGN KEY (MMSI) REFERENCES public.ship(MMSI)
)WITHOUT OIDS;



