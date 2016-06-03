CREATE TABLE statusKode
(
	statusKodeId INT NOT NULL AUTO_INCREMENT, 
	navn VARCHAR(45) NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_statusKode PRIMARY KEY (statusKodeId)
);

CREATE TABLE billettType
(
	billettTypeId INT NOT NULL AUTO_INCREMENT,
	navn VARCHAR(45) NOT NULL,
	statusKodeId INT NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_billetType PRIMARY KEY (billettTypeId),
	CONSTRAINT fk_billetType1 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);


CREATE TABLE fly
(
	flyId INT NOT NULL AUTO_INCREMENT,
	flyNr VARCHAR(45) NOT NULL,
	modell VARCHAR(45) NOT NULL,
	type VARCHAR(45) NOT NULL,
	plasser INT NOT NULL,
	aarsmodell CHAR (4) NOT NULL,
	statusKodeId INT NOT NULL,
	CONSTRAINT pk_fly PRIMARY KEY (flyId),
	CONSTRAINT fk_fly1 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);



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


CREATE TABLE reiseType
(
	reiseTypeId INT NOT NULL AUTO_INCREMENT,
	navn VARCHAR(45) NOT NULL,
	statusKodeId INT NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_reiseType PRIMARY KEY (reiseTypeId),
	CONSTRAINT fk_reiseType FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);



CREATE TABLE reise
(
	reiseId INT NOT NULL AUTO_INCREMENT,
	reiseFra VARCHAR(45) NOT NULL,
	reiseTil VARCHAR(45),
	utreiseDato DATE NOT NULL,
	reiseTypeId INT NOT NULL,
	returDato DATE,
	voksne INT NOT NULL,
	barn INT NOT NULL,
	statusKodeId INT NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_reise PRIMARY KEY (reiseId),
	CONSTRAINT fk_reise1 FOREIGN KEY (reiseTypeId) REFERENCES reiseType (reiseTypeId),
	CONSTRAINT fk_reise2 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);



CREATE TABLE flyvningsType
(
	flyvningsTypeId INT NOT NULL AUTO_INCREMENT,
	navn VARCHAR(500) NOT NULL,
	statusKodeId INT NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_flyvningsType PRIMARY KEY (flyvningsTypeId),
	CONSTRAINT fk_flyvningsType FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);



CREATE TABLE flyvning
(
	flyvningId INT NOT NULL AUTO_INCREMENT,
	linkId INT NOT NULL, 
	flyvningsTypeId INT NOT NULL,
	flyId INT NOT NULL, 
	fraFlyplassId INT NOT NULL,
	tilFlyplassId INT NOT NULL,
	dato DATE,
	statusKodeId INT NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_flyvning PRIMARY KEY (flyvningId),
	CONSTRAINT fk_flyvning1 FOREIGN KEY (flyvningsTypeId) REFERENCES flyvningsType (flyvningsTypeId),
	CONSTRAINT fk_flyvning2 FOREIGN KEY (flyId) REFERENCES fly (flyId),
	CONSTRAINT fk_flyvning3 FOREIGN KEY (fraFlyplassId) REFERENCES flyplass (flyplassId),
	CONSTRAINT fk_flyvning4 FOREIGN KEY (tilFlyplassId) REFERENCES flyplass (flyplassId),
	CONSTRAINT fk_flyvning5 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);



CREATE TABLE destinasjon
(
	destinasjonId INT NOT NULL AUTO_INCREMENT,
	navn VARCHAR(500) NOT NULL,
	flyplassId INT NOT NULL,
	statusKodeId INT NOT NULL,
	geo_lat DECIMAL (11, 8) NOT NULL,
	geo_lng DECIMAL(10, 8) NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_destinasjon PRIMARY KEY (destinasjonId),
	CONSTRAINT fk_destinasjon1 FOREIGN KEY (flyplassId) REFERENCES flyplass (flyplassId),
	CONSTRAINT fk_destinasjon2 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);

CREATE TABLE brukerType
(
	brukerTypeId INT NOT NULL AUTO_INCREMENT,
	navn VARCHAR(45) NOT NULL,
	opprettet DATETIME NOT NULL,
	statusKodeId INT NOT NULL, 
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_brukerType PRIMARY KEY (brukerTypeId),
	CONSTRAINT fk_brukerType FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);

