<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Conexao;
use App\Models\PostgreSQL\CidadeModel;

final class CidadeDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function cadastrarCidade(CidadeModel $cidade)
    {
            $statement = $this->pdo
                ->prepare(' INSERT INTO 
                            administracao.cidade (
                                idcidade, 
                                descricao
                            ) VALUES (
                                :idcidade,
                                :descricao  
                            );
                ');
            $statement->execute([
                'descricao'=>$cidade->getDescricao()
            ]);

            $idCidade =  $this->pdo->lastInsertId();
            
            return $idCidade;
 
    }

    public function listarCidades(): array
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

    public function atualizarDadosCidade(CidadeModel $cidade): void
    {
        $statement = $this->pdo
            ->prepare(' UPDATE administracao.cidade SET
                            descricao = :descricao,
                        WHERE
                            idcidade = :idcidade
        ;');

        $statement->execute([
            'descricao' => $cidade->getDescricao(),
        ]);
        return;
    }

}