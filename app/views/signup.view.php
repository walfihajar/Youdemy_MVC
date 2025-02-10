<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ucfirst(App::$page)?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-[sans-serif] h-screen space-y-12">
<?php if(message()) :?>
    <div><?= message('',true) ?></div>
<?php  endif;?>
<div class="absolute top-0 left-0 right-0 flex justify-center items-center py-12 ">
    <a href="home" class="flex items-center text-blue-700 text-2xl font-bold">
        <img src="" alt="Youdemy Logo" class="w-8 h-8 mr-2">
        Youdemy
    </a>
</div>
<div class="grid md:grid-cols-2 items-center h-full">
    <!-- Image Section -->
    <div class="hidden md:block h-full">
        <img src="assets/images/register.jpg" class="max-w-[80%] w-full h-full aspect-square object-contain block mx-auto" alt="Illustration" />
    </div>

    <!-- Form Section -->
    <div class="flex items-center justify-center w-full h-full">
        <form method="POST" action="signup" class="max-w-lg w-full mx-auto bg-white rounded-lg p-8">
            <h3 class="text-2xl font-bold text-center text-blue-600 mb-6">Create an Account</h3>

            <!-- Full Name and Last Name -->
            <div class="mb-4 flex gap-4">
                <!-- First Name -->
                <div class="w-1/2">
                    <label for="first_name" class="text-gray-700 text-sm block mb-2">First Name</label>
                    <div class="relative">
                        <input id="first_name" name="first_name" value="<?= set_value('first_name') ?> " type="text"
                               class="w-full bg-gray-50 border border-gray-300 rounded-md pl-10 pr-4 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-200 outline-none"
                               placeholder="First Name">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </div>
                    <?php if(!empty($errors['first_name'])):?>
                    <div class="text-red-500 w-full"><?=$errors['first_name']?></div>
                    <?php endif;?>

                </div>

                <!-- Last Name -->
                <div class="w-1/2">
                    <label for="last_name" class="text-gray-700 text-sm block mb-2">Last Name</label>
                    <div class="relative">
                        <input id="last_name" value="<?= set_value('last_name')?>"  name="last_name" type="text"
                               class="w-full bg-gray-50 border border-gray-300 rounded-md pl-10 pr-4 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-200 outline-none"
                               placeholder="Last Name">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </div>
                    <?php if(!empty($errors['last_name'])):?>
                        <div class="text-red-500 w-full"><?=$errors['last_name']?></div>
                    <?php endif;?>
                </div>
            </div>

            <!-- Email and Password -->
            <div class="mb-4 flex gap-4">
                <!-- Email -->
                <div class="w-1/2">
                    <label for="email" class="text-gray-700 text-sm block mb-2">Email</label>
                    <div class="relative">
                        <input id="email" value="<?= set_value('email')?>"  name="email" type="email"
                               class="w-full bg-gray-50 border border-gray-300 rounded-md pl-10 pr-4 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-200 outline-none"
                               placeholder="Enter your email">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <?php if(!empty($errors['email'])):?>
                        <div class="text-red-500 w-full"><?=$errors['email']?></div>
                    <?php endif;?>
                </div>

                <!-- Password -->
                <div class="w-1/2">
                    <label for="password" class="text-gray-700 text-sm block mb-2">Password</label>
                    <div class="relative">
                        <input id="password" value="<?= set_value('password')?>"  name="password" type="password"
                               class="w-full bg-gray-50 border border-gray-300 rounded-md pl-10 pr-4 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-200 outline-none"
                               placeholder="Enter your password">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                    </div>
                    <?php if(!empty($errors['password'])):?>
                        <div class="text-red-500 w-full"><?=$errors['password']?></div>
                    <?php endif;?>
                </div>
            </div>

            <!-- Role Selection -->
            <div class="mb-4">
                <label for="id_role" class="text-gray-700 text-sm block mb-2">Role</label>
                <div class="relative">
                    <select id="id_role" name="id_role"
                            class="w-full bg-gray-50 border border-gray-300 rounded-md pl-10 pr-10 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-200 outline-none appearance-none">
                        <option value="" disabled selected>Select your role</option>
                        <option value="2" <?= (set_value('id_role') == 2) ? 'selected' : ''; ?>>Tutor</option>
                        <option value="3" <?= (set_value('id_role') == 3) ? 'selected' : ''; ?>>Student</option>

                    </select>
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full py-2.5 px-4 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:ring focus:ring-blue-200">
                Create an Account
            </button>

            <!-- Login Link -->
            <p class="text-sm text-center text-gray-700 mt-4">
                Already have an account? <a href="login" class="text-blue-600 hover:underline">Login here</a>.
            </p>
        </form>
    </div>
</div>
</body>
</html>
