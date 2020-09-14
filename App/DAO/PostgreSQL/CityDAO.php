<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\CityModel;

final class CityDAO extends Connection
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function registerCity(CityModel $city)
    {
            $statement = $this->pdo
                ->prepare(' INSERT INTO 
                            administracao.cidade (
                                descricao
                            ) VALUES (
                                :descricao  
                            );
                ');
            $statement->execute([
                'descricao'=>$city->getDescription()
            ]);

            $idCity =  $this->pdo->lastInsertId();
            
            return $idCity;
 
    }

    public function listCities(): array
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            idcidade,
                            descricao
                        FROM administracao.cidade
                        ORDER BY idcidade,descricao
            ');
        $statement->execute();
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }

    public function updateDataCity(CityModel $city): void
    {
        $statement = $this->pdo
            ->prepare(' UPDATE administracao.cidade SET
                            idcidade = :idcidade,
                            descricao = :descricao
                        WHERE
                            idcidade = :idcidade
        ;');

        $statement->execute([
            'idcidade' => $city->getIdCity(),
            'descricao' => $city->getDescription(),
        ]);
        return;
    }

}