# DB oversikt

## Oversikt over tabeller med eksempel innhold

**_Utkast_**

### Fly
Viser en oversikt over alle tilgjengelig fly og deres kapasitet.

| id | fly nr |  modell | type | sitteplasser | besetning | status
|----|--------|------------|--------|----------------|---------------|-------|
| 1 | B2-123123  | Boeing | 737 | 150 | 4 | 1 |
| 2 | B2-123333  | Boeing | 800 | 250 | 5 | 1 |

### Flyvning
En flyvning er enten en direkte eller med mellom ladning. Dersom det er mellom landing brukes linkId som nøkkel for å følge flyvning. 

| id | linkId | typeId | flyId | fraFlyplassId | tilFlyplassId | tidspunkt | dato | status |
|----|---------|---------|--------|------------------|------------------|--------------|-------|---------|
| 1 | 1 | 1 | 1 | 1 | 2 | 19:00 | 2016-01-01 | 1 |
| 2 | 2 | 2 | 1 | 1 | 2 | 23:00 | 2016-12-12 | 1 |
| 3 | 2 | 2 | 1 | 2 | 2 | 03:40 | 2016-07-01 | 1 |

### FlyvningType
| id | navn | status |
|----|--------|---------|
| 1 | Direkte | 1 |
| 2 | Mellom landing | 1 |

### Destinasjon
Alle mulige destinasjoner og om de er aktive eller ikke.

| id | navn | flyplassid |  aktivfra | aktivtil | geo_lat | geo_lang | publisert | status |
|----|--------|--------------|------------|----------|-----------|--------------|-------------|----------|
| 1 | Oslo (Torp)  | 1 | 13-05-2016 | null | 59.000053 | 10.019490 | true | 1 |
| 2 | Oslo (Gardemoen) | 2 | 2016-05-01 | null | 60.197591 | 11.100910 | true | 1 |
| 3 | London (Heathrow)  | 3 | 2016-04-13 | null | 51.469996 | -0.454006  | true | 1 |

### Flyplass
Viser alle flyplasser

| id | navn | land | status |
|----|--------|-------|----------|
| 1 | Torp | Norge | 1 |
| 2 | Gardemoen | Norge | 1 |
| 3 | Heathrow | Storbritannia | 1 |

### Ruter
| id | reiseFra | reiseTil | utreise (dato) | type | retur (dato) | antall voksne | antall barn | status |
|----|-------------|-----------|---------------|------------|--------------|-------------------|----------------|-----------|
| 1 | 1 | 2 | 2016-06-01 05:00 | 1 | 2016-06-06 21:00 |  1 | null | 1 |
| 2 | 2 | 3 | 2016-07-01 12:10 | 2 | null | 2 | 1 | 1 |

### Reise type
| id | navn | aktiv | status |
|----|--------|--------|---------|
| 1 | enkel | true | 1 |
| 2 | tur/retur | true | 1 |

### Pris 
Pris tabellen viser alle historiske utgitte priser, både ved søk og salg. (må revideres basert på issue #7 )

| id | reiseId| fradato |  pris |  Reisetype | status |
|----|----------|------------|--------|------|---------|
| 1 | 1 | 2015-01-01 | 1000,00 | 1 | 1 |
| 2 | 3 | 2015-01-01 | 14000,00 | 2 | 1 |

### Prishistorikk

| id | reiseId | fradato |  pris | type | dato | status |
|----|----------|------------|-------|-------|--------|---------|
| 1 | 1 | 2015-01-01 | 1000,00 | 1 | 2016-04-15 | 1 | 
| 2 | 3 | 2015-02-01 | 14000,00 | 1 |  2016-05-13 | 1 |

### Kunde (utgår) 
Opprettet kunde som en brukertype

## Sete

| id | flyId | seteNr | nodUtgang |
|---|--------|----------|-----------------|
| 1 | 1 | 1A | false | 

### Billett
| id | reiseId | ref no | kundeId | prisId | billett type | antall bagasje | datotid | publisert | status |
|----|-----------|---------|------------|---------|---------------|---------------------|----------|-------------|----------|
| 1 | 1 | NO123123 | 1 | 1 | 1 | 0 | 2016-05-13 22:40 | true | 1 |
| 2 | 1 | NO992134 | 1 | 2 | 1 | 2 | 2016-09-01 14:50 | true | 1 |

### Billett typer
| id | navn | status |
|----|--------|----------|
| 1 | billig | 1 |
| 2 | billig+  | 1 | 
| 3 | flex | 1 |

### Innsjekk  (ikke påkrevd)


### Bruker
| id | brukerTypeId | fornavn | etternavn | epost | tlf | fødselsdato | kjønn |  password | salt |
|---|--------------------|------------|--------------|---------|----|-----------------|---------|---------------|-------|
| 1 | 3 | Hans | Hansen | ha@sen.no | 213111 12 | 1955-01-12 | mann | zxczxcsd | salg |
| 2 | 3  |Ola | Norma | ola@norman.com | 90090013 | 1977-12-12 | mann | asdfasdf | salt |
| 1 | 1 | kristoffer | risa | k@k.k | null | null | null | dsafopsdfi | salt | 
| 2 | 2 | Normal | user | sadfsf@dsaf.no | null | null | null | ewrq1| salt | 

### Autentisering
Vi lager en autentisering tabell for å holde styr på sesjons guid pr bruker som er innlogget. Da ser vi kun i __bruker__ tabellen ved innlogging også brukes autentisering tabellen ved alle autentisering sjekker. 

Da må vi selv lagre autentisering cookie som vi sjekker og kontrollerer mot. 

| id | brukerId | sesjon_guid | utgårtidspunkt |
|----|-------------|----------------|---------------------|
| 1 | 1 | a566fe95-272e-4084-858e-23e89fd8f5a5 | 2016-05-05 23:00:00 |
| 2 | 1 | a566fe95-272e-4084-858e-23e89fd8f5a5 | 2016-05-06 23:00:00 |
| 3 | 2 | 00a9c38b-a3e6-4ef7-a2b6-9c1f4d3af622 | 2016-05-06 23:23:00 |

### Brukertype
| id | navn | aktiv | status |
|----|--------|--------|---------|
| 1 | Admin | true | 1 | 
| 2 | Bruker | true | 1 |
| 3 | Kunde | true | 1 |

### Logg
| id | nivå | melding | modul | brukerId | opprettet |
|----|--------|------------|----------|-------------|-----------|
| 1 | error | Ny feilmelding ... | innlogging | 1 | 2016-05-13 21:00 |
| 2 | info | Logget inn som ... | Innlogging | 2 | 2016-05-13 21:01 |
