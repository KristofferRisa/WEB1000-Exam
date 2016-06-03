DROP TABLE IF EXISTS logg;
DROP TABLE IF EXISTS autentisering;
DROP TABLE IF EXISTS billett;
DROP TABLE IF EXISTS pris;
DROP TABLE IF EXISTS prisHistorikk;
DROP TABLE IF EXISTS billett;
DROP TABLE IF EXISTS bruker;
DROP TABLE IF EXISTS tittel;
DROP TABLE IF EXISTS brukerType;
DROP TABLE IF EXISTS destinasjon;
DROP TABLE IF EXISTS reise;
DROP TABLE IF EXISTS reiseType;
DROP TABLE IF EXISTS fly;
DROP TABLE IF EXISTS billettType;
DROP TABLE IF EXISTS flyplass;
DROP TABLE IF EXISTS statusKode;

/*
CREATE TABLE statusKode
(
	statusKodeId INT NOT NULL AUTO_INCREMENT, 
	navn VARCHAR(45) NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_statusKode PRIMARY KEY (statusKodeId)
);
*/

CREATE TABLE fly
(
	flyId INT NOT NULL AUTO_INCREMENT,
	flyNr VARCHAR(45) NOT NULL,
	modell VARCHAR(45) NOT NULL,
	type VARCHAR(45) NOT NULL,
	plasser INT NOT NULL,
	aarsmodell CHAR (4) NOT NULL,
    endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_fly PRIMARY KEY (flyId)
);
COMMIT;

CREATE TABLE flyplass
(
	flyplassId INT NOT NULL AUTO_INCREMENT,
	navn VARCHAR(45) NOT NULL,
	land VARCHAR(45) NOT NULL,
	statusKodeId INT NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_flyplass PRIMARY KEY (flyplassId),
	CONSTRAINT fk_flypass1 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);
COMMIT;

CREATE TABLE destinasjon
(
	destinasjonId INT NOT NULL AUTO_INCREMENT,
	navn VARCHAR(500) NOT NULL,
    land varchar(500) NOT NULL, 
    landskode CHAR(2) NOT NULL,
    stedsnavn VARCHAR(100) NOT NULL,
	flyplassId INT NOT NULL,
	geo_lat DECIMAL (11, 8) NOT NULL,
	geo_lng DECIMAL(10, 8) NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_destinasjon PRIMARY KEY (destinasjonId),
	CONSTRAINT fk_destinasjon1 FOREIGN KEY (flyplassId) REFERENCES flyplass (flyplassId)
);
COMMIT;

CREATE TABLE sesong
(
	sesongId INT NOT NULL AUTO_INCREMENT,
    navn varchar(200) NOT NULL,
    endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT pk_sesong PRIMARY KEY (sesongId)
);
COMMIT;

CREATE TABLE flyvning
(
	flyvningId INT NOT NULL AUTO_INCREMENT,
    fraDestId INT NOT NULL,
    tilDestId INT NOT NULL,
    sesongId INT NOT NULL,
    endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT pk_flyvning PRIMARY KEY (flyvningId),
    CONSTRAINT fk_sesong FOREIGN KEY (sesongId) REFERENCES sesong (sesongId),
    CONSTRAINT fk_fraDestId FOREIGN KEY (fraDestId) REFERENCES destinasjon (destinasjonId),
    CONSTRAINT fk_tilDestId FOREIGN KEY (tilDestId) REFERENCES destinasjon (destinasjonId)
);
COMMIT;

CREATE TABLE ruteTabell
(
	ruteTabellId INT NOT NULL AUTO_INCREMENT,
    flyvningId INT NOT NULL,
    flyId INT NOT NULL,
    direkte BIT NOT NULL,
    fraFlyplassId INT NOT NULL,
    tilFlyplassId INT NOT NULL,
    avgang DATETIME NOT NULL,
    aktivFra DATE NOT NULL,
	aktivTil DATE NOT NULL,
	reiseTid INT NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_ruterTabell PRIMARY KEY (ruterId),
	CONSTRAINT fk_ruterTabell1 FOREIGN KEY (fraFlyplassId) REFERENCES destinasjon (flyplassId),
	CONSTRAINT fk_ruterTabell2 FOREIGN KEY (tilFlyplassId) REFERENCES destinasjon (flyplassId)
);
COMMIT;

CREATE TABLE billettType
(
	billettTypeId INT NOT NULL AUTO_INCREMENT,
	navn VARCHAR(45) NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_billetType PRIMARY KEY (billettTypeId)
);
COMMIT;

CREATE TABLE sete
(
	seteId INT NOT NULL AUTO_INCREMENT,
    flyId INT NOT NULL,
    seteNr VARCHAR(10),
    isEmergency BIT NOT NULL,
    CONSTRAINT pk_sete PRIMARY KEY (seteId),
    CONSTRAINT fk_sete1 FOREIGN KEY (flyId) REFERENCES fly (flyId)
);
COMMIT;

/*
	FORTSETT HER!
*/

