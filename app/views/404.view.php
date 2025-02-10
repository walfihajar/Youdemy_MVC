<?php
$this->view('includes/header', $data);
$this->view('includes/nav', $data); // Ensure the nav is correctly included
?>

<!-- Error Message Section -->
<div class="relative flex items-center justify-center h-screen ">
    <div class="absolute inset-0 pointer-events-none"></div> <!-- Background Animation -->

    <div class="text-center text-white relative z-10"> <!-- This is the content area that will be above the background -->
        <h1 class="text-9xl font-bold mb-8 text-purple-700 animate-bounce">404</h1>
        <p class="text-2xl mb-6 text-black font-medium">Oops! The page you're looking for doesn't exist.</p>
        <p class="text-lg text-black mb-4">It might have been moved, or maybe it never existed in the first place.</p>
    </div>
</div>

<?php
$this->view('includes/footer', $data);
?>
