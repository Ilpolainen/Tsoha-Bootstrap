<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Kayttaja
 *
 * @author vipohjol
 */
class Kayttaja extends BaseModel {

    public $id, $etunimi, $sukunimi, $kayttajatunnus, $salasana, $syntyma_aika, $osoite, $puhelinnumero, $email_osoite, $kuvaus;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validateStrings', 'validateSyntyma_aika');
    }

    public static function getKayttajatunnus() {
        return $this->kayttajatunnus;
    }

    public static function findAll() {

        $query = DB::connection()->prepare('SELECT * FROM kayttaja');
        $query->execute();
        $rows = $query->fetchAll();

        $kayttajat = array();

        foreach ($rows as $row) {
            $kayttajat[] = new Kayttaja(array(
                'id' => $row['id'],
                'etunimi' => $row['etunimi'],
                'sukunimi' => $row['sukunimi'],
                'kayttajatunnus' => $row['kayttajatunnus'],
                'salasana' => $row['salasana'],
                'syntyma_aika' => $row['syntyma_aika'],
                'osoite' => $row['osoite'],
                'puhelinnumero' => $row['puhelinnumero'],
                'email_osoite' => $row['email_osoite'],
                'kuvaus' => $row['kuvaus']
            ));
        }
        return $kayttajat;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $kayttaja = new Kayttaja(array('id' => $row['id'],
                'etunimi' => $row['etunimi'],
                'sukunimi' => $row['sukunimi'],
                'kayttajatunnus' => $row['kayttajatunnus'],
                'salasana' => $row['salasana'],
                'syntyma_aika' => $row['syntyma_aika'],
                'osoite' => $row['osoite'],
                'puhelinnumero' => $row['puhelinnumero'],
                'email_osoite' => $row['email_osoite'],
                'kuvaus' => $row['kuvaus']
            ));
        }
        return $kayttaja;
    }

    public function tallenna() {
        $query = DB::connection()->prepare('INSERT INTO Kayttaja (etunimi, sukunimi, kayttajatunnus, salasana, syntyma_aika, osoite, puhelinnumero, email_osoite, kuvaus) VALUES (:etunimi, :sukunimi, :kayttajatunnus, :salasana, :syntyma_aika, :osoite, :puhelinnumero, :email_osoite, :kuvaus) RETURNING id');
        $query->execute(array('etunimi' => $this->etunimi, 'sukunimi' => $this->sukunimi, 'kayttajatunnus' => $this->kayttajatunnus, 'salasana' => $this->salasana, 'syntyma_aika' => $this->syntyma_aika, 'osoite' => $this->osoite, 'puhelinnumero' => $this->puhelinnumero, 'email_osoite' => $this->email_osoite, 'kuvaus' => $this->kuvaus));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Kayttaja SET etunimi = :etunimi, sukunimi = :sukunimi, kayttajatunnus = :kayttajatunnus, salasana = :salasana, syntyma_aika = :syntyma_aika, osoite = :osoite, puhelinnumero = :puhelinnumero, email_osoite = :email_osoite, kuvaus = :kuvaus WHERE id = :id');
        $query->execute(array('id' => $this->id, 'etunimi' => $this->etunimi, 'sukunimi' => $this->sukunimi, 'kayttajatunnus' => $this->kayttajatunnus, 'salasana' => $this->salasana, 'syntyma_aika' => $this->syntyma_aika, 'osoite' => $this->osoite, 'puhelinnumero' => $this->puhelinnumero, 'email_osoite' => $this->email_osoite, 'kuvaus' => $this->kuvaus));
    }

    public function authenticate($kayttajatunnus, $salasana) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttajatunnus = :kayttajatunnus AND salasana = :salasana LIMIT 1');
        $query->execute(array('kayttajatunnus' => $kayttajatunnus, 'salasana' => $salasana));
        $row = $query->fetch();
        if ($row) {
            $kayttaja = new Kayttaja(array('id' => $row['id'],
                'etunimi' => $row['etunimi'],
                'sukunimi' => $row['sukunimi'],
                'kayttajatunnus' => $row['kayttajatunnus'],
                'salasana' => $row['salasana'],
                'syntyma_aika' => $row['syntyma_aika'],
                'osoite' => $row['osoite'],
                'puhelinnumero' => $row['puhelinnumero'],
                'email_osoite' => $row['email_osoite'],
                'kuvaus' => $row['kuvaus']
            ));
            return $kayttaja;
            // Käyttäjä löytyi, palautetaan löytynyt käyttäjä oliona
        } else {
            return null;
            // Käyttäjää ei löytynyt, palautetaan null
        }
    }

    public function validateSyntyma_aika() {
        $errors = array();
        if (!$this->validate_string_length($this->syntyma_aika, 1)) {
            $errors[] = 'Päivämäärä ei saa olla tyhjä!';
        } else {
            if (!$this->checkIfDate($this->syntyma_aika)) {
                $errors[] = 'Syntymä-aika ei ole muotoa YYYY-MM-DD!';
            }
        }
        return $errors;
    }

    public function validateStrings() {
        $errors = array();
        if (!$this->validate_min_string_length($this->etunimi, 2)) {
            $errors[] = 'Etunimen tulee olla vähintään 2 merkkiä pitkä';
        }
        if (!$this->validate_max_string_length($this->etunimi, 50)) {
            $errors[] = 'Etunimi saa olla enintään 50 merkkiä pitkä';
        }
        return $errors;
         if (!$this->validate_min_string_length($this->sukunimi, 2)) {
            $errors[] = 'Sukunimen tulee olla vähintään 2 merkkiä pitkä';
        }
        if (!$this->validate_max_string_length($this->sukunimi, 50)) {
            $errors[] = 'Sukunimi saa olla enintään 50 merkkiä pitkä';
        }
         if (!$this->validate_min_string_length($this->kayttajatunnus, 4)) {
            $errors[] = 'Käyttäjätunnuksen tulee olla vähintään 4 merkkiä pitkä';
        }
        if (!$this->validate_max_string_length($this->kayttajatunnus, 20)) {
            $errors[] = 'Käyttäjätunnus saa olla enintään 20 merkkiä pitkä';
        }
         if (!$this->validate_min_string_length($this->salasana, 5)) {
            $errors[] = 'Salasanan tulee olla vähintään 5 merkkiä pitkä';
        }
        if (!$this->validate_max_string_length($this->salasana, 16)) {
            $errors[] = 'Salasana saa olla enintään 16 merkkiä pitkä';
        }
        if (!$this->validate_max_string_length($this->puhelinnumero, 15)) {
            $errors[] = 'Puhelinnumero saa olla enintään 15 merkkiä pitkä';
        }
        if (!$this->validate_max_string_length($this->osoite, 60)) {
            $errors[] = 'Osoite saa olla enintään 60 merkkiä pitkä';
        }
        if (!$this->validate_max_string_length($this->email_osoite, 50)) {
            $errors[] = 'Email -osoite saa olla enintään 50 merkkiä pitkä';
        }
        if (!$this->validate_max_string_length($this->kuvaus, 300)) {
            $errors[] = 'Kuvaus saa olla enintään 300 merkkiä pitkä';
        }
        return $errors;
    }
}
