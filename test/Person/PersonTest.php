<?php

namespace test\Person;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{
    private $http;

    public function setUp(): void
    {
        $this->http = new Client(['base_uri' => 'http://200.129.161.231:8090/sistema-hemo/index.php/']);
    }

    public function testListPersons()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImxvZ2luIjoibmF0YS5iYW5kZWlyYUBoZW1vYW0uYW0uZ292LmJyIiwiZGF0YV9leHBpcmEiOiIyMDIwLTA5LTE2IDE3OjUyOjExIn0.c3yuuaz9Tm3O7975Rh9ZA2dPO4CGUzXES6joa57xnqQ';

        $response = $this->http->request('GET', 'person', [
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $contentType = $response->getHeaders()["Content-Type"][0];
        
        $this->assertEquals("application/json", $contentType);
        $decodedResponse = json_decode($response->getBody());

        $this->assertEquals($decodedResponse->result[0]->idpessoa, 2);
        $this->assertEquals($response->getStatusCode(), 200);
    }
    
    public function testRegisterPerson()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImxvZ2luIjoibmF0YS5iYW5kZWlyYUBoZW1vYW0uYW0uZ292LmJyIiwiZGF0YV9leHBpcmEiOiIyMDIwLTA5LTE2IDE3OjUyOjExIn0.c3yuuaz9Tm3O7975Rh9ZA2dPO4CGUzXES6joa57xnqQ';

        $data = [
            'naturalidade' => 1,
            'nome' => 'Alfonso de Oliveira Filho',
            'dataNascimento' => '2000-12-20',
            'sexo' => 'M',
            'cpf' => '44132122211',
            'nomeMae' => 'Teste do Sistema',
            'email' => 'alfonso.teste@gmail.com',
            'telefone1' => '22221111',
            'telefone2' => ''
        ];

        $response = $this->http->request('POST', 'person', [
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ],
            'form_params' => $data
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $contentType = $response->getHeaders()["Content-Type"][0];
        
        $this->assertEquals("application/json", $contentType);
        $decodedResponse = json_decode($response->getBody());

        $this->assertEquals($decodedResponse->message->pt,'Pessoa cadastrado com sucesso.');
    }

    public function testUpdatePersonData()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImxvZ2luIjoibmF0YS5iYW5kZWlyYUBoZW1vYW0uYW0uZ292LmJyIiwiZGF0YV9leHBpcmEiOiIyMDIwLTA5LTE2IDE3OjUyOjExIn0.c3yuuaz9Tm3O7975Rh9ZA2dPO4CGUzXES6joa57xnqQ';

        $data = [
            'naturalidade' => 1,
            'nome' => 'Alfonso de Oliveira Filho Atualizado',
            'dataNascimento' => '2000-12-20',
            'sexo' => 'M',
            'cpf' => '44132122211',
            'nomeMae' => 'Teste do Sistema',
            'email' => 'alfonso222.teste@gmail.com',
            'telefone1' => '22221111',
            'telefone2' => '22223333'
        ];

        $response = $this->http->request('PUT', 'person', [
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ],
            'form_params' => $data
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $contentType = $response->getHeaders()["Content-Type"][0];
        
        $this->assertEquals("application/json", $contentType);
        $decodedResponse = json_decode($response->getBody());

        $this->assertEquals($decodedResponse->message->pt,'Pessoa atualizada com sucesso.');
    }
}