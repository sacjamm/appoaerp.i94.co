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
        foreach ($centros as $centro) {
            $button_edit = '<a href="' . base_url('centrodecustos/edit/' . $centro['CodigoCentroCusto']) . '" class=" btn-link text-primary"><i class="fas fa-edit"></i></a>';
            if (!hasPermission($userPermissions, 'eCentrodecusto')) {
                $button_edit = '';
            }
            $button_delete = '<a href="#" class=" btn-link text-danger delete-btn" data-id="' . $centro['CodigoCentroCusto'] . '"><i class="fas fa-trash"></i></a>';
            if (!hasPermission($userPermissions, 'dCentrodecusto')) {
                $button_delete = '';
            }
            ?>
            <tr>
                <td><?= $centro['CodigoCentroCusto']; ?></td>
                <td><?= $centro['NomeCentroCusto']; ?></td>
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