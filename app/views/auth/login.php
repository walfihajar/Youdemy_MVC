<?php
// session_start();
include __DIR__ . '/../includes/header.php';
?>

<main class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Connexion</h1>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= $_SESSION['error'] ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?= $_SESSION['success'] ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <form action="<?= URL ?>/AuthController/login" method="POST">
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border rounded-lg" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700">Mot de passe</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded-lg" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                Se connecter
            </button>
        </form>
        <p class="text-center mt-4">
            Pas encore de compte ? <a href="register.php" class="text-blue-500 hover:underline">S'inscrire</a>
        </p>
    </div>
</main>


<!-- <main class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Connexion</h1>
        <form action="<?= URL ?>/AuthController/login" method="POST">
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border rounded-lg" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700">Mot de passe</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded-lg" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                Se connecter
            </button>
        </form>
    </div>
</main> -->

<?php include __DIR__ . '/../includes/footer.php'; ?>