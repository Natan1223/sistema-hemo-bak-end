<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\RequisitionItemsModel;

final class RequisitionItemsDAO extends Connection
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function listProduct(): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT
                            p.idprodutos,
                            p.nome_produto,
                            p.sigla_produtos
                        FROM laboratorio.produtos p 
                        ORDER BY p.nome_produto
            ");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    // public function listTypeAttendance(): array
    // {
    //     $statement = $this->pdo
    //         ->prepare(" SELECT 
    //                         idtipo_atendimento as idtipoatendimento,
    //                         descricao
    //                     FROM prontuario.tipo_atendimento
    //                     WHERE ativo = 'T'
    //                     ");
    //     $statement->execute();
    //     $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

    //     return $result;
    // }

    public function registerItemsRequisition(RequisitionItemsModel $itemsRequisition)
    {
        $statement = $this->pdo
            ->prepare(' INSERT INTO prontuario.itens_requisicao (
                            idrequisicao, 
                            idproduto, 
                            abo, 
                            rhd, 
                            quantidade_unidade, 
                            quantidade_ml, 
                            fenotipado, 
                            intervalo, 
                            data_programada, 
                            data_hora_registro
                        ) VALUES (
                            :idRequisition,
                            :idProduct,
                            :abo,
                            :rhd,
                            :unitQuantity,
                            :mlQuantity,
                            :phenotyped,
                            :interval,
                            :dateScheduled,
                            :dateTimeRegister
                        );
            ');
        $statement->execute([
            'idRequisition' => $itemsRequisition->getIdRequisition(),
            'idProduct' => $itemsRequisition->getIdProducts(),
            'abo' => $itemsRequisition->getAbo(),
            'rhd' => $itemsRequisition->getRhd(),
            'unitQuantity' => $itemsRequisition->getUnitQuantity(),
            'mlQuantity' => $itemsRequisition->getMlQuantity(),
            'phenotyped' => $itemsRequisition->getPhenotyped(),
            'interval' => $itemsRequisition->getInterval(),
            'dateScheduled' => $itemsRequisition->getDateScheduled(),
            'dateTimeRegister' => $itemsRequisition->getDateTimeRegister()
        ]);

        $idAttendance =  $this->pdo->lastInsertId();
        
        return $idAttendance;
    }
    
}