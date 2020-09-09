<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\UsuarioDAO;
use App\Models\PostgreSQL\UsuarioModel;
use Firebase\JWT\JWT;
use PHPMailer\PHPMailer\PHPMailer;

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
            
            if(strlen($data['senha']) < 8)
                return $response
                    ->withJson([
                        "menssage" => 'Senha abaixo de 8 caracteres!'
                    ])
                    ->withStatus(401);

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

        $result = $usuario->listarUsuarios();

        $response = $response
            ->withjson($result);

        return $response;
    }

    public function atualizarDadosUsuario(Request $request, Response $response, array $args): Response
    {

        return $response;
    }

    public function atualizarSenha(Request $request, Response $response, array $args): Response
    {   
        $data = $request->getParsedBody();

        $usuarioDAO = new UsuarioDAO();
        $usuario = new UsuarioModel();

        if(strlen($data['senha']) < 8)
            return $response
                ->withJson([
                    "menssage" => 'Senha abaixo de 8 caracteres!'
                ])
                ->withStatus(401);

        $token = $data['token'];
        $tokenDecoded = JWT::decode($token, getenv('JWT_SECRET_KEY'), array('HS256'));

        $expireDate = date_format(new \DateTime($tokenDecoded->data_expira), 'Y-m-d H:i:s');
        $now = new \DateTime();
        $now = date_format($now, 'Y-m-d H:i:s');
        
        if($expireDate > $now && $tokenDecoded->login == $data['email']){
            $usuario
                ->setLogin($data['email'])
                ->setSenha(md5($data['senha']));

            $usuarioDAO->atualizarSenha($usuario);
            $response = $response->withjson([
                "message" => "Senha alterada com sucesso..."
            ]);

        }else {
            $response = $response->withjson([
                "message" => "Token invalido."
            ]);
        }

        return $response;
    }

    public function consultaUsuarioRest(Request $request, Response $response, array $args): Response
    {
        $queryParams = $request->getQueryParams();

        $usuarioDAO = new UsuarioDAO();
        $email = $queryParams['email'];
        $metodo = $queryParams['metodo'];

        if($metodo == null){
            $dadosUsuario = $usuarioDAO->consultaUsuarioRest($email);

            if($dadosUsuario){
                $response = $response
                    ->withJson($dadosUsuario[0]);
            }else{

                $response = $response->withjson([
                    "message" => "Usuário não cadastrado no sistema."
                ]);
            }

        }elseif($metodo == 'reset'){

            $verifica = $usuarioDAO->consultaUsuarioRest($email);
            $emailDestinatario = $verifica[0]['login'];
           
            if($emailDestinatario){

                $emailOrigen = 'natanbandeira18@gmail.com';
                $senha = 'Natan1223#';
                $nomeProjeto = 'Projeto HEMO';

                $mailer = new PHPMailer();
                $mailer->IsSMTP();
                $mailer->CharSet = 'UTF-8';
                $mailer->Port = 587; //Indica a porta de conexão para a saída de e-mails. Utilize obrigatoriamente a porta 587.
                
                $mailer->Host = 'smtp.gmail.com'; //google
                $mailer->SMTPSecure = 'tls';
                $mailer->SMTPAuth = true; //Define se haverá ou não autenticação no SMTP
                $mailer->Username = $emailOrigen; //Informe o e-mai o completo
                $mailer->Password = $senha; //Senha da caixa postal
                $mailer->FromName = $nomeProjeto; //Nome que será exibido para o destinatário
                $mailer->From = $emailOrigen; //Obrigatório ser a mesma caixa postal indicada em "username"
                $mailer->AddAddress($emailDestinatario); //Destinatários
                $mailer->Subject = 'Recuperação de senha '.$nomeProjeto.' - '.date("d/m/Y");
                $mailer->Body = '
                                <h2>Sistema HEMO</h2>
                                <b>Orientação ao usuario:</b><br>
                                <p><font color="red">Sua senha de acesso é <b>pessoal</b> e <b>intransferivel</b>. Caso seja anotada, mantenha em local seguro.<br>
                                Obs: Encerre a sessão efetuando logoff sempre que se afastar da maquina (Computador).</font><p>
                                Para validar seu acesso e alterar sua senha clique no link a seguir: <br>
                                <a href="">
                                http://usuario-senha.com.br</a><br><br>
                                
                                <p>
                                Para mais informaçoes entre em contato com LABTEC UEA<br>
                                <b>Contato:</b> (92) 3655-0000 / 3655-0000 <br>
                                <b>E-mail:</b> nata.bandeira@hemoam.am.gov.br
                                </p>
                    ';
                $mailer->isHTML(true);
                if($mailer->Send())
                {
                    $response = $response->withJson([
                                "message" => 'E-mail encaminhado com sucesso',
                                "e-mail" => $emailDestinatario
                            ]);
                }else{
                    $response = $response->withjson([
                        "message" => "Favor entrar em contato com o sistemas."
                    ]);
                }

            }else{
                $response = $response->withjson([
                    "message" => "Favor entrar em contato com o setor de RH."
                ]);
            }


        }
        return $response;
    }
}