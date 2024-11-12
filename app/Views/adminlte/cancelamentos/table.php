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
        foreach ($cancelamentos as $cancelamento) {
            $button_edit = '<a href="' . base_url('cancelamentos/edit/' . $cancelamento['CodigoMotivoCancel']) . '" class=" btn-link text-primary"><i class="fas fa-edit"></i></a>';
            if (!hasPermission($userPermissions, 'eCancelamento')) {
                $button_edit = '';
            }
            $button_delete = '<a href="#" class=" btn-link text-danger delete-btn" data-id="' . $cancelamento['CodigoMotivoCancel'] . '"><i class="fas fa-trash"></i></a>';
            if (!hasPermission($userPermissions, 'dCancelamento')) {
                $button_delete = '';
            }
            ?>
            <tr>
                <td><?= $cancelamento['CodigoMotivoCancel']; ?></td>
                <td><?= $cancelamento['NomeMotivoCancel']; ?></td>
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