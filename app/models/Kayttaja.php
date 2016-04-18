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

    public $id, $etunimi, $sukunimi, $kayttajatunnus, $salasana, $syntyma_aika, $osoite, $puhelinnumero, $email_osoite;

    public function __construct($attributes) {
        parent::__construct($attributes);
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
                'email_osoite' => $row['email_osoite']
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
                'email_osoite' => $row['email_osoite']
            ));
        }
        return $kayttaja;
    }

    public function tallenna() {
        $query = DB::connection()->prepare('INSERT INTO Kayttaja (etunimi, sukunimi, kayttajatunnus, salasana, syntyma_aika, osoite, puhelinnumero, email_osoite) VALUES (:etunimi, :sukunimi, :kayttajatunnus, :salasana, :syntyma_aika, :osoite, :puhelinnumero, :email_osoite) RETURNING id');
        $query->execute(array('etunimi' => $this->etunimi, 'sukunimi' => $this->sukunimi, 'kayttajatunnus' => $this->kayttajatunnus, 'salasana' => $this->salasana, 'syntyma_aika' => $this->syntyma_aika, 'osoite' => $this->osoite, 'puhelinnumero' => $this->puhelinnumero, 'email_osoite' => $this->email_osoite));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function authenticate($kayttajatunnus, $salasana) {
        $query = DB::connection()->prepare('SELECT * FROM Player WHERE kayttajatunnus = :kayttajatunnus AND salasana = :salasana LIMIT 1');
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
                'email_osoite' => $row['email_osoite']
            ));
            return $kayttaja;
            // Käyttäjä löytyi, palautetaan löytynyt käyttäjä oliona
        } else {
            return null;
            // Käyttäjää ei löytynyt, palautetaan null
        }
    }

}
