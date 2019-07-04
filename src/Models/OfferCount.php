<?php declare(strict_types = 1);

namespace App\Models;

use App\Db;

class OfferCount
{
    private $regionId;
    private $count;

    private $db;

    private $collection = 'Cities';
    private $arrayName = 'offer_counts';

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    public function save()
    {
        $offerCount = [
            'count' => $this->count,
            'created_at' => new \DateTime()
        ];

        $this->db->pushToArray($this->collection, ['region_id' => $this->regionId], $this->arrayName, $offerCount);
    }

    public function loadFromArray(array $data)
    {
        foreach($data as $property => $value) {
            $this->$property = $value;
        }
    }
}