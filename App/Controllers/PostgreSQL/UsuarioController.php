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