<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
      View::make('etusivu.html');
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      echo 'Nyt ollaan housut hiekassa!';
    }
    
    public function hello() {
        View::make('Helloworld.html');
    }
    
    public function loginsivu() {
        View::make('kirjautuminen.html');
        
    }
    
    public function loginerrorviesti() {
        View::make('Pelisivu.html');
    }
    
    public function signupsivu() {
        View::make('tilinluonti.html');
    }
    
     public function naytaomasivu() {
        View::make('omasivu.html');
    }
    
     public function muokkaaprofiilia() {
        View::make('profiilinmuokkaus.html');
    }
    
    
    public function etusivu() {
        View::make('etusivu.html');
    }
    
    public function kiinnostussivu() {
        View::make('kiinnostukset.html');
    }
    
    public function luokiinnostus() {
        View::make('kiinnostuksenluonti.html');
    }
    
    
    
   
    
    public function kayttajienlistaus() {
        View::make('kayttajienlistaus.html');
    }
    
    public function julkinenprofiili() {
        View::make('julkinenprofiili.html');
    }
    
  }
