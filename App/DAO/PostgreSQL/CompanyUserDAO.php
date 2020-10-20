<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\CompanyUserModel;

final class CompanyUserDAO extends Connection
{
    public function __construct(\PDO $connection = null)
    {
        parent::__construct(); 
        if (isset($connection)) {
            $this->pdo = $connection;
        }
    }

    public function listCompanyUserByStatus(string $status): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT 
                            * 
                        FROM administracao.usuario_empresa
                        WHERE ativo = :ativo
                        ");
        $statement->execute([
            'ativo' => $status
        ]);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function checkIfCompanyUserExists(CompanyUserModel $companyUser): bool
    {
        $exist = false;

        $statement = $this->pdo
            ->prepare(' SELECT 
                            *
                        FROM administracao.usuario_empresa
                        WHERE 
                        :idusuario = idusuario AND
                        :idempresa = idempresa AND
                        :idperfil = idperfil
                    ;');
        $statement->execute([
            'idusuario' => $companyUser->getIdUser(),
            'idempresa' => $companyUser->getIdCompany(),
            'idperfil' => $companyUser->getIdProfile()
        ]);

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC); 
    
        if ($result){
            $exist = true;
        }else{
            $exist = false;
        }
        return $exist;
    }

    public function registerCompanyUser(CompanyUserModel $companyUser)
    {
        $statement = $this->pdo
            ->prepare('INSERT INTO administracao.usuario_empresa (
                idusuario,
                idempresa,
                idperfil,
                ativo
            )
            VALUES(
                :idusuario,
                :idempresa,
                :idperfil,
                :ativo
            );
        ');

        $statement->execute([
            'idusuario' => $companyUser->getIdUser(),
            'idempresa' => $companyUser->getIdCompany(),
            'idperfil' => $companyUser->getIdProfile(),
            'ativo' => $companyUser->getActive()
        ]);
    
        $success = $statement->rowCount() === 1;

        
        return $success;
    }

    public function updateCompanyUser(CompanyUserModel $companyUser)
    {
        $statement = $this->pdo
            ->prepare('UPDATE administracao.usuario_empresa SET
                ativo = :ativo
            WHERE
                idusuario = :idusuario AND
                idempresa = :idempresa AND
                idperfil = :idperfil
            ;
        ');

        $statement->execute([
            'idusuario' => $companyUser->getIdUser(),
            'idempresa' => $companyUser->getIdCompany(),
            'idperfil' => $companyUser->getIdProfile(),
            'ativo' => $companyUser->getActive()
        ]);
    
        $success = $statement->rowCount() === 1;
        
        return $success;
    }
}