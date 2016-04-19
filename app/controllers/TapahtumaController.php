<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TapahtumaController
 *
 * @author vipohjol
 */
class TapahtumaController {

    public static function luoUusiTapahtuma() {
        $params = $_POST;

        $tapahtuma = new Tapahtuma(array(
            'tapahtuman_nimi' => $params['tapahtuman_nimi'],
            'tapahtumapaikka' => $params['tapahtumapaikka'],
            'lyhyt_kuvaus' => $params['lyhyt_kuvaus'],
            'pvm' => $params['pvm'],
            'kellonaika' => $params['kellonaika']
        ));

        $tapahtuma->tallenna();

        Redirect::to('/tapahtumat', array('message' => 'Tapahtuma lisättiin onnistuneesti!'));
    }

    public static function naytaTapahtumasivu() {
        $tapahtumat = Tapahtuma::findAll();
        View::make('tapahtumat.html', array('tapahtumat' => $tapahtumat));
    }

    public static function naytaTapahtumanluontisivu() {
        View::make('tapahtumanluonti.html');
    }

  

    public static function naytaTapahtumanmuokkaussivu($id) {
        $tapahtuma = Tapahtuma::find($id);
        Kint::dump($tapahtuma);
        View::make('tapahtumanmuokkaus.html', array('tapahtuma' => $tapahtuma));
    }

    public static function update($id) {
        $parametrit = $_POST;

        $attribuutit = array(
            'id' => $id,
            'tapahtuman_nimi' => $parametrit['tapahtuman_nimi'],
            'lyhyt_kuvaus' => $parametrit['lyhyt_kuvaus'],
            'pvm' => $parametrit['pvm'],
            'kellonaika' => $parametrit['kellonaika'],
            'tapahtumapaikka' => $parametrit['tapahtumapaikka']
        );
        
//
//        // Alustetaan Game-olio käyttäjän syöttämillä tiedoilla
        $tapahtuma = new Tapahtuma($attribuutit);
        Kint::dump($attribuutit);
        $virheet = $tapahtuma->errors();
        
        if (count($virheet) > 0) {
         Kint::dump($virheet); 
            View::make('tapahtumanmuokkaus.html', array('virheet' => $virheet, 'attribuutit' => $attribuutit));
        } else {
            
            // Kutsutaan alustetun olion update-metodia, joka päivittää pelin tiedot tietokannassa
            $tapahtuma->update();

           Redirect::to('/tapahtumat', array('message' => 'Tapahtumaa muokattiin onnistuneesti!'));
        }
    }

    public static function poista($id) {
        // Alustetaan Game-olio annetulla id:llä
        $tapahtuma = new Tapahtuma(array('id' => $id));
        // Kutsutaan Game-malliluokan metodia destroy, joka poistaa pelin sen id:llä
        $tapahtuma->poista();

        // Ohjataan käyttäjä pelien listaussivulle ilmoituksen kera
        Redirect::to('/tapahtumat', array('message' => 'Tapahtuma on poistettu onnistuneesti!'));
    }

}

//put your code here

