<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/hello', function() {
    HelloWorldController::hello();
});

$routes->get('/pelisivu', function() {
    HelloWorldController::pelisivu();
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

$routes->get('/tapahtumasivu', function () {
    HelloWorldController::tapahtumasivu();
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

$routes->get('/tapahtumanluonti', function() {
    HelloWorldController::luotapahtuma();
});

$routes->get('/tapahtumanmuokkaus', function() {
    HelloWorldController::muokkaatapahtumaa();
});

$routes->get('/kayttajienlistaus', function() {
    HelloWorldController::kayttajienlistaus();
});

$routes->get('/julkinenprofiili', function() {
    HelloWorldController::julkinenprofiili();
});


