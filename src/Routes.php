<?php declare(strict_types = 1);

return [
    ['GET', '/', ['App\Controllers\CityController', 'index']],
    ['GET', '/testCreate', ['App\Controllers\CityController', 'testCreate']],
    ['GET', '/testAll', ['App\Controllers\CityController', 'testAll']],
    ['GET', '/testAddOfferCount', ['App\Controllers\CityController', 'testAddOfferCount']],
    ['GET', '/city/{id}/offers', ['App\Controllers\CityController', 'offers']],
];