<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OsallistumisController
 *
 * @author vipohjol
 */
class OsallistumisController extends BaseController {
    
    public static function osallistu($tapahtuma_id) {
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
    //put your code here
}
