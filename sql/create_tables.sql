-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Kayttaja (
id SERIAL PRIMARY KEY,
etunimi varchar(50) NOT NULL,
sukunimi varchar(50) NOT NULL,
lyhyt_kuvaus varchar(255),
syntyma_aika DATE,
kayttajatunnus varchar(20) NOT NULL,
puhelinnumero varchar(15),
email_osoite varchar(50),
salasana varchar(16) NOT NULL
);


CREATE TABLE Tapahtuma (
id SERIAL PRIMARY KEY,
tapahtuman_nimi varchar(50) NOT NULL,
lyhyt_kuvaus varchar(255),
pvm DATE NOT NULL,
kellonaika TIME NOT NULL,
tapahtumapaikka varchar(100) NOT NULL,
tapahtuman_luoja INTEGER REFERENCES Kayttaja(id)
);



CREATE TABLE Osallistuminen (
id SERIAL PRIMARY KEY,
kayttaja INTEGER REFERENCES Kayttaja(id),
tapahtuma INTEGER REFERENCES Tapahtuma(id)
);

CREATE TABLE Kiinnostustagi (
id SERIAL PRIMARY KEY,
kiinnostus varchar(25) NOT NULL
);

CREATE TABLE Tapahtuman_aihe (
id SERIAL PRIMARY KEY,
tapahtuma INTEGER REFERENCES Tapahtuma(id),
kiinnostustagi INTEGER REFERENCES Kiinnostustagi(id) 
);

CREATE TABLE Kayttajan_kiinnostus (
id SERIAL PRIMARY KEY,
kayttaja INTEGER REFERENCES Kayttaja(id),
kiinnostustagi INTEGER REFERENCES Kiinnostustagi(id) 
)

