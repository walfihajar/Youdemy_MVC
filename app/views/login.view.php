<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ucfirst(App::$page)?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-[sans-serif] h-screen">

<!-- Youdemy Logo and Text Section -->
<div class="absolute top-0 left-0 right-0 flex justify-center items-center py-12 ">
    <a href="home" class="flex items-center text-blue-700 text-2xl font-bold">
        <img src="" alt="Youdemy Logo" class="w-8 h-8 mr-2">
        Youdemy
    </a>
</div>

<!-- Main Content Section -->
<div class="grid md:grid-cols-2 items-center h-full mt-8">
    <!-- Form Section -->
    <div class="flex items-center justify-center w-full h-full">
        <form method="POST" class="max-w-lg w-full mx-auto bg-white rounded-lg p-8">
            <h3 class="text-2xl font-bold text-center text-blue-600 mb-6">Login to Your Account</h3>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="text-gray-700 text-sm block mb-2">Email</label>
                <div class="relative">
                    <input id="email" name="email" type="email" required
                           class="w-full bg-gray-50 border border-gray-300 rounded-md pl-10 pr-4 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-200 outline-none"
                           placeholder="Enter your email">
                    <!-- Email Icon -->
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label for="password" class="text-gray-700 text-sm block mb-2">Password</label>
                <div class="relative">
                    <input id="password" name="password" type="password" required
                           class="w-full bg-gray-50 border border-gray-300 rounded-md pl-10 pr-4 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-200 outline-none"
                           placeholder="Enter your password">
                    <!-- Lock Icon -->
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <?php if ($msg = message('', true)) : ?>
                <div class="flex items-center justify-center mb-8 w-full bg-red-200 h-8">
                    <div><?= htmlspecialchars($msg) ?></div>
                </div>
            <?php endif; ?>



            <!-- Submit Button -->
            <button type="submit"
                    class="w-full py-2.5 px-4 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:ring focus:ring-blue-200">
                Login
            </button>

            <!-- Register Link -->
            <p class="text-sm text-center text-gray-700 mt-4">
                Don't have an account? <a href="signup" class="text-blue-600 hover:underline">Register here</a>.
            </p>
        </form>
    </div>

    <!-- Image Section -->
    <div class="hidden md:block h-full">
        <img src="assets/images/register.jpg" class="max-w-[80%] w-full h-full aspect-square object-contain block mx-auto" alt="Illustration" />
    </div>
</div>
</body>
</html>
