<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Kayttajan_kiinnostus
 *
 * @author vipohjol
 */
class Kayttajan_kiinnostus extends BaseModel {

    public $kayttaja_id, $kiinnostustagi_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function findAll() {
        $query = DB::connection()->prepare('SELECT * FROM Kayttajan_kiinnostus');
        $query->execute();
        $rows = $query->fetchAll();

        $kayttajienKiinnostukset = array();
        foreach ($rows as $row) {
            $kayttajienKiinnostukset[] = new Kayttajan_kiinnostus(array('kayttaja_id' => $rows['kayttaja_id'], 'kiinnostustagi_id' => $rows['kiinnostustagi_id']));
        }
        return $kayttajienKiinnostukset;
    }

    public static function findAllByKayttaja($id) {
        $query = DB::connection()->prepare("SELECT * FROM Kayttajan_kiinnostus WHERE kayttaja_id = :id LIMIT 1");
        $query->execute(array('kayttaja_id' => $id));
        $row = $query->fetchAll();
        $kayttajien_kiinnostukset = array();
        foreach ($rows as $row) {
            $kayttajien_kiinnostukset[] = new Kayttajan_kiinnostus(array('kayttaja_id' => $rows['kayttaja_id'], 'kiinnostustagi_id' => $rows['kiinnostustagi_id']));
        }

        return $kayttajien_kiinnostukset;
    }

    public static function findAllByTagi($id) {
        $query = DB::connection()->prepare("SELECT * FROM Kayttajan_kiinnostus WHERE kiinnostustagi_id = :id LIMIT 1");
        $query->execute(array('kiinnostustagi_id' => $id));
        $row = $query->fetchAll();
        $kayttajien_kiinnostukset = array();
        foreach ($rows as $row) {
            $kayttajien_kiinnostukset[] = new Kayttajan_kiinnostus(array('kayttaja_id' => $rows['kayttaja_id'], 'kiinnostustagi_id' => $rows['kiinnostustagi_id']));
        }

        return $kayttajien_kiinnostukset;
    }

    //put your code here
}
