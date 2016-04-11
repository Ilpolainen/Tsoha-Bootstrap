<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of KayttajaController
 *
 * @author vipohjol
 */
class KayttajaController extends BaseController {
    
    public static function index() {
        $kayttajat = Kayttaja::findAll();
        View::make('kayttajienlistaus.html', array('kayttajat' => $kayttajat));
    }
    //put your code here
}
