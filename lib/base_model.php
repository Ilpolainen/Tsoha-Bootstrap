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

    public function validate_min_string_length($string, $length) {
        if ($string == '' || $string == null || strlen($string) < $length) {
            return false;
        } else {
            return true;
        }
    }
    
    public function validate_max_string_length($string, $length) {
        if ($string == '' || $string == null || strlen($string) > $length) {
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
                $y = $part;
            } elseif ($i == 1) {
                $m = $part;
            } elseif ($i == 2) {
                $d = $part;
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
        $seconds;
        $minutes = 0;
        $hours = 0;
        foreach ($parts as $part) {
            if ($i == 0) {
                $hours = $part;
            } elseif ($i == 1) {
                $minutes = $part;
            } elseif ($i == 2) {
                $seconds = $part;
            }
            $i = $i + 1;
        }

        if ($i == 2) {
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

        if ($i == 3) {
            if (!(is_numeric($minutes) && is_numeric($hours) && is_numeric($seconds))) {
                return false;
            }
            $minutes = intval($minutes);
            $hours = intval($hours);
            $seconds = intval($seconds);
            if ($seconds < 0 || $seconds > 59 ||  $minutes < 0 || $minutes > 59 || $hours < 0 || $hours > 23) {
                return false;
            }
            return true;
        }

        return false;
    }

}
