<?php

// https://github.com/Jekshmek/elasticsearch-php
//  https://github.com/Jekshmek/elasticsearch-sql
use Elasticsearch\ClientBuilder;
require 'D:\OpenServer\domains\elasticsearch\vendor/autoload.php';
$client = ClientBuilder::create()->build();
/*
$params = [
    'index' => 'my_index',
    'type' => 'my_type',
    'id' => 'my_id',
    'body' => ['testField' => 'abc']
];

$response = $client->index($params);

$params = [
    'index' => 'my_index',
    'type' => 'my_type',
    'id' => 'my_id_2',
    'body' => ['testField' => 'Коля на природе']
];

$response = $client->index($params);

print_r($response);
*/

// GET
/*
$params = [
    'index' => 'my_index',
    'type' => 'my_type',
    'id' => 'my_id'
];

$response = $client->get($params);
print_r($response);
*/


// SEARCH
/*
$params = [
    'index' => 'my_index',
    'type' => 'my_type',
    'body' => [
        'query' => [
            'match' => [
                'testField' => 'коля abc'
            ]
        ]
    ]
];

$response = $client->search($params);
print_r($response);
*/




// DELETE DOC
/*
$params = [
    'index' => 'my_index',
    'type' => 'my_type',
    'id' => 'my_id'
];

$response = $client->delete($params);
print_r($response);// [found] => 1 [_index] => my_index [_type] => my_type [_id] => my_id [_version] => 2
*/




// DELETE INDEX
/*
$deleteParams = [
    'index' => 'my_index'
];
$response = $client->indices()->delete($deleteParams);
print_r($response);//[acknowledged] => 1
*/




// CREATE INDEX
/*
$params = [
    'index' => 'my_index',
    'body' => [
        'settings' => [
            'number_of_shards' => 2,
            'number_of_replicas' => 0
        ]
    ]
];

$response = $client->indices()->create($params);
print_r($response); //  [acknowledged] => 1

*/