CREATE TABLE tittel
(
	tittelId INT NOT NULL AUTO_INCREMENT, 
	navn VARCHAR(45) NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_tittel PRIMARY KEY (tittelId)
);


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
	statusKodeId INT NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_bruker PRIMARY KEY (brukerId),
	CONSTRAINT fk_bruker1 FOREIGN KEY (brukerTypeId) REFERENCES brukerType (brukerTypeId),
	CONSTRAINT fk_bruker2 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId),
	CONSTRAINT fk_bruker3 FOREIGN KEY (tittelId) REFERENCES tittel (tittelId)
);



CREATE TABLE rute
(
	ruterId INT NOT NULL AUTO_INCREMENT,
	hovedRute INT,
	fraFlyplassId INT NOT NULL,
	tilFlyplassId INT NOT NULL,
	aktivFra DATE NOT NULL,
	aktivTil DATE NOT NULL,
	reiseTid INT NOT NULL,
	statusKodeId INT NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_ruter PRIMARY KEY (ruterId),
	CONSTRAINT fk_ruter1 FOREIGN KEY (fraFlyplassId) REFERENCES destinasjon (flyplassId),
	CONSTRAINT fk_ruter2 FOREIGN KEY (tilFlyplassId) REFERENCES destinasjon (flyplassId),
	CONSTRAINT fk_ruter3 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);


CREATE TABLE pris
(
	prisId INT NOT NULL AUTO_INCREMENT,
	reiseId INT NOT NULL,
	fraDato DATE,
	pris DECIMAL(12,2),
	reiseTypeId INT NOT NULL,
	statusKodeId INT NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_pris PRIMARY KEY (prisId),
	CONSTRAINT fk_pris1 FOREIGN KEY (reiseId) REFERENCES reise (reiseId),
	CONSTRAINT fk_pris2 FOREIGN KEY (reiseTypeId) REFERENCES reiseType (reiseTypeId),
	CONSTRAINT fk_pris3 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);



CREATE TABLE prisHistorikk 
(
	prisHistorikkId INT NOT NULL AUTO_INCREMENT,
	reiseId INT NOT NULL,
	fraDato DATE,
	reiseTypeId INT NOT NULL,
	dato DATE,
	statusKodeId INT NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_prishistorikk PRIMARY KEY (prisHistorikkId),
	CONSTRAINT fk_prishistorikk1 FOREIGN KEY (reiseId) REFERENCES reise (reiseId),
	CONSTRAINT fk_prishistorikk2 FOREIGN KEY (reiseTypeId) REFERENCES reiseType (reiseTypeId),
	CONSTRAINT fk_prishistorikk3 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);


CREATE TABLE billett
(
	billettId INT NOT NULL AUTO_INCREMENT,
	reiseId INT NOT NULL,
	brukerId INT NOT NULL,
	prisId INT NOT NULL,
	billettTypeId INT NOT NULL,
	antBagasje INT NOT NULL,
	datoTid DATETIME,
	statusKodeId INT NOT NULL,
	CONSTRAINT pk_billett PRIMARY KEY (billettId),
	CONSTRAINT fk_billett1 FOREIGN KEY (reiseId) REFERENCES reise (reiseId),
	CONSTRAINT fk_billett2 FOREIGN KEY (brukerId) REFERENCES bruker (brukerId),
	CONSTRAINT fk_billett3 FOREIGN KEY (prisId) REFERENCES pris (prisId),
	CONSTRAINT fk_billett4 FOREIGN KEY (billettTypeId) REFERENCES billettType (billettTypeId),
	CONSTRAINT fk_billett5 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);


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


DROP TABLE logg, autentisering;
DROP TABLE flyvning, flyvningsType, billett, pris, prisHistorikk, rute, bruker, tittel, brukerType, destinasjon, reise, reiseType, fly, billettType, flyplass, statusKode; 


insert into statusKode (navn) values ('Opprettet');
insert into statusKode (navn) values ('Slettet');
​
insert into brukerType (navn,statusKodeId) Values ('Admin',1);
insert into brukerType (navn,statusKodeId) Values ('Kunde',1);
insert into brukerType (navn,statusKodeId) Values ('Ansatt',1);

insert into tittel (navn) values ('Hr.'),('Fru.'),('Dr.');