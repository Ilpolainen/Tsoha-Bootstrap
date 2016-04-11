<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tapahtuman_aihe
 *
 * @author vipohjol
 */
class Tapahtuman_aihe extends BaseModel {
    
    public $tapahtuma_id, $kiinnostustagi_id;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function findAll() {
        $query = DB::connection()->prepare('SELECT * FROM Tapahtman_aihe');
        $query->execute();
        $rows = $query->fetchAll();
        
        $aiheet = array();
        foreach ($rows as $row) {
            $aiheet[] = new Tapahtuman_aihe(array('tapahtuma_id' => $rows['tapahtuma_id'], 'kiinnostustagi_id' => $rows['kiinnostustagi_id']));
        }
        return $aiheet;
    }
    
     public static function findAllByTapahtuma($id) {
        $query = DB::connection()->prepare("SELECT * FROM Tapahtuman_aihe WHERE tapahtuma_id = :id LIMIT 1");
        $query->execute(array('tapahtuma_id' => $id));
        $row = $query->fetchAll();
        $tapahtuman_aiheet = array();
        foreach ($rows as $row) {
            $tapahtuman_aiheet[] = new Tapahtuman_aihe(array('tapahtuma_id' => $rows['tapahtuma_id'], 'kiinnostustagi_id' => $rows['kiinnostustagi_id']));
        }

        return $tapahtuman_aiheet;
    }

    public static function findAllByTagi($id) {
        $query = DB::connection()->prepare("SELECT * FROM Tapahtuman_aihe WHERE kiinnostustagi_id = :id LIMIT 1");
        $query->execute(array('kiinnostustagi_id' => $id));
        $row = $query->fetchAll();
        $tapahtuman_aiheet = array();
        foreach ($rows as $row) {
            $tapahtuman_aiheet[] = new Tapahtuman_aihe(array('tapahtuma_id' => $rows['tapahtuma_id'], 'kiinnostustagi_id' => $rows['kiinnostustagi_id']));
        }

        return $tapahtuman_aiheet;
    }
    //put your code here
}
