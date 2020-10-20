<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\RequisitionModel;

final class RequisitionDAO extends Connection
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function listTransfusionModality(): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT
                            tt.idtipo_transfusao as idtipotransfusao,
                            tt.descricao
                        FROM prontuario.tipo_transfusao tt
                        ");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function registerRequisition(RequisitionModel $requisition)
    {
        $statement = $this->pdo
            ->prepare(' INSERT INTO prontuario.requisicao (
                            idprocedimento, 
                            idusuario, 
                            idstatus_requisicao, 
                            idtipo_transfusao, 
                            idempresa, 
                            idclinica, 
                            idleito, 
                            idprofissional_medico, 
                            peso, 
                            paquetas, 
                            hematoctro, 
                            hemoglobina, 
                            observacao, 
                            data_hora_cadastro
                        ) VALUES (
                            :idProcedure,
                            :idUser,
                            :idStatusRequisition,
                            :idTypeTransfusion,
                            :idCompany,
                            :idClinic,
                            :idBed,
                            :idProfessionalMedical,
                            :weight,
                            :platelets,
                            :hematoctro,
                            :hemoglobin,
                            :observation,
                            :dateTimeRegister
                        );
            ');
        $statement->execute([
            'idProcedure' => $requisition->getIdProcedure(),
            'idUser' =>$requisition->getIdUser(),
            'idStatusRequisition' => $requisition->getIdStatusRequisition(),
            'idTypeTransfusion' => $requisition->getIdTypeTransfusion(),
            'idCompany' => $requisition->getIdCompany(),
            'idClinic' => $requisition->getIdClinic(),
            'idBed' => $requisition->getIdBed(),
            'idProfessionalMedical' => $requisition->getIdProfessionalMedical(),
            'weight' => $requisition->getWeight(),
            'platelets' => $requisition->getPlatelets(),
            'hematoctro' => $requisition->getHematoctro(),
            'hemoglobin' => $requisition->getHemoglobin(),
            'observation' => $requisition->getObservation(),
            'dateTimeRegister' => $requisition->getDateTimeRegister()
        ]);

        $idRequisition =  $this->pdo->lastInsertId();
        
        return $idRequisition;
    }
    
}