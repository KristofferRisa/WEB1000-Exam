INSERT INTO bruker (brukernavn, fornavn, etternavn, epost, passord,isAdmin) 
VALUES ('admin','admin','admin','admin@admin','$2y$11$588375129575004edc18cunE7l5lf6G1zI2bAHn7apB0mBvwdfYmi','Ja');


INSERT INTO fly (flyNr,    flyModell,type, plasser, aarsmodell) 
VALUES ('A-222', 'Boeing', 'A730',20,2016);


INSERT INTO flyplass (navn) VALUES ('OSL (GARDEMOEN)'), ('OSL (TORP)'), ('LON GATWICK'), ('LON HEATHROW');


INSERT INTO destinasjon (flyplassId ,navn, land , landskode ,stedsnavn,geo_lat, geo_lng)
VALUES (1, 'OSLO GARDEMOEN', 'NORGE', 'NO', 'Oslo','60.197591', '11.100910'),
       (2, 'OSLO TORP', 'NORGE', 'NO', 'Sandefjord','59.000053', '10.019490'),
       (3, 'LONDON GATWICK', 'ENGLAND', 'EN', 'London',null, null),
       (4, 'LONDON HEATHROW', 'ENGLAND', 'EN', 'London','51.469996', '-0.454006');


INSERT INTO rute (fraDestId, tilDestId, navn)
VALUES (2, 3, 'Torp-Gatw'),
       (4, 1, 'Heath-Gard');
      
      
INSERT INTO avgang (ruteId, fraFlyplassId, tilFlyplassId, tilgjFraDato, tilgjTilDato, direkte, 
reiseTid, ukedagNr, klokkeslett,fastpris);
       
VALUES (1, 2, 3, '01/01/16', '01/06/16', 'Ja', '02:10', '4', '06:50', 1700),
       (2, 1, 4, '01/01/16', NULL, 'Nei', '04:40', '1', '02:50', 200),
       (1, 2, 3, '01/10/16', '01/02/17', 'Ja', '02:10', '4', '06:50', 2300);
       
       
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
VALUES ('01/01/2016', 'MKU16', '02/02/2016', '03/03/2016', 'Ola', 'Nordmann', 'olanordmann@nord.mann', '8888888', '1', '0', '1'),
       ('02/01/2016', 'MKU17', '04/04/2016', 'Kari', 'Sta', 'karista@hei.du', '9999999', '1');
       
       
INSERT INTO billett (bestillingId, avgangId, seteId, fornavn, etternavn, kjonn, antBagasje)
VALUES ('1', '3', '25', 'Ola', 'Nordmann', 'mann', '1'),
       ('1', '3', '26', 'Harriet', 'Nordmann', 'jente', '0'),
       ('2', '2', '27', 'Kari', 'Sta', 'dame', '2');
       
  


