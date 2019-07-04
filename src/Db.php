<?php declare(strict_types = 1);

namespace App;

use \MongoDB\Client;
use \MongoDB\Database;

class Db
{
    private $dm;

    /**
     * Constructs db object
     * Set $dm property - database object to connect to mongo database
     * Connection properties gets from environment variables
     * */
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

    /**
     * Inserts document into collection
     * @param string $collection collection name
     * @param array $document array of document properties
     * */
    public function createDocument(string $collection, array $document)
    {
        $this->dm->selectCollection($collection)->insertOne($document);
    }

    /**
     * Gets array of documents in collection
     * @param string $collection collection name
     * @return array
     * */
    public function getDocuments(string $collection) : array
    {
        return $this->dm->selectCollection($collection)->find([])->toArray();
    }

    /**
     * Gets array of documents in collection with joined last element in provided array
     * @param string $collection collection name
     * @param array $documentFields array of fields which included in result
     * @param string $array name of joined array in document
     * @return array
     * */
    public function getDocumentsWithLastElementInArray(string $collection, array $documentFields, string $array) : array
    {
        $project = [];
        foreach($documentFields as $field) {
            $project[$field] = 1;
        }
        $project[ $array.'_last'] = ['$arrayElemAt' => ['$'.$array, -1]];
        return $this->dm->selectCollection($collection)->aggregate([[ '$project' => $project ]])->toArray();
    }

    /**
     * Inserts element to array in document
     * @param string $collection collection name
     * @param string $arrayName name of the array
     * @param any $arrayElement element to insert
     * */
    public function pushToArray(string $collection, array $document, string $arrayName, $arrayElement)
    {
        $this->dm->selectCollection($collection)->updateOne(
            $document,
            ['$push' => [$arrayName => $arrayElement]]
        );

    }

    /**
     * Creates index in collection
     * @param string $collection collection name
     * @param string $key name of field
     * @param array $options index options
     * */
    public function createIndex(string $collection, string $key, array $options = [])
    {
        $this->dm->selectCollection($collection)->createIndex([$key => 1], $options);
    }

    /**
     * Drop collection
     * @param string $collection collection name
     * */
    public function dropCollection(string $collection)
    {
        $this->dm->selectCollection($collection)->drop();
    }

    /**
     * Gets first document in collection with provided filter
     * @param string $collection collection name
     * @param array $filter filter options
     * @return array
     * */
    public function getDocument(string $collection, array $filter = []) : array
    {
        return (array)$this->dm->selectCollection($collection)->findOne($filter);
    }
}