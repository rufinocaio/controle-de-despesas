<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link href="/css/tailwind.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
</head>
<body class="bg-gray-200 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded shadow-md w-80">
        <h2 class="text-lg font-bold mb-4">Cadastro</h2>
        <form action="/registrar" method="POST">
            <div class="mb-4">
                <label class="block text-gray-700" for="name">Nome</label>
                <input type="text" id="name" name="name" class="border border-gray-300 p-2 w-full" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="email">E-mail</label>
                <input type="email" id="email" name="email" class="border border-gray-300 p-2 w-full" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="password">Senha</label>
                <input type="password" id="password" name="password" class="border border-gray-300 p-2 w-full" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Cadastrar</button>
        </form>
        <p class="mt-4">
            <?php if (isset($_SESSION['error'])): ?>
                <span class="text-red-500"><?php echo $_SESSION['error']; ?></span>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
        </p>
    </div>
</body>
</html>