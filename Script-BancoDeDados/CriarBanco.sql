CREATE DATABASE "bd-hemo-uea"
  WITH OWNER = postgres
       ENCODING = 'UTF8'
       TABLESPACE = pg_default
       LC_COLLATE = 'C.UTF-8'
       LC_CTYPE = 'C.UTF-8'
       CONNECTION LIMIT = -1;



tipo_atendimento
    idTipoAtendimento
    descricao
    ativo

atatendimento
    idAtendimento
    idTipoAtendimento
    idPaciente
    dataAtendimento
    dataEncerramento
    idEmpresa
    idConvenio

atendimento_diagnostico
    idAtendimentoDiagnostico
    idAtendimento
    idProfissionalAtendimento

tipo_prodcedimento
    idTipoProcedimento 
    descricao

prcedimento
    idProcedimento
    idTipoProcedimento
    idAtendimento
    observacao
    dataSolicitacao

requisicao
    idrequisicao
    idUsuario
    idStatus_Requisicao
    idTipoTransfusao
    idClinica
    idLeito
    idProfissionalMedico
    peso
    plaquetas
    hemoglobina
    hematoctro
    data_hora_cadastro

itens_requisicao
    idItensRequisicao
    idRequisicao
    idProdutos
    abo
    rhd
    quantidade_unidade
    quantidade_ml
    fenotipado
    intervalo
    data_programada