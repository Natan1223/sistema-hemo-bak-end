<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\UserDAO;
use App\Models\PostgreSQL\UserModel;
use Firebase\JWT\JWT;
use PHPMailer\PHPMailer\PHPMailer;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UserController
{

    public function registerUser(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $userDAO = new UserDAO();
        $user = new UserModel();

        if($data){
            $user
                ->setIdPerson((int)$data['idPessoa'])
                ->setLogin((string)$data['login'])
                ->setPassword(md5($data['senha']))
                ->setActive((string)$data['ativo']);
            
            if(strlen($data['senha']) < 8)
                return $response
                    ->withJson([
                        "menssage" => 'Senha abaixo de 8 caracteres!'
                    ])
                    ->withStatus(401);

            $idUser = $userDAO->registerUser($user); 
            
            if($idUser){
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

    public function listUsers(Request $request, Response $response, array $args): Response
    {
        $user = new UserDAO();

        $data = $user->listUsers();

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

    public function updateUserData(Request $request, Response $response, array $args): Response
    {

        return $response;
    }

    public function updatePassword(Request $request, Response $response, array $args): Response
    {   
        $data = $request->getParsedBody();

        $userDAO = new UserDAO();
        $user = new UserModel();

        if(strlen($data['senha']) < 8){
            
            $result = [
                'message' => [
                    'pt' => 'Senha com menos de 8 caracteres',
                    'en' => 'Password less than 8 characters'
                ],
                'result' => null
            ];

            return $response
                ->withJson($result)
                ->withStatus(401);
        }

        $token = $data['token'];
        $tokenDecoded = JWT::decode($token, getenv('JWT_SECRET_KEY'), array('HS256'));

        $expireDate = date_format(new \DateTime($tokenDecoded->data_expira), 'Y-m-d H:i:s');
        $now = new \DateTime();
        $now = date_format($now, 'Y-m-d H:i:s');
        
        if($expireDate > $now && $tokenDecoded->login == $data['email']){
            $user
                ->setLogin($data['email'])
                ->setPassword(md5($data['senha']));

            $userDAO->updatePassword($user);
           
            $result = [
                'message' => [
                    'pt' => 'Senha alterada com sucesso.',
                    'en' => 'Password changed successfully.'
                ],
                'result' => null
            ];            

            $response = $response->withjson($result);

        }else {

            $result = [
                'message' => [
                    'pt' => 'Token inválido',
                    'en' => 'Invalid token.'
                ],
                'result' => null
            ]; 
            $response = $response->withjson($result);
        }

        return $response;
    }

    public function queryUserRest(Request $request, Response $response, array $args): Response
    {
        $queryParams = $request->getQueryParams();

        $userDAO = new UserDAO();
        $email = $queryParams['email'];
        @$method = $queryParams['method'];

        if($method == ''){
            $dataUser = $userDAO->queryUserRest($email);

            if($dataUser){
                $response = $response
                    ->withJson($dataUser[0]);
            }else{
                $result = [
                    'message' => [
                        'pt' => 'Usuário não cadastrado no sistema.',
                        'en' => 'User not registered in the system.'
                    ],
                    'result' => null
                ];
                $response = $response->withjson($result);
            }

        }elseif($method == 'reset'){

            $checks = $userDAO->queryUserRest($email);
            $emailRecipient = $checks[0]['login'];
           
            if($emailRecipient){

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
                $mailer->AddAddress($emailRecipient); //Destinatários
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
                    $result = [
                        'message' => [
                            'pt' => 'Email encaminhado com sucesso.',
                            'en' => 'Email forwarded successfully.'
                        ],
                        'result' => [
                            "email" => $emailRecipient
                        ]
                    ];
                    $response = $response->withJson($result);
                }else{
                    $result = [
                        'message' => [
                            'pt' => 'Favor entrar em contato com o administrador do sistema.',
                            'en' => 'Please contact your system administrator.'
                        ],
                        'result' => [
                            "email" => $emailRecipient
                        ]
                    ];
                    $response = $response->withjson($result);
                }

            }else{
                $result = [
                    'message' => [
                        'pt' => 'Usuário não cadastrado no sistema.',
                        'en' => 'User not registered in the system.'
                    ],
                    'result' => null
                ];
                $response = $response->withjson($result);
            }


        }
        return $response;
    }
}