<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Adicionar Despesa</h2>
        <form id="add-expense-form" action="/adicionar-despesa" method="POST">
            <div class="mb-4">
                <label class="block text-gray-700" for="amount">Valor</label>
                <input type="number" id="amount" name="amount" class="border border-gray-300 p-2 w-full" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="type_id">Tipo de Despesa</label>
                <select id="type_id" name="type_id" class="border border-gray-300 p-2 w-full" required>
                    <?php if (!empty($expenseTypes)): ?>
                        <?php foreach ($expenseTypes as $type): ?>
                            <option value="<?php echo htmlspecialchars($type->getId()); ?>"><?php echo htmlspecialchars($type->getName()); ?></option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">Nenhum tipo de despesa encontrado</option>
                    <?php endif; ?>
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
                        foreach ($users as $user):
                            if ($user->id != $_SESSION['user_id']): ?>
                                <option value="<?php echo htmlspecialchars($user->id); ?>"><?php echo htmlspecialchars($user->name); ?></option>
                            <?php endif;?>
                        <?php endforeach; 
                    ?>
                </select>
                <small class="text-gray-600">Segure Ctrl (ou Cmd) para selecionar múltiplos usuários.</small>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded">Adicionar Despesa</button>
        </form>
    </div> 
</div>

<!-- <script>
    document.getElementById('add-expense-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting

        const formData = new FormData(this);
        const data = {};
        formData.forEach((value, key) => {
            if (data[key]) {
                if (Array.isArray(data[key])) {
                    data[key].push(value);
                } else {
                    data[key] = [data[key], value];
                }
            } else {
                data[key] = value;
            }
        });
        console.log(<?php print($_SESSION['user_id']);?>)
        console.log('Form Data:', data);

        // Optionally, you can submit the form after logging the data
        // this.submit();
    });
</script> -->