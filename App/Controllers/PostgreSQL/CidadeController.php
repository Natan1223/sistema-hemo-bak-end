<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\CidadeDAO;
use App\Models\PostgreSQL\CidadeModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class CidadeController
{

    public function cadastrarCidade(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $cidadeDAO = new CidadeDAO();
        $cidade = new CidadeModel();

        if($data){
            $cidade
            ->setDescricao((string)$data['descricao']);

            $idCidade = $cidadeDAO->cadastrarCidade($cidade); 
            
            if($idCidade){
                $response = $response->withjson([
                    "message" => "Cidade cadastrada com sucesso..."
                ]);
            }else {
                $response = $response
                ->withStatus(406)
                ->withjson([
                    "message" => "Erro ao cadastrar cidade..."
                ]);
            }
        }else{
            $response = $response
            ->withStatus(406)
            ->withjson([
                "message" => "Parametros não aceitaveis..."
            ]);
        }
    
        return $response;
    }

    public function listarCidades(Request $request, Response $response, array $args): Response
    {
        $cidade = new CidadeDAO();

        $result = $cidade->listarCidades();

        $response = $response
            ->withjson($result);

        return $response;
    }

    public function atualizarDadosCidade(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $cidadeDAO = new CidadeDAO();
        $cidade = new CidadeModel();
        if($data){
            $cidade
            ->setDescricao ($data['descricao']);
            
        $cidadeDAO->atualizarDadosCidade($cidade);

        if($cidadeDAO){
            $response = $response->withjson([
                "message" => "Cidade atualizada com sucesso..."
            ]);
        }else {
            $response = $response
            ->withStatus(406)
            ->withjson([
                "message" => "Erro ao atualizar cidade..."
            ]);
        }
    }else{
        $response = $response
        ->withStatus(406)
        ->withjson([
            "message" => "Parametros não aceitaveis..."
        ]);
    }

    return $response;

        return $response;
    }
}