CREATE TABLE statusKode
(
	statusKodeId INT NOT NULL, 
	navn VARCHAR(45),
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	opprettet DATETIME NOT NULL,
	CONSTRAINT pk_statusKode PRIMARY KEY (statusKodeId),
);


CREATE TABLE billettType
(
	billettTypeId INT NOT NULL,
	navn VARCHAR(45),
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	opprettet DATETIME NOT NULL,
	statusKodeId INT NOT NULL,
	CONSTRAINT pk_billettype PRIMARY KEY (billettTypeId),
	CONSTRAINT fk_billettype1 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);

CREATE TABLE fly
(
	flyId INT NOT NULL,
	flyNr VARCHAR(45),
	modell VARCHAR(45),
	type VARCHAR(45),
	plasser INT,
	laget DATE,
	startet DATE,
	opprettet NOT NULL DEFAULT CURRENT_TIMESTAMP,
	statusKodeId INT NOT NULL,
	CONSTRAINT pk_fly PRIMARY KEY (flyId),
	CONSTRAINT fk_fly1 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);

CREATE TABLE flyplass
(
	flyplassId INT NOT NULL,
	navn VARCHAR(45),
	land VARCHAR(45),
	statusKodeId INT NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	opprettet DATETIME NOT NULL,
	CONSTRAINT pk_flyplass PRIMARY KEY (flyplassId),
	CONSTRAINT fk_flypass1 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);

CREATE TABLE reiseType
(
	reiseTypeId INT NOT NULL,
	navn VARCHAR(45),
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	opprettet DATETIME NOT NULL,
	statusKodeId INT NOT NULL,
	CONSTRAINT pk_reiseType PRIMARY KEY (reiseTypeId),
	CONSTRAINT fk_reiseType FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);

CREATE TABLE reise
(
	reiseId INT NOT NULL,
	reiseFra VARCHAR(45),
	reiseTil VARCHAR(45),
	utreiseDato DATE,
	reiseTypeId INT NOT NULL,
	returDato DATE,
	voksne INT,
	barn INT,
	statusKodeId INT NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	opprettet DATETIME NOT NULL,
	CONSTRAINT pk_reise PRIMARY KEY (reiseId),
	CONSTRAINT fk_reise1 FOREIGN KEY (reiseTypeId) REFERENCES reiseType (reiseTypeId),
	CONSTRAINT fk_reise2 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);

CREATE TABLE kunde 
(
	kundeId INT NOT NULL,
	fornavn NOT NULL VARCHAR(45),
	etternavn NOT NULL VARCHAR(45),
	epost NOT NULL VARCHAR(45),
	tlf NOT NULL VARCHAR(45),
	fødselsdato NOT NULL DATE,
	kjønn VARCHAR(45),
	passord NOT NULL VARCHAR(45),
	salt NOT NULL VARCHAR(45),
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	opprettet DATETIME NOT NULL,
	statusKodeId INT NOT NULL, 
	CONSTRAINT pk_kunde PRIMARY KEY (kundeId),
	CONSTRAINT fk_kunde1 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);

CREATE TABLE flyvningstype
(
	flyvningstypeId INT NOT NULL,
	navn VARCHAR(500),
	statusKodeId INT NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	opprettet DATETIME NOT NULL,
	CONSTRAINT pk_flyvningstype PRIMARY KEY (flyvningstypeId);
	CONSTRAINT fk_flyvningstype FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);

CREATE TABLE flyvning
(
	flyvningId INT NOT NULL,
	linkId INT, 
	flyvningsTypeId INT,
	flyId INT NOT NULL, 
	fraFlyplassId INT NOT NULL,
	tilFlyplassId INT NOT NULL,
	dato DATE,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	opprettet DATETIME NOT NULL,
	statusKodeId INT NOT NULL,
	CONSTRAINT pk_flyvning PRIMARY KEY (flyvningId),
	CONSTRAINT fk_flyvning1 FOREIGN KEY (flyvningsTypeId) REFERENCES flyvningType (flyvningsTypeId),
	CONSTRAINT fk_flyvning2 FOREIGN KEY (flyId) REFERENCES fly (flyId),
	CONSTRAINT fk_flyvning3 FOREIGN KEY (fraFlyplassId) REFERENCES flyplass (flyplassId),
	CONSTRAINT fk_flyvning4 FOREIGN KEY (tilFlyplassId) REFERENCES flyplass (flyplassId),
	CONSTRAINT fk_flyvning5 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);

CREATE TABLE destinasjon
(
	destinasjonId INT NOT NULL,
	navn VARCHAR(500),
	flyplassId INT NOT NULL,
	aktivFra NOT NULL DATE,
	aktivTil NOT NULL DATE,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	opprettet DATETIME NOT NULL,
	statusKodeId INT NOT NULL,
	CONSTRAINT pk_destinasjon PRIMARY KEY (destinasjonId),
	CONSTRAINT fk_destinasjon1 FOREIGN KEY (flyplassId) REFERENCES flyplass (flyplassId),
	CONSTRAINT fk_destinasjon2 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodkeId)
);


