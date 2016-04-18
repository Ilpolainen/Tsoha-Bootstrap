<?php

class BaseModel {

    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null) {
        // Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
            // Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }
    }

    public function errors() {
        // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
        $errors = array();

        foreach ($this->validators as $validator) {
            $errors = array_merge($errors, $this->{$validator}());
        }

        return $errors;
    }

    public function validate_string_length($string, $length) {
        if ($string == '' || $string == null || strlen($string) < $length) {
            return false;
        } else {
            return true;
        }
    }

    public function checkIfDate($date) {
        $parts = explode('-', $date);
        $i = 0;
        $d = 0;
        $m = 0;
        $y = 0;
        foreach ($parts as $part) {
            if ($i == 0) {
                $d = $part;
            } elseif ($i == 1) {
                $m = $part;
            } elseif ($i == 2) {
                $y = $part;
            }
            $i = $i + 1;
        }
        if ($i != 3) {
            return false;
        } else if (!(is_numeric($d) && is_numeric($m) && is_numeric($y))) {
            return false;
        }
        if (!checkdate($m, $d, $y)) {
            return false;
        }
        return true;
    }

    public function checkIfTime($time) {
        $parts = explode(':', $time);
        $i = 0;
        $minutes = 0;
        $hours = 0;
        foreach ($parts as $part) {
            if ($i == 0) {
                $hours = $part;
            } elseif ($i == 1) {
                $minutes = $part;
            }
            $i = $i + 1;
        }
        
        if ($i != 2) {         
            return false;
        }
        if (!(is_numeric($minutes) && is_numeric($hours))) {
            return false;
        }
        $minutes = intval($minutes);
        $hours = intval($hours);
        if ($minutes < 0 || $minutes > 59 || $hours < 0 || $hours > 23) {
            return false;
        }
        return true;
    }

}
