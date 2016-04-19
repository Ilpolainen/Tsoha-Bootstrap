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
        $this->validators = array('validateTapahtumannimi', 'validatePvm', 'validateKellonaika');
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
                'pvm' => $row['pvm'],
                'kellonaika' => $row['kellonaika'],
                'tapahtumapaikka' => $row['tapahtumapaikka'],
            ));
        }
        return $tapahtuma;
    }

    public function tallenna() {
        $query = DB::connection()->prepare('INSERT INTO Tapahtuma (tapahtuman_nimi, tapahtumapaikka, lyhyt_kuvaus, pvm, kellonaika) VALUES (:tapahtuman_nimi, :tapahtumapaikka, :lyhyt_kuvaus, :pvm, :kellonaika) RETURNING id');
        $query->execute(array('tapahtuman_nimi' => $this->tapahtuman_nimi, 'tapahtumapaikka' => $this->tapahtumapaikka, 'lyhyt_kuvaus' => $this->lyhyt_kuvaus, 'pvm' => $this->pvm, 'kellonaika' => $this->kellonaika));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
    public function update() {
        $query = DB::connection()->prepare('UPDATE Tapahtuma SET tapahtuman_nimi = :tapahtuman_nimi, lyhyt_kuvaus = :lyhyt_kuvaus, pvm = :pvm, kellonaika = :kellonaika, tapahtumapaikka = :tapahtumapaikka WHERE id = :id');
        $query->execute(array('id' => $this->id,'tapahtuman_nimi' => $this->tapahtuman_nimi, 'lyhyt_kuvaus' => $this->lyhyt_kuvaus, 'pvm' => $this->pvm, 'kellonaika' => $this->kellonaika, 'tapahtumapaikka' => $this->tapahtumapaikka));
    }
    
    public function poista() {
        $query = DB::connection()->prepare('DELETE FROM Tapahtuma WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

    public function validateTapahtumannimi() {
        $errors = array();
        if (!$this->validate_string_length($this->tapahtuman_nimi, 3)) {
            $errors[] = 'Tapahtumannimen tulee olla vähintään 3 merkkiä pitkä';
        }
        return $errors;
    }

    public function validatePvm() {
        $errors = array();
        if (!$this->validate_string_length($this->pvm, 1)) {
            $errors[] = 'Päivämäärä ei saa olla tyhjä!';
        } else {
            if (!$this->checkIfDate($this->pvm)) {
                $errors[] = 'Päivämäärä ei ole muotoa YYYY-MM-DD!';
            }
        }
        return $errors;
    }
    
    public function validateKellonaika() {
        $errors = array();
        if (!$this->validate_string_length($this->kellonaika, 1)) {
            $errors[] = 'Kellonaika ei saa olla tyhjä!';
        } else {
            if (!$this->checkIfTime($this->kellonaika)) {
                $errors[] = 'Kellonaika ei ole muotoa MM:HH tai MM:HH:SS!';
            }
        }
        return $errors;
    }
    
    
    
    
    
    

    public static function findByParams($params) {
        foreach ($params as $par) {
            
        }
    }

    public static function constructQuery($params) {
        
    }

    //put your code here
}
