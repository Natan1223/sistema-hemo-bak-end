<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\CompanyModel;

final class CompanyDAO extends Connection
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function registerCompany(CompanyModel $company)
    {
            $statement = $this->pdo
                ->prepare(' INSERT INTO 
                            administracao.empresa (
                                nome,
                                telefone,
                                ativo
                            ) VALUES (
                                :nome,
                                :telefone,
                                :ativo
                            );
                ');
            $statement->execute([
                'nome'=>$company->getName(),
                'telefone'=>$company->getTelephone(),
                'ativo'=>$company->getActive()
            ]);

            $idCompany =  $this->pdo->lastInsertId();
            
            return $idCompany;
 
    }

    public function listCompanies(): array
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            idempresa,
                            nome,
                            telefone,
                            ativo
                        FROM administracao.empresa
                        ORDER BY idempresa
            ');
        $statement->execute();
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }

    public function updateCompanyData(CompanyModel $company, int $id): void
    {
        $statement = $this->pdo
            ->prepare(' UPDATE administracao.empresa SET
                            nome = :nome,
                            telefone = :telefone,
                            ativo = :ativo
                        WHERE
                            idempresa = ' . $id);

        $statement->execute([
            'nome' => $company->getName(),
            'telefone' => $company->getTelephone(),
            'ativo' => $company->getActive()
        ]);
        return;
    }

    public function getCompanyByIdCompany(int $idCompany)
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            *
                        FROM administracao.empresa
                        WHERE idempresa = :idempresa
            ');
        $statement->bindParam('idempresa', $idCompany);
        $statement->execute();
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }
}