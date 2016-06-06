INSERT INTO bruker (brukernavn, fornavn, etternavn, epost, passord,isAdmin) 
VALUES ('admin','admin','admin','admin@admin','$2y$11$588375129575004edc18cunE7l5lf6G1zI2bAHn7apB0mBvwdfYmi','Ja');

INSERT INTO fly (flyNr,    flyModell,type, plasser, aarsmodell) 
VALUES ('A-222', 'Boeing', 'A730',20,2016);

INSERT INTO flyplass (navn) VALUES ('OSL (GARDEMOEN)'), ('OSL (TROP)'), ('GATWICK'), ('HEATHROW');

INSERT INTO destinasjon (flyplassId ,navn, land , landskode ,stedsnavn,geo_lat, geo_lng)
VALUES (1, 'OSLO GARDEMOEN', 'NORGE', 'NO', 'Oslo','60.197591', '11.100910'),
       (2, 'OSLO TORP', 'NORGE', 'NO', 'Sandefjord','59.000053', '10.019490'),
       (3, 'LONDON GATWICK', 'ENGLAND', 'EN', 'London',null, null),
       (4, 'LONDON HEATHROW', 'ENGLAND', 'EN', 'London','51.469996', '-0.454006');

/*
    FORTSETT HER!
*/

INSERT INTO sesong ('navn') VALUES ()



-- GAMLE SQLer
insert into statusKode (navn) values ('Opprettet');
insert into statusKode (navn) values ('Slettet');

insert into brukerType (navn,statusKodeId) Values ('Admin',1);
insert into brukerType (navn,statusKodeId) Values ('Kunde',1);
insert into brukerType (navn,statusKodeId) Values ('Ansatt',1);
