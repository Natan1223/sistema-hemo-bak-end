<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\UserModel;

use App\DAO\PostgreSQL\PersonDAO;
//use App\DAO\PostgreSQL\CompanyDAO;
use App\DAO\PostgreSQL\CompanyUserDAO;
use App\DAO\PostgreSQL\ProfessionalDAO;
use App\DAO\PostgreSQL\ProfessionalOccupationDAO;

use App\Models\PostgreSQL\PersonModel;
use App\Models\PostgreSQL\CompanyModel;
use App\Models\PostgreSQL\CompanyUserModel;
use App\Models\PostgreSQL\ProfessionalModel;
use App\Models\PostgreSQL\ProfessionalOccupationModel;

final class UserDAO extends Connection
{
    public function __construct()
    {
        parent::__construct(); 
    }

    // public function registerUserComplete(UserModel $user, PersonModel $person, CompanyModel $company, ProfessionalModel $professional, ProfessionalOccupationModel $professionalOccupation)
    // {
    //     $personDAO = new PersonDAO();
    //     $companyUserDAO = new CompanyUserDAO();
    //     $companyUser = new CompanyUserModel();

    //     $professionalDAO = new ProfessionalDAO();
    //     $professionalOccupationDAO = new ProfessionalOccupationDAO();

        
    //     // $idUser =  $this->pdo->lastInsertId();
        
    //     return $idUser;
    // }

    public function registerUser(UserModel $user)
    {
        $statement = $this->pdo
            ->prepare(' SELECT
                            *
                        FROM administracao.pessoa, administracao.usuario
                        WHERE
                            :idpessoa = administracao.usuario.idpessoa OR 
                            :login = administracao.usuario.login

            ');
        $statement->execute([
            'idpessoa'=>$user->getIdPerson(),
            'login'=>$user->getLogin()
        ]);

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        if ($result){
            return null;
        }

        $statement = $this->pdo
            ->prepare(' INSERT INTO 
                        administracao.usuario (
                            idpessoa, 
                            login, 
                            senha, 
                            ativo
                        ) VALUES (
                            :idpessoa,
                            :login,
                            :senha,
                            :ativo   
                        );
            ');
        $statement->execute([
            'idpessoa'=>$user->getIdPerson(),
            'login'=>$user->getLogin(),
            'senha'=>$user->getPassword(),
            'ativo' =>$user->getActive()
        ]);

        $idUser =  $this->pdo->lastInsertId();
        
        return $idUser;
    }

    public function listUsers(): array
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            u.idusuario,
                            u.idpessoa,
                            u.login,
                            u.ativo
                        FROM administracao.usuario AS u
                        JOIN administracao.pessoa AS p
                        ON u.idpessoa = p.idpessoa
                        ORDER BY idusuario,ativo
            ');
        $statement->execute();
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }

    public function updateUserData(UserModel $user): array
    {
        
        return $response;
    }

    public function queryUserRest(string $email): array
    {
        $statement = $this->pdo
            ->prepare(' SELECT
                            u.idusuario,
                            p.nome,
                            u.login
                        FROM administracao.usuario u
                        join administracao.pessoa p
                            on u.idpessoa = p.idpessoa
                        WHERE login = :email
            ');
        $statement->bindParam('email', $email);
        $statement->execute();
        $user = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $user;
    }

    public function updatePassword(UserModel $user): array
    {
        $statement = $this->pdo
            ->prepare(' UPDATE administracao.usuario SET
                            senha = :senha
                        WHERE login = :login
                
            ');
        $statement->execute([
            'login'=>$user->getLogin(),
            'senha'=>$user->getPassword()
        ]);
        $user = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $user;
    }

    public function userLogin(string $user): ?UserModel
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            u.idusuario,
                            u.login,
                            u.senha
                        FROM administracao.usuario u
                        WHERE u.login = :usuario
            ');
        $statement->bindParam('usuario', $user);
        $statement->execute();
        $users = $statement->fetchAll(\PDO::FETCH_ASSOC);

        if(count($users) === 0)
            return null;
        
        $user = new UserModel();
        $user
            ->setIdPerson($users[0]['idusuario'])
            ->setLogin($users[0]['login'])
            ->setPassword($users[0]['senha']);

        return $user;
    }

    public function listUserCompany(string $login): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT e.idempresa, e.nome
                        FROM administracao.usuario u 
                        join administracao.usuario_empresa ue 
                            on u.idusuario = ue.idusuario 
                            and ue.ativo = 'T'
                        join administracao.empresa e 
                            on ue.idempresa = e.idempresa 
                        WHERE u.login = :login
            ");
        $statement->bindParam('login', $login);
        $statement->execute();
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }

    public function getUserById(int $idUser)
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            idusuario,
                            idpessoa,
                            login,
                            ativo
                        FROM administracao.usuario
                        WHERE idusuario = :idusuario
                        ORDER BY idusuario,ativo
            ');
        $statement->bindParam('idusuario', $idUser);
        $statement->execute();
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }

}