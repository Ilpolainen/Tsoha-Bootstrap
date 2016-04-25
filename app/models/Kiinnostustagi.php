<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Kiinnostustagi
 *
 * @author vipohjol
 */
class Kiinnostustagi extends BaseModel {

    public $id, $kiinnostus;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validateKiinnostus');
    }

    public static function findAll() {
        $query = DB::connection()->prepare('SELECT * FROM Kiinnostustagi');
        $query->execute();
        $rows = $query->fetchAll();

        $tagit = array();
        foreach ($rows as $row) {
            $tagit[] = new Kiinnostustagi(array('id' => $row['id'], 'kiinnostus' => $row['kiinnostus']));
        }

        return $tagit;
    }

    public function tallenna() {
        $query = DB::connection()->prepare('INSERT INTO Kiinnostustagi (kiinnostus) VALUES (:kiinnostus) RETURNING id');
        $query->execute(array('kiinnostus' => $this->kiinnostus));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function onJoOlemassa() {
        $query = DB::connection()->prepare('SELECT * FROM Kiinnostustagi WHERE kiinnostus = :kiinnostus');
        $query->execute(array("kiinnostus" => $this->kiinnostus));
        $row = $query->fetch();
        if ($row == null) {
            return false;
        }
        return true;
    }

    public static function find($id) {
        $query = DB::connection()->prepare("SELECT * FROM Kiinnostustagi WHERE id = :id LIMIT 1");
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $tagi = new Kiinnostustagi(array('id' => $row['id'], 'kiinnostus' => $row['kiinnostus']));
        }

        return $tagi;
    }

    public static function findByKayttaja($id) {
        $kookoot = Kayttajan_kiinnostus::findByKayttaja($id);
        $kiinnostukset = array();
        foreach ($kookoot as $kk) {

            $kiinnostukset[] = self::find($kk->kiinnostus);
        }
        return $kiinnostukset;
    }

    public function validateKiinnostus() {
        $errors = array();
        if (!$this->validate_string_length($this->kiinnostus, 2)) {
            $errors[] = 'kiinnostuksen nimen tulee olla vähintään 2 merkkiä pitkä';
        }
    }

    public static function findByTapahtuma($id) {
        $tat = Tapahtuman_aihe::findAllByTapahtuma($id);
        foreach ($tat as $ta) {
            $tagit[] = new Kiinnostustagi(array(
                $kiinnostus =  self::find($ta->aihe),
                'id' => $kiinnostus->id,
                'kiinnostus' => $kiinnostus->kiinnostus));
        }
        return $tagit;
    }

    //put your code here
}
