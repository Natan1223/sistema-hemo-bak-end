<?php

namespace test\City;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class CityTest extends TestCase
{
    private $http;

    public function setUp(): void
    {
        //$this->http = new Client(['base_uri' => 'http://90.0.3.231:8090/sistema-hemo/index.php/']);
        $this->http = new Client(['base_uri' => 'http://200.129.161.231:8090/sistema-hemo/index.php/']);
    }

    // public function testListCities()
    // {
    //     $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImxvZ2luIjoibmF0YS5iYW5kZWlyYUBoZW1vYW0uYW0uZ292LmJyIiwiZGF0YV9leHBpcmEiOiIyMDIwLTA5LTE2IDE3OjUyOjExIn0.c3yuuaz9Tm3O7975Rh9ZA2dPO4CGUzXES6joa57xnqQ';

    //     $response = $this->http->request('GET', 'cities', [
    //         'headers' => [
    //             'Authorization' => 'Bearer '.$token
    //         ]
    //     ]);

    //     $this->assertEquals(200, $response->getStatusCode());
    //     $contentType = $response->getHeaders()["Content-Type"][0];
        
    //     $this->assertEquals("application/json", $contentType);
    //     $decodedResponse = json_decode($response->getBody());

    //     $this->assertEquals($decodedResponse->result[0]->idcidade, 2);
    //     $this->assertEquals($response->getStatusCode(), 200);
    // }  

    // public function testRegisterCitySuccess()
    // {
    //     $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImxvZ2luIjoibmF0YS5iYW5kZWlyYUBoZW1vYW0uYW0uZ292LmJyIiwiZGF0YV9leHBpcmEiOiIyMDIwLTA5LTE2IDE3OjUyOjExIn0.c3yuuaz9Tm3O7975Rh9ZA2dPO4CGUzXES6joa57xnqQ';

    //     $data = [
    //         'description' => 'Manaus',
    //     ];

    //     $response = $this->http->request('POST', 'city', [
    //         'headers' => [
    //             'Authorization' => 'Bearer '.$token
    //         ],
    //         'form_params' => $data
    //     ]);

    //     $this->assertEquals(200, $response->getStatusCode());
    //     $contentType = $response->getHeaders()["Content-Type"][0];
        
    //     $this->assertEquals("application/json", $contentType);
    //     $decodedResponse = json_decode($response->getBody());

    //     $this->assertEquals($decodedResponse->message->pt,'Cidade cadastrada com sucesso...');
        
    // }

    public function testUpdateCityData()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImxvZ2luIjoibmF0YS5iYW5kZWlyYUBoZW1vYW0uYW0uZ292LmJyIiwiZGF0YV9leHBpcmEiOiIyMDIwLTA5LTE2IDE3OjUyOjExIn0.c3yuuaz9Tm3O7975Rh9ZA2dPO4CGUzXES6joa57xnqQ';

        $data = [
            'description' => "Manacapuru",
        ];

        $response = $this->http->request('PUT', 'city', [
            'query' => [
                'id' => 20
            ],
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ],
            'form_params' => $data
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $contentType = $response->getHeaders()["Content-Type"][0];
        
        $this->assertEquals("application/json", $contentType);
        $decodedResponse = json_decode($response->getBody());

        $this->assertEquals($decodedResponse->message->pt,'Cidade atualizada com sucesso...');
    }
}