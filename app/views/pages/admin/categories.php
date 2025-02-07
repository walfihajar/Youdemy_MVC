<?php 
require_once __DIR__.'/../../../config/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Catégories</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .ocean-gradient {
            background: linear-gradient(135deg, #034694 0%, #00a7b3 100%);
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }
    </style>
</head>
<body class="bg-slate-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-72 ocean-gradient text-white py-8 px-6 fixed h-full">
            <div class="flex items-center mb-12">
                <span class="text-2xl font-bold tracking-wider">Youdemy</span>
            </div>

            <nav class="space-y-6">
                <a href="<?= URL ?>/AdminController/dashboard" class="flex items-center space-x-4 px-6 py-4 bg-white bg-opacity-10 rounded-xl">
                    <i class="fas fa-th-large text-lg"></i>
                    <span class="font-medium">Tableau de Bord</span>
                </a>
                <a href="<?= URL ?>/AdminController/afficherUtilisateurs" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl">
                    <i class="fas fa-users text-lg"></i>
                    <span class="font-medium">Utilisateurs</span>
                </a>
                <a href="#" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl">
                    <i class="fas fa-book text-lg"></i>
                    <span class="font-medium">Cours</span>
                </a>
                <div class="relative">
                    <a href="#" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl" id="toggleCategories">
                        <i class="fas fa-tags text-lg"></i>
                        <span class="font-medium">Catégories</span>
                    </a>

                    <ul class="absolute left-0 w-full bg-white bg-opacity-10 rounded-xl mt-2 hidden" id="categoriesDropdown">
                        <li>
                            <a href="<?= URL ?>/CategorieController/afficherCategories" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl">
                                <i class="fas fa-tags text-lg"></i>
                                <span class="font-medium">Catégories</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= URL ?>/TagController/afficherTags" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl">
                                <i class="fas fa-hashtag text-lg"></i>
                                <span class="font-medium">Tags</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <a href="#" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl">
                    <i class="fas fa-cog text-lg"></i>
                    <span class="font-medium">Paramètres</span>
                </a>
            </nav>
        </aside>

        <script>
            const toggleButton = document.getElementById('toggleCategories');
            const dropdownMenu = document.getElementById('categoriesDropdown');

            toggleButton.addEventListener('click', function(event) {
                event.preventDefault();
                dropdownMenu.classList.toggle('hidden');
            });

            window.addEventListener('click', function(e) {
                if (!e.target.closest('.relative')) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        </script>

        

        <!-- Main Content -->
        <main class="flex-1 ml-72 p-8">
            <div class="flex justify-between items-center mb-12 bg-white rounded-2xl p-6 shadow-sm">
                <h1 class="text-2xl font-bold text-slate-800">Gestion des Catégories</h1>
                <button onclick="toggleCategoryModal()" class="px-4 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-all duration-300">
                    <i class="fas fa-plus mr-2"></i>Ajouter une Catégorie
                </button>
            </div>

            <!-- Messages de succès ou d'erreur -->
            <?php if (isset($_SESSION['success'])) : ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?= $_SESSION['success'] ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])) : ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?= $_SESSION['error'] ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Tableau des catégories -->
            <div class="bg-white rounded-2xl shadow-sm">
                <div class="overflow-x-auto p-4">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left bg-slate-50">
                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">Nom</th>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $categorie): ?>
                                <tr class="border-b">
                                    <td class="px-6 py-4"><?= htmlspecialchars($categorie->getNom()) ?></td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-3">
                                            <button onclick="editCategory('<?= $categorie->getIdCategorie() ?>', '<?= htmlspecialchars($categorie->getNom()) ?>')" class="px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                                                Modifier
                                            </button>
                                            <form method="POST" action="<?= URL ?>/CategorieController/gererCategorie">
                                                <input type="hidden" name="categoryId" value="<?= $categorie->getIdCategorie() ?>">
                                                <button type="submit" name="delete_category" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal for Adding or Editing Category -->
            <div id="categoryModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center hidden">
                <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
 <h3 id="modalTitle" class="text-xl font-bold text-slate-800 mb-4">Ajouter une Catégorie</h3>
                    <form method="POST" action="<?= URL ?>/CategorieController/gererCategorie">
                        <div class="mb-4">
                            <label for="nom" class="block text-sm font-semibold text-slate-600">Nom</label>
                            <input type="text" id="nom" name="nom" class="mt-2 px-4 py-2 w-full border border-slate-300 rounded-lg" required>
                        </div>
                        <input type="hidden" id="categoryId" name="categoryId">
                        <div class="flex justify-end">
                            <button type="submit" id="submitButton" name="add_category" class="px-4 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600">Ajouter</button>
                            <button type="button" onclick="closeCategoryModal()" class="ml-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-xl hover:bg-gray-400">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Fonction pour afficher ou masquer le modal
        function toggleCategoryModal() {
            document.getElementById('categoryModal').classList.toggle('hidden');
        }

        // Fonction pour fermer le modal
        function closeCategoryModal() {
            document.getElementById('categoryModal').classList.add('hidden');
        }

        // Fonction pour pré-remplir le formulaire lors de la modification
        function editCategory(id, nom) {
            document.getElementById('nom').value = nom;
            document.getElementById('categoryId').value = id;
            document.getElementById('modalTitle').innerText = 'Modifier une Catégorie';
            document.getElementById('submitButton').innerText = 'Modifier';
            document.getElementById('submitButton').name = 'update_category';
            toggleCategoryModal();
        }
    </script>
</body>
</html>