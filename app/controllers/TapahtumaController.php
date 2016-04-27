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
        $errors = $tapahtuma->errors();
        if (count($errors) > 0) {
            View::make('tapahtumanluonti.html', array('errors' => $errors));
        } else {
            $tapahtuma->tallenna();
            Tapahtuman_aiheController::paivitaAiheet($tapahtuma->id);
            Redirect::to('/tapahtumat', array('message' => 'Tapahtuma lisättiin onnistuneesti!'));
        }
    }

    public static function naytaTapahtumatSivu() {
        self::check_logged_in();
        $kirjautunut = self::get_user_logged_in();
        $tapahtumat = Tapahtuma::findAll();
        $laajennetut = array();
        foreach ($tapahtumat as $tapahtuma) {
            $osallistuminen = false;
            $onLuoja = false;
            if (Osallistuminen::isAttending($kirjautunut->id, $tapahtuma->id)) {
                $osallistuminen = true;
            }
            if ($kirjautunut->id == $tapahtuma->tapahtuman_luoja) {
                $onLuoja = true;
            }
            $laajennetut[] = array('id' => $tapahtuma->id, 'tapahtuman_nimi' => $tapahtuma->tapahtuman_nimi, 'lyhyt_kuvaus' => $tapahtuma->lyhyt_kuvaus, 'pvm' => $tapahtuma->pvm, 'kellonaika' => $tapahtuma->kellonaika, 'tapahtumapaikka' => $tapahtuma->tapahtumapaikka, 'osallistuminen' => $osallistuminen, 'onLuoja' => $onLuoja, 'kirjautunut' => $kirjautunut);
        }
        View::make('tapahtumat.html', array('tapahtumat' => $laajennetut));
    }

    public static function naytaTapahtuma($id) {
        self::check_logged_in();
        $tapahtumaId = intval($id);
        $tapahtuma = Tapahtuma::find($tapahtumaId);
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
        $laajennettu = array('id' => $tapahtuma->id, 'tapahtuman_nimi' => $tapahtuma->tapahtuman_nimi, 'lyhyt_kuvaus' => $tapahtuma->lyhyt_kuvaus, 'pvm' => $tapahtuma->pvm, 'kellonaika' => $tapahtuma->kellonaika, 'tapahtumapaikka' => $tapahtuma->tapahtumapaikka, 'osallistuminen' => $osallistuminen, 'onLuoja' => $onLuoja, 'tapahtuman_luoja' => $luoja->kayttajatunnus, 'kirjautunut' => $kirjautunut);
        $kiinnostustagit = Kiinnostustagi::findByTapahtuma($id);
        $tagit = array();
        foreach ($kiinnostustagit as $tagi) {
            $tagit[] = $tagi->kiinnostus;
        }
        View::make('tapahtumasivu.html', array('tapahtuma' => $laajennettu, 'tagit' => $tagit));
    }

    public static function naytaTapahtumanluontisivu() {
        $tagit = Kiinnostustagi::findAll();
        View::make('tapahtumanluonti.html', array('tagit' => $tagit));
    }

    public static function naytaTapahtumanmuokkaussivu($id) {

        $tapahtuma = Tapahtuma::find($id);
        $tagit = Kiinnostustagi::findAll();
        View::make('tapahtumanmuokkaus.html', array('tapahtuma' => $tapahtuma, 'tagit' => $tagit));
    }

    public static function naytaModattuSivu() {
        $kayttaja = self::get_user_logged_in();
        $valitut = Tapahtuma::etsiKayttajaaKiinnostavat(intval($kayttaja->id));
        $laajennetut = array();
        foreach ($valitut as $tapahtuma) {
            $osallistuminen = false;
            $onLuoja = false;
            if (Osallistuminen::isAttending($kayttaja->id, $tapahtuma->id)) {
                $osallistuminen = true;
            }
            if ($kayttaja->id == $tapahtuma->tapahtuman_luoja) {
                $onLuoja = true;
            }
            $laajennetut[] = array('id' => $tapahtuma->id, 'tapahtuman_nimi' => $tapahtuma->tapahtuman_nimi, 'lyhyt_kuvaus' => $tapahtuma->lyhyt_kuvaus, 'pvm' => $tapahtuma->pvm, 'kellonaika' => $tapahtuma->kellonaika, 'tapahtumapaikka' => $tapahtuma->tapahtumapaikka, 'osallistuminen' => $osallistuminen, 'onLuoja' => $onLuoja, 'kirjautunut' => $kayttaja);
        }
        View::make('tapahtumat.html', array('tapahtumat' => $laajennetut));
    }

    public static function update($id) {
        $parametrit = $_POST;
        Tapahtuman_aiheController::paivitaAiheet(intval($id));
        $attribuutit = array('id' => $id, 'tapahtuman_nimi' => $parametrit['tapahtuman_nimi'], 'lyhyt_kuvaus' => $parametrit['lyhyt_kuvaus'], 'pvm' => $parametrit['pvm'], 'kellonaika' => $parametrit['kellonaika'], 'tapahtumapaikka' => $parametrit['tapahtumapaikka'], 'tapahtuman_luoja' => self::get_user_logged_in()->id);
        $tapahtuma = new Tapahtuma($attribuutit);
        $virheet = $tapahtuma->errors();
        if (count($virheet) > 0) {
            View::make('tapahtumanmuokkaus.html', array('virheet' => $virheet, 'attribuutit' => $attribuutit));
        } else {
            $tapahtuma->update();
            Redirect::to('/tapahtumat', array('message' => 'Tapahtumaa muokattiin onnistuneesti!'));
        }
    }

    public static function poista($id) {
        $tapahtuma = new Tapahtuma(array('id' => $id));
        $tapahtuma->poista();
        Redirect::to('/tapahtumat', array('message' => 'Tapahtuma on poistettu onnistuneesti!'));
    }

    public static function osallistu($tapahtuma_id) {
        if (!isset($_SESSION['user'])) {
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

