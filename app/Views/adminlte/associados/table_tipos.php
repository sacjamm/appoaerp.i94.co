<table id="table_tipos" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome Tipo Associado</th>
            <th>Uso Sistema</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($tipos) {
            foreach ($tipos as $tipo) {
                $button_edit = '<a href="' . base_url('associados/edit_tipo/' . $tipo['CodigoAssocTipo']) . '" class=" btn-link text-primary"><i class="fas fa-edit"></i></a>';
                if (!hasPermission($userPermissions, 'eAssociado')) {
                    $button_edit = '';
                }
                $button_delete = '<a href="#" class=" btn-link text-danger delete-btn" data-id="' . $tipo['CodigoAssocTipo'] . '"><i class="fas fa-trash"></i></a>';
                if (!hasPermission($userPermissions, 'dAssociado')) {
                    $button_delete = '';
                }
                ?>
                <tr id="<?= $tipo['CodigoAssocTipo']; ?>">
                    <td><?= $tipo['CodigoAssocTipo']; ?></td>
                    <td><?= $tipo['NomeAssocTipo']; ?></td>
                    <td><?= $tipo['AssociacaoTipo']; ?></td>
                    <td>
                        <?= $button_edit . $button_delete; ?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>