<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Descrição</th>
            <th>Possui assinatura?</th> 
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($tipos as $tipo) {
            $button_edit = '<a href="' . base_url('tipopublicacao/edit/' . $tipo['CodigoPublicacaoTipo']) . '" class=" btn-link text-primary"><i class="fas fa-edit"></i></a>';
            if (!hasPermission($userPermissions, 'eTipopublicacao')) {
                $button_edit = '';
            }
            $button_delete = '<a href="#" class=" btn-link text-danger delete-btn" data-id="' . $tipo['CodigoPublicacaoTipo'] . '"><i class="fas fa-trash"></i></a>';
            if (!hasPermission($userPermissions, 'dTipopublicacao')) {
                $button_delete = '';
            }
            ?>
            <tr>
                <td><?= $tipo['CodigoPublicacaoTipo']; ?></td>
                <td><?= $tipo['NomePublicacaoTipo']; ?></td>
                <td><?= ($tipo['AssinaturaTipo'] === '1' || $tipo['AssinaturaTipo'] === 1) ? 'Sim' : 'Não'; ?></td>
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
            <th>Possui assinatura?</th>
            <th>Ações</th>
        </tr>
    </tfoot>
</table>