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
        $kiinnostustagit = Kiinnostustagi::findAll();
        
        View::make('kiinnostukset.html', array('tagit' => $kiinnostustagit));
        
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
        $checkBoxLista = $_POST;
        foreach ($checkBoxLista as $key => $value) {
            foreach ($kiinnostukset as $kiinnostus) {
                $kk = new Kayttajan_kiinnostus(array('kayttaja' => $kayttaja->id, 'kiinnostus' => $kiinnostus->id));                
                if ($key == $kiinnostus->id && !$kk->onJoOlemassa()) {
//                    Kint::dump($kiinnostus);
                    $kk->tallenna();
                }
            }
        }
        
        $kayttajanKomplementti = array();
        foreach ($kiinnostukset as $kiinnostus) {
            $kayttajanKomplementti[] = $kiinnostus->id;
        }
//        Kint::dump($checkBoxLista);
        foreach ($checkBoxLista as $key => $value) {
            unset($kayttajanKomplementti[$key - 1]);
        }
        
//        Kint::dump($kayttajanKomplementti);
       
        
        foreach ($kayttajanKomplementti as $kiinnostusId) {
            $kk = new Kayttajan_kiinnostus(array('kayttaja' => $kayttaja->id, 'kiinnostus' => $kiinnostusId));
            $kk->poistaArvoilla();
        }
        Redirect::to('/julkinenprofiili/' . $kayttaja->id);
    }
    
     public static function haeTagitTapahtumaIdlla($id) {
        $teeteet = Tapahtuman_aihe::findAllByTapahtuma($id);
        $tagit = array();
        foreach ($teeteet as $tt) {
            $tagi = self::
            $tagit[] = $tagi;
        }
        
        return $tagit;
    }
    
    

}
