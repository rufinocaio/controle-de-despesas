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
            <?php if (!empty($expenses) && is_array($expenses)): ?>
                <?php foreach ($expenses as $expense): ?>
                    <tr>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($expense['date']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($expense['amount']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($expense['type_name']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($expense['description']); ?></td>
                        <td class="py-2 px-4 border-b">
                            <?php if (!empty($expense['shared_with']) && is_array($expense['shared_with'])): ?>
                                <?php foreach ($expense['shared_with'] as $sharedUser): ?>
                                    <div><?php echo htmlspecialchars($sharedUser['name']); ?> (<?php echo htmlspecialchars($sharedUser['amount_due']); ?>)</div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <button onclick="openEditModal(<?php echo htmlspecialchars(json_encode($expense)); ?>)" class="text-blue-500">Editar</button>
                            <button onclick="openDeleteModal(<?php echo htmlspecialchars($expense['id']); ?>)" class="text-red-500">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="py-2 px-4 border-b text-center">Nenhuma despesa encontrada.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal de Edição -->
<div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Editar Despesa</h2>
        <form id="editForm" action="/public/index.php?url=editar-despesa" method="POST">
            <input type="hidden" id="editId" name="id">
            <div class="mb-4">
                <label class="block text-gray-700" for="editAmount">Valor</label>
                <input type="number" id="editAmount" name="amount" class="border border-gray-300 p-2 w-full" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="editTypeId">Tipo de Despesa</label>
                <select id="editTypeId" name="type_id" class="border border-gray-300 p-2 w-full" required>
                    <?php foreach ($expenseTypes as $type): ?>
                        <option value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="editDate">Data</label>
                <input type="date" id="editDate" name="date" class="border border-gray-300 p-2 w-full" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700" for="editDescription">Descrição</label>
                <textarea id="editDescription" name="description" class="border border-gray-300 p-2 w-full" required></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="editSharedWith">Compartilhar com:</label>
                <select id="editSharedWith" name="shared_with[]" class="border border-gray-300 p-2 w-full" multiple>
                    <?php 
                    $users = $expenseModel->getAllUsers();
                    foreach ($users as $user): ?>
                        <option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <small class="text-gray-600">Segure Ctrl (ou Cmd) para selecionar múltiplos usuários.</small>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded">Salvar</button>
            <button type="button" onclick="closeEditModal()" class="w-full bg-gray-500 text-white py-2 px-4 rounded mt-2">Cancelar</button>
        </form>
    </div>
</div>

<!-- Modal de Exclusão -->
<div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Excluir Despesa</h2>
        <p>Tem certeza de que deseja excluir esta despesa?</p>
        <form id="deleteForm" action="/public/index.php?url=deletar-despesa" method="POST">
            <input type="hidden" id="deleteId" name="id">
            <button type="submit" class="w-full bg-red-500 text-white py-2 px-4 rounded">Excluir</button>
            <button type="button" onclick="closeDeleteModal()" class="w-full bg-gray-500 text-white py-2 px-4 rounded mt-2">Cancelar</button>
        </form>
    </div>
</div>

<script>
    function openEditModal(expense) {
        document.getElementById('editId').value = expense.id;
        document.getElementById('editAmount').value = expense.amount;
        document.getElementById('editTypeId').value = expense.type_id;
        document.getElementById('editDate').value = expense.date;
        document.getElementById('editDescription').value = expense.description;
        document.getElementById('editSharedWith').value = expense.shared_with.map(user => user.id);
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    function openDeleteModal(id) {
        document.getElementById('deleteId').value = id;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>