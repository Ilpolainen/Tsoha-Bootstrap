<?php


$routes->get('/', function() {
    HelloWorldController::naytaEtusivu();
});


$routes->get('/kirjautuminen', function() {
    HelloWorldController::naytaKirjautumislomake();
});

$routes->get('/tilinluonti', function() {
    KayttajaController::naytaTilinluontilomake();
});

$routes->post('/tilinluonti', function() {
    KayttajaController::luoTili();
});

$routes->get('/omasivu', function() {
    HelloWorldController::naytaomasivu();
});

$routes->get('/profiilinmuokkaus', function() {
    HelloWorldController::muokkaaprofiilia();
});

$routes->get('/etusivu', function() {
    HelloWorldController::naytaEtusivu();
});

$routes->get('/kiinnostukset', function() {
    KiinnostusController::naytaKiinnostustagit();
});

$routes->get('/kiinnostuksenluonti', function() {
    HelloWorldController::luokiinnostus();
});

$routes->get('/kayttajienlistaus', function() {
    KayttajaController::naytaKayttajat();
});

$routes->get('/julkinenprofiili', function() {
    HelloWorldController::julkinenprofiili();
});

$routes->get('/tapahtumat', function () {
    TapahtumaController::naytaTapahtumasivu();
});

$routes->get('/tapahtumanluonti', function() {
    TapahtumaController::naytaTapahtumanluontisivu();
});

$routes->post('/tapahtumanluonti', function() {
    TapahtumaController::luoUusiTapahtuma();
});


$routes->get('/tapahtumanmuokkaus/:id/', function($id){
  // Pelin muokkauslomakkeen esittäminen
  TapahtumaController::editoiTapahtumaa($id);
});
$routes->post('/tapahtumanmuokkaus/:id/', function($id){
  // Pelin muokkaaminen
  TapahtumaController::editoiTapahtumaa($id);
});

$routes->post('/tapahtumanpoisto/:id/', function($id){
  // Pelin poisto
  TapahtumaController::poista($id);
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/kirjautuminen', function(){
  // Kirjautumislomakkeen esittäminen
  KayttajaController::login();
});
$routes->post('/kirjautuminen', function(){
  // Kirjautumisen käsittely
  KayttajaController::handle_login();
});



