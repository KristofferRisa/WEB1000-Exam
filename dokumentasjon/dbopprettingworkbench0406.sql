CREATE TABLE autentisering
(
    autentiseringId INT NOT NULL AUTO_INCREMENT,
    brukertypeId INT NOT NULL,
    sesjon_guide INT NOT NULL,
    utgaarstidspunkt DATETIME
    CONSTRAINT pk_autentisering PRIMARY KEY (autentiseringId)
); 


CREATE TABLE billettType
(
    billettTypeId INT NOT NULL AUTO_INCREMENT,
    navn VARCHAR (50) NOT NULL,
    statusKodeId INT NOT NULL,
    endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT pk_bilettType PRIMARY KEY (billettTypeId),
    CONSTRAINT fk_billettType FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId) 
);



CREATE TABLE bestilling
(
    bestillingId INT NOT NULL AUTO_INCREMENT,
    bestiller VARCHAR (100) NOT NULL,
    reiseFra VARCHAR (100) NOT NULL,
    reiseTil VARCHAR (100) NOT NULL,
    utreiseDato DATE NOT NULL,
    returDato DATE NOT NULL,
    reiseTypeId INT NOT NULL,
    voksne INT NOT NULL,
    barn INT NOT NULL,
    baby INT NOT NULL,
    statusKodeId INT NOT NULL,
    endret TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT pk_bestilling PRIMARY KEY (bestillingId),
    CONSTRAINT fk_bestilling1 FOREIGN KEY (reiseTypeId) REFERENCES reiseType (reiseTypeId),
    CONSTRAINT fk_bestilling2 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId) 
);

CREATE TABLE billett
(
    billettId INT NOT NULL AUTO_INCREMENT,
    bestillingId INT NOT NULL,
    brukerId INT NOT NULL,
    bestillerNavn VARCHAR (100) NOT NULL,
    fornavn VARCHAR (100) NOT NULL,
    etternavn VARCHAR (100) NOT NULL,
    tlf VARCHAR (50),
    epost VARCHAR (100),
    kjonn VARCHAR (50),
    tittelId INT NOT NULL,
    seteReservasjon VARCHAR (20),
    antBagasje INT NOT NULL,
    datoTid DATETIME,
    prisId INT NOT NULL,
    billettTypeId INT NOT NULL,
    statusKodeId INT NOT NULL,
    CONSTRAINT pk_billett PRIMARY KEY (billettId),
    CONSTRAINT fk_billett1 FOREIGN KEY (bestillingId) REFERENCES bestilling (bestillingId),
    CONSTRAINT fk_billett2 FOREIGN KEY (brukerId) REFERENCES bruker (brukerId),
    CONSTRAINT fk_billett3 FOREIGN KEY (tittelId) REFERENCES tittel (tittelId),
    CONSTRAINT fk_billett4 FOREIGN KEY (prisId) REFERENCES pris (prisId),
    CONSTRAINT fk_billett5 FOREIGN KEY (billettTypeId) REFERENCES billettType (billettTypeId),
    CONSTRAINT fk_billett6 FOREIGN KEY (statusKodeId) REFERENCES statusKode (statusKodeId)    
);

