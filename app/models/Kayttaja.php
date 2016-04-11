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

    public $id, $etunimi, $sukunimi, $kayttajatunnus, $salasana, $syntyma_aika, $osoite, $puhelinnumero, $email_osoite, $lyhyt_kuvaus;

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
                'email_osoite' => $row['email_osoite'],
                'lyhyt_kuvaus' => $row['lyhyt_kuvaus']
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
                'lyhyt_kuvaus' => $row['lyhyt_kuvaus']
            ));
        }
        return $kayttaja;
    }

}
