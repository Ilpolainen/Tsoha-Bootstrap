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

    public $kayttaja_id, $tapahtuma_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function findAll() {
        $query = DB::connection()->prepare('SELECT * FROM Osallistuminen');
        $query->execute();
        $rows = $query->fetchAll();
        $osallistumiset = array();
        foreach ($rows as $row) {
            $osallistumiset[] = new Osallistuminen(array('kayttaja_id' => $rows['kayttaja_id'], 'tapahtuma_id' => $rows['tapahtuma_id']));
        }
        return $osallistumiset;
    }
    
    public static function findAllByKayttaja($id) {
        $query = DB::connection()->prepare("SELECT * FROM Osallistuminen WHERE kayttaja_id = :id LIMIT 1");
        $query->execute(array('kayttaja_id' => $id));
        $row = $query->fetchAll();
        $osallistumiset = array();
        foreach ($rows as $row) {
           $osallistumiset[] = new Osallistuminen(array('kayttaja_id' => $rows['kayttaja_id'], 'tapahtuma_id' => $rows['tapahtuma_id']));
        }

        return $osallistumiset;
    }
    
    public static function findAllByTapahtuma($id) {
        $query = DB::connection()->prepare("SELECT * FROM Osallistuminen WHERE tapahtuma_id = :id LIMIT 1");
        $query->execute(array('tapahtuma_id' => $id));
        $row = $query->fetchAll();
        $osallistumiset = array();
        foreach ($rows as $row) {
            $osallistumiset[] = new Osallistuminen(array('kayttaja_id' => $rows['kayttaja_id'], 'tapahtuma_id' => $rows['tapahtuma_id']));
        }

        return $osallistumiset;
    }

    //put your code here
}
