

-- Lisää INSERT INTO lauseet tähän tiedost
INSERT INTO Kayttaja (etunimi, sukunimi, kayttajatunnus, salasana, syntyma_aika, osoite, puhelinnumero, email_osoite, kuvaus) VALUES ('Ilpo', 'Mäkelä', 'Pultsari', 'potkukelkka', '1989-03-03', 'Maalarintie 5', '0000000', 'ilpo@ilpo.com', 'olen kiltti mies');
INSERT INTO Tapahtuma (tapahtuman_nimi, tapahtumapaikka, lyhyt_kuvaus, pvm, kellonaika, tapahtuman_luoja) VALUES ('Ruokakerho', 'Turun keittiö', 'Laitetaan ruokaa yhdessä', '2016-12-12', '12:00' , 1);
INSERT INTO Kiinnostustagi (kiinnostus) VALUES ('rumpujensoitto');

INSERT INTO Kayttajan_kiinnostus (kayttaja, kiinnostus) VALUES (1, 1);
INSERT INTO Osallistuminen (kayttaja_id, tapahtuma_id) VALUES (1, 1);
INSERT INTO Tapahtuman_aihe (tapahtuma, aihe) VALUES (1, 1);