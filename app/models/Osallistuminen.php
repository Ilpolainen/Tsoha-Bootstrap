<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Osallistuminen
 *
 * @author vipohjol
 */
class Osallistuminen extends BaseModel {

    public $id, $kayttaja_id, $tapahtuma_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function findAll() {
        $query = DB::connection()->prepare('SELECT * FROM Osallistuminen');
        $query->execute();
        $rows = $query->fetchAll();
        $osallistumiset = array();
        foreach ($rows as $row) {
            $osallistumiset[] = new Osallistuminen(array('id' => $rows['id'], 'kayttaja_id' => $rows['kayttaja_id'], 'tapahtuma_id' => $rows['tapahtuma_id']));
        }
        return $osallistumiset;
    }
    
    public static function findAllByKayttaja($kayttaja_id) {
        $query = DB::connection()->prepare("SELECT * FROM Osallistuminen WHERE kayttaja_id = :kayttaja_id");
        $query->execute(array('kayttaja_id' => $kayttaja_id));
        $rows = $query->fetchAll();
        $osallistumiset = array();
        foreach ($rows as $row) {
           $osallistumiset[] = new Osallistuminen(array('id' => $row['id'], 'kayttaja_id' => $row['kayttaja_id'], 'tapahtuma_id' => $row['tapahtuma_id']));
        }

        return $osallistumiset;
    }
    
    public static function findAllByTapahtuma($tapahtuma_id) {
        $query = DB::connection()->prepare("SELECT * FROM Osallistuminen WHERE tapahtuma_id = :tapahtuma_id");
        $query->execute(array('tapahtuma_id' => $tapahtuma_id));
        $rows = $query->fetchAll();
        $osallistumiset = array();
        foreach ($rows as $row) {
            $osallistumiset[] = new Osallistuminen(array('id' => $row['id'], 'kayttaja_id' => $row['kayttaja_id'], 'tapahtuma_id' => $row['tapahtuma_id']));
        }

        return $osallistumiset;
    }

    public static function isAttending($kayttajaid, $tapahtumaid) {
        $kayttajanOsallistumiset = Osallistuminen::findAllByKayttaja($kayttajaid);
        $osallistujat = Osallistuminen::findAllByTapahtuma($tapahtumaid);
        foreach ($kayttajanOsallistumiset as $kayt) {
            foreach ($osallistujat as $os) {
                if ($os->id == $kayt->id) {
                    return true;
                }
            }
        }
        return false;
    }
    
    public static function find($kayttajaid, $tapahtumaid) {
        $kayttajanOsallistumiset = Osallistuminen::findAllByKayttaja($kayttajaid);
        $osallistujat = Osallistuminen::findAllByTapahtuma($tapahtumaid);
        $osallistumiset = array();
        foreach ($kayttajanOsallistumiset as $kayt) {
            foreach ($osallistujat as $os) {
                if ($os->id == $kayt->id) {
                    $osallistumiset[] = $os;
                }
            }
        }
        return $osallistumiset;
    }
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Osallistuminen (kayttaja_id, tapahtuma_id) VALUES (:kayttaja_id, :tapahtuma_id) RETURNING id');
        $query->execute(array('kayttaja_id' => $this->kayttaja_id, 'tapahtuma_id' => $this->tapahtuma_id));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
     public function poista() {
        $query = DB::connection()->prepare('DELETE FROM Osallistuminen WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }
    //put your code here
}
