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

    public static function naytaKayttajat() {
        self::check_logged_in();
        $kayttajat = Kayttaja::findAll();
        View::make('kayttajienlistaus.html', array('kayttajat' => $kayttajat));
    }

    public static function luoTili() {
        $params = $_POST;
        $kayttaja = new Kayttaja(array('etunimi' => $params['etunimi'],
            'sukunimi' => $params['sukunimi'],
            'kayttajatunnus' => $params['kayttajatunnus'],
            'salasana' => $params['salasana'],
            'syntyma_aika' => $params['syntyma_aika'],
            'osoite' => $params['osoite'],
            'puhelinnumero' => $params['puhelinnumero'],
            'email_osoite' => $params['email_osoite'],
            'kuvaus' => $params['kuvaus']
        ));
        $errors = $kayttaja->errors();
        if (count($errors) == 0) {
            $kayttaja->tallenna();
            Redirect::to('/etusivu', array('message' => 'Profiili lisättiin onnistuneesti!'));
        } else {
            View::make('tilinluonti.html', array('errors' => $errors));
        }
    }

    public static function poistetaankoTili($id) {
        $kayttaja = Kayttaja::find($id);
        View::make('tilinpoisto.html', array('kayttaja' => $kayttaja));
    }
    
    public static function poistaTili($id) {
        $kayttaja = Kayttaja::find($id);
        $kayttaja->poista();
        self::naytaKayttajat();
    }

    public static function julkinenprofiili($id) {
        self::check_logged_in();
        $kayttajaid = intval($id);
        $kayttaja = Kayttaja::find($id);
        $yllapitaja = (self::get_user_logged_in()->id == 1);
        $kiinnostukset = Kiinnostustagi::findByKayttaja($kayttajaid);
        View::make('julkinenprofiili.html', array('kiinnostukset' => $kiinnostukset, 'kayttaja' => $kayttaja, 'yllapitaja' => $yllapitaja));
    }

    public static function naytaTilinluontilomake() {
        View::make('tilinluonti.html');
    }

    public static function muokkaaProfiilia() {
        self::check_logged_in();
        $id = self::get_user_logged_in();
        $parametrit = $_POST;

        $attribuutit = array(
            'id' => $id,
            'etunimi' => $parametrit['etunimi'],
            'sukunimi' => $parametrit['sukunimi'],
            'kayttajatunnus' => $parametrit['kayttajatunnus'],
            'salasana' => $parametrit['salasana'],
            'osoite' => $parametrit['osoite'],
            'puhelinnumero' => $parametrit['puhelinnumero'],
            'email_osoite' => $parametrit['email_osoite'],
            'kuvaus' => $parametrit['kuvaus']
        );

//
//        // Alustetaan Game-olio käyttäjän syöttämillä tiedoilla
        $kayttaja = new Kayttaja($attribuutit);
        Kint::dump($attribuutit);
        $virheet = $kayttaja->errors();

        if (count($virheet) > 0) {
            Kint::dump($virheet);
            View::make('profiilinmuokkaus.html', array('virheet' => $virheet, 'attribuutit' => $attribuutit));
        } else {

            // Kutsutaan alustetun olion update-metodia, joka päivittää pelin tiedot tietokannassa
            $kayttaja->update();

            Redirect::to('/tapahtumat', array('message' => 'Profiiliasi muokattiin onnistuneesti!'));
        }
    }

    public static function naytaKirjautumislomake() {
        View::make('kirjautuminen.html');
    }

    public static function naytaProfiilinmuokkaussivu() {
        self::check_logged_in();
        $kayttaja = self::get_user_logged_in();
        View::make('profiilinmuokkaus.html', array('kayttaja' => $kayttaja));
    }

    public static function handle_login() {
        $params = $_POST;

        $kayttaja = Kayttaja::authenticate($params['kayttajatunnus'], $params['salasana']);

        if (!$kayttaja) {
            View::make('/kirjautuminen.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'kayttajatunnus' => $params['kayttajatunnus']));
        } else {
            $_SESSION['kayttaja'] = $kayttaja->id;
            self::julkinenprofiili($kayttaja->id);
        }
    }

    public static function kirjauduUlos() {
        $_SESSION['kayttaja'] = null;

        Redirect::to('/etusivu', array('message' => 'Olet kirjautunut ulos! Tervetuloa uudelleen!'));
    }

    public static function naytaEtusivu() {
        View::make('etusivu.html');
    }

}
