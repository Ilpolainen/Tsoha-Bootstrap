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

    public $id, $kayttaja, $kiinnostus;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function findAll() {
        $query = DB::connection()->prepare('SELECT * FROM Kayttajan_kiinnostus');
        $query->execute();
        $rows = $query->fetchAll();

        $kayttajienKiinnostukset = array();
        foreach ($rows as $row) {
            $kayttajienKiinnostukset[] = new Kayttajan_kiinnostus(array('kayttaja' => $rows['kayttaja'], 'kiinnostus' => $rows['kiinnostus']));
        }
        return $kayttajienKiinnostukset;
    }

     public static function findByKayttaja($id) {
        $query = DB::connection()->prepare("SELECT * FROM Kayttajan_kiinnostus WHERE kayttaja = :id LIMIT 1");
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $kiinnostukset = array();
        foreach ($rows as $row) {
            if ($row) {
                $tagi = new Kiinnostustagi(array('id' => $row['id'], 'kiinnostus' => $row['kiinnostus']));
                $kiinnostukset[] = $tagi;
            }
        }
        return $kiinnostukset;
    }

    public static function findAllByTagi($id) {
        $query = DB::connection()->prepare("SELECT * FROM Kayttajan_kiinnostus WHERE kiinnostus = :id LIMIT 1");
        $query->execute(array('kiinnostus' => $id));
        $row = $query->fetchAll();
        $kayttajien_kiinnostukset = array();
        foreach ($rows as $row) {
            $kayttajien_kiinnostukset[] = new Kayttajan_kiinnostus(array('id' => $row['id'], 'kayttaja' => $row['kayttaja'], 'kiinnostus' => $row['kiinnostus']));
        }

        return $kayttajien_kiinnostukset;
    }

   
    public function tallenna() {
        $query = DB::connection()->prepare('INSERT INTO Kayttajan_kiinnostus (kayttaja, kiinnostus) VALUES (:kayttaja, :kiinnostus) RETURNING id');
        $query->execute(array('kayttaja' => $this->kayttaja, 'kiinnostus' => $this->kiinnostus));
        $this->id = $query->fetch();
    }

     public function onJoOlemassa() {
        $query = DB::connection()->prepare('SELECT * FROM Kayttajan_kiinnostus WHERE kiinnostus = :kiinnostus');
        $query->execute(array("kiinnostus" => $this->kiinnostus));
        $row = $query->fetch();
        if ($row == null) {
            return false;
        }
        return true;
    }
    
    public function poista() {
        $query = DB::connection()->prepare('DELETE FROM Kayttajan_kiinnostus WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }
    //put your code here
}
