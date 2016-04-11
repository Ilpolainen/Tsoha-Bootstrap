<?php


$routes->get('/', function() {
    HelloWorldController::index();
});


$routes->get('/hello', function() {
    HelloWorldController::hello();
});

$routes->get('/kirjautuminen', function() {
    HelloWorldController::loginsivu();
});

$routes->get('/tilinluonti', function() {
    HelloWorldController::signupsivu();
});

$routes->get('/omasivu', function() {
    HelloWorldController::naytaomasivu();
});

$routes->get('/profiilinmuokkaus', function() {
    HelloWorldController::muokkaaprofiilia();
});

$routes->get('/etusivu', function() {
    HelloWorldController::etusivu();
});

$routes->get('/kiinnostukset', function() {
    HelloWorldController::kiinnostussivu();
});

$routes->get('/kiinnostuksenluonti', function() {
    HelloWorldController::luokiinnostus();
});

$routes->get('/kayttajienlistaus', function() {
    KayttajaController::index();
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

$routes->get('/tapahtumanmuokkaus', function() {
    TapahtumaController::naytaTapahtumanmuokkaussivu();
});





