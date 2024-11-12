<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Descrição</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($grupos as $grupo) {
            $button_edit = '<a href="' . base_url('grupoprodutos/edit/' . $grupo['CodigoProdutoGrupo']) . '" class=" btn-link text-primary"><i class="fas fa-edit"></i></a>';
            if (!hasPermission($userPermissions, 'eGrupodeproduto')) {
                $button_edit = '';
            }
            $button_delete = '<a href="#" class=" btn-link text-danger delete-btn" data-id="' . $grupo['CodigoProdutoGrupo'] . '"><i class="fas fa-trash"></i></a>';
            if (!hasPermission($userPermissions, 'dGrupodeproduto')) {
                $button_delete = '';
            }
            ?>
            <tr>
                <td><?= $grupo['CodigoProdutoGrupo']; ?></td>
                <td><?= $grupo['NomeProdutoGrupo']; ?></td>
                <td>
                    <?= $button_edit . $button_delete; ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>ID</th>
            <th>Descrição</th>
            <th>Ações</th>
        </tr>
    </tfoot> 
</table> 