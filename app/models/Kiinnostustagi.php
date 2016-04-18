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

    public static function find($id) {
        $query = DB::connection()->prepare("SELECT * FROM Kiinnostustagi WHERE id = :id LIMIT 1");
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $tagi = new Kiinnostustagi(array('id' => $row['id'], 'kiinnostus' => $row['kiinnostus']));
        }

        return $tagi;
    }

    public function validateKiinnostus() {
        $errors = array();
        if (!$this->validate_string_length($this->kiinnostus, 2)) {
            $errors[] = 'kiinnostuksen nimen tulee olla vähintään 2 merkkiä pitkä';
        }
    }

    //put your code here
}