<?php declare(strict_types = 1);

namespace App\Models;
use App\Db;

class City
{
    private $id;
    private $regionId;
    private $name;

    private $db;
    private $collection = 'Cities';

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    public function all() : array
    {
        return [
            ["name" => "Новосибирск", "latest_offer_count" => ["count" => 1]],
            ["name" => "Москва", "latest_offer_count" => ["count" => 2]]
        ];
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

    public function addOfferCount(array $data)
    {
        $this->db->pushToArray($this->collection, ['name' => $this->name], 'offer_counts', $data);
    }
}