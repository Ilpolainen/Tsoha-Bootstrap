<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	echo 'Cool!';
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      echo 'Nyt ollaan housut hiekassa!';
    }
    
    public function hello() {
        View::make('Helloworld.html');
    }
    
    public function pelisivu() {
        View::make('Pelisivu.html');
    }
    
    public function loginsivu() {
        View::make('Login.html');
        
    }
    
    public function loginerrorviesti() {
        View::make('Pelisivu.html');
    }
  }
