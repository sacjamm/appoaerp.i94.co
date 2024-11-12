<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nível</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($permissoes as $permissions) {
            $button_edit = '<a href="' . base_url('permissions/edit/' . $permissions['idPermissao']) . '" class="btn btn-link text-primary"><i class="fas fa-edit"></i></a>';
            if (!hasPermission($userPermissions, 'ePermissao')) {
                $button_edit = '';
            }
            $button_delete = '<a href="#" class="btn btn-link text-danger delete-btn" data-id="' . $permissions['idPermissao'] . '"><i class="fas fa-trash"></i></a>';
            if (!hasPermission($userPermissions, 'dPermissao')) {
                $button_delete = '';
            }
            ?>
            <tr>
                <td><?= $permissions['idPermissao']; ?></td>
                <td><?= $permissions['nome']; ?></td>
                <td>
                    <?= $button_edit . $button_delete; ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>ID</th>
            <th>Nível</th>
            <th>Ações</th>
        </tr>
    </tfoot>
</table>