CREATE TABLE billett
(
	billettId INT NOT NULL AUTO_INCREMENT,
	brukerId INT NOT NULL,
	bestillerNavn VARCHAR (100) NOT NULL,
    ref varchar(200) NOT NULL,
	fornavn VARCHAR(100) NOT NULL,
	etternavn VARCHAR(100) NOT NULL,
	tlf VARCHAR(45),
	epost VARCHAR (60) NOT NULL,
	kjonn VARCHAR (50),
	tittelId INT,
	seteReservasjonId VARCHAR (20),
	antBagasje INT NOT NULL,
	datoTid DATETIME,
	prisId INT NOT NULL,
	billettTypeId INT NOT NULL,
	statusKodeId INT NOT NULL,
	CONSTRAINT pk_billett PRIMARY KEY (billettId),
	CONSTRAINT fk_billett2 FOREIGN KEY (brukerId) REFERENCES bruker (brukerId),
	CONSTRAINT fk_billett3 FOREIGN KEY (prisId) REFERENCES pris (prisId),
	CONSTRAINT fk_billett4 FOREIGN KEY (billettTypeId) REFERENCES billettType (billettTypeId),
	CONSTRAINT fk_billett5 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);


CREATE TABLE reiseType
(
	reiseTypeId INT NOT NULL AUTO_INCREMENT,
	navn VARCHAR(45) NOT NULL,
	statusKodeId INT NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_reiseType PRIMARY KEY (reiseTypeId),
	CONSTRAINT fk_reiseType FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);

/*
CREATE TABLE bestilling
(
	bestillingId INT NOT NULL AUTO_INCREMENT,
	bestiller VARCHAR (100) NOT NULL,
	reiseFra VARCHAR(45) NOT NULL,
	reiseTil VARCHAR(45),
	utreiseDato DATE NOT NULL,
	returDato DATE,
	reiseTypeId INT NOT NULL,
	voksne INT NOT NULL,
	barn INT NOT NULL,
	baby INT NOT NULL,
	statusKodeId INT NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_reise PRIMARY KEY (bestillingId),
	CONSTRAINT fk_reise1 FOREIGN KEY (reiseTypeId) REFERENCES reiseType (reiseTypeId),
	CONSTRAINT fk_reise2 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);
*/

CREATE TABLE tittel
(
	tittelId INT NOT NULL AUTO_INCREMENT, 
	navn VARCHAR(45) NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_tittel PRIMARY KEY (tittelId)
);
COMMIT;


CREATE TABLE bruker 
(
	brukerId INT NOT NULL AUTO_INCREMENT,
	brukernavn VARCHAR (100) NOT NULL UNIQUE,
	passord CHAR (60) NOT NULL,
	fornavn VARCHAR(45) NOT NULL,
	etternavn VARCHAR(45) NOT NULL,
	epost VARCHAR(45) NOT NULL,
	tlf VARCHAR(45),
	dob VARCHAR (45),
	kjonn VARCHAR (50),
	tittelId INT,
	brukerTypeId INT NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_bruker PRIMARY KEY (brukerId),
	CONSTRAINT fk_bruker1 FOREIGN KEY (brukerTypeId) REFERENCES brukerType (brukerTypeId),
	CONSTRAINT fk_bruker3 FOREIGN KEY (tittelId) REFERENCES tittel (tittelId)
);

CREATE TABLE pris
(
	prisId INT NOT NULL AUTO_INCREMENT,
	bestillingId INT NOT NULL,
	fraDato DATE,
	pris DECIMAL(12,2),
	reiseTypeId INT NOT NULL,
	statusKodeId INT NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_pris PRIMARY KEY (prisId),
	CONSTRAINT fk_pris1 FOREIGN KEY (bestillingId) REFERENCES bestilling (bestillingId),
	CONSTRAINT fk_pris2 FOREIGN KEY (reiseTypeId) REFERENCES reiseType (reiseTypeId),
	CONSTRAINT fk_pris3 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);



/*
	SYSTEM TABELLER
*/

CREATE TABLE autentisering
(
	autentiseringId INT NOT NULL,
	brukertypeId INT NOT NULL,
	sesjon_guide INT NOT NULL,
	utgårstidspunkt DATETIME NOT NULL,
	CONSTRAINT pk_autentisering PRIMARY KEY (autentiseringId),
	CONSTRAINT fk_autentisering1 FOREIGN KEY (brukertypeId) REFERENCES brukerType (brukertypeId)
);

CREATE TABLE logg 
(
	loggId INT NOT NULL AUTO_INCREMENT,
	nivaa VARCHAR (500),
	melding VARCHAR (500),
	modul VARCHAR (500), 
	bruker VARCHAR (50) NOT NULL, 
	opprettet TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT pk_logg PRIMARY KEY (loggId)
);
commit;


/*
	legger inn base data
 */

insert into statusKode (navn) values ('Opprettet');
insert into statusKode (navn) values ('Slettet');
​
insert into brukerType (navn,statusKodeId) Values ('Admin',1);
insert into brukerType (navn,statusKodeId) Values ('Kunde',1);
insert into brukerType (navn,statusKodeId) Values ('Ansatt',1);

insert into tittel (navn) values ('Hr.'),('Fru.'),('Dr.');