<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Código do Banco</th>
            <th>Banco</th>
            <th>Código Convênio APPOA</th>
            <th>Código Convênio Instituto</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($bancos as $banco) {
            $button_edit = '<a href="' . base_url('bancos/edit/' . $banco['id']) . '" class=" btn-link text-primary"><i class="fas fa-edit"></i></a>';
            if (!hasPermission($userPermissions, 'eBanco')) {
                $button_edit = '';
            }
            $button_delete = '<a href="#" class=" btn-link text-danger delete-btn" data-id="' . $banco['id'] . '"><i class="fas fa-trash"></i></a>';
            if (!hasPermission($userPermissions, 'dBanco')) {
                $button_delete = '';
            }
            ?>
            <tr>
                <td><?= $banco['id']; ?></td>
                <td><?= $banco['CodigoBanco']; ?></td>
                <td><?= $banco['NomeBanco']; ?></td>
                <td><?= $banco['ConvenioBanco']; ?></td>
                <td><?= $banco['ConvenioBancoInstituto']; ?></td>
                <td>
                    <?= $button_edit . $button_delete; ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>ID</th>
            <th>Código do Banco</th>
            <th>Banco</th>
            <th>Código Convênio APPOA</th>
            <th>Código Convênio Instituto</th>
            <th>Ações</th>
        </tr>
    </tfoot>
</table>