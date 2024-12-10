<div class="bg-white p-6 rounded shadow-md">
    <h1 class="text-2xl font-bold mb-4">Meus Gastos</h1>
    <a href="/adicionar-despesa" class="bg-blue-500 text-white py-2 px-4 rounded">Cadastrar Novo Gasto</a>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <table class="min-w-full bg-white border border-gray-300 mt-4">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2">Descrição</th>
                <th class="border border-gray-300 px-4 py-2">Valor</th>
                <th class="border border-gray-300 px-4 py-2">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($expenses as $expense): ?>
                <tr>
                    <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($expense['description']); ?></td>
                    <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($expense['amount']); ?></td>
                    <td class="border border-gray-300 px-4 py-2">
                        <a href="/public/index.php?url=expenses/delete&id=<?php echo $expense['id']; ?>" class="text-red-500">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>