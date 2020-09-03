<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\UsuarioDAO;
use App\Models\PostgreSQL\UsuarioModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UsuarioController
{

    public function cadastrarUsuario(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $usuarioDAO = new UsuarioDAO();
        $usuario = new UsuarioModel();

        if($data){
            $usuario
            ->setIdPessoa((int)$data['idPessoa'])
            ->setLogin((string)$data['login'])
            ->setSenha(md5($data['senha']))
            ->setAtivo((string)$data['ativo']);

            $idUsuario = $usuarioDAO->cadastrarUsuario($usuario); 
            
            if($idUsuario){
                $response = $response->withjson([
                    "message" => "Usuario cadastrado com sucesso..."
                ]);
            }else {
                $response = $response
                ->withStatus(406)
                ->withjson([
                    "message" => "Erro ao cadastrar usuário..."
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

    public function listarUsuarios(Request $request, Response $response, array $args): Response
    {
        $usuario = new UsuarioDAO();

        $result = $usuario->mostraUsuarios();

        $response = $response
            ->withjson($result);

        return $response;
 
        return $response;
    }

    public function atualizarDadosUsuario(Request $request, Response $response, array $args): Response
    {

        return $response;
    }

    public function atualizarSenha(Request $request, Response $response, array $args): Response
    {

        return $response;
    }
}