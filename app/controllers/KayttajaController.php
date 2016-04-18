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
            'email_osoite' => $params['email_osoite']));
        $kayttaja->tallenna();

        Redirect::to('/', array('message' => 'Profiili lisättiin onnistuneesti!'));
    }

    public function naytaTilinluontilomake() {
        View::make('tilinluonti.html');
    }

    public static function login() {
        View::make('kirjautuminen.html');
    }

    public static function handle_login() {
        $params = $_POST;

        $kayttaja = Kayttaja::authenticate($params['kayttajatunnus'], $params['salasana']);

        if (!$user) {
            View::make('kirjautuminen.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'kayttajatunnus' => $params['kauttajatunnus']));
        } else {
            $_SESSION['kayttaja'] = $kayttaja->id;

            Redirect::to('tapahtumat.html', array('message' => 'Tervetuloa takaisin ' . $kayttaja->kayttajatunnus . '!'));
        }
    }

    //put your code here
}
