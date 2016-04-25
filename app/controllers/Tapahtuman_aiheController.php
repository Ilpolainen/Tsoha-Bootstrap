<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tapahtuman_aiheController
 *
 * @author vipohjol
 */
class Tapahtuman_aiheController extends BaseController {

    public static function lisaaAihe($tapahtuma, $aihe) {
        $tapahtumanAihe = new Tapahtuman_aihe(array('tapahtuma' => $tapahtuma, 'aihe' => $aihe));
        $tapahtumanAihe->save();
    }

    public static function paivitaAiheet($tapahtumaId) {
        $id = intval($tapahtumaId);
        
        $aiheet = Kiinnostustagi::findAll();
        
        $checkBoxLista = $_POST;
        foreach ($checkBoxLista as $key => $value) {
            foreach ($aiheet as $aihe) {
                $ta = new Tapahtuman_aihe(array('tapahtuma' => $id, 'aihe' => $aihe->id));
                if ($key == $aihe->id && !$ta->onJoOlemassa()) {
                    $ta->tallenna();
                }
            }
        }

        $tapahtumanKomplementti = array();
        foreach ($aiheet as $aihe) {
            $tapahtumanKomplementti[] = $aihe->id;
        }
//        Kint::dump($checkBoxLista);
        foreach ($checkBoxLista as $key => $value) {
            unset($tapahtumanKomplementti[$key - 1]);
        }

//        Kint::dump($kayttajanKomplementti);


        foreach ($tapahtumanKomplementti as $aihe) {
            $ta = new Tapahtuman_aihe(array('tapahtuma' => $id, 'aihe' => $aihe));
            $ta->poistaArvoilla();
        }
        TapahtumaController::naytaTapahtuma($id);
    }

    //put your code here
}
