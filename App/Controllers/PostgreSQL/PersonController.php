<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\PersonDAO;
use App\Models\PostgreSQL\PersonModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class PersonController
{

    public function registerPerson(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $personDAO = new PersonDAO();
        $person = new PersonModel();

        if($data){
            $person
            ->setNaturalness ($data['naturalidade'])
            ->setName ($data['nome'])
            ->setBirth ($data['dataNascimento'])
            ->setGender ($data['sexo'])
            ->setCpf ($data['cpf'])
            ->setMotherName ($data['nomeMae'])
            ->setEmail ($data['email'])
            ->setPhone1 ($data['telefone1'])
            ->setPhone2 ($data['telefone2']);

            $idPerson = $personDAO->registerPerson($person); 
            
            if($idPerson){
                $result = [
                    'message' => [
                        'pt' => 'Pessoa cadastrado com sucesso.',
                        'en' => 'Person successfully registered.'
                    ],
                    'result' => null
                ]; 
                $response = $response->withjson($result);
            }else {
                $result = [
                    'message' => [
                        'pt' => 'Erro ao cadastrar pessoa.',
                        'en' => 'Error registering person.'
                    ],
                    'result' => null
                ]; 
                $response = $response->withjson($result)->withStatus(406);
            }
        }else{
            $result = [
                'message' => [
                    'pt' => 'Parametros não aceitaveis.',
                    'en' => 'Parameters are not acceptable.'
                ],
                'result' => null
            ]; 
            $response = $response->withjson($result)->withStatus(406);
        }
        
        return $response;
    }

    public function listPersons(Request $request, Response $response, array $args): Response
    {
        $person = new PersonDAO();

        $data = $person->listPersons();

        $result = [
            'message' => [
                'pt' => null,
                'en' => null
            ],
            'result' => $data
        ];

        $response = $response
            ->withjson($result);

        return $response;
    }

    public function updatePersonData(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $personDAO = new PersonDAO();
        $person = new PersonModel();
        
        if($data){
            $person
            ->setNaturalness ($data['naturalidade'])
            ->setName ($data['nome'])
            ->setBirth ($data['dataNascimento'])
            ->setGender ($data['sexo'])
            ->setCpf ($data['cpf'])
            ->setMotherName ($data['nomeMae'])
            ->setEmail ($data['email'])
            ->setPhone1 ($data['telefone1'])
            ->setPhone2 ($data['telefone2']);
            
            $personDAO->updatePersonData($person);

            if($personDAO){
                $result = [
                    'message' => [
                        'pt' => 'Pessoa atualizada com sucesso.',
                        'en' => 'Successfully updated person.'
                    ],
                    'result' => null
                ]; 
                $response = $response->withjson($result);
                
            }else {
                $result = [
                    'message' => [
                        'pt' => 'Erro ao atualizar pessoa.',
                        'en' => 'Error updating person.'
                    ],
                    'result' => null
                ]; 
                $response = $response->withjson($result)->withStatus(406);
            }
        }else{
            $result = [
                'message' => [
                    'pt' => 'Parametros não aceitaveis.',
                    'en' => 'Parameters are not acceptable.'
                ],
                'result' => null
            ]; 
            $response = $response->withjson($result)->withStatus(406);
        }
        return $response;
    }
}