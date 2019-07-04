<?php declare(strict_types = 1);

namespace App\Models;
use App\Db;

class City
{
    private $id;
    private $regionId;
    private $name;

    private $db;
    private $offerCount;

    private $collection = 'Cities';

    private $client;

    public function __construct(Db $db, OfferCount $offerCount)
    {
        $this->db = $db;
        $this->offerCount = $offerCount;
    }

    private function loadClient()
    {
        $this->client = new N1ApiClient();
    }

    public function all() : array
    {
        return $this->db->getDocumentsWithLastElementInArray($this->collection, ['name', 'region_id'], 'offer_counts');
    }

    public function testAll() : array
    {
        return $this->db->getDocuments($this->collection);
    }

    public function loadFromArray(array $data)
    {
        foreach($data as $property => $value) {
            $this->$property = $value;
        }
    }

    public function save()
    {
        $city = [
            'region_id' => $this->regionId,
            'name' => $this->name,
            'created_at' => new \DateTime()
        ];

        $this->db->createDocument($this->collection, $city);
        return $this->db->getDocuments($this->collection);
    }

    public function addOfferCounts()
    {
        $this->loadClient();
        $regionIDList =  $this->client->getRegionIDList();

        foreach($regionIDList as $regionID) {

            if($count =  $this->client->getCityOfferCount($regionID)) {
                $this->offerCount->loadFromArray(['regionId' => $regionID, 'count' => $count]);
                $this->offerCount->save();
            }

        }
    }

    public function loadCities()
    {
        $this->db->dropCollection($this->collection);
        $this->db->createIndex($this->collection, 'region_id', ['unique' => true]);

        $this->loadClient();
        $regionIDList =  $this->client->getRegionIDList();

        foreach($regionIDList as $regionID) {

            if($name =  $this->client->getCityName($regionID)) {
                $this->loadFromArray(['regionId' => $regionID, 'name' => $name]);
                $this->save();
            }

            if($count =  $this->client->getCityOfferCount($regionID)) {
                $this->offerCount->loadFromArray(['regionId' => $regionID, 'count' => $count]);
                $this->offerCount->save();
            }

        }
    }
}