<?php declare(strict_types = 1);

namespace App;

use \MongoDB\Client;
use \MongoDB\Database;

class Db
{
    static $dm;

    public function __construct()
    {
        if(!(static::$dm instanceof Datatbase)) {
            $env = getenv();

            define('MONGO_HOST', $env['MONGO_SERVER']);
            define('MONGO_DB_USERNAME', $env['MONGO_INITDB_ROOT_USERNAME']);
            define('MONGO_DB_PASSWORD', $env['MONGO_INITDB_ROOT_PASSWORD']);
            //define('MONGO_DB_USERNAME', 'admin');
            //define('MONGO_DB_PASSWORD', 'admin');
            define('MONGO_DB_NAME', $env['MONGO_INITDB_DATABASE']);

            $username_password = MONGO_DB_USERNAME . ':' . MONGO_DB_PASSWORD . '@';
            $host_and_port = MONGO_HOST . ':' . '27017';
            $mongoClient = new Client('mongodb://' . $username_password . $host_and_port, [], [
                'typeMap' => [
                    'array' => 'array',
                    'document' => 'array',
                    'root' => 'array',
                ],
            ]);

            static::$dm = $mongoClient->selectDatabase(MONGO_DB_NAME);
        }
    }

    public function createCollection(string $name)
    {
        static::$dm->createCollection($name);
    }

    public function createDocument(string $collection, array $document)
    {
        static::$dm->selectCollection($collection)->insertOne($document);
    }

    public function getDocuments(string $collection) : array
    {
        return static::$dm->selectCollection($collection)->find([])->toArray();
    }

    public function pushToArray(string $collection, array $document, string $arrayName, $arrayElement)
    {
        static::$dm->selectCollection($collection)->updateOne(
            $document,
            ['$push' => [$arrayName => $arrayElement]]
        );

    }
}