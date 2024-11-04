<!-- app/views/manage-expenses.php -->
<div class="bg-white p-8 rounded shadow-md w-full">
    <h2 class="text-2xl font-bold mb-6 text-center">Gerenciar Despesas</h2>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Data</th>
                <th class="py-2 px-4 border-b">Valor</th>
                <th class="py-2 px-4 border-b">Tipo</th>
                <th class="py-2 px-4 border-b">Descrição</th>
                <th class="py-2 px-4 border-b">Compartilhado com</th>
                <th class="py-2 px-4 border-b">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($expenses as $expense): ?>
                <tr>
                    <td class="py-2 px-4 border-b"><?php echo $expense['date']; ?></td>
                    <td class="py-2 px-4 border-b"><?php echo $expense['amount']; ?></td>
                    <td class="py-2 px-4 border-b"><?php echo $expense['type_name']; ?></td>
                    <td class="py-2 px-4 border-b"><?php echo $expense['description']; ?></td>
                    <td class="py-2 px-4 border-b">
                        <?php foreach ($expense['shared_with'] as $sharedUser): ?>
                            <div><?php echo $sharedUser['name']; ?> (<?php echo $sharedUser['amount_due']; ?>)</div>
                        <?php endforeach; ?>
                    </td>
                    <td class="py-2 px-4 border-b">
                        <a href="/public/index.php?url=delete-expense&id=<?php echo $expense['id']; ?>" class="text-red-500">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
