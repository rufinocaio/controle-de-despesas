<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-200 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        <form action="/public/index.php?url=login" method="POST">
            <div class="mb-4">
                <label class="block text-gray-700" for="email">Email</label>
                <input type="email" id="email" name="email" class="border border-gray-300 p-2 w-full" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700" for="password">Senha</label>
                <input type="password" id="password" name="password" class="border border-gray-300 p-2 w-full" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded">Entrar</button>
        </form>
        <p class="text-center mt-4">
            Não tem uma conta? <a href="/public/index.php?url=register" class="text-blue-500">Registre-se</a>
        </p>
    </div>

</body>
</html>