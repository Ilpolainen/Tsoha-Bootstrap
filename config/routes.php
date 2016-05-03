<?php

$routes->get('/', function() {
    KayttajaController::naytaEtusivu();
});

$routes->get('/etusivu', function() {
    KayttajaController::naytaEtusivu();
});

$routes->get('/sandbox', function() {
    HelloWorldController::sandbox();
    
});

$routes->get('/kirjautuminen', function() {
    KayttajaController::naytaKirjautumislomake();
});

$routes->post('/kirjautuminen', function() {
    KayttajaController::handle_login();
});

$routes->get('/uloskirjautuminen', function() {
    KayttajaController::kirjauduUlos();
});

$routes->get('/tilinluonti', function() {
    KayttajaController::naytaTilinluontilomake();
});

$routes->post('/tilinluonti', function() {
    KayttajaController::luoTili();
});

$routes->post('/tilinpoisto/:id', function($id) {
    KayttajaController::poistaTili($id);
});

$routes->post('/tilinpoistoon/:id', function($id) {
    KayttajaController::poistetaankoTili($id);
});

$routes->get('/omasivu', function() {
    HelloWorldController::naytaomasivu();
});

$routes->get('/profiilinmuokkaus/', function() {
    KayttajaController::naytaProfiilinmuokkaussivu();
});

$routes->post('/profiilinmuokkaus/', function() {
    KayttajaController::muokkaaProfiilia();
});

$routes->get('/kiinnostukset', function() {
    KiinnostusController::naytaKiinnostustagit();
});

$routes->post('/paivitakiinnostukset', function() {
    KiinnostusController::paivitaKiinnostukset();
});

$routes->get('/kiinnostuksenluonti', function() {
    KiinnostusController::naytaKiinnostuksenLuonti();
});

$routes->post('/kiinnostuksenluonti', function() {
    KiinnostusController::luoKiinnostus();
});

$routes->get('/kayttajienlistaus', function() {
    KayttajaController::naytaKayttajat();
});

$routes->get('/julkinenprofiili/:id/', function($id) {
    KayttajaController::julkinenprofiili($id);
});

$routes->get('/tapahtumat', function () {
    TapahtumaController::naytaTapahtumatSivu();
});


$routes->get('/tapahtumanluonti', function() {
    TapahtumaController::naytaTapahtumanluontisivu();
});

$routes->post('/tapahtumanluonti', function() {
    TapahtumaController::luoUusiTapahtuma();
});

$routes->get('/tapahtumasivu/:id/', function($id) {
    TapahtumaController::naytaTapahtuma($id);
});

$routes->post('/naytaTapahtumanmuokkaus/:id/', function($id) {
    TapahtumaController::naytaTapahtumanmuokkaussivu($id);
});

$routes->get('/naytaTapahtumanmuokkaus/:id/', function($id) {
    TapahtumaController::naytaTapahtumanmuokkaussivu($id);
});

$routes->post('/tapahtumanmuokkaus/:id/', function($id) {
    TapahtumaController::update($id);
});

$routes->get('/tapahtumanpoisto/:id/', function($id) {
    TapahtumaController::naytaTapahtumanpoisto($id);
});

$routes->post('/tapahtumanpoisto/:id/', function($id) {
    TapahtumaController::poista($id);
});


$routes->post('/tapahtumasivu/:id/', function($id) {
    OsallistumisController::osallistu($id);
});

$routes->post('/tapahtumasivu/:id/poistaIlmo', function($id) {
    OsallistumisController::poistaIlmo($id);
});

$routes->get('/tapahtumasivuModattu', function() {
    TapahtumaController::naytaModattuSivu();
});


