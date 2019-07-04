<?php declare(strict_types = 1);

return [
    ['GET', '/', ['App\Controllers\CityController', 'index']],
    ['GET', '/city/{region_id}', ['App\Controllers\CityController', 'show']]
];