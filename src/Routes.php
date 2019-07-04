<?php declare(strict_types = 1);

return [
    ['GET', '/', ['App\Controllers\CityController', 'index']],
    ['GET', '/testCreate', ['App\Controllers\CityController', 'testCreate']],
    ['GET', '/testAll', ['App\Controllers\CityController', 'testAll']],
    ['GET', '/testAddOfferCounts', ['App\Controllers\CityController', 'testAddOfferCounts']],
    ['GET', '/testLoadCities', ['App\Controllers\CityController', 'testLoadCities']],
    ['GET', '/city/{id}/offers', ['App\Controllers\CityController', 'offers']],
];