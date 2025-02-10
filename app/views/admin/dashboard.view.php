<?php
$this->view('includes/header',$data);
?>
<body class="bg-gray-100">
<div class="flex min-h-screen flex-col md:flex-row">

    <!-- Sidebar -->
    <nav id="sidebar" class="sidebar w-full md:w-1/5 bg-white h-screen shadow-lg p-6 fixed md:relative top-0 left-0 h-screen z-10 md:transform-none sidebar-hidden">
        <div class="mb-8">
            <a href="#" class="flex items-center">
                <img src="../../Assets/uploads/logo.gif" class="w-10 h-10 md:w-12 md:h-12 lg:w-14 lg:h-14">
                <span class="text-custom-primary text-xl font-bold ml-2">Youdemy</span>
            </a>
        </div>

        <ul class="mb-8">
            <li class="mb-4 flex items-center text-gray-700 hover:text-yellow-500 transition-colors">
                <a href="home">
                    <i class="fas fa-home mr-2"></i><span>Home</span>
                </a>
            </li>

            <li class="mb-4 flex items-center text-gray-700 hover:text-yellow-500 transition-colors">
                <a href="dashboard">
                    <i class="fas fa-chart-bar mr-2"></i><span>Overview</span>
                </a>
            </li>

            <li class="mb-4 flex items-center text-gray-700 hover:text-yellow-500 transition-colors">
                <a href="approve">
                    <i class="fas fa-check-circle mr-2"></i><span>Approve</span>
                </a>
            </li>

            <li class="mb-4 flex items-center text-gray-700 hover:text-yellow-500 transition-colors">
                <a href="learners">
                    <i class="fas fa-users mr-2"></i><span>Learners</span>
                </a>
            </li>

            <li class="mb-4 flex items-center text-gray-700 hover:text-yellow-500 transition-colors">
                <a href="tutors">
                    <i class="fas fa-chalkboard-teacher mr-2"></i><span>Tutors</span>
                </a>
            </li>

            <li class="mb-4 flex items-center text-gray-700 hover:text-yellow-500 transition-colors">
                <a href="courses">
                    <i class="fas fa-book mr-2"></i><span>Courses</span>
                </a>
            </li>

            <li class="mb-4 flex items-center text-gray-700 hover:text-yellow-500 transition-colors">
                <a href="categories">
                    <i class="fas fa-layer-group mr-2"></i><span>Categories</span>
                </a>
            </li>

            <li class="mb-4 flex items-center text-gray-700 hover:text-yellow-500 transition-colors">
                <a href="tags">
                    <i class="fas fa-tag mr-2"></i><span>Tags</span>
                </a>
            </li>

            <li class="mb-4 flex items-center text-red-500 hover:text-red-700 transition-colors">
                <a href="logout">
                    <i class="fas fa-sign-out-alt mr-2"></i><span>Logout</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Sidebar Toggle Button -->
    <button id="sidebarToggle" class="md:hidden p-4 fixed top-4 left-4 bg-blue-500 text-white rounded-full shadow-lg hover:bg-blue-600 transition-colors z-20">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Main Content -->
    <main class="w-full md:w-3/4 mx-auto pt-6 mt-20 md:mt-0">
        <!-- Courses in Progress Section -->
        <section class="mb-6 p-6">
            <h2 class="text-xl font-bold mb-4">Courses in Progress</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Courses Card -->
                <div class="bg-purple-100 p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm text-gray-500">Total</span>
                        <i class="fas fa-ellipsis-h text-gray-500 cursor-pointer"></i>
                    </div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-book text-purple-700 text-2xl mr-2"></i>
                        <h3 class="text-lg font-bold text-purple-700">Total Courses</h3>
                    </div>
                    <p class="text-sm text-gray-600">50 courses</p>
                </div>

                <!-- Most Enrolled Course Card -->
                <div class="bg-orange-100 p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm text-gray-500">Most Enrolled</span>
                        <i class="fas fa-ellipsis-h text-gray-500 cursor-pointer"></i>
                    </div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-users text-orange-700 text-2xl mr-2"></i>
                        <h3 class="text-lg font-bold text-orange-700">Course Name</h3>
                    </div>
                    <p class="text-sm text-gray-600">120 enrollments</p>
                </div>

                <!-- Top Teachers Card -->
                <div class="bg-blue-100 p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm text-gray-500">Top Teachers</span>
                        <i class="fas fa-ellipsis-h text-gray-500 cursor-pointer"></i>
                    </div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-chalkboard-teacher text-blue-700 text-2xl mr-2"></i>
                        <h3 class="text-lg font-bold text-blue-700">Top 3 Teachers</h3>
                    </div>
                    <ul class="text-sm text-gray-600">
                        <li>John Doe - 10 courses</li>
                        <li>Jane Smith - 8 courses</li>
                        <li>Alex Johnson - 7 courses</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Course Categories Section -->
        <section class="mb-6 p-6">
            <h2 class="text-xl font-bold mb-4">Course Categories</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Category 1 -->
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm text-gray-500">Category</span>
                        <i class="fas fa-ellipsis-h text-gray-500 cursor-pointer"></i>
                    </div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-folder text-indigo-500 text-2xl mr-2"></i>
                        <h3 class="text-lg font-bold text-indigo-700">Web Development</h3>
                    </div>
                    <p class="text-sm text-gray-600">15 courses</p>
                </div>

                <!-- Category 2 -->
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm text-gray-500">Category</span>
                        <i class="fas fa-ellipsis-h text-gray-500 cursor-pointer"></i>
                    </div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-folder text-indigo-500 text-2xl mr-2"></i>
                        <h3 class="text-lg font-bold text-indigo-700">Data Science</h3>
                    </div>
                    <p class="text-sm text-gray-600">10 courses</p>
                </div>

                <!-- Category 3 -->
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm text-gray-500">Category</span>
                        <i class="fas fa-ellipsis-h text-gray-500 cursor-pointer"></i>
                    </div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-folder text-indigo-500 text-2xl mr-2"></i>
                        <h3 class="text-lg font-bold text-indigo-700">Design</h3>
                    </div>
                    <p class="text-sm text-gray-600">8 courses</p>
                </div>
            </div>
        </section>
    </main>

</div>

<!-- Sidebar Toggle Script -->
<script>
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');

    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('sidebar-hidden');
    });
</script>

</body>
</html>
