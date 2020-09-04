<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\PessoaDAO;
use App\Models\PostgreSQL\PessoaModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class PessoaController
{

    public function cadastrarPessoa(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $pessoaDAO = new PessoaDAO();
        $pessoa = new PessoaModel();

        if($data){
            $pessoa
            ->setNaturalidade ($data['naturalidade'])
            ->setNome ($data['nome'])
            ->setDataNascimento ($data['dataNascimento'])
            ->setSexo ($data['sexo'])
            ->setCpf ($data['cpf'])
            ->setNomeMae ($data['nomeMae'])
            ->setEmail ($data['email'])
            ->setTelefone1 ($data['telefone1'])
            ->setTelefone2 ($data['telefone2']);

            $idPessoa = $pessoaDAO->cadastrarPessoa($pessoa); 
            
            if($idPessoa){
                $response = $response->withjson([
                    "message" => "Pessoa cadastrado com sucesso..."
                ]);
            }else {
                $response = $response
                ->withStatus(406)
                ->withjson([
                    "message" => "Erro ao cadastrar pessoa..."
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

    public function listarPessoas(Request $request, Response $response, array $args): Response
    {
        $pessoas = new PessoaDAO();

        $result = $pessoas->listarPessoas();

        $response = $response
            ->withjson($result);
        return $response;
    }

    public function atualizarDadosPessoa(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $pessoaDAO = new PessoaDAO();
        $pessoa = new PessoaModel();
        if($data){
            $pessoa
            ->setNaturalidade ($data['naturalidade'])
            ->setNome ($data['nome'])
            ->setDataNascimento ($data['dataNascimento'])
            ->setSexo ($data['sexo'])
            ->setCpf ($data['cpf'])
            ->setNomeMae ($data['nomeMae'])
            ->setEmail ($data['email'])
            ->setTelefone1 ($data['telefone1'])
            ->setTelefone2 ($data['telefone2']);
            
        $pessoaDAO->atualizarDadosPessoa($pessoa);

        if($pessoaDAO){
            $response = $response->withjson([
                "message" => "Pessoa atualizada com sucesso..."
            ]);
        }else {
            $response = $response
            ->withStatus(406)
            ->withjson([
                "message" => "Erro ao atualizar pessoa..."
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