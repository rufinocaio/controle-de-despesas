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
<div class="bg-white p-8 rounded shadow-md w-full max-w-md mx-auto mt-20">
    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
    <form action="/login" method="POST">
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
    <p class="mt-4">
        <!-- Mensagem de erro -->
        <?php if (isset($_SESSION['error'])): ?>
            <span class="text-red-500"><?php echo $_SESSION['error']; ?></span>
        <?php unset($_SESSION['error']); 
        endif ?>
    </p>
    <p class="text-center mt-4">
        Não tem uma conta? <a href="/registrar" class="text-blue-500">Registre-se</a>
    </p>
</div>
</body>
</html>
