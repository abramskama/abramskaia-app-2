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

    public function offers($params)
    {
        $id = $params['id'];
        $this->response->setContent(json_encode([['created_at' => '2019-07-01', 'count' => 1], ['created_at' => '2019-07-02', 'count' => 2]]));
    }

    public function testCreate()
    {
        $this->city->loadFromArray(['regionId' => 1, 'name' => 'Test']);
        $cities = $this->city->save();
        $this->response->setContent(print_r($cities, true));
    }

    public function testLoadCities()
    {
        $this->city->loadCities();
        $cities = $this->city->testAll();
        $this->response->setContent(print_r($cities, true));
    }

    public function testAll()
    {
        $cities = $this->city->all();
        $this->response->setContent(print_r($cities, true));
    }

    public function testAddOfferCounts()
    {
        $this->city->addOfferCounts();
        $cities = $this->city->testAll();
        $this->response->setContent(print_r($cities, true));
    }
}