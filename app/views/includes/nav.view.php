
<nav class="bg-white shadow-lg z-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <div class="flex space-x-7">
                <a href="home" class="flex items-center">
                    <img src="../../Assets/uploads/logo.gif" class="w-10 h-10 md:w-12 md:h-12 lg:w-14 lg:h-14" alt="Logo">
                    <span class="text-custom-primary text-xl font-bold ml-2"><?=APP_NAME?></span>
                </a>
            </div>
            <div class="hidden md:flex items-center space-x-4">
                <a href="home" class="text-gray-700 hover:text-custom-primary transition duration-300">Home</a>
                <a href="courses" class="text-gray-700 hover:text-custom-primary transition duration-300">Courses</a>
                <a href="services" class="text-gray-700 hover:text-custom-primary transition duration-300">Services</a>
                <a href="about" class="text-gray-700 hover:text-custom-primary transition duration-300">About</a>
                <a href="contact" class="text-gray-700 hover:text-custom-primary transition duration-300">Contact</a>

                <!-- Login/Register Links -->
                <?php if (!Auth::logged_in()): ?>
                    <a href="login" class="bg-purple-700 text-white rounded-full py-1 px-3 hover:bg-purple-700-dark transition duration-300">Login</a>
                    <a href="signup" class="bg-purple-700 text-white rounded-full py-1 px-3 hover:bg-purple-700-dark transition duration-300">Signup</a>
                <?php else: ?>
                    <div class="relative group inline-block">
                        <!-- User Icon -->
                        <button class="text-purple-700 rounded-full w-10 h-10 flex items-center justify-center hover:bg-gray-100 transition duration-300">
                            <i class="fa-solid fa-user text-xl"></i>
                        </button>

                        <!-- Dropdown Menu (Appears on Hover) -->
                        <div class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200">
                            <a href="admin" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                            <a href="logout" class="block px-4 py-2 text-red-600 hover:bg-gray-100">Logout</a>
                        </div>
                    </div>
                <?php endif; ?> <!-- ✅ Properly closing the if statement -->



            </div>
            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button class="outline-none mobile-menu-button">
                    <svg class="w-6 h-6 text-gray-500 hover:stroke-custom-primary"
                         fill="none"
                         stroke-linecap="round"
                         stroke-linejoin="round"
                         stroke-width="2"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Mobile menu -->
    <div class="hidden mobile-menu">
        <ul>
            <li><a href="#" class="block text-sm px-2 py-2 text-gray-700">Home</a></li>
            <li><a href="#" class="block text-sm px-2 py-2 text-gray-700">Courses</a></li>
            <li><a href="#" class="block text-sm px-2 py-2 text-gray-700">Blog</a></li>
            <li><a href="#" class="block text-sm px-2 py-2 text-gray-700">Services</a></li>
            <li><a href="#" class="block text-sm px-2 py-2 text-gray-700">About</a></li>
            <li><a href="#" class="block text-sm px-2 py-2 text-gray-700">Contact</a></li>
            <!-- Login/Register Links in Mobile Menu -->
            <li><a href="#" class="block text-sm px-2 py-2 text-gray-700">Login</a></li>
            <li><a href="#" class="block text-sm px-2 py-2 text-gray-700">Register</a></li>
        </ul>
    </div>
</nav>