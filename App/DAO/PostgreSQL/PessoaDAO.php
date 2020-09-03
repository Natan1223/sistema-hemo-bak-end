<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Conexao;
use App\Models\PostgreSQL\PessoaModel;

final class PessoaDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function listarPessoas(): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT 
                            * 
                        FROM pessoa
                        ");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function cadastrarPessoa(PessoaModel $pessoa): array
    {
        $statement = $this->pdo
            ->prepare('INSERT INTO pessoa VALUES(
                :idpessoa,
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
            'idpessoa' => $pessoa->getIdPessoa(),
            'naturalidade' => $pessoa->getNaturalidade(),
            'nome' => $pessoa->getNome(),
            'datanascimento' => $pessoa->getDataNascimento(),
            'sexo' => $pessoa->getSexo(),
            'cpf' => $pessoa->getCpf(),
            'nomemae' => $pessoa->getNomeMae(),
            'email' => $pessoa->getEmail(),
            'telefone1' => $pessoa->getTelefone1(),
            'telefone2' => $pessoa->getTelefone2()
        ]);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function atualizarDadosPessoa(PessoaModel $pessoa): void
    {
        $statement = $this->pdo
            ->prepare(' UPDATE pessoa SET
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
                            idpessoa = :idpessoa
        ;');

        $statement->execute([
            'naturalidade' => $pessoa->getNaturalidade(),
            'nome' => $pessoa->getNome(),
            'datanascimento' => $pessoa->getDataNascimento(),
            'sexo' => $pessoa->getSexo(),
            'cpf' => $pessoa->getCpf(),
            'nomemae' => $pessoa->getNomeMae(),
            'email' => $pessoa->getEmail(),
            'telefone1' => $pessoa->getTelefone1(),
            'telefone2' => $pessoa->getTelefone2(),
            'idpessoa' => $pessoa->getIdPessoa()
        ]);
        return;
    }
}