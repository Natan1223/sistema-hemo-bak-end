<?php

namespace test\User;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $http;

    public function setUp(): void
    {
        //$this->http = new Client(['base_uri' => 'http://90.0.3.231:8090/sistema-hemo/index.php/']);
        $this->http = new Client(['base_uri' => 'http://200.129.161.231:8090/sistema-hemo/index.php/']);
    }

    public function testListUsers()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImxvZ2luIjoibmF0YS5iYW5kZWlyYUBoZW1vYW0uYW0uZ292LmJyIiwiZGF0YV9leHBpcmEiOiIyMDIwLTA5LTE2IDE3OjUyOjExIn0.c3yuuaz9Tm3O7975Rh9ZA2dPO4CGUzXES6joa57xnqQ';

        $response = $this->http->request('GET', 'user', [
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $contentType = $response->getHeaders()["Content-Type"][0];
        
        $this->assertEquals("application/json", $contentType);
        $decodedResponse = json_decode($response->getBody());

        $this->assertEquals($decodedResponse->result[0]->idusuario, 2);
        $this->assertEquals($response->getStatusCode(), 200);
    }  

    public function testRegisterUser()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImxvZ2luIjoibmF0YS5iYW5kZWlyYUBoZW1vYW0uYW0uZ292LmJyIiwiZGF0YV9leHBpcmEiOiIyMDIwLTA5LTE2IDE3OjUyOjExIn0.c3yuuaz9Tm3O7975Rh9ZA2dPO4CGUzXES6joa57xnqQ';

        $data = [
            'idPessoa' => 13,
            'login' => 'teste11sdads1php@gmail.com',
            'password' => '122303321',
            'ativo' => 'T'
        ];

        $response = $this->http->request('POST', 'user', [
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ],
            'form_params' => $data
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $contentType = $response->getHeaders()["Content-Type"][0];
        
        $this->assertEquals("application/json", $contentType);
        $decodedResponse = json_decode($response->getBody());

        $this->assertEquals($decodedResponse->message->pt,'Usuário cadastrado com sucesso.');
    }
}