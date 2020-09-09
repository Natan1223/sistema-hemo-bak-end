<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\TokenDAO;
use App\DAO\PostgreSQL\UsuarioDAO;
use App\Models\PostgreSQL\TokenModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Firebase\JWT\JWT;

final class AutenticaController
{
    public function login(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $login = $data['login'];
        $senha = md5($data['senha']);

        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->usuarioLogin($login);

        if(is_null($usuario))
            return $response->withJson([
                                "menssage" => 'Usuario Invalido.'
                            ])
                            ->withStatus(401);

        if($senha <> $usuario->getSenha())
            return $response->withJson([
                                "menssage" => 'Senha Invalida.'
                            ])
                            ->withStatus(401);

        $data_expeira = (new \DateTime())->modify('+5 hour')->format('Y-m-d H:i:s');

        $tokenCarrega = [
            'sub' => $usuario->getIdUsuario(),
            'login' => $usuario->getLogin(),
            'data_expira' => $data_expeira
        ];

        $token = JWT::encode($tokenCarrega,getenv('JWT_SECRET_KEY'));

        $refreshToken = [
            'login' => $usuario->getLogin()
        ];

        $refreshToken = JWT::encode($refreshToken, getenv('JWT_SECRET_KEY'));

        $tokenModel = new TokenModel();
        $tokenModel
            ->setToken($token)
            ->setRefreshToken($refreshToken)
            ->setDataExpira($data_expeira)
            ->setIdUsuario($usuario->getIdUsuario());

        $tokenDAO = new TokenDAO();
        $tokenDAO->criaToken($tokenModel);

        $response = $response->withJson([
            "token" => $token,
            "refreshToken" => $refreshToken
        ]);

        return $response;
    }

}