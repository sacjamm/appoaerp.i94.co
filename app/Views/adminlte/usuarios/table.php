<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuário</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($users as $user):
            $user = (array) $user;
            $button_edit = '<a href="' . base_url('usuarios/edit/' . $user['id']) . '" class="btn btn-link text-primary"><i class="fas fa-edit"></i></a>';
            if (!hasPermission($userPermissions, 'eUsuario')) {
                $button_edit = '';
            }
            $button_delete = '<a href="#" class="btn btn-link text-danger delete-btn" data-id="' . $user['id'] . '"><i class="fas fa-trash"></i></a>';
            if (!hasPermission($userPermissions, 'dUsuario')) {
                $button_delete = '';
            }
            ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= $user['Usuario'] ?></td>
                <td>
                    <?= $button_edit . $button_delete; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th>ID</th>
            <th>Usuário</th>
            <th>Ações</th>
        </tr>
    </tfoot>
</table>