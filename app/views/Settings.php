<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Configurações</h2>
        <form action="/perfil" method="POST">
            <div class="mb-4">
                <label class="block text-gray-700" for="name">Nome</label>
                <input type="text" id="name" name="name" class="border border-gray-300 p-2 w-full" value="<?php echo $user->name; ?>" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="email">Email</label>
                <input type="email" id="email" name="email" class="border border-gray-300 p-2 w-full" value="<?php echo $user->email; ?>" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="password">Senha</label>
                <input type="password" id="password" name="password" class="border border-gray-300 p-2 w-full" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded">Salvar</button>
        </form>
    </div>
</div>