<?php declare(strict_types = 1);

namespace App\Models;
use App\Db;

class City
{
    private $regionId;
    private $name;

    private $db;
    private $offerCount;

    private $collection = 'Cities';

    private $client;

    /**
     * Constructs city object
     * @param Db $db db object
     * @param OfferCount $offerCount offer count object
     * */
    public function __construct(Db $db, OfferCount $offerCount)
    {
        $this->db = $db;
        $this->offerCount = $offerCount;
    }

    /**
     * Injects client object to client property
     * */
    private function loadClient()
    {
        $this->client = new N1ApiClient();
    }

    /**
     * Gets all cities
     * */
    public function all() : array
    {
        return $this->db->getDocumentsWithLastElementInArray($this->collection, ['name', 'region_id'], 'offer_counts');
    }

    /**
     * Sets city properties from array
     * @param array $data array of properties ['propertyName' => value]
     * */
    public function loadFromArray(array $data)
    {
        foreach($data as $property => $value) {
            $this->$property = $value;
        }
    }

    /**
     * Saves city to db
     * Object must be loaded before save
     * */
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

    /**
     * Gets current offer count for all cities and add it to offer_counts array
     * */
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

    /**
     * Drop all cities and reload it
     * */
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

    /**
     * Gets city from db by its region id
     * @param int $regionId region_id
     * @return array
     * */
    public function getCityByRegionId(int $regionId) : array
    {
        return $this->db->getDocument($this->collection, ['region_id' => $regionId]);
    }
}