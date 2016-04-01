-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Tapahtuma (
id SERIAL PRIMARY KEY,
tapahtuman_nimi varchar(50) NOT NULL,
lyhyt kuvaus varchar(255),
pvm TIMESTAMP NOT NULL,
tapahtuman_luoja INTEGER REFERENCES Kayttaja(id)
);

CREATE TABLE Kayttaja (
id SERIAL PRIMARY KEY,
etunimi varchar(50) NOT NULL,
sukunimi varchar(50) NOT NULL,
kayttajatunnus varchar(20) NOT NULL,
puhelinnumero varchar(15),
email_osoite varchar(50),
password varchar(16) NOT NULL
);

CREATE TABLE Osallistuminen (
id SERIAL PRIMARY KEY,
kayttaja INTEGER REFERENCES Kayttaja(id),
tapahtuma INTEGER REFERENCES Tapahtuma(id)
);

CREATE TABLE Kiinnostustagi (
id SERIAL PRIMARY KEY,
kiinnostus varchar(25) NOT NULL,
);

CREATE TABLE Tapahtuman_aihe (
id SERIAL PRIMARY KEY,
tapahtuma INTEGER REFERENCES Tapahtuma(id),
kiinnostustagi INTEGER REFERENCES Kiinnostustagi(id) 
);

