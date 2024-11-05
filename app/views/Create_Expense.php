<div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Adicionar Despesa</h2>
    <form action="/public/index.php?url=adicionar-despesa" method="POST">
        <div class="mb-4">
            <label class="block text-gray-700" for="amount">Valor</label>
            <input type="number" id="amount" name="amount" class="border border-gray-300 p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700" for="type_id">Tipo de Despesa</label>
            <select id="type_id" name="type_id" class="border border-gray-300 p-2 w-full" required>
                <?php foreach ($expenseTypes as $type): ?>
                    <option value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700" for="date">Data</label>
            <input type="date" id="date" name="date" class="border border-gray-300 p-2 w-full" required>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700" for="description">Descrição</label>
            <textarea id="description" name="description" class="border border-gray-300 p-2 w-full" required></textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700" for="shared_with">Compartilhar com:</label>
            <select id="shared_with" name="shared_with[]" class="border border-gray-300 p-2 w-full" multiple>
                <?php 
                    $users = $expenseModel->getAllUsers();
                     foreach ($users as $user): ?>
                    <option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <small class="text-gray-600">Segure Ctrl (ou Cmd) para selecionar múltiplos usuários.</small>
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded">Adicionar Despesa</button>
    </form>
</div>