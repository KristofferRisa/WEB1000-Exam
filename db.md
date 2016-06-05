# DB oversikt

## Oversikt over tabeller med eksempel innhold

**_Utkast_**

### Fly
Viser en oversikt over alle tilgjengelig fly og deres kapasitet.

| id | fly nr |  modell | type | sitteplasser | aarsmodell | 
|----|--------|------------|--------|----------------|---------------|
| 1 | B2-123123  | Boeing | 737 | 150 | 2012 |
| 2 | B2-123333  | Boeing | 800 | 250 | 2015 | 

### Flyplass
Viser alle flyplasser

| id | navn |
|----|--------|
| 1 | Torp | 
| 2 | Gardemoen | 
| 3 | Heathrow | 

### Destinasjon
En destinasjon er sammensatt av land, stedsnavn og flyplass
| id | navn | land |  landskode | stedsnavn | flyplassId| geo_lat | geo_lang | endret  |
|----|--------|--------------|------------|----------|-----------|--------------|-------------|----------|
| 1 | Oslo (Torp)  | Norge | NO | Sandefjord | 1 | 59.000053 | 10.019490 | 2016-06-04 |
| 2 | Oslo (Gardemoen) | Norge | NO | Oslo | 1 | 60.197591 | 11.100910 | 2016-06-06 |
| 3 | London (Heathrow)  |England | EN | London  | 51.469996 | -0.454006  | 2016-06-06 |

### Sesong
| id | nanvn | endret |
|----|------|---------|
| 1 | Høst | 2016-05-05|
| 2 | vår | 2016-05-06 |
| 2 | sommer 2016 | 2016-06-06 |

### Rute
(tidligere flyvning) består av en fra desitnasjon og til destinasjon.
Dette er en overordnet tabell til avgang tabellen som viser alle flyavganger mellom destinasjoner. 

| id | navn | fraDestId | tilDestId | sesong | endret |
|----|-----------|-----------|--------|---------|
| 1 | 1 | 2 |  1 | 2015-06-06 |
| 2 | 2 | 3 |  1 | 2015-06-06 |

# Fortsett HER!

### Avgang
| id | ruteId | fraFlyplassId | tilFlyplassID | ukedag | klokkeslette | reiseTid | direkte |
|----|-------------|-----------|---------------|------------|
| 1 | 1 | 2 | 2016-06-01 05:00 | 1 | 2016-06-06 21:00 |  1 | null | 1 |
| 2 | 2 | 3 | 2016-07-01 12:10 | 2 | null | 2 | 1 | 1 |

## Priskategori

| id | navn  | prosentpåslagg |
|---|--------|---------|----------------|
| 1 | normal  | null |
| 2 | first class | 200 |
| 3 | billig ++  | -50 |


## Sete

| id | flyModellId | seteNr | nodutgang | priskategoriId |
|---|--------------|--------|-----------|-------------|
| 1 | 1 | 1A | FALSE | 1 | 

## Kunde
|id | fornavn | etternavn | kjonn  | tlf | epost |
|--|---------|------------|--------|---------|----|-------|

##Bestilling

|id | bestillingDato | kundeId | refno |  reiseDato | returDato | antallVoksen | antallBarn | antallBebis  |
|---|----------------|---------|-------|------------|-----------|--------------|------------|---------------|

### Billett
| id | bestillingId | avgangId | ref no | kundeId | prisId | billett type | antall bagasje | datotid 
|----|-----------|---------|------------|---------|---------------|---------------------|----------|-------------|----------|
| 1 | 1 | NO123123 | 1 | 1 | 1 | 0 | 2016-05-13 22:40 | true | 1 |
| 2 | 1 | NO992134 | 1 | 2 | 1 | 2 | 2016-09-01 14:50 | true | 1 |


### Bruker
| id | brukerTypeId | fornavn | etternavn | epost | tlf | fødselsdato | kjønn |  password  |
|---|--------------------|------------|--------------|---------|----|-----------------|---------|---------------|
| 1 | 3 | Hans | Hansen | ha@sen.no | 213111 12 | 1955-01-12 | mann | zxczxcsd |
| 2 | 3  |Ola | Norma | ola@norman.com | 90090013 | 1977-12-12 | mann | asdfasdf |
| 1 | 1 | kristoffer | risa | k@k.k | null | null | null | dsafopsdfi |
| 2 | 2 | Normal | user | sadfsf@dsaf.no | null | null | null | ewrq1| 

### Autentisering
Vi lager en autentisering tabell for å holde styr på sesjons guid pr bruker som er innlogget. Da ser vi kun i __bruker__ tabellen ved innlogging også brukes autentisering tabellen ved alle autentisering sjekker. 

Da må vi selv lagre autentisering cookie som vi sjekker og kontrollerer mot. 

| id | brukerId | sesjon_guid | utgårtidspunkt |
|----|-------------|----------------|---------------------|
| 1 | 1 | a566fe95-272e-4084-858e-23e89fd8f5a5 | 2016-05-05 23:00:00 |
| 2 | 1 | a566fe95-272e-4084-858e-23e89fd8f5a5 | 2016-05-06 23:00:00 |
| 3 | 2 | 00a9c38b-a3e6-4ef7-a2b6-9c1f4d3af622 | 2016-05-06 23:23:00 |

### Logg
| id | nivå | melding | modul | brukerId | opprettet |
|----|--------|------------|----------|-------------|-----------|
| 1 | error | Ny feilmelding ... | innlogging | 1 | 2016-05-13 21:00 |
| 2 | info | Logget inn som ... | Innlogging | 2 | 2016-05-13 21:01 |
