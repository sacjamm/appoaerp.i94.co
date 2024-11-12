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
        foreach ($editoras as $editora) {
            $button_edit = '<a href="' . base_url('editoras/edit/' . $editora['CodigoEditora']) . '" class=" btn-link text-primary"><i class="fas fa-edit"></i></a>';
            if (!hasPermission($userPermissions, 'eEditora')) {
                $button_edit = '';
            }
            $button_delete = '<a href="#" class=" btn-link text-danger delete-btn" data-id="' . $editora['CodigoEditora'] . '"><i class="fas fa-trash"></i></a>';
            if (!hasPermission($userPermissions, 'dEditora')) {
                $button_delete = '';
            }
            ?>
            <tr>
                <td><?= $editora['CodigoEditora']; ?></td>
                <td><?= $editora['NomeEditora']; ?></td>
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