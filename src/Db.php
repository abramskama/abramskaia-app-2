<?php declare(strict_types = 1);

namespace App;

use \MongoDB\Client;
use \MongoDB\Database;

class Db
{
    private $dm;

    public function __construct()
    {
        $env = getenv();

        $mongoHost = $env['MONGO_SERVER'];
        $mongoUsername = $env['MONGO_INITDB_ROOT_USERNAME'];
        $mongoPassword = $env['MONGO_INITDB_ROOT_PASSWORD'];
        $mongoDatabase = $env['MONGO_INITDB_DATABASE'];

        $usernamePassword = $mongoUsername . ':' . $mongoPassword . '@';
        $hostAndPort = $mongoHost . ':' . '27017';
        $mongoClient = new Client('mongodb://' . $usernamePassword . $hostAndPort, [], [
            'typeMap' => [
                'array' => 'array',
                'document' => 'array',
                'root' => 'array',
            ],
        ]);

        $this->dm = $mongoClient->selectDatabase($mongoDatabase);
    }

    public function createCollection(string $name)
    {
        $this->dm->createCollection($name);
    }

    public function createDocument(string $collection, array $document)
    {
        $this->dm->selectCollection($collection)->insertOne($document);
    }

    public function getDocuments(string $collection) : array
    {
        return $this->dm->selectCollection($collection)->find([])->toArray();
    }

    public function pushToArray(string $collection, array $document, string $arrayName, $arrayElement)
    {
        $this->dm->selectCollection($collection)->updateOne(
            $document,
            ['$push' => [$arrayName => $arrayElement]]
        );

    }
}