<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of KiinnostusController
 *
 * @author vipohjol
 */
class KiinnostusController extends BaseController {

    //put your code here
    public static function naytaKiinnostustagit() {
        $tagit = Kiinnostustagi::findAll();
        View::make('kiinnostukset.html', array('tagit' => $tagit));
    }

    public static function naytaKiinnostuksenLuonti() {
        View::make('kiinnostuksenluonti.html');
    }

    public static function luoKiinnostus() {
        $parametrit = $_POST;
        $kiinnostus = $parametrit['kiinnostus'];
        $kiinnostusTagi = new Kiinnostustagi(array('kiinnostus' => $kiinnostus));
        if ($kiinnostusTagi->onJoOlemassa()) {
            Redirect::to('/kiinnostukset', array('message' => 'Samanniminen kiinnostus on jo olemassa!'));
        } else {
            $kiinnostusTagi->tallenna();
            Redirect::to('/kiinnostukset', array('message' => 'Uusi kiinnostus luotu!'));
        }
    }

    public static function paivitaKiinnostukset() {
        $kayttaja = self::get_user_logged_in();
        $kiinnostukset = Kiinnostustagi::findAll();
        $totuusarvot = $_POST;
        foreach ($kiinnostukset as $kiinnostus) {
            $kk = new Kayttajan_kiinnostus($kayttaja->id, $kiinnostus->id);
            if (!$totuusarvot[$kiinnostus->kiinnostus]) {
                $kk->poista();
            } else {
                if (!$kk->onJoOlemassa()) {
                     $kk->tallenna();
                }              
            }
        }
    }

}
