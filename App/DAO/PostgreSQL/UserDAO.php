<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\UserModel;

final class UserDAO extends Connection
{
    public function __construct()
    {
        parent::__construct(); 
    }

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
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        //Se não existe uma pessoa cadastrada com esse ID, então não é possivel cadastrar um usuario
        if(count($response)>0){
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
                            idusuario,
                            idpessoa,
                            login,
                            ativo
                        FROM administracao.usuario
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

}