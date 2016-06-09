DROP TABLE bruker, billett, bestilling, sete, prisKategori, avgang, destinasjon, flyplass, fly;



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
    landskode CHAR(2) NOT NULL,
    stedsnavn VARCHAR(100) NOT NULL,
    geo_lat DECIMAL (11, 8),
    geo_lng DECIMAL(10, 8),
    endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT pk_destinasjon PRIMARY KEY (destinasjonId),
    CONSTRAINT fk_destinasjon1 FOREIGN KEY (flyplassId) REFERENCES flyplass (flyplassId)
);


CREATE TABLE avgang
(
    avgangId INT NOT NULL AUTO_INCREMENT,
    flyId INT NOT NULL,
    fraDestId INT NOT NULL,
    tilDestId INT NOT NULL,
    dato DATE NOT NULL,
    direkte VARCHAR (5) NOT NULL,
    reiseTid CHAR (5) NOT NULL,
    klokkeslett CHAR (5) NOT NULL, -- 00:00 
    fastpris DECIMAL (14,2) NOT NULL,
    endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT pk_avgang PRIMARY KEY (avgangId),
    CONSTRAINT fk_avgang2 FOREIGN KEY (fraDestId) REFERENCES destinasjon (destinasjonId),
    CONSTRAINT fk_avgang3 FOREIGN KEY (tilDestId) REFERENCES destinasjon (destinasjonId)
);


CREATE TABLE prisKategori
(
    prisKategoriId INT NOT NULL AUTO_INCREMENT,
    navn VARCHAR (100) NOT NULL,
    kroner DECIMAL(14,2) NOT NULL,
    endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT pk_prisKategori PRIMARY KEY (prisKategoriId)
);


CREATE TABLE sete
(
    seteId INT NOT NULL AUTO_INCREMENT,
    flyId INT NOT NULL,
    prisKategoriId INT NOT NULL, 
    seteNr VARCHAR(10),
    nodutgang VARCHAR (3),
    forklaring VARCHAR (100), -- gang/midt/vindu
    endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT pk_sete PRIMARY KEY (seteId),
    CONSTRAINT fk_sete1 FOREIGN KEY (flyId) REFERENCES fly (flyId),
    CONSTRAINT fk_sete2 FOREIGN KEY (prisKategoriId) REFERENCES prisKategori (prisKategoriId)
);


CREATE TABLE bestilling
(
    bestillingId INT NOT NULL AUTO_INCREMENT,
    bestillingsDato CHAR (10) NOT NULL, -- 01/01/2016
    refNo varchar(200) NOT NULL,
    reiseDato CHAR (10) NOT NULL, -- 01/01/2016
    returDato CHAR (10), -- 01/01/2016
    bestillerFornavn VARCHAR (50) NOT NULL,
    bestillerEtternavn VARCHAR (50) NOT NULL,
    bestillerEpost VARCHAR (100) NOT NULL,
    bestillerTlf VARCHAR (50) NOT NULL,
    antallVoksne INT NOT NULL,
    antallBarn INT NOT NULL,
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
    melding VARCHAR (3000),
    modul VARCHAR (500), 
    bruker VARCHAR (50) NOT NULL, 
    opprettet TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_logg PRIMARY KEY (loggId)
);


CREATE VIEW LedigePlasser
AS 
SELECT 
    `a`.`avgangId` AS `avgangId`,
    `a`.`dato` AS `dato`,
    `s`.`seteNr` AS `seteNr`,
    `fra`.`navn` AS `fra`,
    `til`.`navn` AS `til`,
    `a`.`fastpris` AS `fastpris`,
    `a`.`fraDestId` AS `fraDestId`,
    `a`.`tilDestId` AS `tilDestId`,
    `a`.`direkte` AS `direkte`,
    `s`.`seteId` AS `seteId`,
    `a`.`klokkeslett` AS `klokkeslett`,
    `b`.`billettId` AS `billettId`
FROM
    ((((`sete` `s`
    JOIN `avgang` `a` ON ((`s`.`flyId` = `a`.`flyId`)))
    JOIN `flyplass` `fra` ON ((`a`.`fraDestId` = `fra`.`flyplassId`)))
    JOIN `flyplass` `til` ON ((`a`.`tilDestId` = `til`.`flyplassId`)))
    LEFT JOIN `billett` `b` ON (((`s`.`seteId` = `b`.`seteId`)
        AND (`a`.`avgangId` = `b`.`avgangId`))))
WHERE
    ISNULL(`b`.`billettId`)


drop view LedigeAvganger;
CREATE VIEW LedigeAvganger
AS 
SELECT 
    `a`.`avgangId` AS `avgangId`,
    `a`.`dato` AS `dato`,
    `a`.`klokkeslett` AS `klokkeslett`,
    `fra`.`navn` AS `fra`,
    `til`.`navn` AS `til`,
    `a`.`fastpris` AS `fastpris`,
    `a`.`fraDestId` AS `fraDestId`,
    `a`.`tilDestId` AS `tilDestId`,
    `a`.`direkte` AS `direkte`,
    COUNT(0) AS `AntallLedige`,
    `b`.`billettId` AS `billettId`
FROM
    ((((`sete` `s`
    JOIN `avgang` `a` ON ((`s`.`flyId` = `a`.`flyId`)))
    JOIN `flyplass` `fra` ON ((`a`.`fraDestId` = `fra`.`flyplassId`)))
    JOIN `flyplass` `til` ON ((`a`.`tilDestId` = `til`.`flyplassId`)))
    LEFT JOIN `billett` `b` ON (((`s`.`seteId` = `b`.`seteId`)
        AND (`a`.`avgangId` = `b`.`avgangId`))))
WHERE
    ISNULL(`b`.`billettId`)
GROUP BY `a`.`avgangId` , `a`.`dato` , `a`.`klokkeslett` , `fra`.`navn` , `til`.`navn` , `a`.`fastpris` , `a`.`fraDestId` , `a`.`tilDestId` , `a`.`direkte` , `b`.`billettId`