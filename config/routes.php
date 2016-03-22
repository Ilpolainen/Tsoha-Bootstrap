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
