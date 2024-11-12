<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Clientes extends BaseController
{
    public function create()
    {
        if (!hasPermission('create_client')) {
            return redirect()->to('/no-access')->with('error', 'Você não tem permissão para criar clientes.');
        }

        // Lógica de criação de cliente
    }

    public function edit($id)
    {
        if (!hasPermission('edit_client')) {
            return redirect()->to('/no-access')->with('error', 'Você não tem permissão para editar clientes.');
        }

        // Lógica de edição de cliente
    }

    public function delete($id)
    {
        if (!hasPermission('delete_client')) {
            return redirect()->to('/no-access')->with('error', 'Você não tem permissão para excluir clientes.');
        }

        // Lógica de exclusão de cliente
    }
}
