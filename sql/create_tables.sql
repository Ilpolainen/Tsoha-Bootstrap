-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Kayttaja (
id SERIAL PRIMARY KEY,
etunimi varchar(50) NOT NULL,
sukunimi varchar(50) NOT NULL,
kayttajatunnus varchar(20) NOT NULL,
salasana varchar(16) NOT NULL,
syntyma_aika DATE,
osoite varchar(60),
puhelinnumero varchar(15),
email_osoite varchar(50)
);


CREATE TABLE Tapahtuma (
id SERIAL PRIMARY KEY,
tapahtuman_nimi varchar(50) NOT NULL,
lyhyt_kuvaus varchar(255),
pvm DATE NOT NULL,
kellonaika TIME NOT NULL,
tapahtumapaikka varchar(100) NOT NULL
);



CREATE TABLE Osallistuminen (
id SERIAL PRIMARY KEY,
kayttaja INTEGER NOT NULL,
tapahtuma INTEGER NOT NULL
);

CREATE TABLE Kiinnostustagi (
id SERIAL PRIMARY KEY,
kiinnostus varchar(60) NOT NULL
);

CREATE TABLE Tapahtuman_aihe (
id SERIAL PRIMARY KEY,
tapahtuma INTEGER NOT NULL,
aihe INTEGER NOT NULL
);

CREATE TABLE Kayttajan_kiinnostus (
id SERIAL PRIMARY KEY,
kayttaja INTEGER NOT NULL,
kiinnostus INTEGER NOT NULL
);

