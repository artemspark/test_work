<?php

namespace TestApi;

require_once './vendor/autoload.php';

error_reporting(E_ALL);

use TestApi\Config\Router;

Router::get('/advertisement', '\TestApi\Controllers\AdvertisementsApi@showAdvertisement');
Router::post('/advertisement/create', '\TestApi\Controllers\AdvertisementsApi@createAdvertisement');
Router::post('/advertisement/update/:id', '\TestApi\Controllers\AdvertisementsApi@updateAdvertisement');

try {
    Router::run();
} catch (\Exception $e) {
    echo json_encode(array('error' => $e->getMessage()));
}