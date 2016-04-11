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
        
         Redirect::to('/tapahtumat', array('message' => 'Taphtuma lisättiin onnistuneesti!'));
    }
    
    public function naytaTapahtumasivu() {
        $tapahtumat = Tapahtuma::findAll();    
         View::make('tapahtumat.html', array('tapahtumat' => $tapahtumat));
    }
    
    public function naytaTapahtumanluontisivu() {
        View::make('tapahtumanluonti.html');
    }


    public function naytaTapahtumanmuokkaussivu() {
        View::make('tapahtumanmuokkaus.html');
    }
   
    //put your code here
}
