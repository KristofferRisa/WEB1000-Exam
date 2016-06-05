DROP TABLE bruker, billett, bestilling, kunde, sete, prisKategori, avgang, rute, sesong, destinasjon, flyplass, fly;



CREATE TABLE fly
(
	flyId INT NOT NULL AUTO_INCREMENT,
	flyNr VARCHAR(45) NOT NULL,
	flyModell VARCHAR(45) NOT NULL,
	type VARCHAR(45) NOT NULL,
	plasser INT NOT NULL,
	aarsmodell CHAR (4) NOT NULL,
    endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_fly PRIMARY KEY (flyId)
);

CREATE TABLE flyplass
(
	flyplassId INT NOT NULL AUTO_INCREMENT,
	navn VARCHAR(45) NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_flyplass PRIMARY KEY (flyplassId)
);


CREATE TABLE destinasjon
(
	destinasjonId INT NOT NULL AUTO_INCREMENT,
	flyplassId INT NOT NULL,
	navn VARCHAR(500) NOT NULL,
    land varchar(500) NOT NULL, 
    landskode CHAR(2) NOT NULL,
    stedsnavn VARCHAR(100) NOT NULL,
	geo_lat DECIMAL (11, 8) NOT NULL,
	geo_lng DECIMAL(10, 8) NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_destinasjon PRIMARY KEY (destinasjonId),
	CONSTRAINT fk_destinasjon1 FOREIGN KEY (flyplassId) REFERENCES flyplass (flyplassId)
);


CREATE TABLE sesong
(
	sesongId INT NOT NULL AUTO_INCREMENT,
    navn varchar(200) NOT NULL,
    endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT pk_sesong PRIMARY KEY (sesongId)
);


CREATE TABLE rute
(
	ruteId INT NOT NULL AUTO_INCREMENT,
    fraDestId INT NOT NULL,
    tilDestId INT NOT NULL,
    sesongId INT NOT NULL,
	navn VARCHAR (45) NOT NULL,
    endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT pk_rute PRIMARY KEY (ruteId),
    CONSTRAINT fk_rute1 FOREIGN KEY (sesongId) REFERENCES sesong (sesongId),
    CONSTRAINT fk_rute2 FOREIGN KEY (fraDestId) REFERENCES destinasjon (destinasjonId),
    CONSTRAINT fk_rute3 FOREIGN KEY (tilDestId) REFERENCES destinasjon (destinasjonId)
);


CREATE TABLE avgang
(
	avgangId INT NOT NULL AUTO_INCREMENT,
    ruteId INT NOT NULL,
    fraFlyplassId INT NOT NULL,
    tilFlyplassId INT NOT NULL,
    direkte BIT NOT NULL,
    avgang DATETIME NOT NULL,
	reiseTid INT NOT NULL,
	ukedagNr INT NOT NULL,
	klokkeslett CHAR (5) NOT NULL, -- 00:00 
	fastpris DECIMAL (14,2) NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_avgang PRIMARY KEY (avgangId),
	CONSTRAINT fk_avgang1 FOREIGN KEY (ruteId) REFERENCES rute (ruteId),
	CONSTRAINT fk_avgang2 FOREIGN KEY (tilFlyplassId) REFERENCES flyplass (flyplassId),
	CONSTRAINT fk_avgang3 FOREIGN KEY (fraFlyplassId) REFERENCES flyplass (flyplassId)
);


CREATE TABLE prisKategori
(
	prisKategoriId INT NOT NULL AUTO_INCREMENT,
	navn VARCHAR (100) NOT NULL,
	prosentPaaslag INT,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_prisKategori PRIMARY KEY (prisKategoriId)
);


CREATE TABLE sete
(
	seteId INT NOT NULL AUTO_INCREMENT,
	flyId INT NOT NULL,
	prisKategoriId INT NOT NULL, 
    seteNr VARCHAR(10),
    nodutgang BIT NOT NULL,
	forklaring VARCHAR (100) NOT NULL, -- gang/midt/vindu
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT pk_sete PRIMARY KEY (seteId),
    CONSTRAINT fk_sete1 FOREIGN KEY (flyId) REFERENCES fly (flyId),
	CONSTRAINT fk_sete2 FOREIGN KEY (prisKategoriId) REFERENCES prisKategori (prisKategoriId)
);


CREATE TABLE bestilling
(
	bestillingId INT NOT NULL AUTO_INCREMENT,
	bestillingsDato CHAR (10) NOT NULL, -- 01/01/206
	refNo varchar(200) NOT NULL,
	reiseDato CHAR (10) NOT NULL, -- 01/01/2016
	returDato CHAR (10), -- 01/01/2016
	bestillerFornavn VARCHAR (50) NOT NULL,
	bestillerEtternavn VARCHAR (50) NOT NULL,
	bestillerEpost VARCHAR (100) NOT NULL,
	bestillerTlf VARCHAR (50) NOT NULL,
	antallVoksne INT NOT NULL,
	antallBarn INT NOT NULL,
	antallBebis INT NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_bestilling PRIMARY KEY (bestillingId)
);


CREATE TABLE billett
(
	billettId INT NOT NULL AUTO_INCREMENT,
	bestillingId INT NOT NULL,
	avgangId INT NOT NULL,
	seteId INT NOT NULL,
	fornavn VARCHAR(100) NOT NULL,
	etternavn VARCHAR(100) NOT NULL,
	kjonn VARCHAR (50),
	antBagasje INT NOT NULL,
	CONSTRAINT pk_billett PRIMARY KEY (billettId),
	CONSTRAINT fk_billett2 FOREIGN KEY (bestillingId) REFERENCES bestilling (bestillingId),
	CONSTRAINT fk_billett3 FOREIGN KEY (avgangId) REFERENCES avgang (avgangId),
	CONSTRAINT fk_billett4 FOREIGN KEY (seteId) REFERENCES sete (seteId)
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
	isAdmin VARCHAR (5) NOT NULL,
	endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT pk_bruker PRIMARY KEY (brukerId)
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


