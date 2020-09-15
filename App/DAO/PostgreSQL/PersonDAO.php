<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\PersonModel;

final class PersonDAO extends Connection
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function listPersons(): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT 
                            * 
                        FROM administracao.pessoa
                        ");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function registerPerson(PersonModel $person): array
    {   
        $statement = $this->pdo
            ->prepare(' SELECT 
                            *
                        FROM administracao.pessoa
                        WHERE
                            :cpf = cpf
                            OR
                            :email = email
                        ;');
        $statement->execute([
            'cpf' => $person->getCpf(),
            'email' => $person->getEmail()
        ]);

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);    
        //Existe uma pessoa cadastrada com o CPF
        if ($result){
            return array();
        }
        //Não existe uma pessoa com este CPF, então pode continuar com o cadastro
        $statement = $this->pdo
            ->prepare('INSERT INTO administracao.pessoa (
                naturalidade,
                nome, 
                datanascimento, 
                sexo, 
                cpf, 
                nomemae, 
                email, 
                telefone1, 
                telefone2
            )
            VALUES(
                :naturalidade,
                :nome, 
                :datanascimento, 
                :sexo, 
                :cpf, 
                :nomemae, 
                :email, 
                :telefone1, 
                :telefone2
            );');

        $statement->execute([
            'naturalidade' => $person->getNaturalness(),
            'nome' => $person->getName(),
            'datanascimento' => $person->getBirth(),
            'sexo' => $person->getGender(),
            'cpf' => $person->getCpf(),
            'nomemae' => $person->getMotherName(),
            'email' => $person->getEmail(),
            'telefone1' => $person->getPhone1(),
            'telefone2' => $person->getPhone2()
        ]);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);        
        return $result;
    }

    public function updatePersonData(PersonModel $person): array
    {
        
        $statement = $this->pdo
            ->prepare(' UPDATE administracao.pessoa SET
                            naturalidade = :naturalidade,
                            nome = :nome, 
                            datanascimento = :datanascimento, 
                            sexo = :sexo, 
                            cpf = :cpf, 
                            nomemae = :nomemae, 
                            email = :email, 
                            telefone1 = :telefone1, 
                            telefone2 = :telefone2
                        WHERE
                            cpf = :cpf
        ;');

        $statement->execute([
            'naturalidade' => $person->getNaturalness(),
            'nome' => $person->getName(),
            'datanascimento' => $person->getBirth(),
            'sexo' => $person->getGender(),
            'cpf' => $person->getCpf(),
            'nomemae' => $person->getMotherName(),
            'email' => $person->getEmail(),
            'telefone1' => $person->getPhone1(),
            'telefone2' => $person->getPhone2()
        ]);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }
}