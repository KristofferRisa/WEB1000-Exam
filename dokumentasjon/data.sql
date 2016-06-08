INSERT INTO bruker (brukernavn, fornavn, etternavn, epost, passord,isAdmin) 
VALUES ('admin','admin','admin','admin@admin','$2y$11$588375129575004edc18cunE7l5lf6G1zI2bAHn7apB0mBvwdfYmi','Ja');


INSERT INTO fly (flyNr,    flyModell,type, plasser, aarsmodell) 
VALUES ('A-222', 'Boeing', 'A730',20,2016);


INSERT INTO flyplass (navn) VALUES ('OSL (GARDEMOEN)'), ('OSL (TORP)'), ('LON GATWICK'), ('LON HEATHROW');


INSERT INTO destinasjon (flyplassId ,navn, land , landskode ,stedsnavn,geo_lat, geo_lng)
VALUES (1, 'OSLO GARDEMOEN', 'NORGE', 'NO', 'Oslo','60.197591', '11.100910'),
       (2, 'OSLO TORP', 'NORGE', 'NO', 'Sandefjord','59.000053', '10.019490'),
       (3, 'LONDON GATWICK', 'ENGLAND', 'EN', 'London', NULL, NULL),
       (4, 'LONDON HEATHROW', 'ENGLAND', 'EN', 'London','51.469996', '-0.454006');



INSERT INTO avgang (flyId, fraDestId, tilDestId, dato, direkte, 
reiseTid, klokkeslett,fastpris)
       
VALUES (1, 2, 3, '2016-01-01', 'Ja', '02:10', '06:50', 1700),
       (1, 1, 4, '2016-01-01', 'Nei', '04:40', '02:50', 200),
       (1, 2, 3, '2016-02-02', 'Ja', '02:10', '06:50', 2300);
       
       
INSERT INTO prisKategori (navn, prosentPaaslag)
VALUES ('standard', 0),
       ('first class', 200),
       ('ungdom+', '-30');
       
       
INSERT INTO sete (flyId, prisKategoriId, seteNr, nodutgang, forklaring)
VALUES ('1', '1', 'A19', 'Nei', 'Vindu'),
       ('1', '1', 'A20', 'Nei', 'Midt'),
       ('1', '2', 'A2', 'Ja', 'Vindu');


INSERT INTO bestilling (bestillingsDato, refNo, reiseDato, returDato, bestillerFornavn, bestillerEtternavn,
bestillerEpost, bestillerTlf, antallVoksne, antallBarn, antallBebis)
VALUES ('01/01/2016', 'MKU16', '2016/02/02', '2016/03/03', 'Ola', 'Nordmann', 'olanordmann@nord.mann', '8888888', '1', '0', '1'),
       ('02/01/2016', 'MKU17', '2016/04/04', NULL, 'Kari', 'Sta', 'karista@hei.du', '9999999', '1', '0', '0');
       
       
INSERT INTO billett (bestillingId, avgangId, seteId, fornavn, etternavn, kjonn, antBagasje)
VALUES ('1', '3', '1', 'Ola', 'Nordmann', 'mann', '1'),
       ('1', '3', '2', 'Harriet', 'Nordmann', 'jente', '0'),
       ('2', '2', '3', 'Kari', 'Sta', 'dame', '2');
       
  


