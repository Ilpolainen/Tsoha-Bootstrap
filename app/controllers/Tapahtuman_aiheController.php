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
        $checkBoxLista = $_POST;
        Tapahtuman_aihe::poistaKaikkiTapahtumanIdlla($id);
        foreach ($checkBoxLista as $key => $value) {
            if (is_numeric($key)) {
                $ta = new Tapahtuman_aihe(array('tapahtuma' => $id, 'aihe' => $key));
                $ta->tallenna();
            }
        }
        TapahtumaController::naytaTapahtuma($id);
    }

    //put your code here
}
