<?php

namespace test\User;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $http;

    public function setUp(): void
    {
<<<<<<< HEAD
        $this->http = new Client(['base_uri' => 'http://90.0.3.231:8090/sistema-hemo/index.php/']);
=======
        //$this->http = new Client(['base_uri' => 'http://90.0.3.231:8090/sistema-hemo/index.php/']);
        $this->http = new Client(['base_uri' => 'http://200.129.161.231:8090/sistema-hemo/index.php/']);
>>>>>>> dad4e53a74541e8a1883d2af6f64d6169e937764
    }

    public function testListUsers()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImxvZ2luIjoibmF0YS5iYW5kZWlyYUBoZW1vYW0uYW0uZ292LmJyIiwiZGF0YV9leHBpcmEiOiIyMDIwLTA5LTE2IDE3OjUyOjExIn0.c3yuuaz9Tm3O7975Rh9ZA2dPO4CGUzXES6joa57xnqQ';

<<<<<<< HEAD
        $response = $this->http->request('GET', 'usuarios', [
=======
        $response = $this->http->request('GET', 'user', [
>>>>>>> dad4e53a74541e8a1883d2af6f64d6169e937764
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $contentType = $response->getHeaders()["Content-Type"][0];
        
        $this->assertEquals("application/json", $contentType);
        $decodedResponse = json_decode($response->getBody());

<<<<<<< HEAD
        $this->assertEquals($decodedResponse[0]->idusuario, 2);
=======
        $this->assertEquals($decodedResponse->result[0]->idusuario, 2);
>>>>>>> dad4e53a74541e8a1883d2af6f64d6169e937764
        $this->assertEquals($response->getStatusCode(), 200);
    }  

    public function testRegisterUser()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImxvZ2luIjoibmF0YS5iYW5kZWlyYUBoZW1vYW0uYW0uZ292LmJyIiwiZGF0YV9leHBpcmEiOiIyMDIwLTA5LTE2IDE3OjUyOjExIn0.c3yuuaz9Tm3O7975Rh9ZA2dPO4CGUzXES6joa57xnqQ';

        $data = [
            'idPessoa' => 13,
<<<<<<< HEAD
            'login' => 'teste11sdads1@gmail.com',
=======
            'login' => 'teste11sdads1php@gmail.com',
>>>>>>> dad4e53a74541e8a1883d2af6f64d6169e937764
            'password' => '122303321',
            'ativo' => 'T'
        ];

<<<<<<< HEAD
        $response = $this->http->request('POST', 'usuario', [
=======
        $response = $this->http->request('POST', 'user', [
>>>>>>> dad4e53a74541e8a1883d2af6f64d6169e937764
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ],
            'form_params' => $data
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $contentType = $response->getHeaders()["Content-Type"][0];
        
        $this->assertEquals("application/json", $contentType);
        $decodedResponse = json_decode($response->getBody());
<<<<<<< HEAD
        var_dump($decodedResponse);

        
    }

    
    // public function testAll()
    // {
    //     $response = $this->http->request('GET', 'apresentacao-hemo');

    //     $this->assertEquals(200, $response->getStatusCode());

    //     $contentType = $response->getHeaders()["Content-Type"][0];

    //     $this->assertEquals("application/json", $contentType);
        
    //     $decodedResponse = json_decode($response->getBody());
    //     $this->assertEquals($decodedResponse->descricao,  'Projeto HEMO - Sistema de gerenciamento de transfusçao sanguínea');
    // }  

    // public function testHerokuStatus()
    // {
    //     $response = $this->http->request('GET', 'apresentacao-hemo'); 

    //     $decodedResponse = json_decode($response->getBody());
    //     $this->assertEquals($decodedResponse->descricao, 'Projeto HEMO - Sistema de gerenciamento de transfusçao sanguínea');

    // }

    // /**
    //  * Test is beberlei collaborator of doctrine/cache
    //  */
    // public function testCollaboratorExists()
    // {
    //     // As opposed to above test, this one calls the Client constructor
    //     //  without passing a base URL, and instead uses a full URL in get().
    //     $response = $this->http->request('GET', 'apresentacao-hemo');
    //     $this->assertEquals($response->getStatusCode(), 200);
    // }
=======

        $this->assertEquals($decodedResponse->message->pt,'Usuário cadastrado com sucesso.');
    }
>>>>>>> dad4e53a74541e8a1883d2af6f64d6169e937764
}