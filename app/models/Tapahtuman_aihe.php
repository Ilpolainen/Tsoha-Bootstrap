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

    public $tapahtuma, $aihe;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function findAll() {
        $query = DB::connection()->prepare('SELECT * FROM Tapahtuman_aihe');
        $query->execute();

        $rows = $query->fetchAll();

        $aiheet = array();
        foreach ($rows as $row) {
            $aiheet[] = new Tapahtuman_aihe(array('tapahtuma' => $rows['tapahtuma'], 'aihe' => $rows['aihe']));
        }
        return $aiheet;
    }

    public static function findAllByTapahtuma($id) {
        $query = DB::connection()->prepare("SELECT * FROM Tapahtuman_aihe WHERE tapahtuma = :tapahtuma");
        $query->execute(array('tapahtuma' => $id));
        $rows = $query->fetchAll();
        $tapahtuman_aiheet = array();
        foreach ($rows as $row) {
            $tapahtuman_aiheet[] = new Tapahtuman_aihe(array('tapahtuma' => $row['tapahtuma'], 'aihe' => $row['aihe']));
        }

        return $tapahtuman_aiheet;
    }

    public static function findAllByTagi($id) {
        $query = DB::connection()->prepare("SELECT * FROM Tapahtuman_aihe WHERE aihe = :id");
        $query->execute(array('aihe' => $id));
        $row = $query->fetchAll();
        $tapahtuman_aiheet = array();
        foreach ($rows as $row) {
            $tapahtuman_aiheet[] = new Tapahtuman_aihe(array('tapahtuma' => $rows['tapahtuma'], 'aihe' => $rows['aihe']));
        }
        return $tapahtuman_aiheet;
    }

    public function onJoOlemassa() {
        $query = DB::connection()->prepare('SELECT * FROM Tapahtuman_aihe WHERE tapahtuma = :tapahtuma AND aihe = :aihe');
        $query->execute(array("tapahtuma" => $this->tapahtuma, "aihe" => $this->aihe));
        $row = $query->fetch();
        if ($row == null) {
            return false;
        }
        return true;
    }

    public function tallenna() {
        $query = DB::connection()->prepare('INSERT INTO Tapahtuman_aihe (tapahtuma, aihe) VALUES (:tapahtuma, :aihe) RETURNING id');
        $query->execute(array('tapahtuma' => $this->tapahtuma, 'aihe' => $this->aihe));
        $this->id = $query->fetch();
    }

    public static function poistaKaikkiTapahtumanIdlla($tapahtumaId) {
        $query = DB::connection()->prepare('DELETE FROM Tapahtuman_aihe WHERE tapahtuma = :tapahtuma');
        $query->execute(array('tapahtuma' => $tapahtumaId));
    }

    public static function poistaKaikki() {
        $query = DB::connection()->prepare('DELETE FROM Tapahtuman_aihe WHERE 1 = 1');
        $query->execute();
    }

    

    public function poistaArvoilla() {
        $query = DB::connection()->prepare('DELETE FROM Tapahtuman_aihe WHERE tapahtuma = :tapahtuma AND aihe = :aihe');
        $query->execute(array('tapahtuma' => $this->tapahtuma, 'aihe' => $this->aihe));
    }

    //put your code here
}
