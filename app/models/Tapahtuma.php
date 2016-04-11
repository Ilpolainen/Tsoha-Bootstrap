<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tapahtuma
 *
 * @author vipohjol
 */
class Tapahtuma extends BaseModel {

    public $id, $tapahtuman_nimi, $lyhyt_kuvaus, $pvm, $kellonaika, $tapahtumapaikka;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }


    public static function findAll() {
        $query = DB::connection()->prepare('SELECT * FROM tapahtuma');
        $query->execute();
        $rows = $query->fetchAll();

        $tapahtumat = array();

        foreach ($rows as $row) {
            $tapahtumat[] = new Tapahtuma(array('id' => $row['id'],
                'tapahtuman_nimi' => $row['tapahtuman_nimi'],
                'lyhyt_kuvaus' => $row['lyhyt_kuvaus'],
                'pvm' => $row['pvm'],
                'kellonaika' => $row['kellonaika'],
                'tapahtumapaikka' => $row['tapahtumapaikka'],
            ));
        }
        Kint::dump($tapahtumat);
        return $tapahtumat;
    }

    public static function find($id) {
        $query = DB::connection()->prepare("SELECT * FROM Tapahtuma WHERE id = :id LIMIT 1");
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $tapahtuma = new Tapahtuma(array('id' => $row['id'],
                'tapahtuman_nimi' => $row['tapahtuman_nimi'],
                'lyhyt_kuvaus' => $row['lyhyt_kuvaus'],
                '$pvm' => $row['pvm'],
                'kellonaika' => $row['kellonaika'],
                'tapahtumapaikka' => $row['tapahtumapaikka'],
            ));
        }
        return $tagi;
    }

    public function tallenna() {
        $query = DB::connection()->prepare('INSERT INTO Tapahtuma (tapahtuman_nimi, tapahtumapaikka, lyhyt_kuvaus, pvm, kellonaika) VALUES (:tapahtuman_nimi, :tapahtumapaikka, :lyhyt_kuvaus, :pvm, :kellonaika) RETURNING id');
        $query->execute(array('tapahtuman_nimi' => $this->tapahtuman_nimi, 'tapahtumapaikka' => $this->tapahtumapaikka, 'lyhyt_kuvaus' => $this->lyhyt_kuvaus, 'pvm' => $this->pvm, 'kellonaika' => $this->kellonaika));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public static function findByParams($params) {
        foreach ($params as $par) {
            
        }
    }

    public static function constructQuery($params) {
        
    }

    //put your code here
}
