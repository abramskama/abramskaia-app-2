<?php declare(strict_types = 1);

namespace App\Controllers;

use App\Template\FrontendRenderer;
use Http\Response;
use App\Models\City;
use App\Db;

class CityController
{
    private $response;
    private $renderer;
    private $city;

    public function __construct(
        Response $response,
        FrontendRenderer $renderer,
        City $city
    ) {
        $this->response = $response;
        $this->renderer = $renderer;
        $this->city = $city;
    }

    public function index()
    {
        $cities = $this->city->all();
        $html = $this->renderer->render('CityList', ['cities' => $cities]);
        $this->response->setContent($html);
    }

    public function show($params)
    {
        $regionId = intval($params['region_id']);
        $city = $this->city->getCityByRegionId($regionId);
        $this->response->setContent(json_encode($city));
    }
}