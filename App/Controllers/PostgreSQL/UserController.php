<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\Connection;

use App\DAO\PostgreSQL\UserDAO;
use App\DAO\PostgreSQL\PersonDAO;
use App\DAO\PostgreSQL\CompanyDAO;
use App\DAO\PostgreSQL\CompanyUserDAO;
use App\DAO\PostgreSQL\ProfessionalDAO;
use App\DAO\PostgreSQL\ProfessionalOccupationDAO;

use App\Models\PostgreSQL\PersonModel;
use App\Models\PostgreSQL\CompanyModel;
use App\Models\PostgreSQL\CompanyUserModel;
use App\Models\PostgreSQL\ProfessionalModel;
use App\Models\PostgreSQL\ProfessionalOccupationModel;

use App\Models\PostgreSQL\UserModel;
use Firebase\JWT\JWT;
use PHPMailer\PHPMailer\PHPMailer;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UserController extends Connection
{

    public function registerUserComplete(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $userDAO = new UserDAO();
        $user = new UserModel();

        $personDAO = new PersonDAO();
        $person = new PersonModel();

        $companyUserDAO = new CompanyUserDAO();
        $companyUser = new CompanyUserModel();

        $professionalDAO = new ProfessionalDAO();
        $professional = new ProfessionalModel();

        $companyDAO = new CompanyDAO();
        $company = new CompanyModel();

        $professionalOccupationDAO = new ProfessionalOccupationDAO();
        $professionalOccupation = new ProfessionalOccupationModel();

        if(strlen($data['usuario']['password']) < 8){
            $result = [
                'message' => [
                    'pt' => 'Senha abaixo de 8 caracteres.',
                    'en' => 'Password below 8 characters.'
                ],
                'result' => null
            ]; 
            $response = $response->withjson($result);

            return $response->withStatus(401);
        }

        if(strlen($data['usuario']['login']) == 0 || !filter_var($data['usuario']['login'], FILTER_VALIDATE_EMAIL)){
            $result = [
                'message' => [
                    'pt' => 'Login invalido.',
                    'en' => 'Invalid login.'
                ],
                'result' => null
            ]; 
            $response = $response->withjson($result);

            return $response->withStatus(401);
        }
    
        if($data){
            $user
                ->setLogin((string)$data['usuario']['login'])
                ->setPassword(md5($data['usuario']['password']))
                ->setActive((string)'F');
            $person
                ->setNaturalness ($data['pessoa']['naturalidade'])
                ->setName ($data['pessoa']['nome'])
                ->setBirth ($data['pessoa']['dataNascimento'])
                ->setGender ($data['pessoa']['sexo'])
                ->setCpf ($data['pessoa']['cpf'])
                ->setMotherName ($data['pessoa']['nomeMae'])
                ->setEmail ($data['pessoa']['email'])
                ->setPhone1 ($data['pessoa']['telefone1'])
                ->setPhone2 ($data['pessoa']['telefone2']);
            $professional
                ->setIdProfessionalCouncil ($data['profissional']['idconselho_profissional'])
                ->setCouncilNumber ($data['profissional']['numero_conselho'])
                ->setRegistry ($data['profissional']['matricula'])
                ->setActive ((string)'F');
            $company
                ->setIdCompany((int)$data['empresa']['idEmpresa']);
            $professionalOccupation
                ->setIdOccupation($data['profissional_ocupacao']['idOcupacao']);
                 
            $result = [
                'message' => [
                    'pt' => 'Erro ao cadastrar usuário.',
                    'en' => 'Error registering user.'
                ],
                'result' => null
            ]; 
            $response = $response->withjson($result)->withStatus(406);

            $this->pdo->beginTransaction();

            $idPerson = $personDAO->registerPerson($person);
    
            $user->setIdPerson($idPerson);
    
            $idUser = $userDAO->registerUser($user);
            if(!$idUser){
                $this->pdo->rollBack();
                var_dump('Erro 2');
                return $response;
            }
    
            $idCompany = $company->getIdCompany();
            $companyUser->setIdCompany($idCompany);
            $companyUser->setIdUser($idUser);
            $companyUser->setIdProfile(9999);
            $companyUser->setActive((string)'F');
    
            $successCompanyUser = $companyUserDAO->registerCompanyUser($companyUser);
            if(!$successCompanyUser){
                var_dump('Erro 3');
                $this->pdo->rollBack();
                return $response;
            }
    
            $professional->setIdPerson($idPerson);
            $idProfessional = $professionalDAO->registerProfessional($professional);
            if(!$idProfessional){
                var_dump('Erro 4');
                $this->pdo->rollBack();
                return $response;
            }
    
            $professionalOccupation->setIdProfessional($idProfessional);
            $professionalOccupation->setIdCompany($idCompany);
            $successProfessionalOccupation = $professionalOccupationDAO->registerProfessionalOccupation($professionalOccupation);
            if(!$successProfessionalOccupation){
                var_dump('Erro 5');
                $this->pdo->rollBack();
                return $response;
            }
    
            if($successProfessionalOccupation){
                $this->pdo->commit();
            }
        
            
            
            if($idUser){
                $result = [
                    'message' => [
                        'pt' => 'Usuário cadastrado com sucesso.',
                        'en' => 'User successfully registered.'
                    ],
                    'result' => null
                ]; 
                $response = $response
                    ->withjson($result)
                    ->withStatus(201);
            }else {
                $result = [
                    'message' => [
                        'pt' => 'Erro ao cadastrar usuário.',
                        'en' => 'Error registering user.'
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

    public function listUsers(Request $request, Response $response, array $args): Response
    {
        $user = new UserDAO();
        $person = new PersonDAO();

        $data = $user->listUsers();

        foreach($data as &$dataUser){
            $_person = $person->getPersonById($dataUser['idpessoa']);
            
            $dataUser['pessoa'] = $_person;
        }

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

    public function getUser(Request $request, Response $response, array $args): Response
    {
        $user = new UserDAO();
        $person = new PersonDAO();

        $data = $user->listUsers();

        foreach($data as &$dataUser){
            $_person = $person->getPersonById($dataUser['idpessoa']);
            
            $dataUser['pessoa'] = $_person;
        }

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

        if(strlen($data['password']) < 8){
            
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

        $expireDate = date_format(new \DateTime($tokenDecoded->dateExpire), 'Y-m-d H:i:s');
        $now = new \DateTime();
        $now = date_format($now, 'Y-m-d H:i:s');
        
        if($expireDate > $now && $tokenDecoded->login == $data['email']){
            $user
                ->setLogin($data['email'])
                ->setPassword(md5($data['password']));

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
            $dataUser = $userDAO->queryUserRest($email);
            $name = $dataUser[0]['nome'];
            
            if($emailRecipient){

                $emailOrigen = 'natanbandeira18@gmail.com';
                $password = 'Natan1223#';
                $nomeProjeto = 'Projeto HEMO';

                $dateExpire = (new \DateTime())->modify('+5 hour')->format('Y-m-d H:i:s');

                $tokenCarrega = [
                    'sub' => $emailRecipient,
                    'login' => $emailRecipient,
                    'dateExpire' => $dateExpire
                ];

                $token = JWT::encode($tokenCarrega,getenv('JWT_SECRET_KEY'));

                $mailer = new PHPMailer();
                $mailer->IsSMTP();
                $mailer->CharSet = 'UTF-8';
                $mailer->Port = 587; //Indica a porta de conexão para a saída de e-mails. Utilize obrigatoriamente a porta 587.
                
                $mailer->Host = 'smtp.gmail.com'; //google
                $mailer->SMTPSecure = 'tls';
                $mailer->SMTPAuth = true; //Define se haverá ou não autenticação no SMTP
                $mailer->Username = $emailOrigen; //Informe o e-mai o completo
                $mailer->Password = $password; //Senha da caixa postal
                $mailer->FromName = $nomeProjeto; //Nome que será exibido para o destinatário
                $mailer->From = $emailOrigen; //Obrigatório ser a mesma caixa postal indicada em "username"
                $mailer->AddAddress($emailRecipient); //Destinatários
                $mailer->Subject = 'Recuperação de password '.$nomeProjeto.' - '.date("d/m/Y");
                $mailer->Body = '
                                <h2>Sistema HEMO</h2>
                                <b>Orientação ao usuario:</b><br>
                                <p><font color="red">Sua password de acesso é <b>pessoal</b> e <b>intransferivel</b>. Caso seja anotada, mantenha em local seguro.<br>
                                Obs: Encerre a sessão efetuando logoff sempre que se afastar da maquina (Computador).</font><p>
                                Para validar seu acesso e alterar sua password clique no link a seguir: <br>
                                <a href="http://localhost:8080/blood/login?token='.$token.'&name='.$name.'">http://localhost:8080/blood/login?token='.$token.'&name='.$name.'</a><br><br>
                                
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
                    $response = $response
                                    ->withjson($result)
                                    ->withStatus(401);
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