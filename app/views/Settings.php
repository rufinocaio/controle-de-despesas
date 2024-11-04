<div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Configurações</h2>
    <form action="/public/index.php?url=settings" method="POST">
        <div class="mb-4">
            <label class="block text-gray-700" for="name">Nome</label>
            <input type="text" id="name" name="name" class="border border-gray-300 p-2 w-full" value="<?php echo $user['name']; ?>" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700" for="email">Email</label>
            <input type="email" id="email" name="email" class="border border-gray-300 p-2 w-full" value="<?php echo $user['email']; ?>" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700" for="email">Senha</label>
            <input type="password" id="password" name="passowrd" class="border border-gray-300 p-2 w-full" value="" required>
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded">Salvar</button>
    </form>
</div>
