<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\OccupationModel;

final class OccupationDAO extends Connection
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function listOccupations(): array
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            idocupacao,
                            numero_registro_cbo,
                            descricao,
                            ativo
                        FROM administracao.ocupacao
                        ORDER BY idocupacao
            ');
        $statement->execute();
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }

    // public function listOccupationId(int $id): array
    // {
    //     $statement = $this->pdo
    //         ->prepare(' SELECT 
    //                         idocupacao,
    //                         numero_registro_cbo,
    //                         descricao,
    //                         ativo
    //                     FROM administracao.ocupacao
    //                     WHERE idocupacao = :id
    //                     ORDER BY idocupacao
    //         ');
    //     $statement->bindValue('id', $id);
    //     $statement->execute();
    //     $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
    //     return $response;
    // }

    public function getOccupationByName(string $name): array
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            idocupacao,
                            numero_registro_cbo,
                            descricao,
                            ativo
                        FROM administracao.ocupacao
                        WHERE descricao = :name
            ');
        $statement->bindParam('name', $name);
        $statement->execute();
        $response = $statement->fetch(\PDO::FETCH_ASSOC);
        return $response;
    }

    public function getOccupationByCbo(string $cbo): array
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            idocupacao,
                            numero_registro_cbo,
                            descricao,
                            ativo
                        FROM administracao.ocupacao
                        WHERE numero_registro_cbo = :cbo
            ');
        $statement->bindParam('cbo', $cbo);
        $statement->execute();
        $response = $statement->fetch(\PDO::FETCH_ASSOC);
        return $response;
    }

    public function getOccupationById(int $id): array
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            idocupacao,
                            numero_registro_cbo,
                            descricao,
                            ativo
                        FROM administracao.ocupacao
                        WHERE idocupacao = :id
            ');
        $statement->bindValue('id', $id);
        $statement->execute();
        $response = $statement->fetch(\PDO::FETCH_ASSOC);
        return $response;
    }

}