CREATE TABLE bruker 
(
	brukerId INT NOT NULL,
	navn VARCHAR(45),
	brukertypeId INT NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	opprettet DATETIME NOT NULL,
	statusKodeId INT NOT NULL,
	CONSTRAINT pk_bruker PRIMARY KEY (brukerId),
	CONSTRAINT fk_bruker1 FOREIGN KEY (brukertypeId) REFERENCES brukerType (brukertypeId),
	CONSTRAINT fk_bruker2 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);

CREATE TABLE brukerType
(
	brukertypeId INT NOT NULL,
	navn VARCHAR(45)
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	opprettet DATETIME NOT NULL,
	statusKodeId INT NOT NULL, 
	CONSTRAINT pk_brukerType PRIMARY KEY (brukertypeId),
	CONSTRAINT fk_brukerType FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);


CREATE TABLE logg 
(
	loggId INT NOT NULL,
	nivaa VARCHAR (500),
	melding VARCHAR (500),
	modul VARCHAR (500), 
	brukerId INT NOT NULL, 
	opprettet NOT NULL DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT pk_logg PRIMARY KEY (loggId),
	CONSTRAINT fk_logg1 FOREIGN KEY (brukerId) REFERENCES bruker (brukerId)
);


CREATE TABLE rute
(
	idRuter INT NOT NULL,
	hovedRute INT,
	fraFlyplassId INT NOT NULL,
	tilFlyplassId INT NOT NULL,
	aktivFra NOT NULL DATE,
	aktivTil NOT NULL DATE,
	reiseTid DECIMAL(2,0),
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	opprettet DATETIME NOT NULL,
	statusKodeId INT NOT NULL,
	CONSTRAINT pk_ruter PRIMARY KEY (idRuter),
	CONSTRAINT fk_ruter1 FOREIGN KEY (fraFlyplassId) REFERENCES destinasjon (flyplassId),
	CONSTRAINT fk_ruter2 FOREIGN KEY (tilfyplassId) REFERENCES destinasjon (flyplassId),
	CONSTRAINT fk_ruter3 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);

CREATE TABLE pris
(
	prisId INT NOT NULL,
	reiseId INT NOT NULL,
	fraDato DATE,
	pris DECIMAL(12,2)
	reiseTypeId INT NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	opprettet DATETIME NOT NULL,
	statusKodeId INT NOT NULL,
	CONSTRAINT pk_pris PRIMARY KEY (prisId),
	CONSTRAINT fk_pris1 FOREIGN KEY (reiseId) REFERENCES reise (reiseId),
	CONSTRAINT fk_pris2 FOREIGN KEY (reiseTypeId) REFERENCES reiseType (reiseTypeId),
	CONSTRAINT fk_pris3 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);

CREATE TABLE prishistorikk 
(
	prisHistorikkId INT NOT NULL,
	reiseId INT NOT NULL,
	fraDato DATE,
	reiseTypeId INT NOT NULL,
	dato DATE,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	opprettet DATETIME NOT NULL,
	statusKodeId INT NOT NULL,
	CONSTRAINT pk_prishistorikk PRIMARY KEY (prisHistorikkId),
	CONSTRAINT fk_prishistorikk1 FOREIGN KEY (reiseId) REFERENCES reise (reiseId),
	CONSTRAINT fk_prishistorikk2 FOREIGN KEY (reiseTypeId) REFERENCES reiseType (reiseTypeId),
	CONSTRAINT fk_prishistorikk3 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)
);

CREATE TABLE billett
(
	billettId INT NOT NULL,
	reiseId INT NOT NULL,
	kundeId INT NOT NULL,
	prisId INT NOT NULL,
	billettTypeId INT NOT NULL,
	antBagasje INT,
	datoTid DATETIME,
	statusKodeId INT NOT NULL,
	CONSTRAINT pk_billett PRIMARY KEY (billettId),
	CONSTRAINT  fk_billett1 FOREIGN KEY (reiseId) REFERENCES reise (reiseId),
	CONSTRAINT fk_billett2 FOREIGN KEY (kundeId) REFERENCES kunde (kundeId),
	CONSTRAINT fk_billett3 FOREIGN KEY (prisId) REFERENCES pris (prisId),
	CONSTRAINT fk_billett4 FOREIGN KEY (billettTypeId) REFERENCES billettType (billettTypeId),
	CONSTRAINT fk_billett5 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId),
);

CREATE TABLE logg 
(
	loggId INT NOT NULL,
	nivaa VARCHAR (500),
	melding VARCHAR (500),
	modul VARCHAR (500), 
	brukerId INT NOT NULL, 
	opprettet NOT NULL DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT pk_logg PRIMARY KEY (loggId),
	CONSTRAINT fk_logg1 FOREIGN KEY (brukerId) REFERENCES bruker (brukerId)
);