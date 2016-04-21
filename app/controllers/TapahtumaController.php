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
class TapahtumaController extends BaseController {

    public static function luoUusiTapahtuma() {
        $params = $_POST;

        $tapahtuma = new Tapahtuma(array(
            'tapahtuman_nimi' => $params['tapahtuman_nimi'],
            'tapahtumapaikka' => $params['tapahtumapaikka'],
            'lyhyt_kuvaus' => $params['lyhyt_kuvaus'],
            'pvm' => $params['pvm'],
            'kellonaika' => $params['kellonaika'],
            'tapahtuman_luoja' => self::get_user_logged_in()->id
        ));

        $tapahtuma->tallenna();

        Redirect::to('/tapahtumat', array('message' => 'Tapahtuma lisättiin onnistuneesti!'));
    }

    public static function naytaTapahtumatSivu() {
        self::check_logged_in();
        $tapahtumat = Tapahtuma::findAll();
        $laajennetut = array();

        foreach ($tapahtumat as $tapahtuma) {
            $kirjautunut = self::get_user_logged_in();
            $osallistuminen = false;
            $onLuoja = false;
            if (Osallistuminen::isAttending($kirjautunut->id, $tapahtuma->id)) {
                $osallistuminen = true;
            }
            if ($kirjautunut->id == $tapahtuma->tapahtuman_luoja) {
                $onLuoja = true;
            }
            $laajennetut[] = array(
                'id' => $tapahtuma->id,
                'tapahtuman_nimi' => $tapahtuma->tapahtuman_nimi,
                'lyhyt_kuvaus' => $tapahtuma->lyhyt_kuvaus,
                'pvm' => $tapahtuma->pvm,
                'kellonaika' => $tapahtuma->kellonaika,
                'tapahtumapaikka' => $tapahtuma->tapahtumapaikka,
                'osallistuminen' => $osallistuminen,
                'onLuoja' => $onLuoja,
                'kirjautunut' => $kirjautunut
            );
        }
        View::make('tapahtumat.html', array('tapahtumat' => $laajennetut));
    }

    public static function naytaTapahtuma($id) {
        self::check_logged_in();
        $tapahtuma = Tapahtuma::find($id);
        $luoja = Kayttaja::find($tapahtuma->tapahtuman_luoja);
        $kirjautunut = TapahtumaController::get_user_logged_in()->id;
        $onLuoja = false;
        if ($luoja->id == $kirjautunut) {
            $onLuoja = true;
        }
        $osallistuminen = false;
        if (Osallistuminen::isAttending($kirjautunut, $tapahtuma->id)) {
            $osallistuminen = true;
        }
        $laajennettu = array(
            'id' => $tapahtuma->id,
            'tapahtuman_nimi' => $tapahtuma->tapahtuman_nimi,
            'lyhyt_kuvaus' => $tapahtuma->lyhyt_kuvaus,
            'pvm' => $tapahtuma->pvm,
            'kellonaika' => $tapahtuma->kellonaika,
            'tapahtumapaikka' => $tapahtuma->tapahtumapaikka,
            'osallistuminen' => $osallistuminen,
            'onLuoja' => $onLuoja,
            'tapahtuman_luoja' => $luoja->kayttajatunnus,
            'kirjautunut' => $kirjautunut
        );
        Kint::dump($laajennettu);
        View::make('tapahtumasivu.html', array('tapahtuma' => $laajennettu));
    }

    public static function naytaTapahtumanluontisivu() {
        View::make('tapahtumanluonti.html');
    }

    public static function naytaTapahtumanmuokkaussivu($id) {
        $tapahtuma = Tapahtuma::find($id);
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
            'tapahtumapaikka' => $parametrit['tapahtumapaikka'],
            'tapahtuman_luoja' => self::get_user_logged_in()->id
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

    public static function osallistu($tapahtuma_id) {
        if(!isset($_SESSION['user'])){
      Redirect::to('/kirjautuminen', array('message' => 'Kirjaudu ensin sisään!'));
    }
        $osallistuminen = new Osallistuminen(array('kayttaja_id' => self::get_user_logged_in()->id, 'tapahtuma_id' => $tapahtuma_id));
        $osallistuminen->save();
        Redirect::to('/tapahtumat');
    }

    public static function poistaIlmo($tapahtumaid) {
        $kayttajanOsallistumiset = Osallistuminen::findAllByKayttaja(self::get_user_logged_in()->id);
        foreach ($kayttajanOsallistumiset as $os) {
            if ($os->tapahtuma_id == $tapahtumaid) {
                $os->poista();
            }
        }

        Redirect::to('/tapahtumat');
    }

    public static function naytaTapahtumanpoisto($id) {
        self::check_logged_in();
        $tapahtuma = Tapahtuma::find($id);
        View::make('tapahtumanpoisto.html', array('tapahtuma' => $tapahtuma));
    }

}

//put your code here

