<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\MenuModel;

final class MenuDAO extends Connection
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function listMenus(): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT 
                            idmenu,
                            idperfil,
                            descricao,
                            path,
                            idmenu_titulo,
                            ativo
                        FROM administracao.menu
                        ");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }
    
    public function registerMenu(MenuModel $menu)
    {
        $statement = $this->pdo
            ->prepare('INSERT INTO administracao.menu (
                descricao,
                ativo,
                path,
                idperfil
            )
            VALUES(
                :descricao,
                :ativo,
                :path, 
                :idperfil 
            );
        ');

        $statement->execute([
            'descricao' => $menu->getDescription(),
            'ativo' => $menu->getActive(),
            'path' => $menu->getPath(),
            'idperfil' => $menu->getIdProfile()
        ]);
        
        $idMenu =  $this->pdo->lastInsertId();
            
        return $idMenu;
    }

    public function updateMenu(MenuModel $menu)
    {
        $statement = $this->pdo
            ->prepare('UPDATE administracao.menu SET
                descricao = :descricao,
                ativo = :ativo,
                path = :path,
                idmenu_titulo = :idmenu_titulo
            WHERE
                idmenu = :idmenu
            ;
        ');

        $statement->execute([
            'idmenu' => $menu->getIdMenu(),
            'descricao' => $menu->getDescription(),
            'ativo' => $menu->getActive(),
            'path' => $menu->getPath(),
            'idmenu_titulo' => $menu->getIdMenuTitle()
        ]);
        
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function getMenuByIdProfile(int $idEmpresa): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT distinct
                            m.idmenu,
                            m.descricao
                        FROM administracao.usuario_empresa ue 
                        JOIN administracao.perfil p
                            on ue.idperfil = p.idperfil
                        join administracao.menu m
                            on p.idperfil = m.idperfil
                            and m.idmenu_titulo = 0
                            and m.ativo = 'T'
                        where ue.idempresa = :idEmpresa
                        and ue.idusuario = :idUsuario
                        ORDER by m.descricao
            ");
        $statement->execute([
            'idUsuario' => $_SESSION['idUsuario'],
            'idEmpresa' => $idEmpresa
        ]);
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }

    public function listMenuPath(int $idMenu): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT 
                            m.idmenu,
                            m.descricao,
                            m.path
                        FROM administracao.menu m
                        WHERE m.idmenu_titulo = :idMenu
                        and m.ativo = 'T'
                        ORDER BY m.descricao
        
            ");
        $statement->execute([
            'idMenu' => $idMenu
        ]);
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }
}